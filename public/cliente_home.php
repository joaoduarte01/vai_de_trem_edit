<?php
require_once('../assets/config/auth.php');
$user = $_SESSION['user'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<title>Área do Cliente - Vai de Trem</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../assets/css/styles.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
<style>
.routes-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 20px;
  margin-top: 20px;
}
.route-card {
  background: #fff;
  border: 1px solid var(--border);
  border-radius: var(--radius);
  padding: 20px;
  box-shadow: 0 4px 14px rgba(0,0,0,0.05);
  transition: var(--transition);
  text-align: left;
}
.route-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 20px rgba(30,102,255,0.15);
}
.route-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 10px;
}
.route-header h3 {
  font-size: 18px;
  color: var(--brand);
  margin: 0;
}
.route-info {
  color: var(--muted);
  font-size: 14px;
  margin-top: 8px;
}
.route-tag {
  background: #eef4ff;
  color: #1e3a8a;
  padding: 4px 10px;
  border-radius: 999px;
  font-size: 13px;
}
.topbar {
  text-align: center;
  margin-bottom: 30px;
}
.topbar h2 {
  color: var(--brand);
  margin-bottom: 8px;
}

/* === MENU INFERIOR MOBILE === */
.mobile-menu {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  background: #fff;
  border-top: 1px solid var(--border);
  display: flex;
  justify-content: space-around;
  align-items: center;
  padding: 10px 0;
  box-shadow: 0 -4px 20px rgba(0,0,0,0.05);
  z-index: 999;
}
.mobile-menu a {
  color: var(--muted);
  font-size: 14px;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 4px;
  transition: var(--transition);
}
.mobile-menu a:hover, .mobile-menu a.active {
  color: var(--brand);
}
.mobile-menu i {
  font-size: 22px;
}
@media (min-width: 768px) {
  .mobile-menu { display: none; } /* oculta no desktop */
}
</style>
</head>
<body>

<div class="container" style="max-width:960px; margin:60px auto;">
  <div class="topbar">
    <div class="brand-icon" style="margin:0 auto 10px auto;"><i class="ri-train-line"></i></div>
    <h2>Bem-vindo(a), <?php echo htmlspecialchars($user['name']); ?>!</h2>
    <p class="link-muted">Você está logado como <b>Cliente</b> no sistema Vai de Trem.</p>
  </div>

  <h3 style="margin-top:30px;">Rotas Disponíveis</h3>
  <p class="link-muted">Confira abaixo as principais linhas em operação:</p>

  <div class="routes-grid">
    <div class="route-card">
      <div class="route-header">
        <h3>São Paulo → Rio de Janeiro</h3>
        <span class="route-tag">Ativa</span>
      </div>
      <div class="route-info">
        <p><i class="ri-map-pin-line"></i> Paradas: Estação Central • Estação Norte • Estação Sul</p>
        <p><i class="ri-time-line"></i> Duração: 6h 30min</p>
        <p><i class="ri-calendar-check-line"></i> Operando diariamente</p>
      </div>
    </div>

    <div class="route-card">
      <div class="route-header">
        <h3>Campinas → Santos</h3>
        <span class="route-tag">Ativa</span>
      </div>
      <div class="route-info">
        <p><i class="ri-map-pin-line"></i> Paradas: Túnel KM 45 • Ponte Rio Grande</p>
        <p><i class="ri-time-line"></i> Duração: 3h 45min</p>
        <p><i class="ri-calendar-check-line"></i> Operando diariamente</p>
      </div>
    </div>

    <div class="route-card">
      <div class="route-header">
        <h3>Belo Horizonte → São Paulo</h3>
        <span class="route-tag" style="background:#ffe9e9;color:#b91c1c;">Manutenção</span>
      </div>
      <div class="route-info">
        <p><i class="ri-map-pin-line"></i> Paradas: Estação Sul • Estação Central</p>
        <p><i class="ri-time-line"></i> Duração: 8h 15min</p>
        <p><i class="ri-alert-line"></i> Em manutenção até 15/11</p>
      </div>
    </div>

    <div class="route-card">
      <div class="route-header">
        <h3>Curitiba → Florianópolis</h3>
        <span class="route-tag">Ativa</span>
      </div>
      <div class="route-info">
        <p><i class="ri-map-pin-line"></i> Paradas: Estação Norte • Ponte Rio Grande</p>
        <p><i class="ri-time-line"></i> Duração: 5h 20min</p>
        <p><i class="ri-calendar-check-line"></i> Operando diariamente</p>
      </div>
    </div>
  </div>
</div>

<!-- MENU FIXO MOBILE -->
<div class="mobile-menu">
  <a href="#" class="active">
    <i class="ri-route-line"></i>
    <span>Rotas</span>
  </a>
  <a href="editar_perfil.php">
    <i class="ri-user-settings-line"></i>
    <span>Perfil</span>
  </a>
  <a href="logout.php">
    <i class="ri-logout-circle-line"></i>
    <span>Sair</span>
  </a>
</div>

</body>
</html>
