<?php 
require_once('../assets/config/auth.php'); 
require_once('../assets/config/db.php'); 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Câmeras - Vai de Trem</title>

<link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
<link href="../assets/css/styles.css" rel="stylesheet">

<style>
  body {
    background: #f5f9ff;
    padding-bottom: 90px;
    font-family: 'Poppins', sans-serif;
  }

  /* HEADER */
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

  /* GRID MOBILE FIRST */
  .cam-grid {
    display: grid;
    gap: 18px;
    padding: 20px;
    grid-template-columns: 1fr;
  }
  @media (min-width: 600px) {
    .cam-grid { grid-template-columns: repeat(2, 1fr); }
  }
  @media (min-width: 900px) {
    .cam-grid { grid-template-columns: repeat(3, 1fr); }
  }

  /* CARD */
  .cam-card {
    background: #fff;
    border-radius: 16px;
    padding: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
  }

  .cam-title {
    font-size: 15px;
    font-weight: 600;
    margin-bottom: 6px;
  }

  .feed-box {
    background: #e9f1ff;
    height: 160px;
    border-radius: 14px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #94a3b8;
    font-size: 15px;
    margin: 12px 0;
  }
  .feed-box i {
    font-size: 40px;
    margin-right: 6px;
  }

  /* BOTTOM NAV */
  .bottom-nav {
    position: fixed; bottom: 0; left: 0; right: 0;
    background: #fff;
    height: 70px;
    display: flex; justify-content: space-around; align-items: center;
    border-top: 1px solid var(--border);
    box-shadow: 0 -2px 10px rgba(0,0,0,0.08);
    z-index: 500;
  }
  .bottom-nav a {
    text-decoration: none;
    text-align: center;
    color: var(--muted);
    font-size: 12px;
  }
  .bottom-nav i {
    font-size: 24px;
    display: block;
    margin-bottom: 4px;
  }
  .bottom-nav a.active {
    color: var(--brand);
  }
</style>

</head>
<body>

<!-- HEADER -->
<div class="top-header">
  <h1><i class="ri-camera-line"></i> Monitoramento</h1>
</div>

<!-- GRID DE CÂMERAS -->
<div class="cam-grid">

<?php
$res = $mysqli->query("SELECT * FROM cameras ORDER BY id ASC");

while ($c = $res->fetch_assoc()) {

  $statusChip = $c['status'] === 'online'
    ? '<span class="badge blue">Online</span>'
    : '<span class="badge red">Offline</span>';

  echo "
  <div class='cam-card'>
    
    <div class='cam-title'>".$c['name']."</div>
    $statusChip

    <div class='feed-box'>
      <i class='ri-live-line'></i>
      Feed ao vivo indisponível (mock)
    </div>

    <div class='link-muted'><i class='ri-map-pin-line'></i> ".$c['location']."</div>
    <div class='link-muted'><i class='ri-train-line'></i> Trem ".($c['train_code'] ? '#'.$c['train_code'] : '-')."</div>

  </div>
  ";
}
?>

</div>

<!-- NAV BOTTOM -->
<div class="bottom-nav">
  <a href="dashboard.php"><i class="ri-dashboard-line"></i>Início</a>
  <a href="rotas.php"><i class="ri-route-line"></i>Rotas</a>
  <a href="cameras.php" class="active"><i class="ri-camera-line"></i>Câmeras</a>
  <a href="avisos.php"><i class="ri-notification-3-line"></i>Avisos</a>
  <a href="meu_perfil.php"><i class="ri-user-3-line"></i>Perfil</a>
</div>

</body>
</html>
