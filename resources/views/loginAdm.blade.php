<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador | Alimente</title>

    <link rel="stylesheet" href="/css/loginAdm.css">

    <!--icon-->
    <link rel="shortcut icon" href="/img/icon.png" type="image/x-icon">

    <!--Fonte-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand" rel="stylesheet">
</head>
    <body>
        <div class="container">
            @if ($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf
                <h3>Olá, Administrador!</h3>

                <label for="">Email:</label>
                <input type="email" name="email" id="email">

                <label for="">Senha:</label>
                <div class="password-container">
                    <input type="password" name="password" id="password">
                    <span class="toggle-password" onclick="togglePasswordVisibility()">
                        <!-- Ícone de Olho em SVG -->
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5z" stroke="#333" stroke-width="2"/>
                            <circle cx="12" cy="12" r="3" fill="none" stroke="#333" stroke-width="2"/>
                        </svg>
                    </span>
                </div>

                <input type="submit" class="button" value="Entrar">
            </form>
        </div>

        <script>
            function togglePasswordVisibility() {
                var passwordField = document.getElementById("password");
                passwordField.type = passwordField.type === "password" ? "text" : "password";
            }
        </script>
    </body>
</html>
