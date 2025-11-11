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
        // Confere se o tipo de login bate com o tipo de conta
        if (($login_type === 'cliente' && $row['role'] !== 'user') ||
            ($login_type === 'usuario' && $row['role'] === 'user')) {
          $error = 'Tipo de login incorreto para esta conta.';
        } else {
          $_SESSION['user'] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'email' => $row['email'],
            'role' => $row['role'],
            'avatar' => $row['avatar']
          ];

          // Redirecionamento
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
.tab-switch {
  display: flex;
  gap: 8px;
  margin-bottom: 16px;
}
.tab-btn {
  flex: 1;
  background: #f1f5ff;
  border: 1px solid var(--border);
  border-radius: 10px;
  padding: 10px;
  cursor: pointer;
  font-weight: 600;
  transition: var(--transition);
  color: var(--brand);
}
.tab-btn.active {
  background: var(--brand);
  color: #fff;
  box-shadow: 0 4px 12px rgba(30, 102, 255, 0.25);
}
.tab-btn:hover {
  background: var(--brand-light);
  color: #fff;
}
</style>
</head>
<body>

<div class="auth-wrap">
  <div class="card pad" style="text-align:center">
    <div class="brand-icon" style="margin:10px auto"><i class="ri-train-line"></i></div>
    <h2>Vai de Trem</h2>
    <div class="link-muted" style="margin-bottom:16px">Sistema de Gerenciamento de Rotas</div>

    <?php if ($error): ?>
      <div class="badge red" style="margin-bottom:12px"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <!-- Abas -->
    <div class="tab-switch">
      <button type="button" class="tab-btn active" id="tab-cliente" onclick="showTab('cliente')">Cliente</button>
<a href="login_admin.php" target="_blank" class="tab-btn" id="tab-usuario" style="text-align:center;display:flex;justify-content:center;align-items:center;">Usuário / Admin</a>
    </div>

    <!-- Login Cliente -->
    <form id="form-cliente" method="post" class="row" style="gap:12px">
      <input type="hidden" name="login_type" value="cliente">
      <div>
        <label>Email</label>
        <input class="input" type="email" name="email" placeholder="cliente@email.com" required>
      </div>
      <div>
        <label>Senha</label>
        <input class="input" type="password" name="password" placeholder="Sua senha" required>
      </div>
      <button class="btn" type="submit">Entrar como Cliente</button>
      <div class="link-muted" style="margin-top:10px">
        Não tem conta? <a href="registrar_se.php">Registrar-se</a>
      </div>
    </form>

    <!-- Login Usuário/Admin -->
    <form id="form-usuario" method="post" class="row" style="gap:12px;display:none;">
      <input type="hidden" name="login_type" value="usuario">
      <div>
        <label>Email</label>
        <input class="input" type="email" name="email" placeholder="admin@vaidetrem.com" required>
      </div>
      <div>
        <label>Senha</label>
        <input class="input" type="password" name="password" placeholder="Sua senha" required>
      </div>
      <button class="btn secondary" type="submit">Entrar como Usuário</button>
    </form>
  </div>
</div>

<script>
function showTab(type) {
  const clienteForm = document.getElementById('form-cliente');
  const usuarioForm = document.getElementById('form-usuario');
  const tabCliente = document.getElementById('tab-cliente');
  const tabUsuario = document.getElementById('tab-usuario');

  if (type === 'cliente') {
    clienteForm.style.display = 'block';
    usuarioForm.style.display = 'none';
    tabCliente.classList.add('active');
    tabUsuario.classList.remove('active');
  } else {
    clienteForm.style.display = 'none';
    usuarioForm.style.display = 'block';
    tabCliente.classList.remove('active');
    tabUsuario.classList.add('active');
  }
}
</script>

</body>
</html>
