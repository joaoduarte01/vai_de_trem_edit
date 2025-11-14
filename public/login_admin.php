<?php
require_once('../assets/config/db.php');
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $pass = $_POST['password'] ?? '';

  if ($email && $pass) {
    $stmt = $mysqli->prepare("SELECT id,name,email,password,role FROM users WHERE email=? LIMIT 1");
    $stmt->bind_param('s',$email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
      if (password_verify($pass, $row['password']) && $row['role'] === 'admin') {
        $_SESSION['user'] = $row;
        header('Location: dashboard.php');
        exit;
      } else {
        $error = 'Acesso negado. Esta conta não é de administrador.';
      }
    } else $error = 'Usuário não encontrado.';
  } else $error = 'Preencha todos os campos.';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login Administrativo - Vai de Trem</title>

<link href="../assets/css/styles.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">

<style>
body {
  background: #f1f5f9;
  font-family: 'Poppins', sans-serif;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  padding: 20px;
}

.card-login {
  background: #fff;
  width: 100%;
  max-width: 380px;
  padding: 30px 24px;
  border-radius: 18px;
  box-shadow: 0 8px 26px rgba(0,0,0,0.08);
  text-align: center;
}

.brand-icon {
  font-size: 54px;
  background: var(--brand);
  color: #fff;
  width: 84px;
  height: 84px;
  border-radius: 20px;
  margin: 0 auto 14px;
  display: flex;
  align-items: center;
  justify-content: center;
}

h2 {
  font-size: 22px;
  font-weight: 700;
  margin-bottom: 4px;
}

.sub {
  color: var(--muted);
  font-size: 14px;
  margin-bottom: 20px;
}

.error-box {
  background: #ffe6e6;
  color: #c90000;
  padding: 10px;
  border-radius: 10px;
  margin-bottom: 16px;
  font-size: 14px;
}

label {
  text-align: left;
  display: block;
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
  margin-top: 16px;
  background: var(--brand);
  color: #fff;
  padding: 14px;
  font-size: 16px;
  border-radius: 12px;
  font-weight: 600;
}

.back-link {
  margin-top: 16px;
  display: block;
  font-size: 14px;
  color: var(--brand);
}
</style>

</head>
<body>

<div class="card-login">

  <div class="brand-icon"><i class="ri-shield-user-line"></i></div>

  <h2>Área Administrativa</h2>
  <div class="sub">Acesso restrito</div>

  <?php if ($error): ?>
    <div class="error-box"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>

  <form method="post">
    <label>Email</label>
    <input class="input" type="email" name="email" placeholder="admin@vaidetrem.com" required>

    <label style="margin-top:12px;">Senha</label>
    <input class="input" type="password" name="password" placeholder="Senha" required>

    <button class="btn-login" type="submit">Entrar</button>
  </form>

  <a href="login.php" class="back-link">
    <i class="ri-arrow-left-line"></i> Voltar ao login de clientes
  </a>

</div>

</body>
</html>
