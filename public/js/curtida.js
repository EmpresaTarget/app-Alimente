document.addEventListener("DOMContentLoaded", function () {
    function likeButton(event) {
        const heartImage = event.target;
        const postId = heartImage.getAttribute('data-post-id');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const likesCountElement = heartImage.closest('.card-postagem').querySelector('.likes');

        fetch(`/curtir-postagem/${postId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Já curtiu') {
                console.log("Usuário já curtiu esta postagem.");
                return;
            }

            // Atualiza o coração para vermelho e exibe a nova contagem de curtidas
            heartImage.src = "/img/coracao-vermelho.png"; // O coração permanece vermelho
            likesCountElement.textContent = `${data.curtidas} curtidas`;
        })
        .catch(error => console.error('Erro ao curtir postagem:', error));
    }

    // Vincula o evento de clique a cada elemento com a classe 'heart'
    document.querySelectorAll('.heart').forEach(heartImage => {
        heartImage.addEventListener('click', likeButton);
        
        // Verifique se o usuário já curtiu a postagem e mantenha o coração vermelho
        const postId = heartImage.getAttribute('data-post-id');
        
        fetch(`/verificar-curtida/${postId}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.jaCurtiu) {
                heartImage.src = "/img/coracao-vermelho.png"; // Mantém o coração vermelho
            }
        });
    });
});
