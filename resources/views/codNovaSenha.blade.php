<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperação de Senha | Alimente</title>
    <link rel="stylesheet" href="/css/autenticacao.css">

    <!-- Ícone -->
    <link rel="shortcut icon" href="/img/icon.png" type="image/x-icon">

    <!-- Fonte -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand" rel="stylesheet">
</head>
<body>
    <div class="container">
    <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <h3>Recuperação de Senha</h3>

            <!-- Mensagem de sucesso -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Mensagem de erro -->
            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first('email') }}
                </div>
            @endif

            <label for="email">Digite seu E-mail:</label>
            <input type="email" name="email" required>

            <button type="submit" class="enviar">Enviar</button>
        </form>
    </div>
</body>
</html>
