<x-guest-layout>

    <div class="login-card">

        {{-- Logo + Brand --}}
        <div class="brand">

            <img
                src="{{ $appConfig?->logo ? asset('storage/' . $appConfig->logo) : asset('images/logo.png') }}"
                alt="{{ $appConfig?->nom_app ?? 'Noubti' }} Logo"
                class="brand-logo"
            >

            <div class="brand-name">
                {{ $appConfig?->nom_app ?? 'Noubti' }}
            </div>

            <div class="brand-app">
                QUEUEFLOW
            </div>

        </div>


        {{-- Title --}}
        <h1 class="page-title">
            Connexion
        </h1>

        <p class="page-subtitle">
            Connectez-vous à votre compte {{ $appConfig?->nom_app ?? 'QueueFlow' }}
        </p>


        {{-- Session Status --}}
        @if (session('status'))
            <div class="general-error" style="color:#166534;background:#f0fdf4;border-color:#bbf7d0;">
                {{ session('status') }}
            </div>
        @endif


        {{-- Login Errors --}}
        @if ($errors->any())
            <div class="general-error">
                {{ $errors->first() }}
            </div>
        @endif


        {{-- Login Form --}}
        <form method="POST" action="{{ route('login') }}">

            @csrf


            {{-- Email --}}
            <div class="form-group">

                <label
                    for="email"
                    class="form-label"
                >
                    Email
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-input"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="admin@queueflow.com"
                >

                @error('email')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            {{-- Password --}}
            <div class="form-group">

                <label
                    for="password"
                    class="form-label"
                >
                    Mot de passe
                </label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    class="form-input"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••••"
                >

                @error('password')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            {{-- Remember Me --}}
            <label class="remember">

                <input
                    type="checkbox"
                    name="remember"
                    id="remember"
                >

                <span>
                    Se souvenir de moi
                </span>

            </label>


            {{-- Submit --}}
            <button
                type="submit"
                class="login-button"
            >
                Se connecter
            </button>

        </form>


        {{-- Footer --}}
        <div class="footer">
            © {{ date('Y') }} {{ $appConfig?->nom_app ?? 'Noubti' }} - QueueFlow
        </div>

    </div>

</x-guest-layout>