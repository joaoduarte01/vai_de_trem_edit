<?php 
require_once('../assets/config/auth.php'); 
require_once('../assets/config/db.php');

$feedback = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $name       = trim($_POST['name'] ?? '');
  $phone      = trim($_POST['phone'] ?? '');
  $department = trim($_POST['department'] ?? '');
  $job        = trim($_POST['job_title'] ?? '');

  // Avatar
  $avatarPath = $user['avatar'];
  if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {

    $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
    $fname = 'u'.$user['id'].'_'.time().'.'.$ext;

    $dest = '../assets/uploads/profile_photos/'.$fname;

    if (move_uploaded_file($_FILES['avatar']['tmp_name'], $dest)) {
      $avatarPath = $fname;
      $_SESSION['user']['avatar'] = $avatarPath;
    }
  }

  // Update
  $stmt = $mysqli->prepare("UPDATE users SET name=?, phone=?, department=?, job_title=?, avatar=? WHERE id=?");
  $stmt->bind_param('sssssi', $name, $phone, $department, $job, $avatarPath, $user['id']);

  if ($stmt->execute()) {
    $_SESSION['user']['name'] = $name;
    $feedback = 'Perfil atualizado com sucesso!';
  }
}

// Busca atualizada
$res = $mysqli->query("SELECT * FROM users WHERE id=".$user['id']);
$me  = $res->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Meu Perfil - Vai de Trem</title>
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
<link href="../assets/css/styles.css" rel="stylesheet">

<style>
body {
  background: #f5f9ff;
  padding-bottom: 110px;
  font-family: 'Poppins', sans-serif;
  transition: 0.25s ease;
}

/* Dark Mode */
body.dark {
  background: #1e293b;
  color: #e2e8f0;
}
body.dark .profile-card {
  background: #334155;
  color: #e2e8f0;
}
body.dark input,
body.dark .input {
  background: #475569;
  border-color: #334155;
  color: #fff;
}
body.dark .bottom-nav {
  background: #334155;
  border-color: #1e293b;
}
body.dark .top-header {
  background: #0ea5e9;
}

/* HEADER */
.top-header {
  background: var(--brand);
  color: #fff;
  padding: 18px 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-radius: 0 0 18px 18px;
}
.top-header h1 {
  font-size: 20px;
  font-weight: 700;
  display: flex;
  align-items: center;
  gap: 6px;
}

/* Toggle Dark Mode */
.toggle-dark {
  background: rgba(255,255,255,0.25);
  padding: 8px 12px;
  border-radius: 10px;
  cursor: pointer;
  font-size: 20px;
}

/* CARD PRINCIPAL */
.profile-card {
  margin: 22px;
  background: #fff;
  border-radius: 16px;
  padding: 22px;
  box-shadow: 0 3px 12px rgba(0,0,0,0.08);
}

/* AVATAR */
.avatar-box {
  text-align: center;
  margin-bottom: 22px;
  position: relative;
}
.avatar-box img {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  object-fit: cover;
  border: 4px solid #fff;
  box-shadow: 0 3px 12px rgba(0,0,0,0.15);
  transition: 0.3s ease;
}
.avatar-box img:hover {
  transform: scale(1.05);
}
.file-input {
  margin-top: 10px;
  font-size: 13px;
}

/* LEVEL */
.level-box {
  text-align: center;
  margin-bottom: 10px;
}
.level-bar {
  width: 100%;
  height: 10px;
  background: #e2e8f0;
  border-radius: 14px;
  overflow: hidden;
}
.level-fill {
  width: <?php echo rand(45,85); ?>%;
  height: 100%;
  background: linear-gradient(90deg, #0ea5e9, #38bdf8);
}

/* ACTIVITY BOX */
.activity-box {
  padding: 14px;
  margin-top: 18px;
  border-radius: 14px;
  background: #f8fafc;
}
body.dark .activity-box { background: #475569; }

.activity-box div {
  font-size: 14px;
  margin-bottom: 6px;
}

/* Bottom Nav */
.bottom-nav {
  position: fixed; bottom: 0; left: 0; right: 0;
  background: #fff;
  height: 70px;
  display: flex; justify-content: space-around; align-items: center;
  border-top: 1px solid var(--border);
  box-shadow: 0 -2px 10px rgba(0,0,0,0.08);
  z-index: 500;
}
.bottom-nav a {
  text-decoration: none;
  text-align: center;
  color: var(--muted);
  font-size: 12px;
}
.bottom-nav i {
  font-size: 24px;
  display: block;
  margin-bottom: 4px;
}
.bottom-nav a.active {
  color: var(--brand);
}

</style>
</head>

<body>

<!-- HEADER -->
<div class="top-header">
  <h1><i class="ri-user-settings-line"></i> Meu Perfil</h1>

  <div class="toggle-dark" onclick="toggleDarkMode()">
    <i class="ri-moon-line"></i>
  </div>
</div>

<!-- CARD -->
<div class="profile-card">

  <?php if ($feedback): ?>
    <div class="badge" style="margin-bottom:12px;"><?php echo $feedback; ?></div>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data">

    <div class="avatar-box">
      <img id="previewImg"
        src="<?php echo $me['avatar'] 
        ? '../assets/uploads/profile_photos/'.$me['avatar'] 
        : '../assets/uploads/profile_photos/avatar-default.png'; ?>">

      <input type="file" name="avatar" class="file-input" accept="image/*" onchange="previewImage(event)">
    </div>

    <!-- LEVEL -->
    <div class="level-box">
      <small>Nível da conta</small>
      <div class="level-bar"><div class="level-fill"></div></div>
    </div>

    <input class="input" name="name" value="<?php echo htmlspecialchars($me['name']); ?>" placeholder="Nome completo">
    <input class="input" type="email" disabled value="<?php echo htmlspecialchars($me['email']); ?>">
    <input class="input" name="phone" value="<?php echo htmlspecialchars($me['phone']); ?>" placeholder="Telefone">
    <input class="input" name="department" value="<?php echo htmlspecialchars($me['department']); ?>" placeholder="Departamento">
    <input class="input" name="job_title" value="<?php echo htmlspecialchars($me['job_title']); ?>" placeholder="Cargo">

    <button class="btn btn-save">Salvar Alterações</button>
  </form>

  <!-- ATIVIDADES RECENTES -->
  <div class="activity-box">
    <h3 style="margin-bottom:10px;font-size:15px;">Atividades Recentes</h3>
    <div><i class="ri-checkbox-circle-line"></i> Alterou seu perfil</div>
    <div><i class="ri-time-line"></i> Último login: há 2 horas</div>
    <div><i class="ri-route-line"></i> Consultou rotas hoje</div>
    <div><i class="ri-notification-line"></i> Viu 3 avisos novos</div>
  </div>

</div>

<!-- NAV INFERIOR -->
<div class="bottom-nav">
  <a href="dashboard.php"><i class="ri-dashboard-line"></i>Início</a>
  <a href="rotas.php"><i class="ri-route-line"></i>Rotas</a>
  <a href="cameras.php"><i class="ri-camera-line"></i>Câmeras</a>
  <a href="avisos.php"><i class="ri-notification-3-line"></i>Avisos</a>
  <a href="meu_perfil.php" class="active"><i class="ri-user-3-line"></i>Perfil</a>
</div>

<script>
// Preview instantâneo do avatar
function previewImage(event) {
    let img = document.getElementById("previewImg");
    img.src = URL.createObjectURL(event.target.files[0]);
}

// Dark Mode
function toggleDarkMode() {
    document.body.classList.toggle("dark");
}
</script>

</body>
</html>
