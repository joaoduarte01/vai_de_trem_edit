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
    gap: 18px;
}

/* CARD */
.route-card {
    background: #fff;
    padding: 18px;
    border-radius: 18px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
}

/* PROGRESS BAR COMPLEXA */
.progress-container {
    margin-top: 16px;
}

.stations {
    display: flex;
    justify-content: space-between;
    font-size: 11px;
    color: #475569;
    margin-bottom: 6px;
}

.bar-outer {
    width: 100%;
    height: 14px;
    background: #e2e8f0;
    border-radius: 20px;
    position: relative;
    overflow: hidden;
}

.bar-inner {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg, #0ea5e9, #38bdf8);
    border-radius: 20px;
    transition: width 1s linear;
}

.train-icon {
    position: absolute;
    top: -16px;
    font-size: 26px;
    transition: left 1s linear;
}

/* DETALHES DE INFORMAÇÃO */
.live-info {
    margin-top: 10px;
    font-size: 14px;
    color: #334155;
    line-height: 1.4;
}

.live-info b {
    color: #1e66ff;
}

/* BADGES */
.badge.blue { background:#00c52b; color:#fff; padding:5px 10px; border-radius:10px;}
.badge.red { background:#ff4b4b; color:#fff; padding:5px 10px; border-radius:10px; }

/* NAV */
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
.bottom-nav a.active { color: var(--brand); }

</style>
</head>

<body>

<!-- HEADER -->
<div class="top-header">
    <h1><i class="ri-route-line"></i> Rotas – Monitoramento ao Vivo</h1>
</div>

<div class="route-list">

<!-- ============================
      ROTA 1 – ANIMAÇÃO COMPLETA
============================= -->
<div class="route-card">
    <div class="route-title">São Paulo → Rio de Janeiro</div>
    <span class="badge blue">Ativa</span>

    <div class="details">
        <i class="ri-map-pin-line"></i> Estações: Central • Norte • Fronteira • Rio Centro <br>
        <i class="ri-time-line"></i> Duração total: 6h 30min
    </div>

    <!-- Estações -->
    <div class="progress-container">
        <div class="stations">
            <span>Central</span>
            <span>Norte</span>
            <span>Fronteira</span>
            <span>Rio</span>
        </div>

        <div class="bar-outer">
            <div class="bar-inner" id="r1"></div>
            <i class="ri-train-fill train-icon" id="train1"></i>
        </div>
    </div>

    <div class="live-info">
        Progresso: <b id="r1_txt">0%</b><br>
        Velocidade: <b id="v1">0 km/h</b><br>
        Chegada prevista: <b id="eta1">--:--</b>
    </div>
</div>


<!-- ============================
      ROTA 2 – COM ATRASO
============================= -->
<div class="route-card">
    <div class="route-title">Campinas → Santos</div>
    <span class="badge red">Atraso</span>

    <div class="details">
        <i class="ri-map-pin-line"></i> KM45 • Ponte Grande • Baixada<br>
        <i class="ri-time-line"></i> Duração: 3h 45min
    </div>

    <div class="progress-container">
        <div class="stations">
            <span>KM45</span>
            <span>Ponte</span>
            <span>Baixada</span>
        </div>

        <div class="bar-outer">
            <div class="bar-inner" id="r2" style="background:linear-gradient(90deg,#f59e0b,#fbbf24);"></div>
            <i class="ri-train-fill train-icon" id="train2"></i>
        </div>
    </div>

    <div class="live-info" style="color:#b45309;">
        Progresso: <b id="r2_txt">0%</b> (trecho lento)<br>
        Velocidade: <b id="v2">0 km/h</b><br>
        ETA ajustada: <b id="eta2">--:--</b>
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
// Função de animação completa
function simulateRoute(progressId, trainId, textId, speedId, etaId, maxProgress, durationMinutes, delay = 0) {
    let bar = document.getElementById(progressId);
    let train = document.getElementById(trainId);
    let txt = document.getElementById(textId);
    let speedTxt = document.getElementById(speedId);
    let etaTxt = document.getElementById(etaId);

    let p = 0;

    let interval = setInterval(() => {
        if (p >= maxProgress) clearInterval(interval);

        p++;

        bar.style.width = p + "%";
        train.style.left = `calc(${p}% - 12px)`;
        txt.innerText = p + "%";

        // velocidade variando realisticamente
        let speed = Math.floor(Math.random() * 30) + 70 - delay;
        if (speed < 10) speed = 10;
        speedTxt.innerText = speed + " km/h";

        // ETA aproximada
        let minutesLeft = Math.floor((durationMinutes * (100 - p)) / 100);
        let now = new Date();
        now.setMinutes(now.getMinutes() + minutesLeft);
        etaTxt.innerText = now.toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'});
    }, 90);
}

// ROTA 1
simulateRoute("r1", "train1", "r1_txt", "v1", "eta1", 72, 390);

// ROTA 2 (com atraso)
simulateRoute("r2", "train2", "r2_txt", "v2", "eta2", 40, 225, 25);
</script>

</body>
</html>
