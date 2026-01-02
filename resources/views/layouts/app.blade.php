<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Genki Food & Drink')</title>
    
    <!-- External JS & CSS -->
    <script src="/_sdk/data_sdk.js"></script>
    <script src="/_sdk/element_sdk.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Link to custom CSS (This should be in public/css/styles.css) -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <style>
        /* Global Styles */
        body {
            box-sizing: border-box;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box; 
        }

        html, body {
            height: 100%;
            width: 100%;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        }

        .card {
            background: #1e293b;
            border: 1px solid #334155;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
        }

        .btn {
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn:hover {
            transform: scale(1.02);
        }

        .btn:active {
            transform: scale(0.98);
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="gradient-bg h-full w-full">
    <!-- Main content -->
    <div id="app" class="w-full h-full">
        @yield('content')
    </div>

    <script>
    
    </script>
</body>
</html>
