function showPixModal(postagemId) {
    // Encontrar o modal e a chave Pix da postagem
    const modal = document.getElementById('pixModal');
    const pixKey = modal.querySelector('#pixKey').innerText.trim();
    
    if (pixKey !== 'Chave Pix não disponível') {
        // Gerar a URL do QR Code com a chave Pix
        const qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?data=${pixKey}&size=200x200`;

        // Definir a chave Pix no modal
        document.getElementById('pixKey').innerText = pixKey;
        document.getElementById('qrcode').src = qrCodeUrl;
    } else {
        alert("Chave Pix não disponível para esta postagem.");
    }

    // Mostrar o modal
    modal.style.display = 'block';
}

function selectValue(button) {
    // Remove a classe "selected" de todos os botões
    document.querySelectorAll('.value-button').forEach(btn => btn.classList.remove('selected'));
    // Adiciona a classe "selected" ao botão clicado
    button.classList.add('selected');
}

function closeModal() {
    document.getElementById("pixModal").style.display = "none";
}

