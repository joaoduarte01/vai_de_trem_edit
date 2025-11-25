<?php
require_once('../assets/config/auth.php');
$user = $_SESSION['user'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<title>Área do Cliente - Vai de Trem</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../assets/css/styles.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">

</head>
<body>

<div class="container" style="max-width:960px; margin: 20px auto;">

  <div class="topbar">
    <div class="brand-icon"><i class="ri-train-line"></i></div>
    <h2>Olá, <?php echo htmlspecialchars($user['name']); ?>!</h2>
    <p>Bem-vindo(a) à sua área de rotas.</p>
  </div>

  <h3 class="section-title">Rotas Disponíveis</h3>
  <p class="link-muted">Escolha uma rota para visualizar mais informações.</p>

  <div class="routes-grid">

    <div class="route-card">
      <div class="route-header">
        <h3>São Paulo → Rio de Janeiro</h3>
        <span class="route-tag">Ativa</span>
      </div>
      <div class="route-info">
        <p><i class="ri-map-pin-line"></i> Estações: Central • Norte • Sul</p>
        <p><i class="ri-time-line"></i> 6h 30min</p>
        <p><i class="ri-calendar-check-line"></i> Opera diariamente</p>
      </div>
    </div>

    <div class="route-card">
      <div class="route-header">
        <h3>Campinas → Santos</h3>
        <span class="route-tag">Ativa</span>
      </div>
      <div class="route-info">
        <p><i class="ri-map-pin-line"></i> KM 45 • Ponte Rio Grande</p>
        <p><i class="ri-time-line"></i> 3h 45min</p>
        <p><i class="ri-calendar-check-line"></i> Opera diariamente</p>
      </div>
    </div>

    <div class="route-card">
      <div class="route-header">
        <h3>Belo Horizonte → São Paulo</h3>
        <span class="route-tag red">Manutenção</span>
      </div>
      <div class="route-info">
        <p><i class="ri-map-pin-line"></i> Estação Sul • Estação Central</p>
        <p><i class="ri-time-line"></i> 8h 15min</p>
        <p><i class="ri-alert-line"></i> Retorno previsto: 15/11</p>
      </div>
    </div>

    <div class="route-card">
      <div class="route-header">
        <h3>Curitiba → Florianópolis</h3>
        <span class="route-tag">Ativa</span>
      </div>
      <div class="route-info">
        <p><i class="ri-map-pin-line"></i> Estação Norte • Ponte Rio Grande</p>
        <p><i class="ri-time-line"></i> 5h 20min</p>
        <p><i class="ri-calendar-check-line"></i> Opera diariamente</p>
      </div>
    </div>

  </div>
</div>

<!-- MENU MOBILE -->
<div class="mobile-menu">
  <a href="#" class="active">
    <i class="ri-route-line"></i>
    <span>Rotas</span>
  </a>
  <a href="perfil_cliente.php">
    <i class="ri-user-3-line"></i>
    <span>Perfil</span>
  </a>
  <a href="logout.php">
    <i class="ri-logout-box-r-line"></i>
    <span>Sair</span>
  </a>
</div>

</body>
</html>
