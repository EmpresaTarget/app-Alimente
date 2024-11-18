<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador | Alimente</title>
    <link rel="stylesheet" href="/css/adm.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

    <div class="row">
        @foreach($prestacoes as $prestacao)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $prestacao->ong->nomeOng }}</h5> 
                        <p class="card-text">A ONG <span>{{ $prestacao->ong->nomeOng }}</span> fez sua prestação de contas na data <b>{{$prestacao->created_at->format('d/m/Y') }}</b>.</p>
                        <p class="card-text"><strong>Status:</strong> Em dia!</p>
                        <button 
                        class="buttonP" 
                        data-bs-toggle="modal" 
                        data-bs-target="#prestacaoModal" 
                        data-fotos="{{ json_encode([$prestacao->foto1, $prestacao->foto2, $prestacao->foto3, $prestacao->foto4, $prestacao->foto5]) }}"
                        data-balanco="{{ $prestacao->balanco }}"
                        data-demonstracao="{{ $prestacao->demonstracao }}"
                        data-receitas="{{ $prestacao->receitas }}"
                        data-despesas="{{ $prestacao->despesas }}">
                        Ver prestação
                        </button>
                    </div>
                    
                </div>
            </div>
        @endforeach
    </div>

<!-- Modal -->
<div class="modal fade" id="prestacaoModal" tabindex="-1" aria-labelledby="prestacaoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="prestacaoModalLabel">Prestação de Contas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="background-color: #fff;"></button>
            </div>
            <div class="modal-body">
            <h4>Receitas da Campanha</h4>
                <!-- Imagens principais (balanco, demonstracao, receitas, despesas) -->
                <div id="modal-principais-fotos" class="row mb-3">
                    <div class="col-3">
                        <img id="balanco-img" src="" class="img-fluid img-thumbnail" alt="Balanço">
                    </div>
                    <div class="col-3">
                        <img id="demonstracao-img" src="" class="img-fluid img-thumbnail" alt="Demonstração">
                    </div>
                    <div class="col-3">
                        <img id="receitas-img" src="" class="img-fluid img-thumbnail" alt="Receitas">
                    </div>
                    <div class="col-4">
                        <img id="despesas-img" src="" class="img-fluid img-thumbnail" alt="Despesas">
                    </div>
                </div>

                <h4>Fotos tiradas durante o andamento da campanha</h4>
                <!-- Fotos adicionais (foto1, foto2, foto3, foto4, foto5) -->
                <div id="modal-fotos-container" class="row">
                    
                    <!-- As imagens serão inseridas aqui dinamicamente -->
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const prestacaoModal = document.getElementById('prestacaoModal');
    const fotosContainer = document.getElementById('modal-fotos-container');
    const balancoImg = document.getElementById('balanco-img');
    const demonstracaoImg = document.getElementById('demonstracao-img');
    const receitasImg = document.getElementById('receitas-img');
    const despesasImg = document.getElementById('despesas-img');

    prestacaoModal.addEventListener('show.bs.modal', (event) => {
        const button = event.relatedTarget;
        const fotos = JSON.parse(button.getAttribute('data-fotos'));
        const modalDialog = prestacaoModal.querySelector('.modal-dialog');
        modalDialog.style.width = '90%';
        console.log('Fotos recebidas:', fotos);

        // Limpar o conteúdo anterior
        fotosContainer.innerHTML = '';
        balancoImg.src = ''; 
        demonstracaoImg.src = '';
        receitasImg.src = '';
        despesasImg.src = '';

        // Preencher as imagens principais (balanço, demonstracao, receitas, despesas)
        balancoImg.src = `/storage/${button.getAttribute('data-balanco')}`;
        demonstracaoImg.src = `/storage/${button.getAttribute('data-demonstracao')}`;
        receitasImg.src = `/storage/${button.getAttribute('data-receitas')}`;
        despesasImg.src = `/storage/${button.getAttribute('data-despesas')}`;

        // Preencher as 5 fotos adicionais
        fotos.forEach(foto => {
            if (foto) {
                const colDiv = document.createElement('div');
                colDiv.className = 'col-md-2 mb-3 b-3';
                colDiv.innerHTML = `<img src="/storage/${foto}" class="img-fluid img-thumbnail" alt="Prestação de contas">`;
                fotosContainer.appendChild(colDiv);
            }
        });
    });
});

</script>
</body>
</html>
