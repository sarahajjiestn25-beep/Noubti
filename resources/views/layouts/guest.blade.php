<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Connexion - ' . ($appConfig?->nom_app ?? 'QueueFlow') }}</title>

    <style>
        :root {
            --app-primary: {{ $appConfig?->couleur_primaire ?? '#5146e5' }};
            --app-secondary: {{ $appConfig?->couleur_secondaire ?? '#4338ca' }};
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f7f9fc;
            color: #0f172a;
            min-height: 100vh;
        }

        .guest-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .login-card {
            width: 100%;
            max-width: 450px;
            background: #ffffff;
            border-radius: 16px;
            padding: 38px 40px;
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.08);
        }

        .brand {
            text-align: center;
            margin-bottom: 28px;
        }

        .brand-logo {
            width: 75px;
            height: 75px;
            object-fit: contain;
            margin-bottom: 12px;
        }

        .brand-name {
            font-size: 25px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 3px;
        }

        .brand-app {
            font-size: 14px;
            color: var(--app-primary);
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        .page-title {
            text-align: center;
            font-size: 27px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #111827;
        }

        .page-subtitle {
            text-align: center;
            color: #64748b;
            font-size: 15px;
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            height: 46px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            padding: 0 14px;
            font-size: 14px;
            color: #0f172a;
            background: #ffffff;
            outline: none;
            transition: 0.2s ease;
        }

        .form-input:focus {
            border-color: var(--app-primary);
            box-shadow: 0 0 0 3px rgba(81, 70, 229, 0.12);
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 9px;
            margin: 4px 0 24px;
            color: #64748b;
            font-size: 14px;
        }

        .remember input {
            width: 17px;
            height: 17px;
            accent-color: var(--app-primary);
            cursor: pointer;
        }

        .login-button {
            width: 100%;
            height: 46px;
            border: none;
            border-radius: 7px;
            background: var(--app-primary);
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .login-button:hover {
            background: var(--app-secondary);
        }

        .login-button:active {
            transform: translateY(1px);
        }

        .error-message {
            color: #dc2626;
            font-size: 13px;
            margin-top: 6px;
        }

        .general-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            padding: 10px 12px;
            border-radius: 7px;
            font-size: 13px;
            margin-bottom: 18px;
        }

        .footer {
            text-align: center;
            margin-top: 26px;
            font-size: 13px;
            color: #94a3b8;
        }

        @media (max-width: 520px) {
            .guest-page {
                padding: 20px;
            }

            .login-card {
                padding: 30px 24px;
            }
        }
    </style>
</head>

<body>

    <main class="guest-page">
        {{ $slot }}
    </main>

</body>
</html>