<?php 
require_once('../assets/config/auth.php'); 
require_once('../assets/config/db.php');

$feedback = "";

/* CADASTRAR FUNCIONÁRIO */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $name   = trim($_POST['name'] ?? '');
  $role   = trim($_POST['role'] ?? '');
  $cep    = trim($_POST['cep'] ?? '');
  $street = trim($_POST['street'] ?? '');
  $neigh  = trim($_POST['neighborhood'] ?? '');
  $city   = trim($_POST['city'] ?? '');
  $uf     = trim($_POST['uf'] ?? '');
  $phone  = trim($_POST['phone'] ?? '');

  // FOTO
  $photo = null;
  if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
      $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
      $fname = 'f_'.time().'_'.rand(1000,9999).'.'.$ext;
      $dest = '../assets/uploads/funcionarios/'.$fname;

      if (move_uploaded_file($_FILES['photo']['tmp_name'], $dest)) {
          $photo = $fname;
      }
  }

  if ($name && $role) {

    $stmt = $mysqli->prepare("
      INSERT INTO employees (name, role, cep, street, neighborhood, city, uf, phone, photo)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param(
      'sssssssss',
      $name, $role, $cep, $street, $neigh, $city, $uf, $phone, $photo
    );
    $stmt->execute();

    $feedback = "Funcionário cadastrado com sucesso!";
  }
}

// Carregar lista
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

<style>

body {
    background:#f5f9ff;
    padding-bottom:90px;
    font-family:'Poppins',sans-serif;
}

/* HEADER */
.top-header {
    background:var(--brand);
    color:#fff;
    padding:18px 20px;
    display:flex;
    align-items:center;
    gap:10px;
    border-radius:0 0 20px 20px;
}
.top-header h1 {
    font-size:20px;
    font-weight:700;
}

/* FORM CARD */
.form-card {
    margin:20px;
    padding:20px;
    background:#fff;
    border-radius:16px;
    box-shadow:0 2px 10px rgba(0,0,0,0.06);
}

.input {
    margin:8px 0;
}

/* FOTO */
.photo-preview {
    width: 120px;
    height: 120px;
    border-radius:12px;
    object-fit:cover;
    background:#e2e8f0;
    display:block;
    margin-bottom:10px;
}

/* LISTA */
.employee-card {
    margin:20px;
    background:#fff;
    border-radius:16px;
    padding:18px;
    box-shadow:0 2px 10px rgba(0,0,0,0.06);
    display:flex;
    gap:18px;
    align-items:center;
}

.employee-card img {
    width:80px;
    height:80px;
    border-radius:12px;
    object-fit:cover;
}

/* NAV MOBILE */
.bottom-nav {
    position: fixed; bottom:0; left:0; right:0;
    background:#fff;
    border-top:1px solid var(--border);
    display:flex;
    justify-content:space-around;
    padding:10px 0;
    box-shadow:0 -4px 12px rgba(0,0,0,0.05);
}
.bottom-nav a {
    text-decoration:none;
    color:#64748b;
    font-size:12px;
    display:flex;
    flex-direction:column;
    align-items:center;
}
.bottom-nav a.active {
    color:var(--brand);
}

</style>

<script>
async function buscarCEP() {
    let cep = document.getElementById("cep").value.replace(/\D/g,'');
    if (cep.length !== 8) return;

    let url = `https://viacep.com.br/ws/${cep}/json/`;

    let data = await fetch(url).then(r => r.json());

    if (!data.erro) {
        document.getElementById("street").value = data.logradouro;
        document.getElementById("neighborhood").value = data.bairro;
        document.getElementById("city").value = data.localidade;
        document.getElementById("uf").value = data.uf;
    }
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
<div class="badge" style="margin:20px;"><?php echo $feedback; ?></div>
<?php endif; ?>

<!-- FORM DE CADASTRO -->
<div class="form-card">
  <h2>Cadastrar Novo Funcionário</h2>

  <form method="post" enctype="multipart/form-data">

    <img id="preview" class="photo-preview" src="../assets/uploads/profile_photos/avatar-default.png">

    <input type="file" name="photo" accept="image/*" class="input" 
           onchange="preview.src = window.URL.createObjectURL(this.files[0])">

    <input class="input" name="name" placeholder="Nome completo" required>
    <input class="input" name="role" placeholder="Cargo no sistema" required>
    <input class="input" name="phone" placeholder="Telefone">

    <div class="row cols-3">
      <input class="input" id="cep" name="cep" placeholder="CEP" onblur="buscarCEP()">
      <input class="input" id="city" name="city" placeholder="Cidade">
      <input class="input" id="uf" name="uf" placeholder="UF">
    </div>

    <input class="input" id="street" name="street" placeholder="Rua">
    <input class="input" id="neighborhood" name="neighborhood" placeholder="Bairro">

    <button class="btn" style="margin-top:10px;width:100%;">Salvar Funcionário</button>
  </form>
</div>

<!-- LISTA -->
<?php while($f = $employees->fetch_assoc()): ?>
<div class="employee-card">
  <img src="<?php echo $f['photo']
     ? '../assets/uploads/funcionarios/'.$f['photo']
     : '../assets/uploads/profile_photos/avatar-default.png'; ?>">

  <div>
    <div><strong><?php echo htmlspecialchars($f['name']); ?></strong></div>
    <div class="link-muted"><?php echo htmlspecialchars($f['role']); ?></div>
    <div class="link-muted"><i class="ri-map-pin-line"></i> <?php echo $f['city']." - ".$f['uf']; ?></div>
  </div>
</div>
<?php endwhile; ?>


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
