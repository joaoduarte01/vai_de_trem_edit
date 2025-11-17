<?php require_once('../assets/config/auth.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Rotas - Vai de Trem</title>

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
    gap: 10px;
    border-radius: 0 0 18px 18px;
}
.top-header h1 {
    font-size: 20px;
    font-weight: 700;
}

/* LISTA */
.route-list {
    padding: 18px;
    display: grid;
    gap: 16px;
}

/* CARD */
.route-card {
    background: #fff;
    padding: 18px;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
}

/* PROGRESS BAR */
.progress-box {
    margin-top: 14px;
    background: #eef3ff;
    border-radius: 12px;
    height: 12px;
    position: relative;
    overflow: hidden;
}
.progress {
    height: 100%;
    border-radius: 12px;
    background: linear-gradient(90deg, #00c52b, #32e36e);
    width: 0%;
    transition: width 1s ease-in-out;
}
.progress.delay {
    background: linear-gradient(90deg, #facc15, #fcd34d);
}

/* TEXTOS */
.route-title {
    font-size: 17px;
    font-weight: 600;
}
.badge.blue { background:#00c52b; color:#fff; }
.badge.red { background:#ff6b6b; color:#fff; }

.details {
    font-size: 14px;
    color: #64748b;
    margin-top: 6px;
}

.live-info {
    font-size: 13px;
    color: #334155;
    margin-top: 6px;
}

/* BOTTOM NAV */
.bottom-nav {
    position: fixed; bottom: 0; left: 0; right: 0;
    background: #fff;
    height: 70px;
    display: flex; justify-content: space-around; align-items: center;
    border-top: 1px solid var(--border);
    box-shadow: 0 -2px 10px rgba(0,0,0,0.08);
}
.bottom-nav a {
    color: var(--muted);
    text-align: center;
    font-size: 12px;
    text-decoration: none;
}
.bottom-nav i {
    font-size: 24px;
    display: block;
}
.bottom-nav a.active {
    color: var(--brand);
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="top-header">
    <h1><i class="ri-route-line"></i> Rotas</h1>
</div>

<div class="route-list">

<!-- ROTA 1 -->
<div class="route-card">
    <div class="route-title">São Paulo → Rio de Janeiro</div>
    <span class="badge blue">Ativa</span>

    <div class="details">
        <i class="ri-map-pin-line"></i> Paradas: Estação Central • Norte • Sul<br>
        <i class="ri-time-line"></i> Duração total: 6h 30min
    </div>

    <div class="live-info">
        <i class="ri-train-line"></i> Progresso: <b id="p1_text">0%</b> — Chegando em Estação Norte
    </div>

    <div class="progress-box">
        <div class="progress" id="p1"></div>
    </div>
</div>

<!-- ROTA 2 - ATRASO -->
<div class="route-card">
    <div class="route-title">Campinas → Santos</div>
    <span class="badge blue">Ativa</span>

    <div class="details">
        <i class="ri-map-pin-line"></i> Paradas: KM45 • Ponte Rio Grande<br>
        <i class="ri-time-line"></i> Duração total: 3h 45min
    </div>

    <div class="live-info" style="color:#b45309;">
        <i class="ri-alert-line"></i> Atraso de 5 minutos — trecho lento
    </div>

    <div class="progress-box">
        <div class="progress delay" id="p2"></div>
    </div>
</div>

<!-- ROTA 3 - PARADA -->
<div class="route-card">
    <div class="route-title">Belo Horizonte → São Paulo</div>
    <span class="badge red">Manutenção</span>

    <div class="details">
        <i class="ri-map-pin-line"></i> Paradas: Estação Sul • Central<br>
        <i class="ri-time-line"></i> Duração: 8h 15min
    </div>

    <div class="live-info" style="color:#b91c1c;">
        <i class="ri-error-warning-line"></i> Operação suspensa até 15/11
    </div>

    <div class="progress-box">
        <div class="progress delay" style="width:0%"></div>
    </div>
</div>

<!-- ROTA 4 -->
<div class="route-card">
    <div class="route-title">Curitiba → Florianópolis</div>
    <span class="badge blue">Ativa</span>

    <div class="details">
        <i class="ri-map-pin-line"></i> Paradas: Estação Norte • Ponte Rio Grande<br>
        <i class="ri-time-line"></i> Duração total: 5h 20min
    </div>

    <div class="live-info">
        <i class="ri-check-line"></i> Trem pontual — tudo normal
    </div>

    <div class="progress-box">
        <div class="progress" id="p4"></div>
    </div>
</div>

</div>

<!-- NAV -->
<div class="bottom-nav">
  <a href="dashboard.php"><i class="ri-dashboard-line"></i>Início</a>
  <a href="rotas.php" class="active"><i class="ri-route-line"></i>Rotas</a>
  <a href="cameras.php"><i class="ri-camera-line"></i>Câmeras</a>
  <a href="avisos.php"><i class="ri-notification-3-line"></i>Avisos</a>
  <a href="meu_perfil.php"><i class="ri-user-line"></i>Perfil</a>
</div>

<script>
// progresso simulado
function animateProgress(id, textId, target) {
    let bar = document.getElementById(id);
    let txt = document.getElementById(textId);
    let progress = 0;

    let interval = setInterval(() => {
        if (progress >= target) clearInterval(interval);
        progress++;
        bar.style.width = progress + "%";
        if (txt) txt.innerText = progress + "%";
    }, 50);
}

animateProgress("p1", "p1_text", 72); // rota 1: 72% concluído
animateProgress("p2", null, 40);    // rota atrasada
animateProgress("p4", null, 83);    // rota avançada
</script>

</body>
</html>
