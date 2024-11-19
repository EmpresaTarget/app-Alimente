<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Doador | Alimente</title>

    <link rel="stylesheet" href="/css/doadorPerfil.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
    $(document).ready(function(){
        // Esconde a tela de Configurações inicialmente
        $(".account-settings").hide();

        // Exibe a seção de "Conta" e oculta a de "Configurações"
        $("#accountLink").click(function(event){
            event.preventDefault();
            $(".account").show();
            $(".account-settings").hide();
            $('.menu-link').removeClass('active');
            $(this).addClass('active');
        });

        // Exibe a seção de "Configurações" e oculta a de "Conta"
        $("#configLink").click(function(event){
            event.preventDefault();
            $(".account").hide();
            $(".account-settings").show();
            $('.menu-link').removeClass('active');
            $(this).addClass('active');
        });

        // Alternar a classe "active" para os links ao clicar
        $(".menu-link").click(function(event){
            event.preventDefault();
            $(".menu-link").removeClass("active");
            $(this).addClass("active");
        });

        // Remover o estilo azul do first-child quando for clicado em outra página
        $("ul li a").click(function() {
            $("ul li a:first-child").removeClass("active");
        });

        $(".hamburguer").click(function(){
            $(".wrapper").toggleClass("collapse");
        });

        // Modal de confirmação
        $(".btn-save").click(function(event){
            event.preventDefault(); // Previne o comportamento padrão do botão
            $("#confirmationModal").show(); // Exibe o modal
        });

        // Fecha o modal ao clicar no botão "Fechar"
        $("#closeModal").click(function(){
            $("#confirmationModal").hide();
        });

        $("#cancelLogout").click(function() {
        $("#logoutModal").hide(); // Esconde o modal de logout
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
        </div>
    </div>

    <div class="sidebar">
        <ul>
            <li><a href="feedDoador">
                <span class="icon"><i class="fa-solid fa-house"></i></span>
                <span class="title">Início</span>
            </a></li>

            <li><a href="/perfilDoador">
                <span class="icon"><i class="fa-solid fa-user"></i></span>
                <span class="title">Perfil</span>
            </a></li>

            <li><a href="/geolocalizacao">
                <span class="icon"><i class="fa-solid fa-location-dot"></i></span>
                <span class="title">Buscar</span>
            </a></li>
        </ul>
    </div>

    <!-- Modal de Confirmação de Logout -->
    <div id="logoutModal" class="modal">
    <div class="modal-content">
        <p>Deseja mesmo sair da sessão?</p>
        <div class="modal-buttons">
            <form action="{{ route('logout') }}" method="POST" id="logoutForm" style="display: inline;">
                @csrf
                <button type="submit" class="confirm-button">Confirmar</button>
            </form>
            <button id="cancelLogout">Não</button>
        </div>
    </div>
</div>


    <div class="container">
        <!-- Seção de Perfil -->
        <div class="profile">
            <div class="profile-header">
            <div class="user-img">
            <img src="{{ asset('storage/' . $doador->fotoDoador) }}" id="photo" class="profile-img">
            <input type="file" name="fotoDoador" id="file" accept="image/*" style="display: none;" onchange="uploadPhoto()">
            <label for="file" id="uploadbtn"><i class="fas fa-camera"></i></label>
            </div>
                <div class="profile-text-container">
                    <h1 class="profle-title">{{$doador->nomeUsuarioDoador}}</h1>
                    <p class="profile-email">{{$doador->emailDoador}}</p>
                    <p class="status">Doador</p>
                </div>
            </div>
            
            <div class="menu">
                <a href="#" class="menu-link" id="accountLink">
                    <i class="fa-solid fa-circle-user menu-icon"></i> Conta
                </a>
                <a href="#" id="configLink" class="menu-link">
                    <i class="fa-solid fa-gear menu-icon"></i> Configurações
                </a>
                <a href="#" class="menu-link" id="logoutLink">
                    <i class="fa-solid fa-right-from-bracket menu-icon"></i> Logout
                </a>
            </div>
        </div>

        
        <!-- Tela de Configurações de Conta (visível inicialmente) -->
        <form class="account" id="doadorForm" method="POST" action="{{ route('doador.atualizarPerfil') }}">
    @csrf
    <div class="account-header">
        <h1 class="account-tittle">Informações de conta</h1>
        <div class="btn-container">
            <button type="button" class="btn-cancel">Cancelar</button>
            <button type="submit" class="btn-save">Salvar</button>
        </div>
    </div>

    <div class="account-edit">
        <div class="input-container">
            <label>Nome:</label>
            <input type="text" id="nomeDoador" name="nomeDoador" value="{{$doador->nomeDoador}}">
        </div>
        <div class="input-container">
            <label>Nome de usuário:</label>
            <input type="text" id="nomeUsuarioDoador" name="nomeUsuarioDoador" value="{{$doador->nomeUsuarioDoador}}">
        </div>
        <div class="input-container">
            <label>Email:</label>
            <input type="email" id="emailDoador" name="emailDoador" value="{{$doador->emailDoador}}">
        </div>
    </div>

    <div class="account-edit">
        <div class="input-container">
            <label>Bio:</label>
            <textarea id="biografiaDoador" name="biografiaDoador">{{$doador->biografiaDoador}}</textarea>
        </div>
    </div>

</form>

        <!-- Modal de Confirmação -->
        <div id="confirmationModal" class="modal-perfil" style="display:none;">
            <div class="modal-content-perfil">
                <p>Perfil editado com sucesso!</p>
                <button id="closeModal" class="close-modal-perfil">Fechar</button>
            </div>
        </div>

        <div id="modal-confirmacao" class="modal" style="display:none;">
        <div class="modal-content">
            <p>Tem certeza de que deseja excluir sua conta?</p>
            <button id="cancelar-exclusao">Cancelar</button>
            <button id="confirmar-exclusao">Confirmar</button>
        </div>
    </div>

        <!-- Tela de Configurações (inicialmente oculta) -->
        <form class="account-settings">
            <div class="account-header">
                <h1 class="account-tittle">Configurações</h1>
            </div>

            <div class="account-edit">
                <div class="input-container">
                    <label>Excluir Conta:</label>
                    <p class="warning-text">Ao excluir sua conta, todos os seus dados serão permanentemente removidos. Esta ação não pode ser desfeita.</p>
                    <button class="btn-excluir">Excluir Conta</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="/js/perfilDoador.js"></script>
<script src="/js/logoutDoador.js"></script>
<script src="/js/atualizarDoador.js"></script>
<script src="/js/atualizarFotoDoador.js"></script>

<script>
        // Exibe o modal de confirmação
        $('#btn-excluir-conta').click(function(){
            $('#modal-confirmacao').show();
        });

        // Fecha o modal ao cancelar
        $('#cancelar-exclusao').click(function(){
            $('#modal-confirmacao').hide();
        });

        // Exclui a conta (a ação de exclusão pode ser implementada aqui)
        $('#confirmar-exclusao').click(function(){
            alert('Conta excluída!');
            $('#modal-confirmacao').hide();
        });
    </script>
</body>
</html>
