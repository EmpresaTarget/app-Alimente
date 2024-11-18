// Obter referências ao modal e seus elementos
var postModal = document.getElementById("postModal");
var postBtn = document.getElementById("openPostModalBtn");
var postSpan = document.getElementsByClassName("post-close")[0];
var postUploadInput = document.getElementById('postUploadImage');
var imagePreview = document.getElementById('imagePreview');
var postTextarea = document.getElementById('postDescription');
var hashtagsContainer = document.getElementById('hashtagsContainer'); // Container para exibir as hashtags

// Array para armazenar as hashtags separadamente
let hashtags = [];

// Abrir o modal
postBtn.onclick = function() {
  postModal.style.display = "block";
}

// Fechar o modal
postSpan.onclick = function() {
  postModal.style.display = "none";
}

// Fechar o modal clicando fora dele
window.onclick = function(event) {
  if (event.target === postModal) {
    postModal.style.display = "none";
  }
}

// Exibir a imagem no quadrado ao selecionar um arquivo
postUploadInput.addEventListener('change', function() {
  var file = this.files[0];
  if (file) {
    var reader = new FileReader();
    reader.onload = function(e) {
      imagePreview.innerHTML = '<img src="' + e.target.result + '" alt="Image Preview">';
    }
    reader.readAsDataURL(file);
  }
});

// Função para adicionar hashtags sem exibir na textarea
function insertHashtag(hashtag) {
  // Verificar se a hashtag já foi adicionada
  if (!hashtags.includes(hashtag)) {
    hashtags.push(hashtag); // Adiciona ao array de hashtags
    displayHashtags(); // Atualiza a exibição das hashtags
  }
}

// Função para exibir as hashtags no container
function displayHashtags() {
  hashtagsContainer.innerHTML = hashtags.map(tag => `#${tag}`).join(' ');
}

// Listener para os botões de hashtags
document.querySelectorAll('.hashtag-btn').forEach(function(button) {
  button.addEventListener('click', function() {
    var hashtag = this.getAttribute('data-hashtag');
    insertHashtag(hashtag);
  });
});

// Botão de cancelar
document.querySelector('.post-cancel-btn').onclick = function() {
  postModal.style.display = "none";
  postTextarea.value = ''; // Limpar a textarea ao cancelar
  imagePreview.innerHTML = ''; // Limpar a pré-visualização da imagem
  hashtags = []; // Limpar o array de hashtags
  displayHashtags(); // Limpar a exibição das hashtags
};

// Botão de enviar
// Botão de enviar
document.querySelector('.post-send-btn').onclick = function() {
  var formData = new FormData();
  var conteudo = postTextarea.value.trim(); // Obter o valor do textarea e remover espaços em branco
  var idOng = document.getElementById('idOng').value; // Obter o ID da ONG
  var chavePix = document.getElementById('chavePix').value.trim();

  if (!conteudo) {
      alert('Por favor, insira um conteúdo para a postagem.');
      return;
  }

  formData.append('conteudo', conteudo);
  formData.append('hashtags', hashtags.join(', ')); // Adiciona as hashtags do array ao FormData
  formData.append('idOng', idOng); // Adiciona o ID da ONG ao FormData
  formData.append('chavePix', chavePix);

  var fileInput = document.getElementById('postUploadImage');
  if (fileInput.files[0]) {
      formData.append('imagem', fileInput.files[0]);
  }

  // Enviar a postagem via fetch
  fetch('/postagem', {
      method: 'POST',
      body: formData,
      headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Accept': 'application/json'
      }
  })
  .then(response => response.json()) // Extrair o JSON diretamente
  .then(data => {
    if (data.success) {
      // Fecha o modal
      postModal.style.display = "none";
      
      // Limpa os campos
      postTextarea.value = '';
      imagePreview.innerHTML = '';
      hashtags = [];
      displayHashtags();

      // Recarrega a página
      location.reload();
    } else {
      // Se o backend indicar falha, lança o erro com a mensagem do backend
      throw new Error(data.message || 'Erro desconhecido ao criar a postagem.');
    }
  })
  .catch(error => {
    console.error('Erro:', error);
    alert(error.message); // Mostra a mensagem de erro do backend (se houver)
  });
};

