<?php
require_once('../assets/config/db.php');
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $pass = $_POST['password'] ?? '';
  $login_type = $_POST['login_type'] ?? 'cliente';

  if ($email && $pass) {
    $stmt = $mysqli->prepare("SELECT id, name, email, password, role, avatar FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {

      if (password_verify($pass, $row['password'])) {

        if (($login_type === 'cliente' && $row['role'] !== 'user')) {
          $error = 'Essa conta é de administrador. Use a tela de login de usuário.';
        } elseif (($login_type === 'usuario' && $row['role'] !== 'admin')) {
          $error = 'Essa conta é de cliente. Use o login de cliente.';
        } else {

          $_SESSION['user'] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'email' => $row['email'],
            'role' => $row['role'],
            'avatar' => $row['avatar']
          ];

          if ($row['role'] === 'admin') {
            header('Location: dashboard.php');
          } else {
            header('Location: cliente_home.php');
          }
          exit;
        }

      } else {
        $error = 'Senha incorreta.';
      }

    } else {
      $error = 'Usuário não encontrado.';
    }

  } else {
    $error = 'Preencha todos os campos.';
  }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login - Vai de Trem</title>

<link href="../assets/css/styles.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">

<style>
body {
  background: #f1f5f9;
  font-family: 'Poppins', sans-serif;
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  padding: 20px;
}

.card-login {
  background: #fff;
  width: 100%;
  max-width: 380px;
  padding: 28px 22px;
  border-radius: 18px;
  box-shadow: 0 6px 26px rgba(0,0,0,0.08);
  text-align: center;
}

.brand-icon {
  font-size: 52px;
  background: var(--brand);
  color: #fff;
  width: 82px;
  height: 82px;
  border-radius: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 12px;
}

h2 {
  font-size: 24px;
  margin: 0;
  margin-bottom: 4px;
  font-weight: 700;
}

.sub {
  color: var(--muted);
  font-size: 14px;
  margin-bottom: 20px;
}

.error-box {
  background: #ffe0e0;
  color: #d90404;
  font-size: 14px;
  padding: 10px;
  border-radius: 10px;
  margin-bottom: 16px;
}

.tab-switch {
  display: flex;
  margin-bottom: 16px;
  gap: 10px;
}

.tab-btn {
  flex: 1;
  border-radius: 10px;
  padding: 10px;
  border: 1px solid var(--border);
  background: #eef3ff;
  color: var(--brand);
  font-weight: 600;
  text-align: center;
}

.tab-btn.active {
  background: var(--brand);
  color: #fff;
}

label {
  display: block;
  text-align: left;
  font-size: 14px;
  margin-bottom: 6px;
  color: #334155;
}

.input {
  width: 100%;
  padding: 12px;
  border-radius: 10px;
  border: 1px solid #cbd5e1;
  font-size: 15px;
}

.btn-login {
  width: 100%;
  margin-top: 10px;
  background: var(--brand);
  color: #fff;
  font-weight: 600;
  padding: 14px;
  border-radius: 12px;
  font-size: 16px;
}

.auth-note {
  margin-top: 12px;
  font-size: 14px;
  color: var(--muted);
}
</style>
</head>

<body>

<div class="card-login">

  <div class="brand-icon"><i class="ri-train-line"></i></div>

  <h2>Vai de Trem</h2>
  <div class="sub">Acesso ao sistema</div>

  <?php if ($error): ?>
    <div class="error-box"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <div class="tab-switch">
    <button type="button" id="tab-cliente" class="tab-btn active" onclick="showTab('cliente')">Cliente</button>
    <a href="login_admin.php" target="_blank" id="tab-usuario" class="tab-btn">Usuário/Admin</a>
  </div>

  <!-- Form CLIENTE -->
  <form id="form-cliente" method="post">
    <input type="hidden" name="login_type" value="cliente">

    <label>Email</label>
    <input class="input" type="email" name="email" placeholder="cliente@vaidetrem.com" required>

    <label style="margin-top:12px">Senha</label>
    <input class="input" type="password" name="password" placeholder="Sua senha" required>

    <button class="btn-login" type="submit">Entrar</button>

    <p class="auth-note">
      Não tem conta? <a href="registrar_se.php">Registrar-se</a>
    </p>
  </form>

</div>

<script>
function showTab(type){
  document.getElementById('form-cliente').style.display = 'block';
  document.getElementById('tab-cliente').classList.add('active');
  document.getElementById('tab-usuario').classList.remove('active');
}
</script>

</body>
</html>
