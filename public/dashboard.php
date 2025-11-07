<?php require_once('../assets/config/auth.php'); require_once('../assets/config/db.php'); ?>
<!DOCTYPE html><html lang="pt-BR"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard - Vai de Trem</title>
<?php include '_partials/header.php'; ?>
</head><body>
<div class="container">
  <div class="grid cols-4">
    <?php
      $stats = [
        ['label'=>'Trens Ativos','icon'=>'ri-train-line','value'=>24],
        ['label'=>'Rotas Hoje','icon'=>'ri-map-pin-2-line','value'=>mysqli_num_rows($mysqli->query("SELECT id FROM routes WHERE status='ativa'"))],
        ['label'=>'Passageiros','icon'=>'ri-user-3-line','value'=>'8.5K'],
        ['label'=>'Eficiência','icon'=>'ri-line-chart-line','value'=>'94%']
      ];
      foreach($stats as $s){
        echo '<div class="card stat"><i class="'.$s['icon'].'"></i><div><div class="big">'.$s['value'].'</div><div class="link-muted">'.$s['label'].'</div></div></div>';
      }
    ?>
  </div>

  <h2 style="margin-top:18px">Acesso Rápido</h2>
  <div class="grid cols-4">
    <a class="card pad" href="cameras.php"><div class="badge blue">Câmeras</div><div class="link-muted">Monitorar câmeras</div></a>
    <a class="card pad" href="avisos.php"><div class="badge blue">Avisos</div><div class="link-muted">Central de avisos</div></a>
    <a class="card pad" href="rotas.php"><div class="badge blue">Rotas</div><div class="link-muted">Gerenciar rotas</div></a>
    <a class="card pad" href="relatorios.php"><div class="badge blue">Relatórios</div><div class="link-muted">Ver análises</div></a>
  </div>

  <h2 style="margin-top:18px">Atividades Recentes</h2>
  <div class="list">
    <div class="item">08:30 — Trem #1234 iniciou rota São Paulo → Rio de Janeiro</div>
    <div class="item">08:25 — Manutenção programada para Trem #5678</div>
    <div class="item">08:20 — Nova rota adicionada: Campinas → Santos</div>
    <div class="item">08:15 — Trem #9012 chegou ao destino</div>
  </div>
</div>
<div class="footer-space"></div>
</body></html>
