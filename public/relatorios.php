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

<style>
  body {
    background: #f5f9ff;
    padding-bottom: 90px; /* nav mobile */
    font-family: 'Poppins', sans-serif;
  }

  /* Header padrão */
  .top-header {
    background: var(--brand);
    color: #fff;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    border-radius: 0 0 18px 18px;
  }
  .top-header h1 {
    font-size: 20px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  /* KPI grid */
  .kpi-grid {
    margin: 20px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
  }
  .kpi-card {
    background: #fff;
    padding: 16px;
    border-radius: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    text-align: center;
  }
  .kpi-label {
    font-size: 13px;
    color: var(--muted);
  }
  .kpi-value {
    font-size: 22px;
    font-weight: bold;
    margin-top: 4px;
  }

  /* Sessão de charts */
  .chart-section {
    margin: 20px;
  }
  .chart-card {
    background: #fff;
    border-radius: 14px;
    padding: 16px;
    margin-bottom: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  }
  .chart-card strong {
    font-size: 15px;
    display: block;
  }
  .chart-card img {
    width: 100%;
    border-radius: 10px;
    margin-top: 12px;
  }
  .chart-sub {
    font-size: 12px;
    color: var(--muted);
  }

  /* NAV MOBILE FIXO */
  .bottom-nav {
    position: fixed;
    bottom: 0; left: 0; right: 0;
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
    <div class="chart-sub">Últimos 6 meses (mock)</div>
    <img src="https://dummyimage.com/600x260/e9f2ff/1e66ff.png&text=Line+Chart" alt="chart">
  </div>

  <div class="chart-card">
    <strong>Distribuição por Rota</strong>
    <div class="chart-sub">Percentual de uso (mock)</div>
    <img src="https://dummyimage.com/600x260/e9f2ff/1e66ff.png&text=Pie+Chart" alt="chart">
  </div>

</div>

<!-- NAV MOBILE -->
<div class="bottom-nav">
  <a href="dashboard.php">
    <i class="ri-dashboard-line"></i>Início
  </a>
  <a href="rotas.php">
    <i class="ri-route-line"></i>Rotas
  </a>
  <a href="cameras.php">
    <i class="ri-camera-line"></i>Câmeras
  </a>
  <a href="avisos.php">
    <i class="ri-notification-3-line"></i>Avisos
  </a>
  <a href="relatorios.php" class="active">
    <i class="ri-bar-chart-line"></i>Relatórios
  </a>
</div>

</body>
</html>
