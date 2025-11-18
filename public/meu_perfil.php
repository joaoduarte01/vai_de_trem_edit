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
    }
  }

  // Update
  $stmt = $mysqli->prepare("UPDATE users SET name=?, phone=?, department=?, job_title=?, avatar=? WHERE id=?");
  $stmt->bind_param('sssssi', $name, $phone, $department, $job, $avatarPath, $user['id']);

  if ($stmt->execute()) {
    $_SESSION['user']['name'] = $name;
    $_SESSION['user']['avatar'] = $avatarPath;
    $feedback = 'Perfil atualizado com sucesso!';
  }
}

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
    padding-bottom: 90px;
    font-family: 'Poppins', sans-serif;
  }

  /* Header */
  .top-header {
    background: var(--brand);
    color: #fff;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    border-radius: 0 0 18px 18px;
  }
  .top-header h1 {
    font-size: 20px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 6px;
  }

  /* Card */
  .profile-card {
    margin: 22px;
    background: #fff;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
  }

  /* Avatar */
  .avatar-box {
    text-align: center;
    margin-bottom: 18px;
  }
  .avatar-box img {
    width: 115px;
    height: 115px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #fff;
    box-shadow: 0 3px 10px rgba(0,0,0,0.12);
  }
  .file-input {
    margin-top: 10px;
    font-size: 13px;
  }

  /* Inputs */
  .input {
    width: 100%;
    margin-bottom: 12px;
    border-radius: 10px;
    padding: 12px;
  }

  .btn-save {
    width: 100%;
    padding: 14px;
    border-radius: 10px;
    margin-top: 6px;
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
    font-weight: 600;
  }
</style>

</head>
<body>

<!-- HEADER -->
<div class="top-header">
  <h1><i class="ri-user-settings-line"></i> Meu Perfil</h1>
</div>

<!-- CARD -->
<div class="profile-card">

  <?php if ($feedback): ?>
    <div class="badge" style="margin-bottom:12px;"><?php echo $feedback; ?></div>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data">

    <div class="avatar-box">
      <img src="<?php echo $me['avatar'] 
        ? '../assets/uploads/profile_photos/'.$me['avatar'] 
        : '../assets/uploads/profile_photos/avatar-default.png'; ?>">
      <input type="file" name="avatar" class="file-input" accept="image/*">
    </div>

    <input class="input" name="name" value="<?php echo htmlspecialchars($me['name']); ?>" placeholder="Nome completo">

    <input class="input" type="email" disabled value="<?php echo htmlspecialchars($me['email']); ?>">

    <input class="input" name="phone" value="<?php echo htmlspecialchars($me['phone']); ?>" placeholder="Telefone">

    <input class="input" name="department" value="<?php echo htmlspecialchars($me['department']); ?>" placeholder="Departamento">

    <input class="input" name="job_title" value="<?php echo htmlspecialchars($me['job_title']); ?>" placeholder="Cargo">

    <button class="btn btn-save">Salvar Alterações</button>

  </form>
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

</body>
</html>
