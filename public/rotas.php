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
        <h1><img src="../assets/images/rotas_icone.png" alt="Rotas" class="icon-img" style="width:22px;height:22px;">
            Rotas</h1>
    </div>

    <!-- LISTA VISUAL DE ROTAS -->
    <div class="route-list" id="routeList">

        <!-- ROTA 1 -->
        <div class="route-card" onclick="openModal(this)">
            <div class="route-title">São Paulo → Rio de Janeiro</div>
            <span class="badge blue">Ativa</span>

            <div class="details">
                <img src="../assets/images/local_icone.png" alt="Paradas" class="icon-img"
                    style="width:16px;height:16px;"> Paradas: Estação Central • Estação Norte • Estação Sul<br>
                <img src="../assets/images/relogio_icone.png" alt="Duração" class="icon-img"
                    style="width:16px;height:16px;"> Duração: 6h 30min
            </div>

            <div class="live-info">
                <img src="../assets/images/relogio_icone.png" alt="Atualização" class="icon-img"
                    style="width:16px;height:16px;"> Última atualização: 08:32 — Trem chegando em Estação Norte
            </div>
        </div>

        <!-- ROTA 2 -->
        <div class="route-card" onclick="openModal(this)">
            <div class="route-title">Campinas → Santos</div>
            <span class="badge blue">Ativa</span>

            <div class="details">
                <img src="../assets/images/local_icone.png" alt="Paradas" class="icon-img"
                    style="width:16px;height:16px;"> Paradas: KM45 • Ponte Rio Grande<br>
                <img src="../assets/images/relogio_icone.png" alt="Duração" class="icon-img"
                    style="width:16px;height:16px;"> Duração: 3h 45min
            </div>

            <div class="live-info">
                <img src="../assets/images/notificacao_icone.png" alt="Alerta" class="icon-img"
                    style="width:16px;height:16px;"> 5 min de atraso — trecho em velocidade reduzida
            </div>
        </div>

        <!-- ROTA 3 -->
        <div class="route-card" onclick="openModal(this)">
            <div class="route-title">Belo Horizonte → São Paulo</div>
            <span class="badge red">Manutenção</span>

            <div class="details">
                <img src="../assets/images/local_icone.png" alt="Paradas" class="icon-img"
                    style="width:16px;height:16px;"> Paradas: Estação Sul • Estação Central<br>
                <img src="../assets/images/relogio_icone.png" alt="Duração" class="icon-img"
                    style="width:16px;height:16px;"> Duração: 8h 15min
            </div>

            <div class="live-info">
                <img src="../assets/images/notificacao_icone.png" alt="Aviso" class="icon-img"
                    style="width:16px;height:16px;"> Operação suspensa até 15/11
            </div>
        </div>

        <!-- ROTA 4 -->
        <div class="route-card" onclick="openModal(this)">
            <div class="route-title">Curitiba → Florianópolis</div>
            <span class="badge blue">Ativa</span>

            <div class="details">
                <img src="../assets/images/local_icone.png" alt="Paradas" class="icon-img"
                    style="width:16px;height:16px;"> Paradas: Estação Norte • Ponte Rio Grande<br>
                <img src="../assets/images/relogio_icone.png" alt="Duração" class="icon-img"
                    style="width:16px;height:16px;"> Duração: 5h 20min
            </div>

            <div class="live-info">
                <img src="../assets/images/notificacao_icone.png" alt="OK" class="icon-img"
                    style="width:16px;height:16px;"> Trem pontual — tudo normal
            </div>
        </div>

    </div>

    <!-- BOTÃO "+" -->
    <div class="fab" onclick="openModal()"><img src="../assets/images/rotas_icone.png" alt="Adicionar" class="icon-img"
            style="width:28px;height:28px;filter: brightness(0) invert(1);"></div>

    <!-- MODAL VISUAL -->
    <div class="modal-bg" id="modal">
        <div class="modal" onclick="event.stopPropagation()">
            <h2 id="modalTitle">Nova Rota</h2>
            <input class="input" id="routeName" placeholder="Nome da rota">
            <input class="input" id="routeStops" placeholder="Paradas (separadas por vírgula)">
            <input class="input" id="routeDuration" placeholder="Duração (ex: 5h 30min)">
            <textarea class="input" id="routeExtra" placeholder="Informações adicionais (ex: atrasos, observações)"
                rows="3"></textarea>
            <button class="btn" style="margin-top:10px;width:100%;" onclick="saveRoute()">Salvar</button>
        </div>
    </div>

    <!-- NAV INFERIOR -->
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
                        '<img src="../assets/images/local_icone.png" class="icon-img" style="width:16px;height:16px;"> Paradas: ' + stops +
                        '<br><img src="../assets/images/relogio_icone.png" class="icon-img" style="width:16px;height:16px;"> Duração: ' + duration;
                }
                if (liveInfoEl) {
                    liveInfoEl.innerHTML =
                        (extra
                            ? '<img src="../assets/images/notificacao_icone.png" class="icon-img" style="width:16px;height:16px;"> ' + extra
                            : '<img src="../assets/images/notificacao_icone.png" class="icon-img" style="width:16px;height:16px;"> Sem informações adicionais');
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
                <img src="../assets/images/local_icone.png" class="icon-img" style="width:16px;height:16px;"> Paradas: ${stops}<br>
                <img src="../assets/images/relogio_icone.png" class="icon-img" style="width:16px;height:16px;"> Duração: ${duration}
            </div>

            <div class="live-info">
                ${extra
                        ? `<img src="../assets/images/notificacao_icone.png" class="icon-img" style="width:16px;height:16px;"> ${extra}`
                        : `<img src="../assets/images/notificacao_icone.png" class="icon-img" style="width:16px;height:16px;"> Sem informações adicionais`}
            </div>
        `;

                routeList.appendChild(newCard);
            }

            closeModal();
        }

        // fechar clicando fora do box
        window.addEventListener("click", function (e) {
            if (e.target.id === "modal") {
                closeModal();
            }
        });
    </script>

</body>

</html>