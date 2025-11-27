<?php
require_once('../assets/config/auth.php');
require_once('../assets/config/db.php');

$feedback = "";

/* AÇÕES: CADASTRAR, EDITAR, EXCLUIR */
$action = $_GET['action'] ?? '';
$edit_id = $_GET['edit'] ?? null;
$del_id = $_GET['delete'] ?? null;

// EXCLUIR
if ($del_id) {
  $stmt = $mysqli->prepare("DELETE FROM employees WHERE id = ?");
  $stmt->bind_param('i', $del_id);
  if ($stmt->execute()) {
    $feedback = "Funcionário excluído com sucesso!";
  }
  $stmt->close();
}

// EDITAR (Carregar dados)
$edit_data = null;
if ($edit_id) {
  $stmt = $mysqli->prepare("SELECT * FROM employees WHERE id = ?");
  $stmt->bind_param('i', $edit_id);
  $stmt->execute();
  $res = $stmt->get_result();
  $edit_data = $res->fetch_assoc();
  $stmt->close();
}

// POST (Cadastrar ou Atualizar)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $id = $_POST['id'] ?? '';
  $name = trim($_POST['name'] ?? '');
  $role = trim($_POST['role'] ?? '');
  $cep = trim($_POST['cep'] ?? '');
  $street = trim($_POST['street'] ?? '');
  $neigh = trim($_POST['neighborhood'] ?? '');
  $city = trim($_POST['city'] ?? '');
  $uf = trim($_POST['uf'] ?? '');
  
  // LOGIN ADMIN (Apenas no cadastro)
  $email = trim($_POST['email'] ?? '');
  $password = trim($_POST['password'] ?? '');

  // FOTO
  $photo = null;
  if (!empty($_FILES['photo']['name'])) {
    $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
    $fname = 'f_' . time() . '_' . rand(1000, 9999) . '.' . $ext;
    $dest = '../assets/uploads/funcionarios/' . $fname;

    if (move_uploaded_file($_FILES['photo']['tmp_name'], $dest)) {
      $photo = $fname;
    }
  }

  if ($id) {
    // ATUALIZAR
    $sql = "UPDATE employees SET name=?, role=?, cep=?, street=?, neighborhood=?, city=?, uf=?";
    $params = [$name, $role, $cep, $street, $neigh, $city, $uf];
    $types = "sssssss";

    if ($photo) {
      $sql .= ", photo=?";
      $params[] = $photo;
      $types .= "s";
    }

    $sql .= " WHERE id=?";
    $params[] = $id;
    $types .= "i";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param($types, ...$params);
    
    if ($stmt->execute()) {
      $feedback = "Funcionário atualizado com sucesso!";
      $edit_data = null; 
      // header("Location: funcionarios.php"); exit;
    }
    $stmt->close();

  } else {
    // CADASTRAR
    if ($name && $role && $email && $password) {
      $hash = password_hash($password, PASSWORD_DEFAULT);

      /* 1 — INSERIR NA TABELA EMPLOYEES */
      $stmt = $mysqli->prepare("
        INSERT INTO employees (name, role, cep, street, neighborhood, city, uf, photo)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
      ");
      $stmt->bind_param(
        'ssssssss',
        $name,
        $role,
        $cep,
        $street,
        $neigh,
        $city,
        $uf,
        $photo
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
      const cep = document.getElementById("cep").value.replace(/\D/g, '');

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
      document.getElementById("street").value = data.logradouro;
      document.getElementById("neighborhood").value = data.bairro;
      document.getElementById("city").value = data.localidade;
      document.getElementById("uf").value = data.uf;

      // Efeito visual de confirmado
      flashFields();
    }

    function flashFields() {
      const fields = ["street", "neighborhood", "city", "uf"];
      fields.forEach(id => {
        const el = document.getElementById(id);
        el.style.borderColor = "#000"; // visual indicator
        setTimeout(() => el.style.borderColor = "", 800);
      });
    }
  </script>


</head>

<body>

  <!-- HEADER -->
  <div class="top-header">
    <h1><img src="../assets/images/icones_funcionarios.png" alt="Funcionários" class="icon-img"
        style="width:22px;height:22px;"> Funcionários</h1>
  </div>

  <!-- FEEDBACK -->
  <?php if ($feedback): ?>
    <div class="badge" style="margin:20px;font-size:14px;"><?php echo $feedback; ?></div>
  <?php endif; ?>

  <!-- FORM -->
  <div class="form-card">

    <h2><?php echo $edit_data ? 'Editar Funcionário' : 'Cadastrar Funcionário'; ?></h2>

    <form method="post" enctype="multipart/form-data">
      
      <?php if ($edit_data): ?>
        <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">
      <?php endif; ?>

      <img id="preview" class="photo-preview" src="<?php echo ($edit_data && $edit_data['photo']) 
        ? '../assets/uploads/funcionarios/' . $edit_data['photo'] 
        : '../assets/uploads/profile_photos/avatar-default.png'; ?>">

      <input type="file" name="photo" accept="image/*" class="input"
        onchange="preview.src = window.URL.createObjectURL(this.files[0])">

      <input class="input" name="name" placeholder="Nome completo" required value="<?php echo $edit_data['name'] ?? ''; ?>">
      <input class="input" name="role" placeholder="Cargo no sistema" required value="<?php echo $edit_data['role'] ?? ''; ?>">

      <?php if (!$edit_data): ?>
        <input class="input" name="email" type="email" placeholder="E-mail de login" required>
        <input class="input" name="password" type="password" placeholder="Senha de acesso" required>
      <?php else: ?>
        <p style="font-size:12px; color:#666; margin-bottom:10px;">* Login e senha não podem ser alterados por aqui.</p>
      <?php endif; ?>

      <input class="input" id="cep" name="cep" placeholder="CEP" onblur="buscarCEP()" value="<?php echo $edit_data['cep'] ?? ''; ?>">
      <div style="display:flex; gap:10px; align-items:center;">
        <button type="button" class="btn" onclick="buscarCEP()" style="padding:10px 14px;">
          Verificar
        </button>
      </div>

      <input class="input" id="city" name="city" placeholder="Cidade" value="<?php echo $edit_data['city'] ?? ''; ?>">
      <input class="input" id="uf" name="uf" placeholder="UF" value="<?php echo $edit_data['uf'] ?? ''; ?>">
      <input class="input" id="street" name="street" placeholder="Rua" value="<?php echo $edit_data['street'] ?? ''; ?>">
      <input class="input" id="neighborhood" name="neighborhood" placeholder="Bairro" value="<?php echo $edit_data['neighborhood'] ?? ''; ?>">

      <button class="btn-save"><?php echo $edit_data ? 'Atualizar' : 'Salvar Funcionário'; ?></button>
      
      <?php if ($edit_data): ?>
        <a href="funcionarios.php" class="btn secondary" style="margin-top:10px; display:block; text-align:center;">Cancelar</a>
      <?php endif; ?>

    </form>

  </div>

  <!-- LISTA -->
  <?php while ($f = $employees->fetch_assoc()): ?>
    <div class="employee-card">
      <img src="<?php echo $f['photo']
        ? '../assets/uploads/funcionarios/' . $f['photo']
        : '../assets/uploads/profile_photos/avatar-default.png'; ?>">

      <div style="flex:1;">
        <strong><?php echo htmlspecialchars($f['name']); ?></strong><br>
        <small><?php echo htmlspecialchars($f['role']); ?></small><br>
        <small><img src="../assets/images/local_icone.png" alt="Local" class="icon-img" style="width:14px;height:14px;">
          <?php echo $f['city'] . " - " . $f['uf']; ?></small>
      </div>
      
      <div style="display:flex; flex-direction:column; gap:6px;">
        <a href="?edit=<?php echo $f['id']; ?>" class="btn secondary" style="padding:6px 10px; font-size:12px;">Editar</a>
        <a href="?delete=<?php echo $f['id']; ?>" class="btn" style="padding:6px 10px; font-size:12px; background:#ef4444; border-color:#dc2626;" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
      </div>
    </div>
  <?php endwhile; ?>

  <!-- NAV -->
  <?php include '_partials/bottom_nav.php'; ?>


</body>

</html>