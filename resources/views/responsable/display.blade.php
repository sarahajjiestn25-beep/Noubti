```blade
@extends('layouts.app')

@section('title','Écran d\'affichage')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-blue-700 via-blue-800 to-slate-900 text-white flex flex-col">

<div class="py-8 text-center">

<img src="{{ asset('images/logo.png') }}"
class="w-28 h-28 rounded-full object-cover mx-auto shadow-2xl border-4 border-white">

<h1 class="text-5xl font-black mt-6">

{{ $service->nom_service }}

</h1>

<p class="text-blue-100 mt-3 text-xl">

Ticket actuellement appelé

</p>

</div>

<div class="flex-1 flex items-center justify-center">

@if($currentTicket)

<div class="text-center">

<div id="current-ticket"

class="text-[180px] font-black leading-none">

{{ str_pad((int)preg_replace('/[^0-9]/','',$currentTicket->numero),2,'0',STR_PAD_LEFT) }}

</div>

<p id="current-name"

class="text-4xl mt-6 font-semibold">

{{ $currentTicket->nom_client }}

</p>

</div>

@else

<div class="text-center">

<div id="current-ticket"

class="text-[180px] font-black">

--

</div>

<p id="current-name"

class="text-3xl mt-6">

Aucun ticket

</p>

</div>

@endif

</div>

<div class="bg-white text-slate-800 p-8">

<h2 class="text-3xl font-bold mb-8">

Tickets suivants

</h2>

<div id="next-tickets"

class="grid grid-cols-5 gap-5">

@foreach($nextTickets as $ticket)

<div class="bg-slate-100 rounded-2xl shadow p-6 text-center">

<div class="text-4xl font-bold">

{{ str_pad((int)preg_replace('/[^0-9]/','',$ticket->numero),2,'0',STR_PAD_LEFT) }}

</div>

</div>

@endforeach

</div>

</div>

<script>

function refreshDisplay(){

fetch("{{ route('responsable.realtime') }}")

.then(r=>r.json())

.then(data=>{

const current=document.getElementById("current-ticket");

const name=document.getElementById("current-name");

if(data.currentTicket){

current.innerHTML=String(data.currentTicket.numero).padStart(2,'0');

name.innerHTML=data.currentTicket.nom_client;

}else{

current.innerHTML="--";

name.innerHTML="Aucun ticket";

}

let html="";

data.queue

.filter(t=>t.statut==="En attente")

.slice(0,5)

.forEach(ticket=>{

html+=`

<div class="bg-slate-100 rounded-2xl shadow p-6 text-center">

<div class="text-4xl font-bold">

${String(ticket.numero).padStart(2,'0')}

</div>

</div>

`;

});

document.getElementById("next-tickets").innerHTML=html;

});

}

refreshDisplay();

setInterval(refreshDisplay,3000);

</script>

@endsection
```
