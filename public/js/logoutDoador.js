document.addEventListener('DOMContentLoaded', function () {
    // Seleciona os elementos
    const logoutLink = document.getElementById('logoutLink');
    const logoutModal = document.getElementById('logoutModal');
    const confirmLogout = document.querySelector('.confirm-button'); // Form button
    const cancelLogout = document.getElementById('cancelLogout');

    // Mostra o modal ao clicar em "Logout"
    if (logoutLink) {
        logoutLink.addEventListener('click', function(event) {
            event.preventDefault(); // Evita a ação padrão do link
            logoutModal.style.display = 'flex'; // Exibe o modal
        });
    }

    // Ação para o botão "Confirmar" (formulário será enviado ao ser clicado)
    if (confirmLogout) {
        confirmLogout.addEventListener('click', function() {
            document.getElementById('logoutForm').submit(); // Submete o formulário
        });
    }

    // Ação para o botão "Não"
    if (cancelLogout) {
        cancelLogout.addEventListener('click', function() {
            logoutModal.style.display = 'none'; // Oculta o modal
        });
    }

    // Fecha o modal se clicar fora do conteúdo do modal
    window.addEventListener('click', function(event) {
        if (event.target === logoutModal) {
            logoutModal.style.display = 'none';
        }
    });
});
