function uploadPhoto() {
    const formData = new FormData();
    const fileInput = document.getElementById('file');
    formData.append('fotoDoador', fileInput.files[0]);

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('/atualizar-foto', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) throw new Error('Erro na resposta do servidor');
        return response.json();
    })
    .then(data => {
        if (data.success) {
            document.getElementById('photo').src = data.newImageUrl;
        }
    })
    .catch(error => console.error('Erro:', error));
}
