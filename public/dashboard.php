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
    padding-bottom: 110px;
    font-family: 'Poppins', sans-serif;
  }

  /* HEADER */
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
    font-weight: 700;
  }

  /* STATS */
  .stats-grid {
    margin: 20px;
    display: grid;
    grid-template-columns: repeat(2,1fr);
    gap: 14px;
  }
  .stat-card {
    background: #fff;
    padding: 18px;
    border-radius: 14px;
    text-align: center;
    box-shadow: 0 3px 12px rgba(0,0,0,0.05);
  }
  .stat-card i {
    font-size: 28px;
    color: var(--brand);
  }
  .stat-value {
    font-size: 22px;
    font-weight: 700;
    margin-top: 4px;
  }
  .stat-label {
    font-size: 13px;
    color: #6b7280;
  }

  /* QUICK ACCESS */
  .quick-section {
    margin: 20px;
  }
  .quick-section h2 {
    font-size: 18px;
    margin-bottom: 12px;
    font-weight: 700;
  }
  .quick-grid {
    display: grid;
    grid-template-columns: repeat(3,1fr);
    gap: 12px;
  }
  .quick-card {
    padding: 16px;
    background: #fff;
    border-radius: 14px;
    text-align: center;
    box-shadow: 0 3px 12px rgba(0,0,0,0.05);
    transition: .2s;
  }
  .quick-card:hover { transform: translateY(-4px); }
  .quick-card i { 
    font-size: 26px; 
    color: var(--brand); 
  }
  .quick-card-title {
    margin-top: 6px;
    font-size: 12px;
    color: #1e293b;
    font-weight: 600;
  }

  /* Recent activity */
  .recent-section { margin: 20px; }
  .recent-section h2 { font-size: 18px; margin-bottom: 12px; }

  .recent-item {
    background: #fff;
    padding: 16px;
    border-radius: 14px;
    margin-bottom: 10px;
    display: flex;
    gap: 12px;
    align-items: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  }
  .recent-item i {
    font-size: 24px;
    color: var(--brand);
  }

  /* Bottom nav */
  .bottom-nav {
    position: fixed;
    bottom: 0; left: 0; right: 0;
    background: #fff;
    border-top: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    padding: 10px 25px 8px;
    box-shadow: 0 -4px 14px rgba(0,0,0,0.07);
    z-index: 9999;
  }
  .bottom-nav a {
    text-decoration: none;
    color: #64748b;
    font-size: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 3px;
    transition: .2s;
  }
  .bottom-nav i {
    font-size: 22px;
  }
  .bottom-nav a.active,
  .bottom-nav a:hover {
    color: var(--brand);
  }

  /* Centro levantado */
  .center-btn {
    transform: translateY(-12px);
    background: var(--brand);
    padding: 10px 18px;
    border-radius: 18px;
    color: #fff !important;
    font-weight: 600;
    box-shadow: 0 4px 14px rgba(0,0,0,0.12);
  }
  .center-btn i { color: #fff !important; font-size: 22px; }
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
