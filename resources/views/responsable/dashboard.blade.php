@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-slate-100 p-8">

<div class="max-w-7xl mx-auto">

@if(session('success'))
<div class="mb-6 bg-green-100 border border-green-300 text-green-700 p-4 rounded-xl">
{{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="mb-6 bg-red-100 border border-red-300 text-red-700 p-4 rounded-xl">
{{ session('error') }}
</div>
@endif


<div class="flex justify-between items-center mb-8">

<div>

<h1 class="text-4xl font-bold text-slate-800">
Dashboard Responsable
</h1>

<p class="text-slate-500">
{{ $service->nom_service }}
</p>

</div>

<div class="bg-white rounded-2xl shadow px-6 py-4">

<p class="text-slate-500">
Aujourd'hui
</p>

<h2 class="font-bold">
{{ now()->format('d/m/Y') }}
</h2>

</div>

</div>


<div class="grid md:grid-cols-4 gap-5 mb-8">

<div class="bg-white rounded-2xl shadow p-6">

<p class="text-slate-500">En attente</p>
<h2 id="waitingCount" class="text-4xl font-bold text-yellow-500">
{{ $waitingCount }}
</h2>

</div>

<div class="bg-white rounded-2xl shadow p-6">

<p class="text-slate-500">En cours</p>

<h2 id="processingCount" class="text-4xl font-bold text-blue-600">
{{ $processingCount }}
</h2>

</div>

<div class="bg-white rounded-2xl shadow p-6">

<p class="text-slate-500">Terminés</p>

<h2 id="finishedCount" class="text-4xl font-bold text-green-600">
{{ $finishedCount }}
</h2>

</div>

<div class="bg-white rounded-2xl shadow p-6">

<p class="text-slate-500">Annulés</p>

<h2 id="cancelledCount" class="text-4xl font-bold text-red-600">
{{ $cancelledCount }}
</h2>

</div>

</div>


<div class="grid lg:grid-cols-3 gap-8">


<div class="lg:col-span-2">


<div class="bg-blue-700 rounded-3xl text-white p-8 mb-8">

<h3 class="text-xl">
Ticket actuel
</h3>

@if($currentTicket)

<div id="current-ticket" class="text-8xl font-black mt-5">

{{ str_pad((int)preg_replace('/[^0-9]/','',$currentTicket->numero),2,'0',STR_PAD_LEFT) }}

</div>
<p id="current-name" class="mt-4 text-blue-100">

{{ $currentTicket->nom_client }}

</p>

@else

<div class="text-4xl mt-6 font-bold">

--

</div>

<p class="mt-4">

Aucun ticket appelé.

</p>

@endif

</div>



<div class="bg-white rounded-3xl shadow">

<div class="p-6 border-b">

<h2 class="text-2xl font-bold">

File d'attente

</h2>

</div>

<table class="w-full">

<thead class="bg-slate-50">

<tr>

<th class="text-left p-4">Ticket</th>
<th class="text-left">Nom</th>
<th class="text-left">Téléphone</th>
<th class="text-left">Statut</th>

</tr>

</thead>

<tbody id="queue-body">

@forelse($queue as $ticket)

<tr class="border-t hover:bg-slate-50">

<td class="p-4 font-bold">

{{ str_pad((int)preg_replace('/[^0-9]/','',$ticket->numero),2,'0',STR_PAD_LEFT) }}

</td>

<td>

{{ $ticket->nom_client }}

</td>

<td>

{{ $ticket->telephone_client }}

</td>

<td>

{{ $ticket->statut }}

</td>

</tr>

@empty

<tr>

<td colspan="4" class="text-center py-10 text-slate-500">

Aucun ticket

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>


<div>

<div class="bg-white rounded-3xl shadow p-8">

<h2 class="text-2xl font-bold mb-6">

Actions

</h2>

<form action="{{ route('responsable.ticket.suivant') }}" method="POST">

@csrf

<button class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-4 mb-4">

▶ Appeler le prochain

</button>

</form>

<form action="{{ route('responsable.ticket.terminer') }}" method="POST">

@csrf

<button class="w-full bg-green-600 hover:bg-green-700 text-white rounded-xl py-4 mb-4">

✔ Terminer

</button>

</form>

<form action="{{ route('responsable.ticket.annuler') }}" method="POST">

@csrf

<button class="w-full bg-red-600 hover:bg-red-700 text-white rounded-xl py-4">

✖ Annuler

</button>

</form>

</div>

</div>

</div>

</div>

</div>
<script>

function badgeClass(status){

    switch(status){

        case "En attente":
            return "bg-yellow-100 text-yellow-700";

        case "En cours":
            return "bg-blue-100 text-blue-700";

        case "Terminé":
            return "bg-green-100 text-green-700";

        case "Annulé":
            return "bg-red-100 text-red-700";

        default:
            return "bg-slate-100 text-slate-700";
    }

}

function formatNumero(numero){

    numero = String(numero).replace(/\D/g,'');

    return numero.padStart(2,'0');

}

function refreshDashboard(){

    fetch("{{ route('responsable.realtime') }}")

    .then(response => response.json())

    .then(data => {

        document.getElementById("waitingCount").textContent = data.waitingCount;
        document.getElementById("processingCount").textContent = data.processingCount;
        document.getElementById("finishedCount").textContent = data.finishedCount;
        document.getElementById("cancelledCount").textContent = data.cancelledCount;

        const current = document.getElementById("current-ticket");
        const currentName = document.getElementById("current-name");

        if(data.currentTicket){

            current.textContent = formatNumero(data.currentTicket.numero);
            currentName.textContent = data.currentTicket.nom_client ?? "-";

        }else{

            current.textContent = "--";
            currentName.textContent = "Aucun ticket appelé";

        }

        let html = "";

        if(data.queue.length === 0){

            html = `
                <tr>
                    <td colspan="4" class="py-10 text-center text-slate-400">
                        Aucun ticket
                    </td>
                </tr>
            `;

        }else{

            data.queue.forEach(ticket => {

                html += `
                <tr class="border-t hover:bg-slate-50 transition">

                    <td class="p-4 font-bold text-blue-700">
                        ${formatNumero(ticket.numero)}
                    </td>

                    <td>
                        ${ticket.nom_client ?? "-"}
                    </td>

                    <td>
                        ${ticket.telephone_client ?? "-"}
                    </td>

                    <td>
                        <span class="px-3 py-1 rounded-full text-xs font-bold ${badgeClass(ticket.statut)}">
                            ${ticket.statut}
                        </span>
                    </td>

                </tr>
                `;

            });

        }

        document.getElementById("queue-body").innerHTML = html;

    })

    .catch(error => console.log(error));

}

refreshDashboard();

setInterval(refreshDashboard,3000);

</script>
@endsection