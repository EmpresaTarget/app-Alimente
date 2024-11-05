<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador | Alimente</title>
    <link rel="stylesheet" href="/css/adm.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand" rel="stylesheet">
</head>
<body>
<div class="sidebar">
    <header>
        <img src="/img/fotoAdm.png" alt="">
    </header>
    <ul>
        <li><a href="{{ route('admin.dashboard') }}"><i class="bi bi-columns-gap"></i> Dashboard</a></li>
        <li><a href="{{ route('admin.doadores') }}"><i class="bi bi-person"></i> Doadores</a></li>
        <li><a href="{{ route('admin.ongs') }}"><i class="bi bi-people"></i> Ongs</a></li>
        <li><a href="{{ route('prestacaoContaAdm') }}"><i class="bi bi-file-earmark-text"></i> Prestações de conta</a></li>
    </ul>
</div>

<div class="feed-dash">
    <div class="row center ong-header">
        <div class="col-6"><h2>Prestações de Conta</h2></div>
        <div class="col-6"><span>{{ $prestacoes->count() }} Prestações de conta</span></div>
    </div>

    <div class="nav-pesquisa ong-search">
        <form action="">
            <div class="input-field">
                <input placeholder="Pesquisar..." id="search-ong" class="search-ong" type="search">
                <i class="bi bi-search"></i>
            </div>
        </form>
    </div>

    <div class="row">
        @foreach($prestacoes as $prestacao)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="{{ asset('storage/' . $prestacao->fotos) }}" class="card-img-top" alt="Foto da ONG">
                    <div class="card-body">
                        <h5 class="card-title">{{ $prestacao->ong->nomeOng }}</h5> <!-- Nome da ONG -->
                        <p class="card-text">A ONG {{ $prestacao->ong->nomeOng }} fez sua prestação de contas.</p>
                        <p class="card-text"><strong>Status:</strong> Em dia!</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
</body>
</html>
