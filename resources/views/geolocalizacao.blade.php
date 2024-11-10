<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doador | Alimente</title>
    <link rel="stylesheet" href="/css/doador.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand" rel="stylesheet">

    
   <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
   <style>
        /* Estilos da Navbar */
        .wrapper {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .top_navbar {
            width: 100%;
            height: 60px;
            display: flex;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background-color: #ffffff;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
        }

        .top_navbar .hamburguer {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 70px;
            background-color: #2e8b57;
            padding: 10px;
            border-top-right-radius: 20px;
            cursor: pointer;
        }

        .top_navbar .hamburguer div {
            width: 30px;
            height: 4px;
            background: #8fbc8f;
            margin: 5px 0;
            border-radius: 5px;
        }

        .top_menu {
            width: calc(100% - 70px);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 10px;
        }

        .sidebar {
            position: fixed;
            top: 60px; /* Abaixo da navbar */
            left: 0;
            width: 200px; /* Largura da sidebar */
            height: calc(100% - 60px);
            background: #f8f9fa;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            padding: 10px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 10px 0;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #333;
            display: flex;
            align-items: center;
        }

        .sidebar ul li .icon {
            margin-right: 10px;
        }

        /* Outros estilos já existentes */
        #map {
            height: 400px;
            width: calc(100% - 220px); /* Considerando a sidebar */
            margin-left: 210px; /* Margem para a sidebar */
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .info-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
            justify-content: flex-start; /* Alinha os cards à esquerda */
            padding: 5px;
            max-width: calc(100% - 320px); /* Considerando a sidebar */
            margin-left: 320px; /* Margem para a sidebar */
        }

        /* Card Individual */
        .info-card {
            background: linear-gradient(135deg, #4f7942, #2c5f2d);
            color: #fff;
            border-radius: 15px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 300px;
            text-align: center;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        h1 {
            font-size: 1.8rem;
            color: #4f7942;
            text-align: center;
            margin-top: 15px;
            margin-bottom: 15px;
            font-family: 'Quicksand', sans-serif;
            letter-spacing: 1px;
        }
    </style>
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
            <li>
                <form action="{{ route('logout') }}" method="POST" id="logoutForm" style="display: inline;">
            @csrf
           <button type="button" href="/logindoador" class="logout-button">
                <i class="fa-solid fa-right-from-bracket menu-icon"></i> Logout
            </button>
        </form></li>
        </div>
    </div>

    <div class="sidebar">
        <ul>
            <li><a href="#">
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

    <h1>Localização Atual e ONGs</h1>
    <div id="map"></div>
    <!-- Modal de Confirmação de Logout -->
<div id="logoutModal" class="modal-logout" style="display: none;">
    <div class="modal-content-logout">
        <h3>Confirmar Logout</h3>
        <p>Você tem certeza de que deseja sair?</p>
        <form action="{{ route('logout') }}" method="POST" id="logoutForm" style="display: inline;">
            @csrf
            <button type="submit" class="confirm-button">Confirmar</button>
        </form>
        <button type="button" onclick="closeLogoutModal()" class="cancel-button">Cancelar</button>
    </div>
</div>

<!-- API do Google Maps -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8YyZUk2tSHm0ON3oPDGWKogkEepg2e00&callback=initMap" async defer></script>
<script>
    let map;
    let userMarker;
    const ongs = [
        { nome: "Amigos da Paz", latitude: -23.561414, longitude: -46.656856, descricao: "Doações para animais" },
        { nome: "Refazendo Histórias", latitude: -23.563312, longitude: -46.660212, descricao: "Proteção infantil" },
    ];

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: -23.5505, lng: -46.6333 },
            zoom: 12
        });

        // Obtendo a localização do usuário
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                const userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                // Marcando a localização do usuário
                userMarker = new google.maps.Marker({
                    position: userLocation,
                    map: map,
                    title: "Sua localização",
                    icon: 'https://maps.google.com/mapfiles/ms/icons/blue-dot.png'
                });

                // Centralizando o mapa na localização do usuário
                map.setCenter(userLocation);

                // Adicionando marcadores das ONGs
                colocarMarcadores(ongs);
            }, () => {
                alert("Não foi possível obter a sua localização.");
            });
        } else {
            alert("Geolocalização não é suportada pelo seu navegador.");
        }
    }

    function colocarMarcadores(ongs) {
        ongs.forEach(ong => {
            const marker = new google.maps.Marker({
                position: { lat: ong.latitude, lng: ong.longitude },
                map: map,
                title: ong.nome,
                icon: 'https://maps.google.com/mapfiles/ms/icons/green-dot.png'
            });

            const infoWindow = new google.maps.InfoWindow({
                content: `<h3>${ong.nome}</h3><p>${ong.descricao}</p>`
            });

            marker.addListener('click', () => {
                infoWindow.open(map, marker);
            });
        });
    }
</script>
<div class="info-cards">
    <div class="info-card">
        <div class="card-icon"><i class="fa-solid fa-question"></i></div>
        <h3>Como Utilizar</h3>
        <p class="card-content">Aprenda a navegar pelo mapa, localizar informações e utilizar as funções de busca de forma intuitiva e eficaz.</p>
        <div class="card-content-hover">Este mapa é fácil de usar! Para começar, escolha sua região de interesse para encontrar locais específicos. Explore as ferramentas de zoom e filtro para ajustar a visualização conforme sua necessidade.</div>
    </div>
    <div class="info-card">
        <div class="card-icon"><i class="fa-solid fa-circle-exclamation"></i></div>
        <h3>Funcionalidades</h3>
        <p class="card-content">Conheça as principais funcionalidades do sistema, como filtros personalizados e visualizações avançadas.</p>
        <div class="card-content-hover">Aproveite filtros para ajustar resultados de acordo com sua localização e preferências. Com visualizações personalizáveis e atualizações em tempo real, você encontra o que precisa de forma rápida e precisa.</div>
    </div>
    <div class="info-card">
        <div class="card-icon"><i class="fa-solid fa-star"></i></div>
        <h3>Dicas Úteis</h3>
        <p class="card-content">Receba dicas de uso para aproveitar ao máximo o sistema de localização e otimizar sua experiência.</p>
        <div class="card-content-hover">Dica Pro: use o modo de visualização em tela cheia para uma experiência mais imersiva! Se precisar de ajuda, consulte nossa seção de FAQ ou entre em contato com o suporte.</div>
    </div>
</div>
</div>
</body>
</html>
