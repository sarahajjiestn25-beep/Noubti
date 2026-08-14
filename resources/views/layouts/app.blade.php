<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', $appConfig?->nom_app ?? 'Noubti')
    </title>

    <style>
        :root {
            --primary-color: {{ $appConfig?->couleur_primaire ?? '#1A73E8' }};
            --secondary-color: {{ $appConfig?->couleur_secondaire ?? '#34A853' }};
            --app-primary: {{ $appConfig?->couleur_primaire ?? '#1A73E8' }};
            --app-secondary: {{ $appConfig?->couleur_secondaire ?? '#34A853' }};
        }
    </style>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >

</head>

<body class="bg-slate-100 font-[Poppins]">

    @yield('content')

    @if(session('success'))

        <div
            id="toast-success"
            class="fixed top-6 right-6 z-50 bg-green-600 text-white px-6 py-4 rounded-2xl shadow-2xl"
        >
            {{ session('success') }}
        </div>

    @endif

    @if(session('error'))

        <div
            id="toast-error"
            class="fixed top-6 right-6 z-50 bg-red-600 text-white px-6 py-4 rounded-2xl shadow-2xl"
        >
            {{ session('error') }}
        </div>

    @endif

    <script>

        document.addEventListener("DOMContentLoaded", () => {

            const success = document.getElementById("toast-success");
            const error = document.getElementById("toast-error");

            if (success) {
                setTimeout(() => {
                    success.classList.add(
                        "opacity-0",
                        "translate-x-10",
                        "transition",
                        "duration-500"
                    );

                    setTimeout(() => success.remove(), 500);

                }, 3000);
            }

            if (error) {
                setTimeout(() => {
                    error.classList.add(
                        "opacity-0",
                        "translate-x-10",
                        "transition",
                        "duration-500"
                    );

                    setTimeout(() => error.remove(), 500);

                }, 3000);
            }

            document.querySelectorAll("form").forEach(form => {

                form.addEventListener("submit", function () {

                    const btn = this.querySelector(
                        "button[type='submit'], button:not([type])"
                    );

                    if (!btn) return;

                    btn.disabled = true;

                    btn.classList.add(
                        "opacity-70",
                        "cursor-not-allowed"
                    );

                    btn.innerHTML = `
                        <div class="flex items-center justify-center gap-2">

                            <svg
                                class="animate-spin h-5 w-5"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4">
                                </circle>

                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                                </path>
                            </svg>

                            Chargement...

                        </div>
                    `;

                });

            });

        });

    </script>

</body>

</html>