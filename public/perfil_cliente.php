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

<style>
body {
  background: #f1f5f9;
  font-family: "Inter", sans-serif;
  padding-bottom: 80px;
}

.topbar {
  text-align: center;
  margin-top: 26px;
}

.profile-icon {
  width: 95px;
  height: 95px;
  border-radius: 50%;
  background: var(--brand);
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 45px;
  color: #fff;
  margin: 0 auto 12px auto;
  box-shadow: 0 6px 16px rgba(0,0,0,0.12);
}

.topbar h2 {
  margin: 0;
  font-size: 22px;
  font-weight: 700;
  color: #1e293b;
}

.topbar p {
  color: #64748b;
  margin-top: 4px;
}

.card-info {
  background: #fff;
  padding: 20px;
  border-radius: 16px;
  box-shadow: 0 6px 20px rgba(0,0,0,0.06);
  margin-top: 25px;
}

.card-info h3 {
  font-size: 18px;
  margin-bottom: 14px;
  color: var(--brand);
  font-weight: 700;
}

.info-row {
  display: flex;
  justify-content: space-between;
  padding: 12px 0;
  border-bottom: 1px solid #e2e8f0;
}
.info-row:last-child {
  border-bottom: none;
}

.info-label {
  color: #64748b;
  font-size: 14px;
}
.info-value {
  font-size: 15px;
  font-weight: 600;
  color: #1e293b;
}

.edit-btn {
  margin-top: 18px;
  display: block;
  text-align: center;
  background: var(--brand);
  color: #fff;
  padding: 12px;
  border-radius: 10px;
  text-decoration: none;
  font-weight: 600;
}

.edit-btn:hover {
  background: #0058e0;
}

/* MENU MOBILE */
.mobile-menu {
  position: fixed;
  bottom: 0; left:0; right:0;
  height: 65px;
  background: #fff;
  border-top: 1px solid #e2e8f0;
  display: flex;
  justify-content: space-around;
  align-items: center;
  box-shadow: 0 -4px 14px rgba(0,0,0,0.06);
  z-index: 999;
}
.mobile-menu a {
  text-decoration: none;
  display:flex;
  flex-direction:column;
  align-items:center;
  color:#64748b;
  font-size:13px;
}
.mobile-menu a.active, .mobile-menu a:hover {
  color: var(--brand);
}
.mobile-menu i {
  font-size:22px;
}

@media(min-width:768px){
  .mobile-menu { display:none }
}
</style>

</head>
<body>

<div class="container" style="max-width:900px; margin: 20px auto;">

  <div class="topbar">
    <div class="profile-icon"><i class="ri-user-3-line"></i></div>
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
      <i class="ri-edit-line"></i> Editar Perfil
    </a>
  </div>

</div>

<!-- MENU INFERIOR MOBILE -->
<div class="mobile-menu">
  <a href="cliente_home.php">
    <i class="ri-route-line"></i>
    <span>Rotas</span>
  </a>
  <a href="perfil_cliente.php" class="active">
    <i class="ri-user-line"></i>
    <span>Perfil</span>
  </a>
  <a href="logout.php">
    <i class="ri-logout-box-r-line"></i>
    <span>Sair</span>
  </a>
</div>

</body>
</html>
