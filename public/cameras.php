<?php require_once('../assets/config/auth.php'); require_once('../assets/config/db.php'); ?>
<!DOCTYPE html><html lang="pt-BR"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Câmeras - Vai de Trem</title>
<?php include '_partials/header.php'; ?>
</head><body>
<div class="container">
  <div class="topbar"><h2>Monitoramento de Câmeras</h2><span class="badge blue">AO VIVO</span></div>
  <div class="grid cols-3">
    <?php
      $res = $mysqli->query("SELECT * FROM cameras ORDER BY id ASC");
      while($c = $res->fetch_assoc()){
        $status = $c['status'] === 'online' ? '<span class=\"badge blue\">Online</span>' : '<span class=\"badge red\">Offline</span>';
        echo '<div class=\"card pad\">'.$status.'
              <div style=\"height:160px;display:flex;align-items:center;justify-content:center;color:#94a3b8\">
                <i class=\"ri-camera-line\"></i> Feed da '.$c['name'].'
              </div>
              <div class=\"link-muted\">'.$c['location'].'</div>
              <div class=\"link-muted\">Trem '.($c['train_code'] ? '#'.$c['train_code'] : '-').'</div>
            </div>';
      }
    ?>
  </div>
</div>
</body></html>
