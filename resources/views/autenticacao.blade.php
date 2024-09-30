<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alteração | Alimente</title>

    <link rel="stylesheet" href="/css/autenticacao.css">

<!--icon-->
<link rel="shortcut icon" href="/img/icon.png" type="image/x-icon">

<!--Fonte-->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Quicksand" rel="stylesheet">
</head>
<body>
    <div class="container">

    <form action="" method="POST">
    @csrf
    <h3>Alteração de Senha</h3>

        <label for="password">Nova senha:</label>
        <input type="password" name="password" placeholder="Nova senha" requered>

        <label for="password_confirmation">Confirmar senha:</label>
        <input type="password" name="password_confirmation" placeholder="Confirmar senha" requered>

        <input class="button" type="submit" value="Concluir">
    </form>


    </div>
</body>
</html>