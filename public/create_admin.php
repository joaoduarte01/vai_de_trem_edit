<?php
// create_admin.php
// One-time admin creator. RUN LOCALLY only, then DELETE the file.

declare(strict_types=1);

// Basic safety: only allow from localhost
$allowed = ['127.0.0.1', '::1', 'localhost'];
$remote = $_SERVER['REMOTE_ADDR'] ?? '';
if (!in_array($remote, $allowed, true)) {
  http_response_code(403);
  echo "Acesso negado. Este script só pode ser executado localmente (localhost).";
  exit;
}

// Load DB (ajuste o path se necessário)
require_once __DIR__ . '/../assets/config/db.php';

// Protection: do not run if script already executed (creates a flag file)
$flag = __DIR__ . '/.admin_created_flag';
if (file_exists($flag)) {
  echo "Este script já foi executado anteriormente. Remova o arquivo .admin_created_flag para usar novamente (não recomendado).";
  exit;
}

// If form submitted, create admin
$err = '';
$ok  = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';

  if (!$name || !$email || !$password) {
    $err = 'Preencha nome, e-mail e senha.';
  } else {
    // Safety: check if email already exists
    $stmt = $mysqli->prepare("SELECT id,role FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
      $err = 'Já existe um usuário com esse e-mail (id: ' . intval($row['id']) . ', role: ' . htmlspecialchars($row['role']) . ').';
    } else {
      // Create admin with password_hash
      $hash = password_hash($password, PASSWORD_DEFAULT);
      $ins = $mysqli->prepare("INSERT INTO users (name,email,password,role,created_at) VALUES (?,?,?,?,NOW())");
      $role = 'admin';
      $ins->bind_param('ssss', $name, $email, $hash, $role);
      if ($ins->execute()) {
        // create flag file to avoid accidental rerun
        @file_put_contents($flag, "created_by_create_admin_php\nemail:$email\ncreated_at:" . date('c') . "\n");
        $ok = "Conta de administrador criada com sucesso! E-mail: {$email} — senha: (a que você informou).";
      } else {
        $err = "Erro ao inserir no banco: " . htmlspecialchars($mysqli->error);
      }
    }
  }
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Criar Admin — Vai de Trem (local)</title>
<link href="assets/css/styles.css" rel="stylesheet">
<style>
  body{font-family:Inter,system-ui,Arial; background:var(--bg); padding:24px}
  .card{max-width:520px;margin:40px auto;padding:20px;background:var(--card);border-radius:12px;border:1px solid var(--border)}
  h1{color:var(--brand)}
  .input, .btn{width:100%;padding:10px;border-radius:8px}
  .input{border:1px solid var(--border);margin:8px 0}
  .btn{background:var(--brand);color:#fff;border:none}
  .note{color:var(--muted);font-size:13px}
  .err{background:#ffe9e9;color:#b91c1c;padding:8px;border-radius:6px}
  .ok{background:#e9f8ee;color:#064f2a;padding:8px;border-radius:6px}
</style>
</head>
<body>
  <div class="card">
    <h1>Criar conta de ADMIN (LOCAL)</h1>
    <p class="note">Este script é seguro para uso local. Depois de criar o admin, <strong>delete este arquivo</strong> e o arquivo <code>.admin_created_flag</code>.</p>

    <?php if($err): ?>
      <div class="err"><?php echo htmlspecialchars($err); ?></div>
    <?php endif; ?>
    <?php if($ok): ?>
      <div class="ok"><?php echo htmlspecialchars($ok); ?></div>
      <p class="note">Remova o arquivo <code>create_admin.php</code> e o arquivo <code>.admin_created_flag</code> só se souber o que faz. É recomendável apagar <strong>create_admin.php</strong> imediatamente.</p>
    <?php endif; ?>

    <?php if(!$ok): ?>
    <form method="post" action="">
      <label>Nome</label>
      <input class="input" name="name" required placeholder="Nome do admin (ex: João Admin)">
      <label>E-mail</label>
      <input class="input" name="email" type="email" required placeholder="admin@example.com">
      <label>Senha</label>
      <input class="input" name="password" type="password" required placeholder="Escolha uma senha segura">
      <div style="margin-top:10px">
        <button class="btn" type="submit">Criar conta ADMIN</button>
      </div>
    </form>
    <?php endif; ?>
  </div>
</body>
</html>
