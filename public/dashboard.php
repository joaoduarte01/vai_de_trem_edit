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

<style>
  body {
    background: #f5f9ff;
    padding-bottom: 90px; /* espaço para nav mobile */
  }

  /* HEADER MOBILE */
  .top-header {
    background: var(--brand);
    color: #fff;
    padding: 18px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: 0 0 20px 20px;
  }
  .top-header h1 {
    font-size: 20px;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  /* SEÇÃO ESTATÍSTICAS MOBILE */
  .stats-mobile {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin: 20px;
  }
  .stat-card {
    padding: 18px;
    background: #fff;
    border-radius: 14px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  }
  .stat-card i {
    font-size: 26px;
    color: var(--brand);
  }
  .stat-value {
    font-size: 22px;
    font-weight: 700;
    margin-top: 4px;
  }
  .stat-label {
    font-size: 13px;
    color: var(--muted);
  }

  /* ACESSO RÁPIDO */
  .quick-section {
    margin: 20px;
  }
  .quick-section h2 {
    font-size: 18px;
    margin-bottom: 10px;
  }
  .quick-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }
  .quick-card {
    padding: 16px;
    background: #fff;
    border-radius: 14px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    transition: 0.2s;
  }
  .quick-card:hover {
    transform: translateY(-3px);
  }
  .quick-card i {
    font-size: 28px;
    color: var(--brand);
  }
  .quick-card-title {
    font-size: 13px;
    margin-top: 6px;
    color: var(--text);
  }

  /* ATIVIDADES RECENTES */
  .recent-section {
    margin: 20px;
  }
  .recent-section h2 {
    font-size: 18px;
    margin-bottom: 10px;
  }
  .recent-item {
    background: #fff;
    padding: 14px;
    border-radius: 12px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
  }
  .recent-item i {
    font-size: 22px;
    color: var(--brand);
  }

  /* NAV MOBILE FIXO BAIXO */
  .bottom-nav {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #fff;
    height: 70px;
    display: flex;
    justify-content: space-around;
    align-items: center;
    border-top: 1px solid var(--border);
    box-shadow: 0 -2px 10px rgba(0,0,0,0.08);
    z-index: 500;
  }
  .bottom-nav a {
    text-align: center;
    font-size: 12px;
    color: var(--muted);
    text-decoration: none;
  }
  .bottom-nav i {
    font-size: 24px;
    display: block;
    margin-bottom: 4px;
  }
  .bottom-nav a.active {
    color: var(--brand);
    font-weight: 600;
  }
</style>

</head>
<body>

<!-- HEADER -->
<div class="top-header">
  <h1><i class="ri-dashboard-line"></i> Dashboard</h1>

  <div style="display:flex;align-items:center;gap:10px;">
    <span><?php echo htmlspecialchars($user['name']); ?></span>
    <a href="logout.php"><i class="ri-logout-circle-line" style="font-size:22px;color:#fff;"></i></a>
  </div>
</div>

<?php
  $routesAtivas = $mysqli->query("SELECT COUNT(*) AS total FROM routes WHERE status='ativa'")->fetch_assoc()['total'];
  $notices = $mysqli->query("SELECT COUNT(*) AS total FROM notices")->fetch_assoc()['total'];
  $stations = $mysqli->query("SELECT COUNT(*) AS total FROM stations")->fetch_assoc()['total'];
  $cameras = $mysqli->query("SELECT COUNT(*) AS total FROM cameras")->fetch_assoc()['total'];
?>

<!-- ESTATÍSTICAS MOBILE -->
<div class="stats-mobile">
  <div class="stat-card">
    <i class="ri-route-line"></i>
    <div class="stat-value"><?php echo $routesAtivas; ?></div>
    <div class="stat-label">Rotas Ativas</div>
  </div>

  <div class="stat-card">
    <i class="ri-map-pin-line"></i>
    <div class="stat-value"><?php echo $stations; ?></div>
    <div class="stat-label">Estações</div>
  </div>

  <div class="stat-card">
    <i class="ri-notification-3-line"></i>
    <div class="stat-value"><?php echo $notices; ?></div>
    <div class="stat-label">Avisos</div>
  </div>

  <div class="stat-card">
    <i class="ri-video-line"></i>
    <div class="stat-value"><?php echo $cameras; ?></div>
    <div class="stat-label">Câmeras</div>
  </div>
</div>

<!-- ACESSO RÁPIDO -->
<div class="quick-section">
  <h2>Acesso Rápido</h2>

  <div class="quick-grid">
    <a href="cameras.php" class="quick-card">
      <i class="ri-camera-line"></i>
      <div class="quick-card-title">Câmeras</div>
    </a>

    <a href="avisos.php" class="quick-card">
      <i class="ri-notification-badge-line"></i>
      <div class="quick-card-title">Avisos</div>
    </a>

    <a href="rotas.php" class="quick-card">
      <i class="ri-route-line"></i>
      <div class="quick-card-title">Rotas</div>
    </a>

    <a href="relatorios.php" class="quick-card">
      <i class="ri-bar-chart-box-line"></i>
      <div class="quick-card-title">Relatórios</div>
    </a>
  </div>
</div>

<!-- ATIVIDADES RECENTES -->
<div class="recent-section">
  <h2>Atividades Recentes</h2>

  <div class="recent-item">
    <i class="ri-train-line"></i>
    08:30 — Trem #1234 iniciou rota SP → RJ
  </div>

  <div class="recent-item">
    <i class="ri-tools-line"></i>
    08:25 — Manutenção programada Trem #5678
  </div>

  <div class="recent-item">
    <i class="ri-map-pin-line"></i>
    08:20 — Nova rota adicionada: Campinas → Santos
  </div>

  <div class="recent-item">
    <i class="ri-check-line"></i>
    08:15 — Trem #9012 chegou ao destino
  </div>
</div>

<!-- NAV MOBILE FIXO -->
<style>
  .bottom-nav {
    position: fixed;
    bottom: 0; left: 0; right: 0;
    background: #fff;
    border-top: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-around;
    padding: 10px 0 8px;
    box-shadow: 0 -4px 12px rgba(0,0,0,0.05);
    z-index: 9999;
  }
  .bottom-nav a {
    text-decoration: none;
    color: #64748b;
    font-size: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    transition: .2s;
  }
  .bottom-nav a i {
    font-size: 22px;
  }
  .bottom-nav a.active,
  .bottom-nav a:hover {
    color: var(--brand);
  }

  /* esconder nav no desktop */
  @media (min-width: 768px) {
    .bottom-nav { display: none !important; }
  }
</style>

<div class="bottom-nav">
  <a href="dashboard.php" class="active">
    <i class="ri-dashboard-line"></i>
    <span>Início</span>
  </a>

  <a href="rotas.php">
    <i class="ri-route-line"></i>
    <span>Rotas</span>
  </a>

  <a href="cameras.php">
    <i class="ri-camera-line"></i>
    <span>Câmeras</span>
  </a>

  <a href="avisos.php">
    <i class="ri-notification-3-line"></i>
    <span>Avisos</span>
  </a>

  <a href="meu_perfil.php">
    <i class="ri-user-3-line"></i>
    <span>Perfil</span>
  </a>
</div>


</body>
</html>
