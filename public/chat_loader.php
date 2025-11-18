<?php
require_once('../assets/config/auth.php');
require_once('../assets/config/db.php');

$res = $mysqli->query("
    SELECT c.*, u.name, u.avatar, u.role 
    FROM chat_messages c
    JOIN users u ON u.id = c.user_id
    ORDER BY c.id ASC
");

while ($m = $res->fetch_assoc()) {

    $me = $m['user_id'] == $user['id'] ? 'me' : 'other';

    $avatar = $m['avatar']
        ? "../assets/uploads/profile_photos/".$m['avatar']
        : "../assets/uploads/profile_photos/avatar-default.png";

    $tag = $m['role'] === 'admin'
        ? "<small style='color:#22c55e;font-weight:600'>Admin</small>"
        : "";

    echo "
    <div class='msg $me'>
        <img class='avatar' src='$avatar'>
        <div class='bubble'>
            <strong>".htmlspecialchars($m['name'])."</strong> $tag<br>
            ".nl2br(htmlspecialchars($m['message']))."
            <small>".$m['created_at']."</small>
        </div>
    </div>
    ";
}
