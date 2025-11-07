<?php
require_once('../assets/config/auth.php');
require_once('../assets/config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $name = trim($_POST['name'] ?? '');
    $status = $_POST['status'] ?? 'ativa';
    $dur = intval($_POST['duration'] ?? 0);

    if ($name) {
        $stmt = $mysqli->prepare("INSERT INTO routes (name, status, duration_minutes) VALUES (?, ?, ?)");
        $stmt->bind_param('ssi', $name, $status, $dur);
        $stmt->execute();
    }

    header('Location: rotas.php');
    exit;
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $mysqli->prepare("DELETE FROM routes WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: rotas.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Rotas - Vai de Trem</title>
  <?php include '_partials/header.php'; ?>
  <style>
    body {
      background: #f5f6fa;
      font-family: 'Poppins', sans-serif;
      color: #222;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 900px;
      margin: 40px auto;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      padding: 20px 30px;
    }
    h2 {
      text-align: center;
      color: #004aad;
      margin-bottom: 20px;
    }
    .topbar details {
      background: #eef3ff;
      padding: 15px;
      border-radius: 8px;
    }
    .row {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }
    .input, .select {
      flex: 1;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 15px;
    }
    .btn {
      background: #004aad;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 6px;
      cursor: pointer;
      transition: 0.3s;
    }
    .btn:hover {
      background: #0061ff;
    }
    .table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 25px;
    }
    .table th, .table td {
      border-bottom: 1px solid #ddd;
      padding: 12px;
      text-align: left;
    }
    .table th {
      background: #004aad;
      color: #fff;
    }
    .badge {
      display: inline-block;
      padding: 5px 10px;
      border-radius: 6px;
      font-size: 13px;
      text-transform: capitalize;
      background: #ccc;
      color: #222;
    }
    .badge.blue {
      background: #00c52b;
      color: #fff;
    }
    a.badge {
      text-decoration: none;
      background: #e74c3c;
      color: #fff;
    }
    a.badge:hover {
      background: #c0392b;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Gerenciamento de Rotas</h2>

  <details>
    <summary style="cursor:pointer;font-weight:600;">+ Nova Rota</summary>
    <form method="post" class="row" style="margin-top:10px">
      <input class="input" name="name" placeholder="Nome da rota" required>
      <select class="select" name="status">
        <option value="ativa">Ativa</option>
        <option value="manutencao">Manutenção</option>
      </select>
      <input class="input" type="number" name="duration" placeholder="Duração (min)">
      <button class="btn" name="create" value="1">Salvar</button>
    </form>
  </details>

  <table class="table">
    <thead>
      <tr>
        <th>Rota</th>
        <th>Status</th>
        <th>Duração</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $res = $mysqli->query("SELECT * FROM routes ORDER BY id DESC");
      if ($res->num_rows > 0) {
        while ($r = $res->fetch_assoc()) {
          $badge = $r['status'] === 'ativa'
            ? '<span class="badge blue">Ativa</span>'
            : '<span class="badge">Manutenção</span>';

          echo '<tr>
                  <td>'.htmlspecialchars($r['name']).'</td>
                  <td>'.$badge.'</td>
                  <td>'.($r['duration_minutes'] ?: '-').' min</td>
                  <td>
                    <a class="badge" href="?delete='.$r['id'].'" onclick="return confirm(\'Excluir esta rota?\')">Excluir</a>
                  </td>
                </tr>';
        }
      } else {
        echo '<tr><td colspan="4" style="text-align:center;color:#777;">Nenhuma rota cadastrada.</td></tr>';
      }
      ?>
    </tbody>
  </table>
</div>

</body>
</html>
