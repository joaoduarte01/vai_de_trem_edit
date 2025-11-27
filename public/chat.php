<?php
require_once('../assets/config/auth.php');
require_once('../assets/config/db.php');

// Enviar mensagem
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
  $msg = trim($_POST['message']);
  if ($msg) {
    $stmt = $mysqli->prepare("INSERT INTO chat_messages (user_id, message) VALUES (?, ?)");
    $stmt->bind_param('is', $user['id'], $msg);
    $stmt->execute();
  }
  exit; // AJAX não recarrega a página
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Chat - Vai de Trem</title>

  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
  <link href="../assets/css/styles.css" rel="stylesheet">

</head>

<body>

  <!-- HEADER -->
  <div class="chat-header">
    <img src="../assets/images/notificacao_icone.png" alt="Chat" class="icon-img" style="width:22px;height:22px;">
    <h1>Chat de Suporte</h1>
  </div>

  <!-- CHAT AREA -->
  <div class="chat-box" id="chatBox"></div>

  <div class="typing" id="typingIndicator">
    Suporte está digitando...
  </div>

  <!-- INPUT -->
  <form class="chat-input-area" id="chatForm">
    <input class="input" id="chatMessage" name="message" placeholder="Digite sua mensagem..." required>
    <button class="send-btn"><img src="../assets/images/notificacao_icone.png" alt="Enviar" class="icon-img"
        style="width:24px;height:24px;filter: brightness(0) invert(1);"></button>
  </form>

  <!-- ONLINE USERS -->
  <div class="online-box">
    <h3 style="font-size:16px;margin-bottom:10px;">Usuários Online</h3>

    <div class="online-user"><span class="online-dot"></span>Administrador</div>
    <div class="online-user"><span class="online-dot"></span>Central de Controle</div>
    <div class="online-user"><span class="online-dot"></span>Operações</div>

    <small style="color:#6b7280;display:block;margin-top:6px;">* Lista ilustrativa</small>
  </div>

  <!-- NAVIGATION -->
  <div class="bottom-nav">
    <a href="dashboard.php" class="active">
      <img src="../assets/images/inicio_png.png" alt="Início" class="icon-img"
        style="width:24px;height:24px;margin-bottom:4px;">
      <span>Início</span>
    </a>

    <a href="rotas.php">
      <img src="../assets/images/rotas_icone.png" alt="Rotas" class="icon-img"
        style="width:24px;height:24px;margin-bottom:4px;">
      <span>Rotas</span>
    </a>

    <a href="chat.php">
      <img src="../assets/images/notificacao_icone.png" alt="Chat" class="icon-img"
        style="width:24px;height:24px;margin-bottom:4px;">
      <span>Chat</span>
    </a>

    <a href="funcionarios.php">
      <img src="../assets/images/icones_funcionarios.png" alt="Funcionários" class="icon-img"
        style="width:24px;height:24px;margin-bottom:4px;">
      <span>Funcionários</span>
    </a>

    <a href="logout_admin.php">
      <img src="../assets/images/logout_icone.png" alt="Sair" class="icon-img"
        style="width:24px;height:24px;margin-bottom:4px;">
      <span>Sair</span>
    </a>
  </div>

  <script>
    // Scroll automático
    function scrollChat() {
      const box = document.getElementById("chatBox");
      box.scrollTop = box.scrollHeight;
    }

    // Buscar mensagens (AJAX)
    function loadMessages() {
      fetch("chat_loader.php")
        .then(r => r.text())
        .then(html => {
          document.getElementById("chatBox").innerHTML = html;
          scrollChat();
        });
    }
    setInterval(loadMessages, 3000);
    loadMessages();

    // Enviar mensagem AJAX
    document.getElementById("chatForm").addEventListener("submit", async function (e) {
      e.preventDefault();

      let msg = document.getElementById("chatMessage").value.trim();
      if (!msg) return;

      let formData = new FormData();
      formData.append("message", msg);

      document.getElementById("typingIndicator").style.display = "block";

      await fetch("chat.php", {
        method: "POST",
        body: formData
      });

      document.getElementById("chatMessage").value = "";
      document.getElementById("typingIndicator").style.display = "none";

      loadMessages();
    });
  </script>

</body>

</html>