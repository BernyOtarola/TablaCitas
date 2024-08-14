<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clínica Dental</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F2F2F2;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #03A6A6;
        }

        .navbar-brand {
            color: #fff;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .navbar-brand img {
            height: 60px;
            margin-left: 10px;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        h1 {
            color: #03A6A6;
            text-align: center;
            margin-bottom: 30px;
        }

        .btn-primary {
            background-color: #03A6A6;
            border-color: #03A6A6;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #ACD90B;
            border-color: #ACD90B;
        }

        footer {
            background-color: #7D868C;
            color: #fff;
            padding: 10px 0;
            position: absolute;
            bottom: 0;
            width: 100%;
            text-align: center;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="{{ url('/') }}">
            Clínica Dental
            <img src="{{ asset('images/Logo4.png') }}" alt="Logo">
        </a>
    </nav>
    <div class="container">
        @yield('content')
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let timeout;

        function resetTimer() {
            clearTimeout(timeout);
            timeout = setTimeout(logoutUser, 3 * 60 * 1000); // 3 minutos en milisegundos
        }

        function logoutUser() {
            window.location.href = "{{ route('citas.showLoginForm') }}";
        }

        window.onload = resetTimer;
        document.onmousemove = resetTimer;
        document.onkeypress = resetTimer;
    </script>

    @yield('scripts')
</body>

</html>