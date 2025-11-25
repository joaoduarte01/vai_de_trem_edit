<?php 
require_once('../assets/config/auth.php'); 
require_once('../assets/config/db.php');

$feedback = "";

/* CADASTRAR FUNCIONÁRIO + LOGIN ADMIN */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $name   = trim($_POST['name'] ?? '');
  $role   = trim($_POST['role'] ?? '');
  $cep    = trim($_POST['cep'] ?? '');
  $street = trim($_POST['street'] ?? '');
  $neigh  = trim($_POST['neighborhood'] ?? '');
  $city   = trim($_POST['city'] ?? '');
  $uf     = trim($_POST['uf'] ?? '');
  
  // LOGIN ADMIN
  $email    = trim($_POST['email'] ?? '');
  $password = trim($_POST['password'] ?? '');
  $hash     = password_hash($password, PASSWORD_DEFAULT);

  // FOTO
  $photo = null;
  if (!empty($_FILES['photo']['name'])) {
      $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
      $fname = 'f_'.time().'_'.rand(1000,9999).'.'.$ext;
      $dest = '../assets/uploads/funcionarios/'.$fname;

      if (move_uploaded_file($_FILES['photo']['tmp_name'], $dest)) {
          $photo = $fname;
      }
  }

  if ($name && $role && $email && $password) {

    /* 1 — INSERIR NA TABELA EMPLOYEES */
    $stmt = $mysqli->prepare("
      INSERT INTO employees (name, role, cep, street, neighborhood, city, uf, photo)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param(
      'ssssssss',
      $name, $role, $cep, $street, $neigh, $city, $uf, $photo
    );
    $stmt->execute();
    $stmt->close();

    /* 2 — CRIAR LOGIN ADMIN */
    $stmt2 = $mysqli->prepare("
      INSERT INTO users (name, email, password, role, avatar)
      VALUES (?, ?, ?, 'admin', ?)
    ");
    $stmt2->bind_param('ssss', $name, $email, $hash, $photo);
    $stmt2->execute();
    $stmt2->close();

    $feedback = "Funcionário cadastrado e login admin criado!";
  }
}

$employees = $mysqli->query("SELECT * FROM employees ORDER BY id DESC");

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Funcionários - Vai de Trem</title>

<link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
<link href="../assets/css/styles.css" rel="stylesheet">

<script>
async function buscarCEP() {
    const cep = document.getElementById("cep").value.replace(/\D/g,'');

    if (cep.length !== 8) {
        alert("CEP inválido! Digite 8 números.");
        return;
    }

    const url = `https://viacep.com.br/ws/${cep}/json/`;
    const data = await fetch(url).then(r => r.json());

    if (data.erro) {
        alert("CEP não encontrado.");
        return;
    }

    // Preenche os campos
    document.getElementById("street").value       = data.logradouro;
    document.getElementById("neighborhood").value = data.bairro;
    document.getElementById("city").value         = data.localidade;
    document.getElementById("uf").value           = data.uf;

    // Efeito visual de confirmado
    flashFields();
}

function flashFields() {
    const fields = ["street","neighborhood","city","uf"];
    fields.forEach(id => {
        const el = document.getElementById(id);
        el.style.background = "#d1fae5"; // verde claro
        setTimeout(() => el.style.background = "", 800);
    });
}
</script>


</head>
<body>

<!-- HEADER -->
<div class="top-header">
  <h1><i class="ri-team-line"></i> Funcionários</h1>
</div>

<!-- FEEDBACK -->
<?php if ($feedback): ?>
<div class="badge" style="margin:20px;font-size:14px;"><?php echo $feedback; ?></div>
<?php endif; ?>

<!-- FORM -->
<div class="form-card">

<h2>Cadastrar Funcionário</h2>

<form method="post" enctype="multipart/form-data">

    <img id="preview" class="photo-preview" src="../assets/uploads/profile_photos/avatar-default.png">

    <input type="file" name="photo" accept="image/*" class="input" 
           onchange="preview.src = window.URL.createObjectURL(this.files[0])">

    <input class="input" name="name" placeholder="Nome completo" required>
    <input class="input" name="role" placeholder="Cargo no sistema" required>

    <input class="input" name="email" type="email" placeholder="E-mail de login" required>
    <input class="input" name="password" type="password" placeholder="Senha de acesso" required>

    <input class="input" id="cep" name="cep" placeholder="CEP" onblur="buscarCEP()">
    <div style="display:flex; gap:10px; align-items:center;">
    <button type="button" class="btn" onclick="buscarCEP()" style="padding:10px 14px;">
        Verificar
    </button>
</div>

    <input class="input" id="city" name="city" placeholder="Cidade">
    <input class="input" id="uf" name="uf" placeholder="UF">
    <input class="input" id="street" name="street" placeholder="Rua">
    <input class="input" id="neighborhood" name="neighborhood" placeholder="Bairro">

    <button class="btn-save">Salvar Funcionário</button>

</form>

</div>

<!-- LISTA -->
<?php while($f = $employees->fetch_assoc()): ?>
<div class="employee-card">
  <img src="<?php echo $f['photo']
     ? '../assets/uploads/funcionarios/'.$f['photo']
     : '../assets/uploads/profile_photos/avatar-default.png'; ?>">

  <div>
    <strong><?php echo htmlspecialchars($f['name']); ?></strong><br>
    <small><?php echo htmlspecialchars($f['role']); ?></small><br>
    <small><i class="ri-map-pin-line"></i> <?php echo $f['city']." - ".$f['uf']; ?></small>
  </div>
</div>
<?php endwhile; ?>

<!-- NAV -->
<div class="bottom-nav">
  <a href="dashboard.php">
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

  <a href="funcionarios.php" class="active">
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
