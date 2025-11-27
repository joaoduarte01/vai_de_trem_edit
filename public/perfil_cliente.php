<?php
require_once('../assets/config/auth.php');
$user = $_SESSION['user'] ?? null;

// Evita que administradores entrem aqui
if ($user['role'] !== 'user') {
  header('Location: dashboard.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Meu Perfil - Cliente</title>
  <link href="../assets/css/styles.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">

</head>

<body>

  <div class="container" style="max-width:900px; margin: 20px auto;">

    <div class="topbar">
      <div class="profile-icon"><img src="../assets/images/icone_adm.png" alt="Perfil" class="icon-img"
          style="width:45px;height:45px;"></div>
      <h2><?php echo htmlspecialchars($user['name']); ?></h2>
      <p>Perfil do Cliente</p>
    </div>

    <div class="card-info">
      <h3>Informações da Conta</h3>

      <div class="info-row">
        <span class="info-label">Nome</span>
        <span class="info-value"><?php echo htmlspecialchars($user['name']); ?></span>
      </div>

      <div class="info-row">
        <span class="info-label">E-mail</span>
        <span class="info-value"><?php echo htmlspecialchars($user['email']); ?></span>
      </div>

      <div class="info-row">
        <span class="info-label">Tipo de Conta</span>
        <span class="info-value">Cliente</span>
      </div>

      <a href="editar_perfil_cliente.php" class="edit-btn">
        <img src="../assets/images/icone_adm.png" alt="Editar" class="icon-img" style="width:16px;height:16px;"> Editar
        Perfil
      </a>
    </div>

  </div>

  <!-- MENU INFERIOR MOBILE -->
  <div class="mobile-menu">
    <a href="cliente_home.php">
      <img src="../assets/images/rotas_icone.png" alt="Rotas" class="icon-img"
        style="width:24px;height:24px;margin-bottom:4px;">
      <span>Rotas</span>
    </a>
    <a href="perfil_cliente.php" class="active">
      <img src="../assets/images/icone_adm.png" alt="Perfil" class="icon-img"
        style="width:24px;height:24px;margin-bottom:4px;">
      <span>Perfil</span>
    </a>
    <a href="logout.php">
      <img src="../assets/images/logout_icone.png" alt="Sair" class="icon-img"
        style="width:24px;height:24px;margin-bottom:4px;">
      <span>Sair</span>
    </a>
  </div>

</body>

</html>