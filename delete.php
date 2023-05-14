<?php
$id = $_POST['delete'];
$user = 'u52806';
$pass = '7974759';
  $db = new PDO('mysql:host=localhost;dbname=u52806', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
$req = "DELETE FROM link WHERE userr_id='$id'";
$res = $db->prepare($req);
$res->execute();
$req = "DELETE FROM login_data WHERE user_id='$id'";
$res = $db->prepare($req);
$res->execute();
$req = "DELETE FROM user WHERE user_id='$id'";
$res = $db->prepare($req);
$res->execute();
header('Location:admin.php');
