<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ong | Alimente</title>
    
    <link rel="stylesheet" href="/css/prestarContaOng.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script>
        $(document).ready(function(){
            $(".hamburguer").click(function(){
                $(".wrapper").toggleClass("collapse");
            });
        });
    </script>

    <!--icon-->
    <link rel="shortcut icon" href="/img/icon.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!--Fonte-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand" rel="stylesheet">
</head>
<body>
<div class="wrapper">
    <div class="top_navbar">
        <div class="hamburguer">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="top_menu">
            <div class="logo">
                <img src="/img/alimente.png" alt="">
            </div>
            <div class="user">
            <img src="{{ asset('storage/uploads/' . $ong->fotoOng) }}" alt="Imagem da ONG" />
            <div class="dropdown-menu">
                    <a href="/perfilOng">
                    <i class="fa-solid fa-users"></i> Perfil
                    </a>
                    <a href="#logout">
                    <i class="fa-solid fa-right-from-bracket menu-icon"></i> Logout
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="sidebar">
        <ul>
        <li><a href="/dashOng">
                        <span class="icon"><i class="fa-solid fa-house"></i></span>
                        <span class="title">Início</span>
                    </a></li>

                    <li><a href="/feedOng">
                        <span class="icon"><i class="fa-solid fa-camera-retro"></i></span>
                        <span class="title">Seus Conteúdos</span>
                    </a></li>
            <li><a href="/perfilOng"><span class="icon"><i class="fa-solid fa-users"></i></span><span class="title">Perfil</span></a></li>
            <li><a href="/prestarContaOng"><span class="icon"><i class="fa-solid fa-file-invoice-dollar"></i></span><span class="title">Prestar Conta</span></a></li>
        </ul>
    </div>

    <div class="container">
        <div class="text">
            <h1>Prestação de Contas</h1>
            <p>A plataforma Alimente preza pela segurança de seus doadores e demais usuários, a prestação de contas tem como objetivo comprovar a veracidade de sua organização e nos deixar atualizados sobre as atividades da instituição. Em resposta a uma prestação de contas em dia, a organização recebe um SELO DE VERACIDADE e automáticamente a confiança do público, cumpra sua prestação e garanta sua permanência e veracidade na nossa rede!</p>
        </div>

        <div class="container-content">
            <div class="container-left">
            <form action="{{ route('prestar-conta.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<input type="hidden" name="idOng" value="{{ Auth::user()->idOng }}">

<div class="container-content">
    <div class="container-left">
        <h3>Movimentações:</h3>
        <label for="balanco">Balanço Patrimonial:</label>
        <div class="file-upload">
            <input type="file" name="balanco" id="balanco" required>
            <i class="fas fa-cloud-upload-alt"></i>
        </div>

        <label for="demonstracao">Demonstração de Resultados:</label>
        <div class="file-upload">
            <input type="file" name="demonstracao" id="demonstracao" required>
            <i class="fas fa-cloud-upload-alt"></i>
        </div>
    </div>

    <div class="container-right">
        <h3>Receitas e Despesas:</h3>
        <label for="receitas">Receitas Totais:</label>
        <div class="file-upload">
            <input type="file" name="receitas" id="receitas" required>
            <i class="fas fa-cloud-upload-alt"></i>
        </div>

        <label for="despesas">Despesas Totais:</label>
        <div class="file-upload">
            <input type="file" name="despesas" id="despesas" required>
            <i class="fas fa-cloud-upload-alt"></i>
        </div>
    </div>
    </div>

    <div class="container-fotos">
        <h3>Fotos tiradas referentes à instituição:</h3>
        <div class="row">
            @for ($i = 0; $i < 10; $i++)
                <div class="input-wrapper">
                    <input type="file" name="fotos[]" />
                    <i class="fas fa-cloud-upload-alt"></i>
                </div>
            @endfor
        </div>
    </div>

    <div class="buttons">
        <button type="submit" class="send">Enviar</button>
        <button type="reset" class="clear">Limpar</button>
    </div>
</form>

    </div><!--container-->
</div><!--wrapper-->
</body>
</html>
