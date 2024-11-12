$(document).ready(function() {
    $('#file').on('change', function() {
        const formData = new FormData($('#uploadForm')[0]);
        
        $.ajax({
            url: '/atualizar-foto', 
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Adicione o token CSRF
            },
            success: function(response) {
                if (response.fotoUrl) {
                    $('#photo').attr('src', response.fotoUrl);  // Atualiza a foto com a nova URL
                } else {
                    alert('Erro ao atualizar a foto.');
                }
            },
            error: function() {
                alert('Falha na solicitação. Tente novamente.');
            }
        });
    });
});
