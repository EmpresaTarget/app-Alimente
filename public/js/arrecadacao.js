let valoresSelecionados = {}; // Objeto para armazenar os valores selecionados por postagem

// Função que será chamada quando o usuário clicar em um botão de valor
function selectValue(button) {
    let valor = parseFloat(button.textContent.replace("R$", "").replace(",", ".").trim());
    const modal = document.getElementById('pixModal');
    const postId = modal.getAttribute('data-post-id');
    console.log(postId); // Verifica o postId
    console.log(valor);
    
    // Verifica se esse valor já foi adicionado para essa postagem
    if (valoresSelecionados[postId] && valoresSelecionados[postId] === valor) {
        // Se o valor já foi adicionado, remove ele
        valoresSelecionados[postId] = 0;
        button.classList.remove('selected'); // Retira a classe 'selected' para mostrar que o valor foi removido
        atualizarArrecadacao(postId, 0);
    } else {
        // Se não, adiciona o valor ao total da postagem
        valoresSelecionados[postId] = valor;
        button.classList.add('selected'); // Adiciona uma classe para mostrar que o valor foi selecionado
        atualizarArrecadacao(postId, valor);
    }
}

// Função para atualizar o total arrecadado da ONG
function atualizarArrecadacao(postId, valor) {
    // Buscar o modal correspondente ao postId
    const modal = document.querySelector(`#pixModal[data-post-id="${postId}"]`);
    
    if (!modal) {
        console.log(`Erro: Modal com postId ${postId} não encontrado.`);
        return;
    }

    // Obter o ID da ONG do modal
    let ongId = modal.getAttribute('data-ong-id'); // ID da ONG associada ao modal
    
    // Verifique se o 'ongId' foi encontrado
    if (!ongId) {
        console.log("Erro: ONG ID não encontrado.");
        return;
    }

    // Enviar o valor para o servidor para atualizar a arrecadação (via AJAX ou fetch)
    fetch(`/atualizar-arrecadacao`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Garantir o CSRF token se necessário
        },
        body: JSON.stringify({
            ongId: ongId,
            valor: valor
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log("Total arrecadado atualizado com sucesso!");
        } else {
            console.log("Erro ao atualizar a arrecadação:", data.message);
        }
    })
    .catch(error => {
        console.log("Erro na requisição:", error);
    });
}
