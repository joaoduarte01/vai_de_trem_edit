<?php
require_once('../assets/config/db.php');
session_start();

$msg = '';
$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($name && $email && $password) {

    // Verifica se o e-mail já existe antes de tentar inserir
    $check = $mysqli->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
    $check->bind_param('s', $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
      $err = 'Este e-mail já está cadastrado. Faça login ou use outro.';
    } else {
      $hash = password_hash($password, PASSWORD_DEFAULT);

      $stmt = $mysqli->prepare("INSERT INTO users(name, email, password, role) VALUES (?, ?, ?, 'user')");
      $stmt->bind_param('sss', $name, $email, $hash);

      if ($stmt->execute()) {
        $msg = '✅ Cadastro realizado com sucesso! Faça login.';
      } else {
        // Qualquer outro erro de banco
        $err = 'Erro ao cadastrar: ' . $mysqli->error;
      }

      $stmt->close();
    }

    $check->close();

  } else {
    $err = 'Preencha todos os campos.';
  }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Registrar - Vai de Trem</title>
<link href="../assets/css/styles.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
<script src="../assets/js/app.js" defer></script>
</head>
<body>
<div class="auth-wrap">
  <div class="card pad" style="text-align:center">
    <div class="brand-icon" style="margin:10px auto"><i class="ri-train-line"></i></div>
    <h2>Crie sua conta</h2>

    <?php if ($msg): ?>
      <div class="badge" style="margin-bottom:10px;"><?php echo htmlspecialchars($msg); ?></div>
    <?php endif; ?>

    <?php if ($err): ?>
      <div class="badge red" style="margin-bottom:10px;"><?php echo htmlspecialchars($err); ?></div>
    <?php endif; ?>

    <form method="post" class="row" style="gap:12px">
      <input class="input" name="name" placeholder="Nome completo" required>
      <input class="input" type="email" name="email" placeholder="E-mail" required>
      <input class="input" type="password" name="password" placeholder="Senha" required>

      <div class="row cols-3">
        <input class="input" id="cep" placeholder="CEP (ViaCEP)">
        <input class="input" id="city" placeholder="Cidade">
        <input class="input" id="uf" placeholder="UF">
      </div>

      <button class="btn secondary" type="button" onclick="buscarCEP('cep',{city:'city',state:'uf'})">
        Buscar CEP
      </button>
      <button class="btn" type="submit">Registrar</button>

      <div class="link-muted" style="margin-top:10px;">
        Já tem conta? <a href="login.php">Entrar</a>
      </div>
    </form>
  </div>
</div>
</body>
</html>
