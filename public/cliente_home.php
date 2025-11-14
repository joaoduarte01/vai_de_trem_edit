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
body {
  background: #f1f5f9;
  font-family: "Inter", sans-serif;
  padding-bottom: 80px; /* espaço pro menu mobile */
}

/* ====== HEADER DO CLIENTE ====== */
.topbar {
  text-align: center;
  margin-top: 26px;
}
.brand-icon {
  background: var(--brand);
  color: #fff;
  font-size: 42px;
  width: 70px;
  height: 70px;
  border-radius: 16px;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 0 auto 12px auto;
}
.topbar h2 {
  margin: 0;
  font-size: 24px;
  font-weight: 700;
  color: #1e293b;
}
.topbar p {
  margin-top: 6px;
  color: #64748b;
}

/* ====== CARDS DE ROTAS ====== */
.section-title {
  margin-top: 32px;
  margin-bottom: 4px;
  font-size: 20px;
  font-weight: 700;
  color: #1e293b;
}

.routes-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(290px, 1fr));
  gap: 18px;
  margin-top: 16px;
}

.route-card {
  background: #fff;
  border-radius: 16px;
  padding: 20px;
  box-shadow: 0 6px 22px rgba(0,0,0,0.06);
  border: 1px solid #e2e8f0;
  transition: .25s ease;
}
.route-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 26px rgba(0,0,0,0.08);
}

.route-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.route-header h3 {
  font-size: 18px;
  color: var(--brand);
  margin: 0;
  font-weight: 700;
}

.route-tag {
  padding: 5px 12px;
  border-radius: 20px;
  font-size: 13px;
  font-weight: 600;
  background: #e5f0ff;
  color: #1e40af;
}

.route-tag.red {
  background: #ffe5e5;
  color: #b91c1c;
}

.route-info {
  margin-top: 10px;
  color: #475569;
  font-size: 14px;
  line-height: 1.45;
}
.route-info i {
  color: var(--brand);
  margin-right: 6px;
}

/* ====== MENU MOBILE FIXO ====== */
.mobile-menu {
  position: fixed;
  bottom: 0;
  left:0;
  right:0;
  height: 65px;
  background: #fff;
  border-top: 1px solid #e2e8f0;
  display: flex;
  justify-content: space-around;
  align-items: center;
  box-shadow: 0 -4px 14px rgba(0,0,0,0.05);
  z-index: 999;
}

.mobile-menu a {
  text-decoration: none;
  display: flex;
  flex-direction: column;
  align-items: center;
  font-size: 13px;
  color: #64748b;
  transition: .2s;
}
.mobile-menu a.active,
.mobile-menu a:hover {
  color: var(--brand);
}

.mobile-menu i {
  font-size: 22px;
}

/* esconder menu no desktop */
@media(min-width: 768px) {
  .mobile-menu { display:none }
}
</style>

</head>
<body>

<div class="container" style="max-width:960px; margin: 20px auto;">

  <div class="topbar">
    <div class="brand-icon"><i class="ri-train-line"></i></div>
    <h2>Olá, <?php echo htmlspecialchars($user['name']); ?>!</h2>
    <p>Bem-vindo(a) à sua área de rotas.</p>
  </div>

  <h3 class="section-title">Rotas Disponíveis</h3>
  <p class="link-muted">Escolha uma rota para visualizar mais informações.</p>

  <div class="routes-grid">

    <div class="route-card">
      <div class="route-header">
        <h3>São Paulo → Rio de Janeiro</h3>
        <span class="route-tag">Ativa</span>
      </div>
      <div class="route-info">
        <p><i class="ri-map-pin-line"></i> Estações: Central • Norte • Sul</p>
        <p><i class="ri-time-line"></i> 6h 30min</p>
        <p><i class="ri-calendar-check-line"></i> Opera diariamente</p>
      </div>
    </div>

    <div class="route-card">
      <div class="route-header">
        <h3>Campinas → Santos</h3>
        <span class="route-tag">Ativa</span>
      </div>
      <div class="route-info">
        <p><i class="ri-map-pin-line"></i> KM 45 • Ponte Rio Grande</p>
        <p><i class="ri-time-line"></i> 3h 45min</p>
        <p><i class="ri-calendar-check-line"></i> Opera diariamente</p>
      </div>
    </div>

    <div class="route-card">
      <div class="route-header">
        <h3>Belo Horizonte → São Paulo</h3>
        <span class="route-tag red">Manutenção</span>
      </div>
      <div class="route-info">
        <p><i class="ri-map-pin-line"></i> Estação Sul • Estação Central</p>
        <p><i class="ri-time-line"></i> 8h 15min</p>
        <p><i class="ri-alert-line"></i> Retorno previsto: 15/11</p>
      </div>
    </div>

    <div class="route-card">
      <div class="route-header">
        <h3>Curitiba → Florianópolis</h3>
        <span class="route-tag">Ativa</span>
      </div>
      <div class="route-info">
        <p><i class="ri-map-pin-line"></i> Estação Norte • Ponte Rio Grande</p>
        <p><i class="ri-time-line"></i> 5h 20min</p>
        <p><i class="ri-calendar-check-line"></i> Opera diariamente</p>
      </div>
    </div>

  </div>
</div>

<!-- MENU MOBILE -->
<div class="mobile-menu">
  <a href="#" class="active">
    <i class="ri-route-line"></i>
    <span>Rotas</span>
  </a>
  <a href="perfil_cliente.php">
    <i class="ri-user-3-line"></i>
    <span>Perfil</span>
  </a>
  <a href="logout.php">
    <i class="ri-logout-box-r-line"></i>
    <span>Sair</span>
  </a>
</div>

</body>
</html>
