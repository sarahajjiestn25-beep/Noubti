<x-guest-layout>

    <div class="mb-8">

        <h2 class="text-3xl font-bold text-slate-800">
            Connexion
        </h2>

        <p class="text-slate-500 mt-2">
            Accédez à votre espace d’administration
        </p>

    </div>

    @if (session('status'))
        <div class="mb-4 text-green-600 text-sm">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- EMAIL -->
        <div class="mb-5">
            <label class="block mb-2 text-sm font-medium text-slate-700">
                Adresse Email
            </label>

            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-slate-500 focus:outline-none"
            >

            @error('email')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- PASSWORD -->
        <div class="mb-5">
            <label class="block mb-2 text-sm font-medium text-slate-700">
                Mot de passe
            </label>

            <input
                type="password"
                name="password"
                required
                class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-slate-500 focus:outline-none"
            >

            @error('password')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- REMEMBER -->
        <div class="flex justify-between items-center mb-6">

            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="remember">
                Se souvenir
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-sm text-slate-500 hover:text-slate-800">
                    Mot de passe oublié ?
                </a>
            @endif

        </div>

        <!-- BUTTON -->
        <button
            type="submit"
            class="w-full bg-slate-900 hover:bg-black text-white py-3 rounded-xl font-semibold transition duration-200"
        >
            Se connecter
        </button>

    </form>

    <div class="mt-8 text-center text-sm text-slate-400">
        QueueFlow © 2026
    </div>

</x-guest-layout>