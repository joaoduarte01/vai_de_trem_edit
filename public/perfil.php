<?php require_once('../assets/config/auth.php'); require_once('../assets/config/db.php');
$feedback='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $name=trim($_POST['name']??''); $phone=trim($_POST['phone']??''); $department=trim($_POST['department']??''); $job=trim($_POST['job_title']??'');
  $avatarPath = $user['avatar'];
  if(isset($_FILES['avatar']) && $_FILES['avatar']['error']===UPLOAD_ERR_OK){
    $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $fname = 'u'.$user['id'].'_'.time().'.'.strtolower($ext);
    $dest = '../assets/uploads/profile_photos/'.$fname;
    if(move_uploaded_file($_FILES['avatar']['tmp_name'],$dest)){ $avatarPath = $fname; }
  }
  $stmt=$mysqli->prepare("UPDATE users SET name=?, phone=?, department=?, job_title=?, avatar=? WHERE id=?");
  $stmt->bind_param('sssssi',$name,$phone,$department,$job,$avatarPath,$user['id']);
  if($stmt->execute()){
    $_SESSION['user']['name']=$name; $_SESSION['user']['avatar']=$avatarPath; $feedback='Salvo!';
  }
}
$res=$mysqli->query("SELECT * FROM users WHERE id=".$user['id']); $me=$res->fetch_assoc();
?>
<!DOCTYPE html><html lang="pt-BR"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Meu Perfil - Vai de Trem</title>
<?php include '_partials/header.php'; ?>
</head><body>
<div class="container">
 <h2>Meu Perfil</h2>
 <div class="card pad">
  <?php if($feedback): ?><div class="badge"><?php echo $feedback; ?></div><?php endif; ?>
  <form method="post" enctype="multipart/form-data" class="row cols-2">
    <div>
      <img class="avatar" src="<?php echo $me['avatar']? '../assets/uploads/profile_photos/'.$me['avatar'] : '../assets/uploads/profile_photos/avatar-default.png'; ?>" onerror="this.src='../assets/uploads/profile_photos/avatar-default.png'">
      <input class="input" type="file" name="avatar" accept="image/*">
    </div>
    <div class="row">
      <input class="input" name="name" value="<?php echo htmlspecialchars($me['name']); ?>" placeholder="Nome completo">
      <input class="input" type="email" disabled value="<?php echo htmlspecialchars($me['email']); ?>">
      <input class="input" name="phone" value="<?php echo htmlspecialchars($me['phone']); ?>" placeholder="Telefone">
      <input class="input" name="department" value="<?php echo htmlspecialchars($me['department']); ?>" placeholder="Departamento">
      <input class="input" name="job_title" value="<?php echo htmlspecialchars($me['job_title']); ?>" placeholder="Cargo">
      <button class="btn">Salvar Alterações</button>
    </div>
  </form>
 </div>
</div>
</body></html>
