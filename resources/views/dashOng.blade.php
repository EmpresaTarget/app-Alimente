<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ong | Alimente</title>

   <link rel="stylesheet" href="/css/feedOng.css">
   <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
   <!--<script src="https://code.jquery.com/jquery-3.4.1.js"></script>-->
    
    <script>
        $(document).ready(function(){
            $(".hamburguer").click(function(){
                $(".wrapper").toggleClass("collapse");
                
            });
            document.querySelector('.user').addEventListener('click', function() {
    const dropdownMenu = this.querySelector('.dropdown-menu');
    dropdownMenu.style.display = dropdownMenu.style.display === 'flex' ? 'none' : 'flex';
});

function showLogoutModal() {
        document.getElementById('logoutModal').style.display = 'flex';
    }

    function closeLogoutModal() {
        document.getElementById('logoutModal').style.display = 'none';
    }
        

        const buttons = document.querySelectorAll('.hashtag-btn');

        buttons.forEach(button => {
    button.addEventListener('click', function() {
        button.classList.add('clicked'); // Adiciona a classe 'clicked' ao botão
    });
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
                    <button type="button" onclick="showLogoutModal()" class="logout-button">
    <i class="fa-solid fa-right-from-bracket menu-icon"></i> Logout
</button>
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

                    <li><a href="/perfilOng">
                    <span class="icon"><i class="fa-solid fa-users"></i></span>
                    <span class="title">Perfil</span>
                    </a></li>

                    <li><a href="/prestarContaOng">
                    <span class="icon"><i class="fa-solid fa-file-invoice-dollar"></i></span>
                    <span class="title">Prestar Conta</span>
                    </a></li>
                </ul>
            </div>

            <div class="row-ola">
                <h3>Olá, {{$ong->nomeOng}} &#128075;</h3>
                <p>Bom te ver por aqui!</p>
            </div>
            
            <div class="main_container-dash">

            <div class="cards-dash">
                <div class="card-dash">
                    <div class="card-content">
                        <div class="number">{{$postagensCount}}</div>
                        <div class="card-name">Postagens</div>
                    </div>
                    <div class="icon-box">
                    <i class="fa-solid fa-camera"></i>
                    </div>
                </div>

                <div class="card-dash">
                    <div class="card-content">
                        <div class="number">{{$campanhasCount}}</div>
                        <div class="card-name">Campanhas</div>
                    </div>
                    <div class="icon-box">
                    <i class="fa-solid fa-box"></i>
                    </div>
                </div>
                
                <div class="card-dash">
                    <div class="card-content">
                        <div class="number">{{$totalCurtidas}}</div>
                        <div class="card-name">Bons feedbacks</div>
                    </div>
                    <div class="icon-box">
                    <i class="fa-solid fa-face-smile"></i>
                    </div>
                </div>

                <div class="card-dash">
                    <div class="card-content">
                        <div class="number">R$ {{$totalArrecadado}}</div>
                        <div class="card-name">Arrecadados</div>
                    </div>
                    <div class="icon-box">
                    <i class="fa-solid fa-dollar-sign"></i>
                    </div>
                </div>

                <div class="card-dash">
                    <div class="card-content">
                        <div class="number">{{ $porcentagemContasPrestadas }}%</div>
                        <div class="card-name">Contas prestadas</div>
                    </div>
                    <div class="icon-box">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                    </div>
                </div>

            </div><!--cards-dash-->

            <div class="charts">

                <div class="chart">
                    <h2>Doações Recebidas</h2>
                    <canvas id="lineChart" height="110"></canvas>
                </div><!--chart1-->

                <div class="chart2" id="doughnut-chart">
                    <h3>Andamento das Campanhas</h3>
                    <canvas id="doughnut"></canvas>
                </div><!--chart2-->

            </div>

    </div>

</div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>

    <script>
        // Obtendo os dados de doações por mês que foram passados do PHP para o JavaScript
var doacoesPorMes = @json($doacoesPorMes);
var doacoesData = Array(12).fill(0); // Inicializando um array com 0 para 12 meses

// Preenchendo os dados de doações por mês
doacoesPorMes.forEach(function(doacao) {
    doacoesData[doacao.mes - 1] = doacao.total_doacoes;
});

// Configurando o gráfico com os dados dinâmicos
const ctx = document.getElementById('lineChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
        datasets: [{
            label: 'Contagem de Doações por Mês',
            data: doacoesData,
            backgroundColor: 'rgba(45, 91, 151, 2)',
            borderColor: 'rgba(45, 91, 151, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true
    }
});

    </script>

    <script>
           const ctx2 = document.getElementById('doughnut').getContext('2d');

new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['Em Andamento', 'Finalizadas'],
        datasets: [{
            label: '# of Votes',
            data: [{{ $campanhasEmAndamentoCount }}, {{ $campanhasFinalizadasCount }}],  // Injetando os dados do PHP
            borderWidth: 1,
            backgroundColor: [
                'rgb(39, 122, 185)',
                'rgb(32,178,170)',
            ],
            borderColor: [
                'rgb(240, 240, 240)',
                'rgb(240, 240, 240)',
            ]
        }]
    },
    options: {
    responsive: true,
    maintainAspectRatio: false,
    cutout: '50%', // Já define a área interna do gráfico
    layout: {
        padding: {
            top: 10, // Reduz espaçamento superior
            bottom: 10 // Reduz espaçamento inferior
        }
    },
    plugins: {
        legend: {
            position: 'top',
        },
    }
}

});
    </script>

    </body>
    </html>