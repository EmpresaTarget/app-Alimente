<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Recuperação de Senha</title>
</head>
<body>
<p>Olá,</p>
<p>Recebemos uma solicitação para redefinir sua senha. Clique no link abaixo para continuar:</p>
<a href="{{ route('password.reset', ['token' => $code]) }}">Redefinir Senha</a>
<p>Se você não solicitou essa ação, ignore este e-mail.</p>
</body>
</html>
