@props([
    'class' => 'w-12 h-12 object-contain'
])

@if($appConfig?->logo)
    <img
        src="{{ asset('storage/' . $appConfig->logo) }}"
        alt="{{ $appConfig?->nom_app ?? 'Noubti' }}"
        class="{{ $class }}"
    >
@else
    <img
        src="{{ asset('images/logo.png') }}"
        alt="{{ $appConfig?->nom_app ?? 'Noubti' }}"
        class="{{ $class }}"
    >
@endif