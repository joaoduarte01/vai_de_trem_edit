<?php require_once('../assets/config/auth.php'); require_once('../assets/config/db.php');
// Save message
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['message'])){
  $msg = trim($_POST['message']);
  if($msg){
    $stmt=$mysqli->prepare("INSERT INTO chat_messages(user_id,message) VALUES(?,?)");
    $stmt->bind_param('is',$user['id'],$msg);
    $stmt->execute();
  }
  header('Location: chat.php'); exit;
}
?>
<!DOCTYPE html><html lang="pt-BR"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Chat de Suporte - Vai de Trem</title>
<?php include '_partials/header.php'; ?>
</head><body>
<div class="container">
  <div class="topbar"><h2>Chat de Suporte (Admin)</h2></div>
  <div class="grid cols-2">
    <div class="card pad">
      <strong>Mensagens</strong>
      <div class="chat-box" id="chat">
        <?php
          $res=$mysqli->query("SELECT c.*, u.name FROM chat_messages c JOIN users u ON u.id=c.user_id ORDER BY c.id ASC");
          while($m=$res->fetch_assoc()){
            $meClass = $m['user_id']==$user['id'] ? 'me' : 'other';
            echo '<div class=\"msg '.$meClass.'\"><div class=\"bubble\"><strong>'.htmlspecialchars($m['name']).':</strong> '.htmlspecialchars($m['message']).'<br><span class=\"link-muted\" style=\"font-size:12px\">'.$m['created_at'].'</span></div></div>';
          }
        ?>
      </div>
      <form method="post" class="row" style="margin-top:8px">
        <input class="input" name="message" placeholder="Digite uma mensagem..." required>
        <button class="btn icon"><i class="ri-send-plane-2-line"></i> Enviar</button>
      </form>
    </div>
    <div class="card pad">
      <strong>Usuários Online</strong>
      <div class="list">
        <div class="item">Administrador</div>
        <div class="item">Equipe de Suporte</div>
        <div class="item">Operações</div>
      </div>
      <div class="badge" style="margin-top:10px">* Lista ilustrativa.</div>
    </div>
  </div>
</div>
<script>
  const chat=document.getElementById('chat'); chat.scrollTop=chat.scrollHeight;
</script>
</body></html>
