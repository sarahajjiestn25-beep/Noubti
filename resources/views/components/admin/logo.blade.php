<a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">

    <img 
        src="{{ $appConfig?->logo ? asset('storage/' . $appConfig->logo) : asset('images/logo.png') }}" 
        alt="{{ $appConfig?->nom_app ?? 'Noubti' }} Logo"
        class="h-10 w-10 object-contain"

    <div class="flex flex-col leading-tight">
        <span class="text-lg font-bold text-slate-900">
            {{ $appConfig?->nom_app ?? 'Noubti' }}
        </span>

        <span class="text-xs text-indigo-600">
            QUEUEFLOW
        </span>
    </div>

</a>
