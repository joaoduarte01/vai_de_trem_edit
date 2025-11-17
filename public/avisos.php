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


<style>

body {
  padding-bottom: 90px !important; /* espaço para não sobrepor conteúdo */
}

  body {
    background: #f5f9ff;
    padding-bottom: 90px;
    font-family: 'Poppins', sans-serif;
  }

 
  .top-header {
    background: var(--brand);
    color: #fff;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    border-radius: 0 0 18px 18px;
  }
  .top-header h1 {
    font-size: 20px;
    font-weight: 700;
  }

 
  .post-box {
    margin: 20px;
    background: #fff;
    padding: 18px;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
  }

  .post-box h2 {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 10px;
  }

  .post-box textarea {
    resize: none;
    border-radius: 12px;
  }

 
  .notice-card {
    margin: 18px;
    background: #fff;
    padding: 18px;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
  }

  .notice-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .notice-title {
    font-size: 17px;
    font-weight: 700;
  }

  .notice-body {
    margin-top: 10px;
    font-size: 14px;
    color: var(--muted);
    line-height: 1.45;
  }

 
.bottom-nav {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  background: #ffffff;
  height: 70px;
  display: flex !important;          /* força aparecer mesmo se outro CSS esconder */
  justify-content: space-around;
  align-items: center;
  border-top: 1px solid var(--border);
  box-shadow: 0 -2px 10px rgba(0,0,0,0.08);
  z-index: 9999;                     /* sempre por cima */
}

.bottom-nav a {
  text-decoration: none;
  text-align: center;
  color: var(--muted);
  font-size: 12px;
  display: flex;
  flex-direction: column;            /* ícone em cima, texto embaixo */
  align-items: center;
  gap: 2px;
}

.bottom-nav i {
  font-size: 22px;
  display: block;
}

.bottom-nav a.active {
  color: var(--brand);
  font-weight: 600;
}

</style>

</head>
<body>

<!-- Header -->
<div class="top-header">
  <h1><i class="ri-notification-3-line"></i> Avisos</h1>
</div>

<!-- Caixa de Postagem -->
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

<!-- Bottom Nav -->
<div class="bottom-nav">
  <a href="dashboard.php"><i class="ri-dashboard-line"></i>Início</a>
  <a href="rotas.php"><i class="ri-route-line"></i>Rotas</a>
  <a href="cameras.php"><i class="ri-camera-line"></i>Câmeras</a>
  <a href="avisos.php" class="active"><i class="ri-notification-3-line"></i>Avisos</a>
  <a href="meu_perfil.php"><i class="ri-user-3-line"></i>Perfil</a>
</div>

</body>
</html>
