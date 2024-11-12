$(document).ready(function(){
    let originalData = {
        nomeDoador: $("#nomeDoador").val(),
        nomeUsuarioDoador: $("#nomeUsuarioDoador").val(),
        emailDoador: $("#emailDoador").val(),
        biografiaDoador: $("#biografiaDoador").val(),
    };

    // Botão "Cancelar": restaura os dados originais
    $(".btn-cancel").click(function(){
        $("#nomeDoador").val(originalData.nomeDoador);
        $("#nomeUsuarioDoador").val(originalData.nomeUsuarioDoador);
        $("#emailDoador").val(originalData.emailDoador);
        $("#biografiaDoador").val(originalData.biografiaDoador);
    });

    // Botão "Salvar": envia os dados para o backend e exibe a confirmação
    $(".btn-save").click(function(event){
        event.preventDefault();
        let formData = new FormData(document.getElementById("doadorForm"));
        $.ajax({
            url: "/doador/perfil/atualizar", // URL do backend para atualizar perfil
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Token CSRF
            },
            success: function(response){
                $("#confirmationModal").show();
                // Atualiza os dados originais após salvar com sucesso
                originalData = {
                    nomeDoador: $("#nomeDoador").val(),
                    nomeUsuarioDoador: $("#nomeUsuarioDoador").val(),
                    emailDoador: $("#emailDoador").val(),
                    biografiaDoador: $("#biografiaDoador").val(),
                };
            },
            error: function(xhr){
                alert("Erro ao salvar as alterações. Tente novamente.");
            }
        });
    });
    $("#closeModal").click(function() {
        $("#confirmationModal").hide();
        location.reload();
    });
});
