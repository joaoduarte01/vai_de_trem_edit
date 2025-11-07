<?php require_once('../assets/config/auth.php'); require_once('../assets/config/db.php');
if($_SERVER['REQUEST_METHOD']==='POST'){
  $title=trim($_POST['title']??''); $body=trim($_POST['body']??''); $tag=$_POST['tag']??'Sistema';
  if($title && $body){ $stmt=$mysqli->prepare("INSERT INTO notices(title,body,tag) VALUES(?,?,?)"); $stmt->bind_param('sss',$title,$body,$tag); $stmt->execute(); }
  header('Location: avisos.php'); exit;
}
?>
<!DOCTYPE html><html lang="pt-BR"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Avisos - Vai de Trem</title>
<?php include '_partials/header.php'; ?>
</head><body>
<div class="container">
  <div class="topbar">
    <h2>Central de Avisos</h2>
    <form method="post" class="row cols-3" style="max-width:700px">
      <input class="input" name="title" placeholder="Título" required>
      <select class="select" name="tag"><option>Manutenção</option><option>Novidades</option><option selected>Sistema</option></select>
      <button class="btn">Publicar</button>
      <textarea class="textarea" name="body" rows="3" placeholder="Escreva o aviso..." required></textarea>
    </form>
  </div>

  <div class="grid cols-1">
  <?php
    $res=$mysqli->query("SELECT * FROM notices ORDER BY id DESC");
    while($n=$res->fetch_assoc()){
      $chip = $n['tag']==='Manutenção' ? '<span class=\"badge red\">Manutenção</span>' : '<span class=\"badge blue\">'.$n['tag'].'</span>';
      echo '<div class=\"card pad\"><div style=\"display:flex;justify-content:space-between\"><strong>'.htmlspecialchars($n['title']).'</strong>'.$chip.'</div>
            <div class=\"link-muted\" style=\"margin-top:6px\">'.htmlspecialchars($n['body']).'</div>
            </div>';
    }
  ?>
  </div>
</div>
</body></html>
