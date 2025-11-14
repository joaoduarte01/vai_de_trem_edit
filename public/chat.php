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
    header('Location: chat.php');
    exit;
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
    background: #f1f5fb;
    font-family: 'Poppins', sans-serif;
    padding-bottom: 90px;
}

/* HEADER */
.chat-header {
    background: var(--brand);
    color: #fff;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    border-radius: 0 0 18px 18px;
}
.chat-header i {
    font-size: 22px;
}
.chat-header h1 {
    font-size: 18px;
    font-weight: 600;
}

/* CHAT AREA */
.chat-box {
    height: calc(100vh - 220px);
    overflow-y: auto;
    padding: 18px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.msg {
    display: flex;
    max-width: 75%;
}

.msg.other { justify-content: flex-start; }
.msg.me { justify-content: flex-end; }

.bubble {
    padding: 12px 14px;
    border-radius: 16px;
    font-size: 14px;
    line-height: 1.4;
    max-width: 100%;
    box-shadow: 0 1px 4px rgba(0,0,0,0.08);
}

.msg.other .bubble {
    background: #fff;
    color: #1e293b;
    border-bottom-left-radius: 4px;
}
.msg.me .bubble {
    background: var(--brand);
    color: #fff;
    border-bottom-right-radius: 4px;
}

.bubble small {
    display: block;
    margin-top: 6px;
    font-size: 11px;
    opacity: 0.7;
}

/* INPUT */
.chat-input-area {
    position: fixed;
    bottom: 70px;
    left: 0; right: 0;
    padding: 10px 12px;
    background: #fff;
    border-top: 1px solid var(--border);
    display: flex;
    gap: 8px;
}

.chat-input-area input {
    flex: 1;
    border-radius: 20px;
}

.send-btn {
    background: var(--brand);
    border: none;
    border-radius: 20px;
    padding: 0 16px;
    color: #fff;
    font-size: 20px;
}

/* Aviso */
.online-box {
    background: #fff;
    padding: 18px;
    border-radius: 14px;
    margin: 18px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
}
.online-box h2 {
    font-size: 16px;
    margin-bottom: 8px;
}
.online-user {
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}
.online-box small {
    color: #6b7280;
}

/* Bottom nav */
.bottom-nav {
    position: fixed;
    bottom: 0; left: 0; right: 0;
    background: #fff;
    height: 70px;
    display: flex; justify-content: space-around; align-items: center;
    border-top: 1px solid var(--border);
    box-shadow: 0 -2px 10px rgba(0,0,0,0.08);
}
.bottom-nav a {
    color: var(--muted);
    text-align: center;
    font-size: 12px;
    text-decoration: none;
}
.bottom-nav i {
    font-size: 24px;
}
.active {
    color: var(--brand) !important;
}
</style>
</head>
<body>

<!-- HEADER -->
<div class="chat-header">
    <i class="ri-message-3-line"></i>
    <h1>Chat de Suporte</h1>
</div>

<!-- CHAT -->
<div class="chat-box" id="chatBox">
    <?php
    $res = $mysqli->query("
        SELECT c.*, u.name, u.role 
        FROM chat_messages c
        JOIN users u ON u.id = c.user_id
        ORDER BY c.id ASC
    ");

    while ($m = $res->fetch_assoc()) {
        $me = $m['user_id'] == $user['id'] ? 'me' : 'other';
        $tag = $m['role'] === 'admin' ? "<small style='color:#00c52b'>Admin</small>" : "";
        
        echo "
        <div class='msg $me'>
            <div class='bubble'>
                <strong>".htmlspecialchars($m['name'])."</strong> $tag<br>
                ".htmlspecialchars($m['message'])."
                <small>".$m['created_at']."</small>
            </div>
        </div>
        ";
    }
    ?>
</div>

<!-- INPUT -->
<form method="post" class="chat-input-area">
    <input class="input" name="message" placeholder="Digite sua mensagem..." required>
    <button class="send-btn"><i class="ri-send-plane-2-line"></i></button>
</form>

<!-- ONLINE LIST -->
<div class="online-box">
    <h2>Usuários Online</h2>
    <div class="online-user">Administrador</div>
    <div class="online-user">Equipe de Suporte</div>
    <div class="online-user" style="border:none;">Operações</div>
    <small>* Lista ilustrativa.</small>
</div>

<!-- NAVIGATION -->
<div class="bottom-nav">
    <a href="dashboard.php"><i class="ri-dashboard-line"></i>Início</a>
    <a href="rotas.php"><i class="ri-route-line"></i>Rotas</a>
    <a href="cameras.php"><i class="ri-camera-line"></i>Câmeras</a>
    <a href="avisos.php"><i class="ri-notification-3-line"></i>Avisos</a>
    <a href="chat.php" class="active"><i class="ri-message-3-line"></i>Chat</a>
    <a href="meu_perfil.php"><i class="ri-user-line"></i>Perfil</a>
</div>

<script>
let chat = document.getElementById("chatBox");
chat.scrollTop = chat.scrollHeight;
</script>

</body>
</html>
