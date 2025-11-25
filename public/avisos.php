<?php 
require_once('../assets/config/auth.php'); 
require_once('../assets/config/db.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = trim($_POST['title'] ?? '');
  $body  = trim($_POST['body'] ?? '');
  $tag   = $_POST['tag'] ?? 'Sistema';

  if ($title && $body) {
    $stmt = $mysqli->prepare("INSERT INTO notices(title, body, tag) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $title, $body, $tag);
    $stmt->execute();
  }

  header('Location: avisos.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Avisos - Vai de Trem</title>

<link href="../assets/css/styles.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">

</head>
<body>

<div class="top-header">
  <h1><i class="ri-notification-3-line"></i> Avisos</h1>
</div>

<div class="post-box">
  <h2>Criar Aviso</h2>
  <form method="post">

    <input class="input" name="title" placeholder="Título do aviso" required>

    <select class="select" name="tag">
      <option>Manutenção</option>
      <option>Novidades</option>
      <option selected>Sistema</option>
    </select>

    <textarea class="textarea" name="body" rows="3" placeholder="Escreva o aviso..." required></textarea>

    <button class="btn" style="margin-top:8px;width:100%;">Publicar</button>
  </form>
</div>

<!-- Lista de Avisos -->
<?php
$res = $mysqli->query("SELECT * FROM notices ORDER BY id DESC");
while ($n = $res->fetch_assoc()) {

  $badge = match ($n['tag']) {
    'Manutenção' => '<span class="badge red">Manutenção</span>',
    'Novidades'  => '<span class="badge blue">Novidades</span>',
    default      => '<span class="badge">Sistema</span>',
  };

  echo "
  <div class='notice-card'>
    <div class='notice-top'>
      <div class='notice-title'>".htmlspecialchars($n['title'])."</div>
      $badge
    </div>

    <div class='notice-body'>".nl2br(htmlspecialchars($n['body']))."</div>
  </div>";
}
?>

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

</body>
</html>
