<?php 
require_once('../assets/config/auth.php'); 
require_once('../assets/config/db.php'); 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard - Vai de Trem</title>

<link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
<link href="../assets/css/styles.css" rel="stylesheet">

</head>
<body>

<!-- HEADER -->
<div class="top-header">
  <h1><i class="ri-dashboard-line"></i> Dashboard</h1>
</div>

<?php
  $routesAtivas  = $mysqli->query("SELECT COUNT(*) AS total FROM routes WHERE status='ativa'")->fetch_assoc()['total'];
  $notices       = $mysqli->query("SELECT COUNT(*) AS total FROM notices")->fetch_assoc()['total'];
  $employees     = $mysqli->query("SELECT COUNT(*) AS total FROM employees")->fetch_assoc()['total'];
?>

<!-- STATS -->
<div class="stats-grid">
  <div class="stat-card">
    <i class="ri-route-line"></i>
    <div class="stat-value"><?php echo $routesAtivas; ?></div>
    <div class="stat-label">Rotas Ativas</div>
  </div>

  <div class="stat-card">
    <i class="ri-team-line"></i>
    <div class="stat-value"><?php echo $employees; ?></div>
    <div class="stat-label">Funcionários</div>
  </div>

  <div class="stat-card">
    <i class="ri-notification-3-line"></i>
    <div class="stat-value"><?php echo $notices; ?></div>
    <div class="stat-label">Avisos</div>
  </div>
</div>

<!-- QUICK ACCESS -->
<div class="quick-section">
  <h2>Acesso Rápido</h2>

  <div class="quick-grid">
    <a href="funcionarios.php" class="quick-card">
      <i class="ri-team-line"></i>
      <div class="quick-card-title">Funcionários</div>
    </a>

    <a href="chat.php" class="quick-card">
      <i class="ri-message-3-line"></i>
      <div class="quick-card-title">Chat</div>
    </a>

    <a href="rotas.php" class="quick-card">
      <i class="ri-route-line"></i>
      <div class="quick-card-title">Rotas</div>
    </a>

    <a href="avisos.php" class="quick-card">
      <i class="ri-notification-badge-line"></i>
      <div class="quick-card-title">Avisos</div>
    </a>

    <a href="relatorios.php" class="quick-card">
      <i class="ri-bar-chart-box-line"></i>
      <div class="quick-card-title">Relatórios</div>
    </a>
  </div>
</div>

<!-- RECENT ACTIVITY -->
<div class="recent-section">
  <h2>Atividades Recentes</h2>

  <div class="recent-item">
    <i class="ri-train-line"></i>
    09:10 — Trem #4321 partiu para Curitiba
  </div>

  <div class="recent-item">
    <i class="ri-user-add-line"></i>
    09:00 — Novo funcionário cadastrado em Operações
  </div>

  <div class="recent-item">
    <i class="ri-camera-line"></i>
    08:52 — Câmera #7 voltou ao status Online
  </div>

  <div class="recent-item">
    <i class="ri-tools-line"></i>
    08:47 — Manutenção agendada em rota SP → Campinas
  </div>
</div>

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
