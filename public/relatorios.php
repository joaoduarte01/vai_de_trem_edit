<?php 
require_once('../assets/config/auth.php'); 
require_once('../assets/config/db.php'); 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Relatórios - Vai de Trem</title>
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
<link href="../assets/css/styles.css" rel="stylesheet">

</head>
<body>

<!-- HEADER -->
<div class="top-header">
  <h1><i class="ri-bar-chart-line"></i> Relatórios</h1>
</div>

<!-- KPIs -->
<div class="kpi-grid">
  <div class="kpi-card">
    <div class="kpi-label">Passageiros/Mês</div>
    <div class="kpi-value">10.2K</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-label">Viagens/Mês</div>
    <div class="kpi-value">185</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-label">Pontualidade</div>
    <div class="kpi-value">94%</div>
  </div>
  <div class="kpi-card">
    <div class="kpi-label">Satisfação</div>
    <div class="kpi-value">4.7</div>
  </div>
</div>

<!-- CHARTS -->
<div class="chart-section">

  <div class="chart-card">
    <strong>Passageiros e Viagens por Mês</strong>
    <div class="chart-sub">Últimos 6 meses </div>
    <img src="https://s3.amazonaws.com/thumbnails.venngage.com/template/0e364154-2c6b-43d4-a2c5-fee2da9c77a5.png" alt="gráfico">
  </div>

  <div class="chart-card">
    <strong>Distribuição por Rota</strong>
    <div class="chart-sub">Percentual de uso </div>
    <img src="https://learn.microsoft.com/pt-br/sql/reporting-services/media/report-builder-column-chart-moving-average.png?view=sql-server-ver17" alt="gráfico">
  </div>

</div>

<!-- NAV MOBILE -->
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