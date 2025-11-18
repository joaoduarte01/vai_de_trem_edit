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

<style>
body {
    background: #eef3fc;
    font-family: 'Poppins', sans-serif;
    padding-bottom: 90px;
}

/* ===== HEADER ===== */
.chat-header {
    background: var(--brand);
    color: #fff;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    border-radius: 0 0 18px 18px;
}
.chat-header h1 {
    font-size: 18px;
    font-weight: 600;
}

/* ===== CHAT CONTAINER ===== */
.chat-box {
    height: calc(100vh - 260px);
    overflow-y: auto;
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.msg {
    display: flex;
    max-width: 85%;
    gap: 8px;
}
.msg.me { margin-left: auto; flex-direction: row-reverse; }

/* Avatares */
.avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    object-fit: cover;
    box-shadow: 0 1px 4px rgba(0,0,0,0.15);
}

/* BOLHAS DE MENSAGEM */
.bubble {
    padding: 12px 14px;
    border-radius: 18px;
    font-size: 14px;
    line-height: 1.4;
    max-width: 100%;
}
.msg.me .bubble {
    background: var(--brand);
    color: #fff;
    border-bottom-right-radius: 6px;
}
.msg.other .bubble {
    background: #fff;
    color: #1e293b;
    border-bottom-left-radius: 6px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
}

.bubble small {
    font-size: 11px;
    opacity: 0.65;
    display: block;
    margin-top: 6px;
}

/* ===== TYPING INDICATOR ===== */
.typing {
    display: none;
    padding: 10px 20px;
    font-size: 13px;
    color: #64748b;
}

/* ===== INPUT ===== */
.chat-input-area {
    position: fixed;
    bottom: 70px;
    left: 0; right: 0;
    padding: 10px 14px;
    background: #fff;
    border-top: 1px solid var(--border);
    display: flex;
    gap: 8px;
}

.chat-input-area input {
    flex: 1;
    border-radius: 22px;
    padding: 12px 16px;
}

.send-btn {
    background: var(--brand);
    border: none;
    border-radius: 50%;
    width: 46px;
    height: 46px;
    color: #fff;
    font-size: 22px;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* ===== ONLINE USERS ===== */
.online-box {
    background: #fff;
    padding: 18px;
    border-radius: 14px;
    margin: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
}
.online-user {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 0;
}
.online-dot {
    width: 10px;
    height: 10px;
    background: #22c55e;
    border-radius: 50%;
}

/* NAV MOBILE */
.bottom-nav {
    position: fixed;
    bottom: 0; left: 0; right: 0;
    background: #fff;
    height: 70px;
    display: flex;
    justify-content: space-around;
    align-items: center;
    border-top: 1px solid var(--border);
    box-shadow: 0 -2px 10px rgba(0,0,0,0.08);
}
.bottom-nav a {
    color: var(--muted);
    text-align: center;
    font-size: 12px;
}
.bottom-nav a.active { color: var(--brand); }
</style>
</head>
<body>

<!-- HEADER -->
<div class="chat-header">
    <i class="ri-message-3-line"></i>
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
    <button class="send-btn"><i class="ri-send-plane-2-line"></i></button>
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
    <i class="ri-dashboard-line"></i>
    <span>Início</span>
  </a>

  <a href="rotas.php">
    <i class="ri-route-line"></i>
    <span>Rotas</span>
  </a>

  <a href="chat.php">
    <i class="ri-message-3-line"></i>
    <span>Chat</span>
  </a>

  <a href="funcionarios.php">
    <i class="ri-team-line"></i>
    <span>Funcionários</span>
  </a>

  <a href="logout_admin.php">
    <i class="ri-logout-box-r-line"></i>
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
document.getElementById("chatForm").addEventListener("submit", async function(e) {
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
