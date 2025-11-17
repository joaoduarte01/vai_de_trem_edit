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

.route-title {
    font-size: 17px;
    font-weight: 600;
    margin-bottom: 4px;
}

.badge {
    font-size: 12px;
    padding: 5px 10px;
    border-radius: 20px;
}
.badge.blue { background:#00c52b; color:#fff; }
.badge.red { background:#ff6b6b; color:#fff; }

.details {
    color: #64748b;
    font-size: 14px;
    margin-top: 6px;
    line-height: 1.45;
}

/* STATUS */
.live-info {
    background: #eef4ff;
    padding: 10px 14px;
    border-radius: 12px;
    font-size: 13px;
    margin-top: 12px;
    color: #1e40af;
}
.live-info i {
    margin-right: 6px;
}

/* FAB */
.fab {
    position: fixed;
    right: 20px;
    bottom: 88px;
    width: 60px;
    height: 60px;
    background: var(--brand);
    color: #fff;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 28px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.2);
    cursor: pointer;
}

/* MODAL */
.modal-bg {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.4);
    display: none;
    justify-content: center;
    align-items: center;
    padding: 20px;
}
.modal {
    background: #fff;
    padding: 20px;
    border-radius: 16px;
    width: 100%;
    max-width: 420px;
}
.modal h2 {
    margin-bottom: 12px;
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
    color: var(--brand) !important;
}
</style>
</head>
<body>

<!-- HEADER -->
<div class="top-header">
    <h1><i class="ri-route-line"></i> Rotas</h1>
</div>

<!-- LISTA VISUAL DE ROTAS -->
<div class="route-list">

    <!-- ROTA 1 -->
    <div class="route-card">
        <div class="route-title">São Paulo → Rio de Janeiro</div>
        <span class="badge blue">Ativa</span>

        <div class="details">
            <i class="ri-map-pin-line"></i> Paradas: Estação Central • Estação Norte • Estação Sul<br>
            <i class="ri-time-line"></i> Duração: 6h 30min
        </div>

        <div class="live-info">
            <i class="ri-time-line"></i> Última atualização: 08:32  
            — Trem chegando em *Estação Norte*
        </div>
    </div>

    <!-- ROTA 2 -->
    <div class="route-card">
        <div class="route-title">Campinas → Santos</div>
        <span class="badge blue">Ativa</span>

        <div class="details">
            <i class="ri-map-pin-line"></i> Paradas: KM45 • Ponte Rio Grande<br>
            <i class="ri-time-line"></i> Duração: 3h 45min
        </div>

        <div class="live-info">
            <i class="ri-alert-line"></i> *5 min de atraso* — trecho em velocidade reduzida
        </div>
    </div>

    <!-- ROTA 3 -->
    <div class="route-card">
        <div class="route-title">Belo Horizonte → São Paulo</div>
        <span class="badge red">Manutenção</span>

        <div class="details">
            <i class="ri-map-pin-line"></i> Paradas: Estação Sul • Estação Central<br>
            <i class="ri-time-line"></i> Duração: 8h 15min
        </div>

        <div class="live-info" style="color:#b91c1c;background:#ffecec;">
            <i class="ri-error-warning-line"></i> Operação suspensa até 15/11
        </div>
    </div>

    <!-- ROTA 4 -->
    <div class="route-card">
        <div class="route-title">Curitiba → Florianópolis</div>
        <span class="badge blue">Ativa</span>

        <div class="details">
            <i class="ri-map-pin-line"></i> Paradas: Estação Norte • Ponte Rio Grande<br>
            <i class="ri-time-line"></i> Duração: 5h 20min
        </div>

        <div class="live-info">
            <i class="ri-check-line"></i> Trem pontual — tudo normal
        </div>
    </div>

</div>

<!-- BOTÃO "+" -->
<div class="fab" onclick="openModal()"><i class="ri-add-line"></i></div>

<!-- MODAL VISUAL -->
<div class="modal-bg" id="modal">
    <div class="modal">
        <h2>Nova Rota (Visual)</h2>
        <input class="input" placeholder="Nome da rota">
        <input class="input" placeholder="Paradas">
        <input class="input" placeholder="Duração (ex: 5h 30min)">
        <button class="btn" style="margin-top:10px;width:100%;" onclick="closeModal()">Salvar (Visual)</button>
    </div>
</div>

<!-- NAV INFERIOR -->
<div class="bottom-nav">
  <a href="dashboard.php"><i class="ri-dashboard-line"></i>Início</a>
  <a href="rotas.php" class="active"><i class="ri-route-line"></i>Rotas</a>
  <a href="cameras.php"><i class="ri-camera-line"></i>Câmeras</a>
  <a href="avisos.php"><i class="ri-notification-3-line"></i>Avisos</a>
  <a href="meu_perfil.php"><i class="ri-user-line"></i>Perfil</a>
</div>

<script>
function openModal() {
    document.getElementById("modal").style.display = "flex";
}
function closeModal() {
    document.getElementById("modal").style.display = "none";
}
window.onclick = e => {
    if (e.target.id === "modal") closeModal();
};
</script>

</body>
</html>
