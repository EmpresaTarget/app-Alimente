<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar | Alimente</title>

    <link rel="stylesheet" href="/css/autenticacao.css">
    <link rel="shortcut icon" href="/img/icon.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand" rel="stylesheet">
</head>
<body>
    <div class="container">
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <h3>Código</h3>
        <label for="code">Código de confirmação:</label>
        <div class="code-inputs">
            <input type="text" maxlength="1" class="code" autofocus required>
            <input type="text" maxlength="1" class="code" required>
            <input type="text" maxlength="1" class="code" required>
            <input type="text" maxlength="1" class="code" required>
        </div>
        <input type="hidden" name="code" id="full_code">
        <button class="button" type="submit">Verificar</button>
    </form>
</div>
</body>
</html>
