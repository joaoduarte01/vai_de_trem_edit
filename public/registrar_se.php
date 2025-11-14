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
        $msg = 'Cadastro realizado com sucesso! Faça login.';
      } else {
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

<style>
body {
  background: #f1f5f9;
  font-family: 'Poppins', sans-serif;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 22px;
  min-height: 100vh;
}

.card-register {
  background: #fff;
  padding: 28px 22px;
  width: 100%;
  max-width: 380px;
  border-radius: 18px;
  box-shadow: 0 8px 26px rgba(0,0,0,0.08);
  text-align: center;
}

.brand-icon {
  font-size: 52px;
  background: var(--brand);
  color: #fff;
  width: 84px;
  height: 84px;
  border-radius: 20px;
  margin: 0 auto 12px;
  display: flex;
  justify-content: center;
  align-items: center;
}

h2 {
  margin: 0;
  font-size: 22px;
  font-weight: 700;
}

.sub {
  color: #64748b;
  margin-bottom: 18px;
  font-size: 14px;
}

.success-box {
  background: #e6ffed;
  color: #0f8f4b;
  padding: 12px;
  border-radius: 10px;
  margin-bottom: 12px;
  font-weight: 600;
}

.error-box {
  background: #ffe6e6;
  color: #c90000;
  padding: 12px;
  border-radius: 10px;
  margin-bottom: 12px;
  font-weight: 600;
}

label {
  text-align: left;
  display: block;
  color: #334155;
  margin-bottom: 6px;
  font-size: 14px;
}

.input {
  width: 100%;
  padding: 12px;
  border-radius: 12px;
  border: 1px solid #cbd5e1;
  font-size: 15px;
}

.row-cep {
  display: flex;
  gap: 8px;
  margin-top: 6px;
}

.input.small {
  flex: 1;
}

.btn-main {
  width: 100%;
  margin-top: 16px;
  padding: 14px;
  font-size: 16px;
  font-weight: 600;
  border-radius: 12px;
  background: var(--brand);
  color: #fff;
}

.btn-outline {
  width: 100%;
  margin-top: 8px;
  padding: 12px;
  font-size: 15px;
  border-radius: 12px;
  background: #e2e8f0;
  color: #1e293b;
}

.back-link {
  margin-top: 14px;
  font-size: 14px;
  color: #64748b;
}

.back-link a {
  color: var(--brand);
  font-weight: 600;
}
</style>

<script src="../assets/js/app.js" defer></script>
</head>

<body>

<div class="card-register">

  <div class="brand-icon"><i class="ri-user-add-line"></i></div>
  <h2>Crie sua conta</h2>
  <div class="sub">Pronto para viajar com a gente?</div>

  <?php if ($msg): ?>
    <div class="success-box"><?php echo htmlspecialchars($msg); ?></div>
  <?php endif; ?>

  <?php if ($err): ?>
    <div class="error-box"><?php echo htmlspecialchars($err); ?></div>
  <?php endif; ?>

  <form method="post">

    <label>Nome completo</label>
    <input class="input" name="name" placeholder="Seu nome" required>

    <label style="margin-top:12px;">E-mail</label>
    <input class="input" type="email" name="email" placeholder="email@exemplo.com" required>

    <label style="margin-top:12px;">Senha</label>
    <input class="input" type="password" name="password" placeholder="Digite uma senha" required>

    <label style="margin-top:12px;">Endereço</label>
    <div class="row-cep">
      <input class="input small" id="cep" placeholder="CEP">
      <input class="input small" id="city" placeholder="Cidade">
      <input class="input small" id="uf" placeholder="UF">
    </div>

    <button type="button" class="btn-outline" onclick="buscarCEP('cep',{city:'city',state:'uf'})">
      Buscar CEP
    </button>

    <button type="submit" class="btn-main">Registrar</button>

    <div class="back-link">
      Já tem conta? <a href="login.php">Entrar</a>
    </div>
  </form>

</div>

</body>
</html>