// Selecionar todos os botões de edição
document.querySelectorAll('.button-editar').forEach(button => {
  button.addEventListener('click', function () {
      const postId = this.getAttribute('data-id');
      const description = this.getAttribute('data-description');
      const chavePix = this.getAttribute('data-chave_pix'); // Pega a chave PIX
      document.getElementById('postDescription').value = description || '';
      document.getElementById('chavePix').value = chavePix || ''; // Preenche o campo chavePix no modal
      const image = this.getAttribute('data-image');
      const hashtagsData = this.getAttribute('data-hashtags');

      // Preencher os campos do modal com os dados da postagem
      document.getElementById('postDescription').value = description;

      // Exibir a imagem da postagem no preview
      const imagePreview = document.getElementById('imagePreview');
      if (image) {
          imagePreview.innerHTML = `<img src="${image}" alt="Image Preview">`;
      } else {
          imagePreview.innerHTML = '';
      }

      // Preencher as hashtags
      hashtags = hashtagsData ? hashtagsData.split(', ') : [];
      displayHashtags();

      // Abrir o modal
      postModal.style.display = "block";

      // Configurar o botão de envio para edição
      document.querySelector('.post-send-btn').onclick = function () {
          editarPostagem(postId);
      };
  });
});

function showSuccessModal() {
  const modal = document.getElementById('successModal-publi');
  modal.style.display = 'flex'; // Mostra o modal
  setTimeout(() => {
      modal.style.display = 'none'; // Oculta o modal após 900ms
  }, 900);
}

// Função para editar a postagem
function editarPostagem(postId) {
  const conteudo = postTextarea.value.trim();
  const chavePix = document.getElementById('chavePix').value.trim();

  if (!conteudo) {
      alert('Por favor, insira um conteúdo para a postagem.');
      return;
  }

  const data = {
      conteudo: conteudo,
      hashtags: hashtags.join(', '),
      chavePix: chavePix,
      idOng: document.getElementById('idOng').value,
  };

  fetch(`/postagem/${postId}`, {
      method: 'PUT',
      headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Accept': 'application/json',
          'Content-Type': 'application/json',
      },
      body: JSON.stringify(data),
  })
  .then(response => response.json())
  .then(data => {
      if (data.success) {
          showSuccessModal(); // Exibir o modal de sucesso
          postModal.style.display = 'none';
          postTextarea.value = '';
          imagePreview.innerHTML = '';
          hashtags = [];
          displayHashtags();
      } else {
          throw new Error(data.message || 'Erro ao editar a postagem.');
      }
  })
  .catch(error => {
      console.error('Erro:', error);
      alert(error.message);
  });
}

const btnExcluir = document.querySelectorAll('.button-excluir');
const modal = document.getElementById('modal-excluir');
const btnSim = document.getElementById('btn-sim');
const btnNao = document.getElementById('btn-nao');
let postagemId = null;

// Função para abrir o modal
btnExcluir.forEach(button => {
  button.addEventListener('click', function () {
    postagemId = this.getAttribute('data-postagem-id');
    modal.style.display = 'flex'; 
  });
});

// Fechar o modal ao clicar em "Não"
btnNao.addEventListener('click', function () {
  modal.style.display = 'none';
});

// Enviar a exclusão ao servidor ao clicar em "Sim"
btnSim.addEventListener('click', function () {
  if (postagemId) {
    fetch(`/postagens/${postagemId}/excluir`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          location.reload(); 
        } else {
          alert('Erro ao excluir a postagem.');
        }
        modal.style.display = 'none';
      })
      .catch(error => {
        console.error('Erro:', error);
        modal.style.display = 'none';
      });
  }
});
