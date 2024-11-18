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
    <form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ request('token') }}">

    <label for="password">Nova Senha:</label>
    <input type="password" name="password" required>

    <label for="password_confirmation">Confirme a Nova Senha:</label>
    <input type="password" name="password_confirmation" required>

    <button type="submit" class="button">Redefinir Senha</button>
</form>
    </div>
</body>
</html>
