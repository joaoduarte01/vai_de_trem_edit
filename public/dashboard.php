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
    <h1><img src="../assets/images/inicio_png.png" alt="Dashboard" class="icon-img" style="width:22px;height:22px;">
      Dashboard</h1>
  </div>

  <?php
  $routesAtivas = $mysqli->query("SELECT COUNT(*) AS total FROM routes WHERE status='ativa'")->fetch_assoc()['total'];
  $notices = $mysqli->query("SELECT COUNT(*) AS total FROM notices")->fetch_assoc()['total'];
  $employees = $mysqli->query("SELECT COUNT(*) AS total FROM employees")->fetch_assoc()['total'];
  ?>

  <!-- STATS -->
  <div class="stats-grid">
    <div class="stat-card">
      <img src="../assets/images/rotas_icone.png" alt="Rotas" class="icon-img"
        style="width:28px;height:28px;margin:0 auto;">
      <div class="stat-value"><?php echo $routesAtivas; ?></div>
      <div class="stat-label">Rotas Ativas</div>
    </div>

    <div class="stat-card">
      <img src="../assets/images/icones_funcionarios.png" alt="Funcionários" class="icon-img"
        style="width:28px;height:28px;margin:0 auto;">
      <div class="stat-value"><?php echo $employees; ?></div>
      <div class="stat-label">Funcionários</div>
    </div>

    <div class="stat-card">
      <img src="../assets/images/notificacao_icone.png" alt="Avisos" class="icon-img"
        style="width:28px;height:28px;margin:0 auto;">
      <div class="stat-value"><?php echo $notices; ?></div>
      <div class="stat-label">Avisos</div>
    </div>
  </div>

  <!-- QUICK ACCESS -->
  <div class="quick-section">
    <h2>Acesso Rápido</h2>

    <div class="quick-grid">
      <a href="funcionarios.php" class="quick-card">
        <img src="../assets/images/icones_funcionarios.png" alt="Funcionários" class="icon-img"
          style="width:26px;height:26px;margin:0 auto;">
        <div class="quick-card-title">Funcionários</div>
      </a>

      <a href="chat.php" class="quick-card">
        <img src="../assets/images/notificacao_icone.png" alt="Chat" class="icon-img"
          style="width:26px;height:26px;margin:0 auto;">
        <div class="quick-card-title">Chat</div>
      </a>

      <a href="rotas.php" class="quick-card">
        <img src="../assets/images/rotas_icone.png" alt="Rotas" class="icon-img"
          style="width:26px;height:26px;margin:0 auto;">
        <div class="quick-card-title">Rotas</div>
      </a>

      <a href="avisos.php" class="quick-card">
        <img src="../assets/images/notificacao_icone.png" alt="Avisos" class="icon-img"
          style="width:26px;height:26px;margin:0 auto;">
        <div class="quick-card-title">Avisos</div>
      </a>

      <a href="relatorios.php" class="quick-card">
        <img src="../assets/images/grafico_icone.png" alt="Relatórios" class="icon-img"
          style="width:26px;height:26px;margin:0 auto;">
        <div class="quick-card-title">Relatórios</div>
      </a>
    </div>
  </div>

  <!-- RECENT ACTIVITY -->
  <div class="recent-section">
    <h2>Atividades Recentes</h2>

    <div class="recent-item">
      <img src="../assets/images/trem_icone.png" alt="Trem" class="icon-img" style="width:24px;height:24px;">
      09:10 — Trem #4321 partiu para Curitiba
    </div>

    <div class="recent-item">
      <img src="../assets/images/registrar_conta.png" alt="Novo usuário" class="icon-img"
        style="width:24px;height:24px;">
      09:00 — Novo funcionário cadastrado em Operações
    </div>

    <div class="recent-item">
      <img src="../assets/images/notificacao_icone.png" alt="Câmera" class="icon-img" style="width:24px;height:24px;">
      08:52 — Câmera #7 voltou ao status Online
    </div>

    <div class="recent-item">
      <img src="../assets/images/rotas_icone.png" alt="Manutenção" class="icon-img" style="width:24px;height:24px;">
      08:47 — Manutenção agendada em rota SP → Campinas
    </div>
  </div>

  <div class="bottom-nav">
    <a href="dashboard.php" class="active">
      <img src="../assets/images/inicio_png.png" alt="Início" class="icon-img"
        style="width:24px;height:24px;margin-bottom:4px;">
      <span>Início</span>
    </a>

    <a href="rotas.php">
      <img src="../assets/images/rotas_icone.png" alt="Rotas" class="icon-img"
        style="width:24px;height:24px;margin-bottom:4px;">
      <span>Rotas</span>
    </a>

    <a href="chat.php">
      <img src="../assets/images/notificacao_icone.png" alt="Chat" class="icon-img"
        style="width:24px;height:24px;margin-bottom:4px;">
      <span>Chat</span>
    </a>

    <a href="funcionarios.php">
      <img src="../assets/images/icones_funcionarios.png" alt="Funcionários" class="icon-img"
        style="width:24px;height:24px;margin-bottom:4px;">
      <span>Funcionários</span>
    </a>

    <a href="logout_admin.php">
      <img src="../assets/images/logout_icone.png" alt="Sair" class="icon-img"
        style="width:24px;height:24px;margin-bottom:4px;">
      <span>Sair</span>
    </a>
  </div>


</body>

</html>