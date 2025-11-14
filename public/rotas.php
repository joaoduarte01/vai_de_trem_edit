<?php
require_once('../assets/config/auth.php');
require_once('../assets/config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $name = trim($_POST['name'] ?? '');
    $status = $_POST['status'] ?? 'ativa';
    $dur = intval($_POST['duration'] ?? 0);

    if ($name) {
        $stmt = $mysqli->prepare("INSERT INTO routes (name, status, duration_minutes) VALUES (?, ?, ?)");
        $stmt->bind_param('ssi', $name, $status, $dur);
        $stmt->execute();
    }

    header('Location: rotas.php');
    exit;
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $mysqli->prepare("DELETE FROM routes WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: rotas.php');
    exit;
}
?>
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

    /* CARDS */
    .route-list {
        padding: 18px;
        display: grid;
        gap: 16px;
    }

    .route-card {
        background: #fff;
        padding: 18px;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    }

    .route-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 6px;
        color: #1e293b;
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
    }

    .delete-btn {
        margin-top: 12px;
        display: inline-block;
        background: #ff4b4b;
        padding: 8px 14px;
        border-radius: 10px;
        color: #fff;
        font-size: 13px;
    }

    /* Floating Button */
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

    /* Modal */
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

    .input, .select {
        width: 100%;
        margin: 6px 0;
    }

    /* Bottom Nav */
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
        margin-bottom: 4px;
    }
    .active {
        color: var(--brand) !important;
    }
</style>

</head>
<body>

<!-- HEADER -->
<div class="top-header">
    <h1><i class="ri-route-line"></i> Rotas</h1>
</div>

<!-- LISTA DE ROTAS -->
<div class="route-list">

<?php
$res = $mysqli->query("SELECT * FROM routes ORDER BY id DESC");

while ($r = $res->fetch_assoc()) {
    $badge = $r['status'] === 'ativa'
        ? '<span class="badge blue">Ativa</span>'
        : '<span class="badge red">Manutenção</span>';

    echo "
    <div class='route-card'>
        <div class='route-title'>".htmlspecialchars($r['name'])."</div>
        $badge
        <div class='details'><i class='ri-time-line'></i> ".($r['duration_minutes'] ?: '-')." min</div>
        <a class='delete-btn' href='?delete=".$r['id']."' onclick='return confirm(\"Excluir esta rota?\")'>
            <i class='ri-delete-bin-line'></i> Excluir
        </a>
    </div>";
}
?>

</div>

<!-- FAB BUTTON -->
<div class="fab" onclick="openModal()"><i class="ri-add-line"></i></div>

<!-- MODAL NOVA ROTA -->
<div class="modal-bg" id="modal">
  <div class="modal">
    <h2>Nova Rota</h2>
    <form method="post">
      <input type="hidden" name="create" value="1">
      <input class="input" name="name" placeholder="Nome da rota" required>
      <select class="select" name="status">
        <option value="ativa">Ativa</option>
        <option value="manutencao">Manutenção</option>
      </select>
      <input class="input" type="number" name="duration" placeholder="Duração (min)">
      <button class="btn" style="margin-top:10px;width:100%;">Salvar</button>
    </form>
  </div>
</div>

<!-- BOTTOM NAV -->
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
window.onclick = e => {
  if (e.target.id === "modal") document.getElementById("modal").style.display = "none";
}
</script>

</body>
</html>
