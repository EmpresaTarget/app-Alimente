// Função para exibir a notificação
function showNotification() {
    document.getElementById("notification").classList.remove("hidden");
  }
  
  // Função para ocultar a notificação
  function hideNotification() {
    document.getElementById("notification").classList.add("hidden");
  }
  
  // Função para resetar o temporizador de inatividade
  function resetNotificationTimeout() {
    clearTimeout(notificationTimeout);
    notificationTimeout = setTimeout(showNotification, 60000); // 60 segundos de inatividade
  }
  
  // Configura a exibição da notificação após o carregamento da página e define os eventos de inatividade
  window.onload = function() {
    // Exibe a notificação 5 segundos após o carregamento da página
    setTimeout(showNotification, 5000);
    
    // Define o temporizador para inatividade
    resetNotificationTimeout();
    
    // Escuta eventos de atividade para resetar o tempo de inatividade
    document.addEventListener("mousemove", resetNotificationTimeout);
    document.addEventListener("keydown", resetNotificationTimeout);
  };
  