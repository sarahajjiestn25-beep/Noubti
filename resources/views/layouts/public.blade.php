<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Noubti')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            font-family:'Poppins',sans-serif;
            background:#eef4ff;
        }

        .hero{
            background:linear-gradient(135deg,#2563eb,#1d4ed8,#1e40af);
        }

        .glass{
            background:white;
            border-radius:30px;
            box-shadow:0 25px 60px rgba(0,0,0,.12);
        }

        .card{
            background:#fff;
            border-radius:20px;
            transition:.3s;
            box-shadow:0 10px 25px rgba(0,0,0,.08);
        }

        .card:hover{
            transform:translateY(-5px);
        }

        .input{
            width:100%;
            padding:15px 18px;
            border:1px solid #dbe4f0;
            border-radius:14px;
            outline:none;
            transition:.25s;
        }

        .input:focus{
            border-color:#2563eb;
            box-shadow:0 0 0 4px rgba(37,99,235,.15);
        }

        .btn-primary{
            width:100%;
            background:#2563eb;
            color:white;
            padding:16px;
            border-radius:14px;
            font-weight:600;
            transition:.25s;
        }

        .btn-primary:hover{
            background:#1d4ed8;
        }

        .feature-icon{
            width:65px;
            height:65px;
            border-radius:18px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:28px;
        }
    </style>

</head>

<body>

@yield('content')

</body>

</html>