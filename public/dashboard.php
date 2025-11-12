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
    background: #f7f9fc;
    font-family: 'Poppins', sans-serif;
    color: #222;
  }
  header {
    background: var(--brand);
    color: #fff;
    padding: 18px 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
  }
  header h1 {
    font-size: 22px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  header .user {
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .container {
    max-width: 1200px;
    margin: 32px auto;
    padding: 0 20px;
  }
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 16px;
  }
  .stat-card {
    background: #fff;
    border-radius: 14px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    transition: all 0.2s ease;
  }
  .stat-card:hover { transform: translateY(-3px); }
  .stat-card i {
    font-size: 34px;
    color: var(--brand);
  }
  .stat-value {
    font-size: 26px;
    font-weight: 700;
  }
  .quick-actions, .recent {
    margin-top: 40px;
  }
  .quick-actions h2, .recent h2 {
    font-size: 20px;
    margin-bottom: 16px;
    font-weight: 600;
  }
  .action-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
  }
  .action-card {
    background: #fff;
    border-radius: 14px;
    padding: 18px;
    text-align: center;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    transition: all 0.2s;
  }
  .action-card:hover {
    background: var(--brand);
    color: #fff;
    transform: translateY(-3px);
  }
  .action-card .badge {
    margin-bottom: 6px;
  }
  .recent .item {
    background: #fff;
    border-radius: 12px;
    padding: 14px 16px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
  }
  .recent .item i {
    color: var(--brand);
  }
  footer {
    text-align: center;
    padding: 20px;
    color: #666;
    font-size: 13px;
  }
</style>
</head>
<body>

<header>
  <h1><i class="ri-train-line"></i> Vai de Trem — Painel Administrativo</h1>
  <div class="user">
    <i class="ri-user-3-line"></i> 
    <span><?php echo htmlspecialchars($user['name']); ?></span>
    <a href="logout.php" class="btn secondary" style="margin-left:10px">Sair</a>
  </div>
</header>

<div class="container">

  <div class="stats-grid">
    <?php
      $routesAtivas = $mysqli->query("SELECT COUNT(*) AS total FROM routes WHERE status='ativa'")->fetch_assoc()['total'];
      $notices = $mysqli->query("SELECT COUNT(*) AS total FROM notices")->fetch_assoc()['total'];
      $stations = $mysqli->query("SELECT COUNT(*) AS total FROM stations")->fetch_assoc()['total'];
      $cameras = $mysqli->query("SELECT COUNT(*) AS total FROM cameras")->fetch_assoc()['total'];

      $stats = [
        ['label'=>'Rotas Ativas','icon'=>'ri-route-line','value'=>$routesAtivas],
        ['label'=>'Estações','icon'=>'ri-map-pin-line','value'=>$stations],
        ['label'=>'Avisos','icon'=>'ri-notification-3-line','value'=>$notices],
        ['label'=>'Câmeras','icon'=>'ri-video-line','value'=>$cameras],
      ];
      foreach($stats as $s){
        echo '<div class="stat-card"><i class="'.$s['icon'].'"></i><div><div class="stat-value">'.$s['value'].'</div><div>'.$s['label'].'</div></div></div>';
      }
    ?>
  </div>

  <div class="quick-actions">
    <h2>Acesso Rápido</h2>
    <div class="action-grid">
      <a href="cameras.php" class="action-card">
        <div class="badge blue"><i class="ri-camera-line"></i> Câmeras</div>
        <div class="link-muted">Monitorar Câmeras</div>
      </a>
      <a href="avisos.php" class="action-card">
        <div class="badge blue"><i class="ri-notification-3-line"></i> Avisos</div>
        <div class="link-muted">Central de Avisos</div>
      </a>
      <a href="rotas.php" class="action-card">
        <div class="badge blue"><i class="ri-route-line"></i> Rotas</div>
        <div class="link-muted">Gerenciar Rotas</div>
      </a>
      <a href="relatorios.php" class="action-card">
        <div class="badge blue"><i class="ri-bar-chart-box-line"></i> Relatórios</div>
        <div class="link-muted">Análises do Sistema</div>
      </a>
    </div>
  </div>

  <div class="recent">
    <h2>Atividades Recentes</h2>
    <div class="item"><i class="ri-train-line"></i> 08:30 — Trem #1234 iniciou rota São Paulo → Rio de Janeiro</div>
    <div class="item"><i class="ri-tools-line"></i> 08:25 — Manutenção programada para Trem #5678</div>
    <div class="item"><i class="ri-map-pin-2-line"></i> 08:20 — Nova rota adicionada: Campinas → Santos</div>
    <div class="item"><i class="ri-check-line"></i> 08:15 — Trem #9012 chegou ao destino</div>
  </div>

</div>

<footer>
  © <?php echo date('Y'); ?> Vai de Trem — Sistema de Monitoramento Ferroviário
</footer>

</body>
</html>
