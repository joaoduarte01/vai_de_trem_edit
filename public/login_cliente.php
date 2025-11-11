<?php
require_once('../assets/config/db.php');
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $pass = $_POST['password'] ?? '';

  if ($email && $pass) {
    $stmt = $mysqli->prepare("SELECT id, name, email, password, role FROM users WHERE email=? LIMIT 1");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
      if (password_verify($pass, $row['password']) && $row['role'] === 'user') {
        $_SESSION['user'] = $row;
        header('Location: cliente_home.php');
        exit;
      } else {
        $error = 'E-mail ou senha incorretos, ou conta não é de cliente.';
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
<title>Login do Cliente - Vai de Trem</title>
<link href="../assets/css/styles.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body>
<div class="auth-wrap">
  <div class="card pad" style="text-align:center">
    <div class="brand-icon"><i class="ri-train-line"></i></div>
    <h2>Login do Cliente</h2>
    <p class="link-muted" style="margin-bottom:16px">Acesse sua área de rotas</p>

    <?php if ($error): ?>
      <div class="badge red" style="margin-bottom:12px;"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="post" class="row" style="gap:12px">
      <input class="input" type="email" name="email" placeholder="E-mail" required>
      <input class="input" type="password" name="password" placeholder="Senha" required>
      <button class="btn" type="submit">Entrar</button>
    </form>

    <div class="link-muted" style="margin-top:10px;">
      Não tem conta? <a href="registrar_se.php">Registrar-se</a><br>
      <a href="login_admin.php" class="link-muted" style="font-size:13px;">Entrar como administrador</a>
    </div>
  </div>
</div>
</body>
</html>
