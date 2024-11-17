// Abre o modal
document.getElementById('openModalBtn').addEventListener('click', function() {
    document.getElementById('modal').style.display = 'flex';
});

// Fecha o modal ao clicar no botão de cancelar
document.getElementById('cancelBtn').addEventListener('click', function() {
    document.getElementById('modal').style.display = 'none';
});

// Fecha o modal ao clicar fora do conteúdo
window.onclick = function(event) {
    const modal = document.getElementById('modal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
};

// Função para exibir a imagem selecionada
document.getElementById('imagemCampanha').addEventListener('change', function(event) {
    const imagePreview = document.getElementById('image-preview');
    const file = event.target.files[0];
    const reader = new FileReader();

    if (file) {
        reader.readAsDataURL(file);
    }

    reader.onload = function(e) {
        const img = document.createElement('img');
        img.src = e.target.result;
        imagePreview.innerHTML = ''; // Limpa o preview anterior
        imagePreview.appendChild(img); // Adiciona a imagem selecionada
    };
});

// Envio do formulário via Fetch API
document.getElementById('campanhaForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Previne o envio padrão do formulário

    const formData = new FormData(this);
    const imageInput = document.getElementById('imagemCampanha');

    if (imageInput.files.length > 0) {
        formData.append('imagemCampanha', imageInput.files[0]);
    }

    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => {
        if (response.ok) {
            // Recarrega a página após o envio bem-sucedido
            location.reload();
        } else {
            throw new Error('Erro no envio da campanha.');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
    });
});
