@php
    $config = $appConfig ?? \App\Models\Configuration::first();

    $appName = $config?->nom_app ?? 'Noubti';

    $logoUrl = $config?->logo
        ? asset('storage/' . $config->logo)
        : asset('images/logo.png');
@endphp

<a href="{{ url('/') }}" class="inline-flex items-center gap-3">

    <img
        src="{{ $logoUrl }}"
        alt="{{ $appName }}"
        {{ $attributes->merge([
            'class' => 'object-contain'
        ]) }}
    >

    @if($showName ?? true)
        <span class="font-bold">
            {{ $appName }}
        </span>
    @endif

</a>