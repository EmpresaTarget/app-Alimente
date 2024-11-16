function selectValue(button) {
    // Remover a classe 'selected' de todos os botões
    const buttons = document.querySelectorAll('.value-button');
    buttons.forEach(btn => btn.classList.remove('selected'));

    // Adicionar a classe 'selected' ao botão clicado
    button.classList.add('selected');

    // Obter o valor selecionado
    let valor = parseFloat(button.textContent.replace("R$", "").replace(",", ".").trim());

    // Obter os IDs do modal
    const modal = document.getElementById('pixModal');
    const postId = modal.getAttribute('data-post-id');
    const ongId = modal.getAttribute('data-ong-id');

    // Registrar doação no servidor
    registrarDoacao(ongId, valor);
}

function registrarDoacao(ongId, valor) {
    // Obter a data atual
    const dataAtual = new Date();
    const mes = dataAtual.getMonth() + 1; // JavaScript retorna meses de 0 a 11
    const ano = dataAtual.getFullYear();

    // Enviar os dados da doação para o servidor
    fetch(`/registrar-doacao`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            ongId: ongId,
            valor: valor,
            mes: mes,
            ano: ano
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log("Doação registrada com sucesso!");
        } else {
            console.log("Erro ao registrar doação:", data.message);
        }
    })
    .catch(error => {
        console.log("Erro na requisição:", error);
    });
}
