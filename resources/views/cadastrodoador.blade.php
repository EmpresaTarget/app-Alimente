<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro | Alimente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!--icon-->
    <link rel="shortcut icon" href="/img/icon.png" type="image/x-icon">

    <!--Fonte-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Quicksand', sans-serif;
        }
        body {
            height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: row;
            background-color: #fdfcfcc5;
        }
        .left-section, .right-section {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .left-section {
            background-color: #fdfcfcc5;
        }
        .right-section {
            background-color: rgba(46, 139, 87, 1);
            border-top-left-radius: 15%;
            border-bottom-left-radius: 15%;
            margin-left: 20px;
        }

        h3 {
            text-align: center;
            font-weight: 600;
            font-size: 1.3em;
        }

        .login-card {
            margin-top: 30px;
            margin-bottom: 30px;
            padding: 1rem;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-btn {
            background: rgba(46, 139, 87, 1);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .login-btn:hover {
            background: rgba(46, 139, 87, 0.6);
            color: white;
        }

        form input::placeholder {
            color: #aaa;
        }

        form label {
            margin-bottom: 5px;
            font-weight: 600;
        }

        form input, form select {
            margin-bottom: 8px;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 1rem;
            width: 100%;
        }

        form select {
            width: 100%;
        }

        .right-section img {
            max-width: 80%;
            object-fit: cover;
            object-position: center;
        }

        /* Estilos para o campo de senha e o ícone de olho */
        .password-container {
            position: relative;
        }
        .password-container input {
            width: 100%;
            padding-right: 30px; /* Deixa o espaço para o ícone de olho */
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="left-section">
        <div class="login-card">
            <h3 class="text-center mb-4">Preencha os Campos:</h3>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('doador.store') }}" method="POST">
            @csrf
                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label">Nome:</label>
                        <input type="text" class="form-control" name="nomeDoador" id="nomeDoador" placeholder="Digite seu nome" >
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label">Email:</label>
                        <input type="email" class="form-control" name="emailDoador" id="emailDoador" placeholder="Insira um email" >
                    </div>
                </div>

                <div class="row">
                    <div class="col mb-3">
                        <label class="form-label">Senha:</label>
                        <div class="password-container">
                            <input type="password" class="form-control" name="senhaDoador" id="senhaDoador" placeholder="Crie uma senha">
                            <span class="toggle-password" onclick="togglePasswordVisibility()">
                                <!-- Ícone de Olho em SVG -->
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5z" stroke="#333" stroke-width="2"/>
                                    <circle cx="12" cy="12" r="3" fill="none" stroke="#333" stroke-width="2"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <a href="/cadastroOng" id="linkCadastrarOng">Quero cadastrar minha Ong</a>
                </div>  
                <button type="submit" class="btn login-btn w-100">Próximo</button>
            </form>
        </div>
    </div>
    <div class="right-section">
        <img src="/img/normal.png" alt="">
    </div>

    <script>
        function togglePasswordVisibility() {
            var passwordField = document.getElementById("senhaDoador");
            passwordField.type = passwordField.type === "password" ? "text" : "password";
        }
    </script>
</body>
</html>
