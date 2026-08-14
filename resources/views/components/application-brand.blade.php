@php
    $config = $appConfig ?? \App\Models\Configuration::first();

    $appName = $config?->nom_app ?? 'Noubti';

    $logoUrl = $config?->logo
        ? asset('storage/' . $config->logo)
        : asset('images/logo.png');

    $imgClass = $attributes->get('class', 'object-contain');
@endphp

<a href="{{ url('/') }}" class="inline-flex items-center gap-3">

    <img
        src="{{ $logoUrl }}"
        alt="{{ $appName }}"
        class="{{ $imgClass }}"
    >

    @if($showName ?? true)
        <span class="font-bold">
            {{ $appName }}
        </span>
    @endif

</a>
