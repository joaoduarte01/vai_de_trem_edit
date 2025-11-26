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
<div class="route-list" id="routeList">

    <!-- ROTA 1 -->
    <div class="route-card" onclick="openModal(this)">
        <div class="route-title">São Paulo → Rio de Janeiro</div>
        <span class="badge blue">Ativa</span>

        <div class="details">
            <i class="ri-map-pin-line"></i> Paradas: Estação Central • Estação Norte • Estação Sul<br>
            <i class="ri-time-line"></i> Duração: 6h 30min
        </div>

        <div class="live-info">
            <i class="ri-time-line"></i> Última atualização: 08:32 — Trem chegando em Estação Norte
        </div>
    </div>

    <!-- ROTA 2 -->
    <div class="route-card" onclick="openModal(this)">
        <div class="route-title">Campinas → Santos</div>
        <span class="badge blue">Ativa</span>

        <div class="details">
            <i class="ri-map-pin-line"></i> Paradas: KM45 • Ponte Rio Grande<br>
            <i class="ri-time-line"></i> Duração: 3h 45min
        </div>

        <div class="live-info">
            <i class="ri-alert-line"></i> 5 min de atraso — trecho em velocidade reduzida
        </div>
    </div>

    <!-- ROTA 3 -->
    <div class="route-card" onclick="openModal(this)">
        <div class="route-title">Belo Horizonte → São Paulo</div>
        <span class="badge red">Manutenção</span>

        <div class="details">
            <i class="ri-map-pin-line"></i> Paradas: Estação Sul • Estação Central<br>
            <i class="ri-time-line"></i> Duração: 8h 15min
        </div>

        <div class="live-info">
            <i class="ri-error-warning-line"></i> Operação suspensa até 15/11
        </div>
    </div>

    <!-- ROTA 4 -->
    <div class="route-card" onclick="openModal(this)">
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
    <div class="modal" onclick="event.stopPropagation()">
        <h2 id="modalTitle">Nova Rota</h2>
        <input class="input" id="routeName" placeholder="Nome da rota">
        <input class="input" id="routeStops" placeholder="Paradas (separadas por vírgula)">
        <input class="input" id="routeDuration" placeholder="Duração (ex: 5h 30min)">
        <textarea class="input" id="routeExtra" placeholder="Informações adicionais (ex: atrasos, observações)" rows="3"></textarea>
        <button class="btn" style="margin-top:10px;width:100%;" onclick="saveRoute()">Salvar</button>
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
let editingCard = null;

function openModal(card = null) {
    const modalBg = document.getElementById("modal");
    const titleEl = document.getElementById("modalTitle");
    const nameInput = document.getElementById("routeName");
    const stopsInput = document.getElementById("routeStops");
    const durationInput = document.getElementById("routeDuration");
    const extraInput = document.getElementById("routeExtra");

    editingCard = card;

    if (editingCard) {
        // Modo editar rota existente
        titleEl.textContent = "Editar Rota";

        const title = editingCard.querySelector(".route-title")?.innerText || "";
        const details = editingCard.querySelector(".details")?.innerText || "";
        const liveInfo = editingCard.querySelector(".live-info")?.innerText || "";

        nameInput.value = title.trim();

        // Pega texto entre "Paradas:" e "Duração:"
        let stopsText = "";
        let durationText = "";

        if (details.includes("Paradas:")) {
            stopsText = details.split("Paradas:")[1] || "";
            if (stopsText.includes("Duração:")) {
                const parts = stopsText.split("Duração:");
                stopsText = parts[0];
                durationText = parts[1];
            }
        }
        if (!durationText && details.includes("Duração:")) {
            durationText = details.split("Duração:")[1] || "";
        }

        stopsInput.value = stopsText.replace(/\s+/g, " ").trim();
        durationInput.value = durationText.replace(/\s+/g, " ").trim();

        extraInput.value = liveInfo
          .replace(/\s+/g, " ")
          .replace(/^\s*[\u200B-\u200D\uFEFF]/g, "")
          .trim();
    } else {
        // Modo criar nova rota
        titleEl.textContent = "Nova Rota";
        nameInput.value = "";
        stopsInput.value = "";
        durationInput.value = "";
        extraInput.value = "";
    }

    modalBg.style.display = "flex";
}

function closeModal() {
    document.getElementById("modal").style.display = "none";
    editingCard = null;
}

function saveRoute() {
    const nameInput = document.getElementById("routeName");
    const stopsInput = document.getElementById("routeStops");
    const durationInput = document.getElementById("routeDuration");
    const extraInput = document.getElementById("routeExtra");
    const routeList = document.getElementById("routeList");

    const name = nameInput.value.trim();
    const stops = stopsInput.value.trim();
    const duration = durationInput.value.trim();
    const extra = extraInput.value.trim();

    if (!name || !stops || !duration) {
        alert("Preencha pelo menos Nome da rota, Paradas e Duração.");
        return;
    }

    if (editingCard) {
        // Atualizar rota existente
        const titleEl = editingCard.querySelector(".route-title");
        const detailsEl = editingCard.querySelector(".details");
        const liveInfoEl = editingCard.querySelector(".live-info");

        if (titleEl) titleEl.innerText = name;
        if (detailsEl) {
            detailsEl.innerHTML =
                '<i class="ri-map-pin-line"></i> Paradas: ' + stops +
                '<br><i class="ri-time-line"></i> Duração: ' + duration;
        }
        if (liveInfoEl) {
            liveInfoEl.innerHTML =
                (extra
                    ? '<i class="ri-information-line"></i> ' + extra
                    : '<i class="ri-check-line"></i> Sem informações adicionais');
        }
    } else {
        // Criar nova rota
        const newCard = document.createElement("div");
        newCard.className = "route-card";
        newCard.onclick = function () { openModal(newCard); };

        newCard.innerHTML = `
            <div class="route-title">${name}</div>
            <span class="badge blue">Ativa</span>

            <div class="details">
                <i class="ri-map-pin-line"></i> Paradas: ${stops}<br>
                <i class="ri-time-line"></i> Duração: ${duration}
            </div>

            <div class="live-info">
                ${extra
                    ? `<i class="ri-information-line"></i> ${extra}`
                    : `<i class="ri-check-line"></i> Sem informações adicionais`}
            </div>
        `;

        routeList.appendChild(newCard);
    }

    closeModal();
}

// fechar clicando fora do box
window.addEventListener("click", function(e) {
    if (e.target.id === "modal") {
        closeModal();
    }
});
</script>

</body>
</html>
