<?php require_once('../assets/config/auth.php'); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Rotas - Vai de Trem</title>

<link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
<link href="../assets/css/styles.css" rel="stylesheet">

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
        <h2>Nova Rota </h2>
        <input class="input" placeholder="Nome da rota">
        <input class="input" placeholder="Paradas">
        <input class="input" placeholder="Duração (ex: 5h 30min)">
        <button class="btn" style="margin-top:10px;width:100%;" onclick="closeModal()">Salvar </button>
    </div>
</div>

<!-- NAV INFERIOR -->
<div class="bottom-nav">
  <a href="dashboard.php" class="active">
    <i class="ri-dashboard-line"></i>
    <span>Início</span>
  </a>

  <a href="rotas.php">
    <i class="ri-route-line"></i>
    <span>Rotas</span>
  </a>

  <a href="chat.php">
    <i class="ri-message-3-line"></i>
    <span>Chat</span>
  </a>

  <a href="funcionarios.php">
    <i class="ri-team-line"></i>
    <span>Funcionários</span>
  </a>

  <a href="logout_admin.php">
    <i class="ri-logout-box-r-line"></i>
    <span>Sair</span>
  </a>
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
