@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4 animate__animated animate__fadeIn">
        <div class="col-md-8">
            <h1 class="fw-bold text-custom-primary">Tableau de Bord : <span id="service-name">{{ $service->name }}</span></h1>
            <p class="text-muted">Gestion de la file d'attente en temps réel pour le préfixe <strong class="badge bg-dark">{{ $service->prefix }}</strong></p>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="card bg-white shadow-sm border-0 p-3">
                <small class="text-muted uppercase fw-bold">Tickets en attente</small>
                <h2 class="fw-bold text-danger id="waiting-count">0</h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5 mb-4">
            <div class="card shadow border-0 text-center style="border-radius: 15px;">
                <div class="card-header card-custom-header py-3 fw-bold uppercase tracking-wider" style="border-radius: 15px 15px 0 0;">
                    Ticket En Cours d'Appel
                </div>
                <div class="card-body py-5">
                    <div id="current-ticket-container">
                        <h1 class="display-1 fw-bold text-custom-primary mb-2" id="current-ticket-code">---</h1>
                        <h4 class="text-dark fw-semibold mb-1" id="current-client-name">Aucun client</h4>
                        <p class="text-muted small" id="current-client-phone">--</p>
                    </div>
                    
                    <div class="mt-4 d-grid gap-2">
                        <button id="btn-next" class="btn btn-custom-primary btn-lg fw-bold py-3 shadow-sm">
                            <i class="bi bi-bell-fill me-2"></i> Appeler le Suivant
                        </button>
                        <div class="row g-2 mt-1">
                            <div class="col-6">
                                <button id="btn-complete" class="btn btn-success w-100 fw-bold py-2" disabled>
                                    Terminer
                                </button>
                            </div>
                            <div class="col-6">
                                <button id="btn-cancel" class="btn btn-outline-danger w-100 fw-bold py-2" disabled>
                                    Annuler
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card shadow border-0" style="border-radius: 15px;">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark">File d'attente (Prochains Passages)</h5>
                </div>
                <div class="card-body p-0" style="max-height: 400px; overflow-y: auto;">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Code Ticket</th>
                                    <th>Nom du Client</th>
                                    <th>Heure d'Inscription</th>
                                    <th class="pe-4 text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody id="queue-table-body">
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Chargement de la file d'attente...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const serviceId = "{{ $service->id }}";
    let currentReservationId = null;

    // 1. Fonction li kat-jib l-guelba live (Fetch Queue Data)
    function fetchLiveQueue() {
        $.ajax({
            url: `/api/services/${serviceId}/queue`,
            method: 'GET',
            success: function(response) {
                // Mettre à jour le nombre total en attente
                $('#waiting-count').text(response.waiting_count);

                // Mettre à jour le ticket "En Cours"
                if (response.current) {
                    currentReservationId = response.current.id;
                    $('#current-ticket-code').text(response.current.ticket_code);
                    $('#current-client-name').text(response.current.client_name);
                    $('#current-client-phone').text(response.current.client_phone);
                    $('#btn-complete').prop('disabled', false);
                    $('#btn-cancel').prop('disabled', false);
                } else {
                    currentReservationId = null;
                    $('#current-ticket-code').text('---');
                    $('#current-client-name').text('Aucun client');
                    $('#current-client-phone').text('--');
                    $('#btn-complete').prop('disabled', true);
                    $('#btn-cancel').prop('disabled', true);
                }

                // Gérer la liste de la file d'attente
                let html = '';
                if (response.queue.length === 0) {
                    html = `<tr><td colspan="4" class="text-center py-4 text-muted">La file d'attente est vide.</td></tr>`;
                } else {
                    response.queue.forEach(function(item) {
                        let time = new Date(item.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                        html += `
                            <tr>
                                <td class="ps-4 fw-bold text-custom-primary">${item.ticket_code}</td>
                                <td>${item.client_name}</td>
                                <td>${time}</td>
                                <td class="pe-4 text-end">
                                    <span class="badge bg-warning text-dark">En attente</span>
                                </td>
                            </tr>
                        `;
                    });
                }
                $('#queue-table-body').html(html);
            }
        });
    }

    // Real-time Polling: nqraw les données kolla 3 secondes
    setInterval(fetchLiveQueue, 3000);
    $(document).ready(fetchLiveQueue);

    // 2. Action: Click 3la "Appeler le Suivant"
    $('#btn-next').click(function() {
        $(this).prop('disabled', true);
        $.ajax({
            url: `/api/services/${serviceId}/next`,
            method: 'POST',
            data: { _token: '{{ csrf_token() }}' },
            success: function(response) {
                fetchLiveQueue();
            },
            complete: function() {
                $('#btn-next').prop('disabled', false);
            }
        });
    });

    // 3. Action: Click 3la "Terminer" wla "Annuler"
    function updateStatus(status) {
        if (!currentReservationId) return;
        $.ajax({
            url: `/api/reservations/${currentReservationId}/status`,
            method: 'PUT',
            data: { 
                _token: '{{ csrf_token() }}',
                status: status 
            },
            success: function() {
                fetchLiveQueue();
            }
        });
    }

    $('#btn-complete').click(function() { updateStatus('Terminé'); });
    $('#btn-cancel').click(function() { updateStatus('Annulé'); });
</script>
@endsection