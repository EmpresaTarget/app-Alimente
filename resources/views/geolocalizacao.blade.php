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

        /* Outros estilos já existentes */
        #map {
            height: 400px;
            width: calc(100% - 560px); /* Considerando a sidebar */
            margin-left: 210px; /* Margem para a sidebar */
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            margin-top: 60px;
            margin-right: 55px;
        }

        .info-cards {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
            justify-content: flex-start; /* Alinha os cards à esquerda */
            padding: 5px;
            max-width: calc(100% - 210px); /* Considerando a sidebar */
            margin-left: 210px; /* Margem para a sidebar */
        }

        /* Card Individual */
.info-card {
    background-color: #fff;
    color: #333;
    border-radius: 15px;
    padding: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 250px;
    text-align: center;
    position: relative;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Título verde */
.card-header {
    background-color: #4f7942; /* Verde */
    color: #fff;
    padding: 10px;
    border-radius: 10px;
    margin-bottom: 10px;
}

.card-header h3 {
    margin: 0;
    font-size: 1.2em;
}

/* Conteúdo do card */
.card-content {
    padding: 10px;
}

/* Link "Ler mais" */
.read-more {
    text-decoration: none;
    color: #4f7942; /* Verde */
    font-weight: bold;
    font-size: 1.1em;
}

.read-more i {
    margin-left: 5px;
}

/* Efeito hover para o link */
.read-more:hover {
    color: #2c5f2d; /* Verde mais escuro */
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
            <li><a href="/feedDoador">
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

    <div class="content-wrapper">
    <div class="left-section">
        <div id="map"></div>
        <div class="info-cards">
            <div class="info-card">
                <div class="card-header">
                    <h3>Como Utilizar</h3>
                </div>
                <div class="card-content">
                    <a href="#" class="read-more">Ler mais <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="info-card">
                <div class="card-header">
                    <h3>Funcionalidades</h3>
                </div>
                <div class="card-content">
                    <a href="#" class="read-more">Ler mais <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="info-card">
                <div class="card-header">
                    <h3>Dicas Úteis</h3>
                </div>
                <div class="card-content">
                    <a href="#" class="read-more">Ler mais <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="right-section">
        <div class="container-right">
            <p>...</p>
        </div>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8YyZUk2tSHm0ON3oPDGWKogkEepg2e00&callback=initMap" async defer></script>
    <script>
        let map;
        let userMarker;

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

                    const doadorMarkerIcon = {
                        url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                            <svg width="40" height="40" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="20" cy="20" r="5" fill="#4285F4" />
                                <circle cx="20" cy="20" r="15" fill="none" stroke="#4285F4" stroke-width="4" opacity="0.3" />
                            </svg>
                        `),
                        scaledSize: new google.maps.Size(40, 40),
                        anchor: new google.maps.Point(20, 20)
                    };

                    userMarker = new google.maps.Marker({
                        position: userLocation,
                        map: map,
                        title: "Sua localização",
                        icon: doadorMarkerIcon
                    });

                    map.setCenter(userLocation);
                    carregarOngsProximas();
                }, () => {
                    alert("Não foi possível obter a sua localização.");
                });
            } else {
                alert("Geolocalização não é suportada pelo seu navegador.");
            }
        }

        function carregarOngsProximas() {
    $.getJSON('{{ route("mapa.ongs_proximas") }}', function(data) {
        const container = document.querySelector('.container-right');
        container.innerHTML = ''; // Limpa o container antes de preencher

        const markers = {}; // Para armazenar os marcadores por ID ou nome

        data.forEach(ong => {
            // Criando um marcador no mapa
            const ongMarkerIcon = {
                url: "/img/marcador.png", // URL do ícone
                scaledSize: new google.maps.Size(40, 50),
                anchor: new google.maps.Point(25, 25),
            };

            const marker = new google.maps.Marker({
                position: { lat: ong.latitude, lng: ong.longitude },
                map: map,
                icon: ongMarkerIcon
            });

            markers[ong.nome] = marker; // Associa o marcador ao nome da ONG

            // Adicionando conteúdo ao mini card
            const miniCard = document.createElement('div');
            miniCard.classList.add('mini-card-geo');

            miniCard.innerHTML = `
                <img src="${ong.foto}" alt="Foto de ${ong.nome}">
                <h4>${ong.nome}</h4>
                <p>perto a você</p>
            `;

            // Adicionando evento para centralizar o mapa no marcador ao clicar no card
            miniCard.addEventListener('click', () => {
                const ongMarker = markers[ong.nome];
                if (ongMarker) {
                    map.setCenter(ongMarker.getPosition());
                    map.setZoom(14); // Ajuste o nível de zoom conforme necessário
                }
            });

            container.appendChild(miniCard);

            // Informações do marcador no mapa
            const contentString = `
                <div class="info-window-content">
                    <img src="${ong.foto}" alt="Foto de ${ong.nome}">
                    <h3>${ong.nome}</h3>
                    <p>${ong.biografia}</p>
                </div>
            `;

            const infoWindow = new google.maps.InfoWindow({
                content: contentString
            });

            marker.addListener('click', () => {
                infoWindow.open(map, marker);
            });
        });
    }).fail(function() {
        alert("Não foi possível carregar as ONGs.");
    });
}

    </script>

</div><!--wrapper-->
</body>
</html>
