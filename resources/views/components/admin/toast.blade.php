@if (session()->has('success') || session()->has('error'))
    <div id="toast-notification" class="fixed bottom-5 right-5 z-50 max-w-md transition-all duration-300">

        @if (session()->has('success'))
            <div class="flex items-center gap-3 rounded-xl bg-slate-900 p-4 text-white shadow-xl ring-1 ring-white/10 dark:bg-slate-800">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-emerald-500/20 text-emerald-400">
                    <x-admin.icon name="check" class="h-5 w-5" />
                </div>

                <p class="text-sm font-medium">
                    {{ session('success') }}
                </p>

                <button
                    type="button"
                    onclick="document.getElementById('toast-notification').remove()"
                    class="ml-auto text-slate-400 hover:text-white"
                >
                    <x-admin.icon name="x" class="h-4 w-4" />
                </button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="flex items-center gap-3 rounded-xl bg-slate-900 p-4 text-white shadow-xl ring-1 ring-white/10 dark:bg-slate-800">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-rose-500/20 text-rose-400">
                    <x-admin.icon name="x" class="h-5 w-5" />
                </div>

                <p class="text-sm font-medium">
                    {{ session('error') }}
                </p>

                <button
                    type="button"
                    onclick="document.getElementById('toast-notification').remove()"
                    class="ml-auto text-slate-400 hover:text-white"
                >
                    <x-admin.icon name="x" class="h-4 w-4" />
                </button>
            </div>
        @endif

    </div>
@endif