<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Alimente</title>

    <!-- Fonte -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Ícone -->
    <link rel="shortcut icon" href="/img/icon.png" type="image/x-icon">
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
        background: linear-gradient(to bottom, rgba(75, 216, 75, 0.5), rgba(54, 102, 235, 0.5));
        border-top-left-radius: 15%;
        border-bottom-left-radius: 15%;
    }
    .login-card {
        padding: 2rem;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 350px;
    }
    .login-btn {
        background: linear-gradient(to right, rgba(88,169,195,1) 0%, rgb(127, 223, 164) 100%);
        color: white;
        padding: 15px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        border: none;
    }
    form label {
        margin-bottom: 5px;
        font-weight: 600;
    }
    h3 {
        text-align: center;
        font-size: 1.5em;
        font-weight: 600;
    }
    .password-container {
        position: relative;
    }
    .password-container input {
        width: 100%;
        padding-right: 2.5rem; /* Espaço para o ícone de olho */
        border-radius: 10px;
        border: 1px solid #ccc;
        font-size: 1em;
    }
    .toggle-password {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #333;
    }
    .right-section img {
        max-width: 80%;
    }
    </style>
</head>
<body>
    <div class="left-section">
        <div class="login-card">
            <h3 class="text-center">Login</h3>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{ route('logindoador') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="seuemail@gmail.com" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Senha:</label>
                    <div class="password-container">
                        <input type="password" class="form-control" id="password" placeholder="Digite sua senha" name="password" required>
                        <span class="toggle-password" onclick="togglePasswordVisibility()">
                            <!-- Ícone de Olho em SVG -->
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5z" stroke="#333" stroke-width="2"/>
                                <circle cx="12" cy="12" r="3" fill="none" stroke="#333" stroke-width="2"/>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="mb-3">
                    <a href="">Esqueceu a senha? Clique aqui para redefinir.</a>
                </div>
                <button type="submit" class="btn login-btn w-100">Login</button>
                <div class="mt-3 text-center">
                    <a href="/cadastrodoador" class="text-muted">Não possuo cadastro</a>
                </div>
            </form>
        </div>
    </div>
    <div class="right-section">
        <img src="/img/alimente.png" alt="Alimente - Gerando Solidariedade">
        <img src="/img/slogan-alimente-cinza.png" alt="Alimente - Gerando Solidariedade">
    </div>
    <script>
    function togglePasswordVisibility() {
        var passwordField = document.getElementById("password");
        passwordField.type = passwordField.type === "password" ? "text" : "password";
    }
    </script>
</body>
</html>
