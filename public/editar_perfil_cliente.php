<?php
require_once('../assets/config/auth.php');
require_once('../assets/config/db.php');

$user = $_SESSION['user'] ?? null;

// Impede admin de acessar essa página
if ($user['role'] !== 'user') {
    header('Location: dashboard.php');
    exit;
}

$feedback = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $cep = trim($_POST['cep'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $state = trim($_POST['state'] ?? '');

    if ($name) {
        $stmt = $mysqli->prepare("UPDATE users SET name=?, phone=?, department=?, job_title=? WHERE id=?");
        $stmt->bind_param('ssssi', $name, $phone, $city, $state, $user['id']);
        if ($stmt->execute()) {
            $_SESSION['user']['name'] = $name;
            $feedback = "Perfil atualizado!";
        } else {
            $error = "Erro ao salvar alterações.";
        }
    } else {
        $error = "O nome é obrigatório.";
    }
}

$res = $mysqli->query("SELECT * FROM users WHERE id=" . $user['id']);
$me = $res->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<title>Editar Perfil - Cliente</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../assets/css/styles.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">

<style>
body {
  background: #f1f5f9;
  padding-bottom: 80px;
  font-family: "Inter", sans-serif;
}

.topbar {
  text-align: center;
  margin-top: 26px;
}

.topbar h2 {
  margin: 0;
  font-size: 22px;
  font-weight: 700;
  color: #1e293b;
}

.form-card {
  background: #fff;
  padding: 22px;
  border-radius: 16px;
  margin-top: 20px;
  box-shadow: 0 6px 18px rgba(0,0,0,0.07);
}

.input {
  width: 100%;
  padding: 13px;
  margin-bottom: 14px;
  border-radius: 10px;
  border: 1px solid #cbd5e1;
  background: #fff;
  font-size: 15px;
}

.btn-save {
  width: 100%;
  background: var(--brand);
  padding: 13px;
  color: #fff;
  font-weight: 600;
  text-decoration: none;
  border-radius: 10px;
  border: none;
  cursor: pointer;
  margin-top: 6px;
}

.btn-save:hover {
  background: #0058e0;
}

.badge.success {
  background: #e8ffe8;
  color: #0f5132;
  padding: 10px;
  border-radius: 8px;
  margin-bottom: 12px;
}

.badge.error {
  background: #ffe0e0;
  color: #842029;
  padding: 10px;
  border-radius: 8px;
  margin-bottom: 12px;
}

/* MENU INFERIOR MOBILE */
.mobile-menu {
  position: fixed;
  bottom: 0; left:0; right:0;
  height: 65px;
  background: #fff;
  border-top: 1px solid #e2e8f0;
  display: flex;
  justify-content: space-around;
  align-items: center;
  box-shadow: 0 -4px 14px rgba(0,0,0,0.06);
  z-index: 999;
}
.mobile-menu a {
  text-decoration: none;
  display:flex;
  flex-direction:column;
  align-items:center;
  color:#64748b;
  font-size:13px;
}
.mobile-menu a.active, .mobile-menu a:hover {
  color: var(--brand);
}
.mobile-menu i {
  font-size:22px;
}

@media(min-width:768px){
  .mobile-menu { display:none }
}
</style>

</head>
<body>

<div class="container" style="max-width:900px; margin: 20px auto;">

  <div class="topbar">
    <h2>Editar Perfil</h2>
    <p class="link-muted">Atualize suas informações abaixo</p>
  </div>

  <div class="form-card">

    <?php if ($feedback): ?>
      <div class="badge success"><?php echo $feedback; ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
      <div class="badge error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="post">
      <input class="input" name="name" value="<?php echo htmlspecialchars($me['name']); ?>" placeholder="Nome completo">

      <input class="input" name="phone" value="<?php echo htmlspecialchars($me['phone']); ?>" placeholder="Telefone">

      <input class="input" id="cep" name="cep" value="" placeholder="CEP (opcional)">

      <input class="input" id="city" name="city" value="<?php echo htmlspecialchars($me['department']); ?>" placeholder="Cidade">

      <input class="input" id="state" name="state" value="<?php echo htmlspecialchars($me['job_title']); ?>" placeholder="UF">

      <button class="btn-save" type="submit">Salvar Alterações</button>
    </form>
  </div>

</div>

<!-- MENU INFERIOR MOBILE -->
<div class="mobile-menu">
  <a href="cliente_home.php">
    <i class="ri-route-line"></i>
    <span>Rotas</span>
  </a>
  <a href="perfil_cliente.php" class="active">
    <i class="ri-user-line"></i>
    <span>Perfil</span>
  </a>
  <a href="logout.php">
    <i class="ri-logout-box-r-line"></i>
    <span>Sair</span>
  </a>
</div>

</body>
</html>
