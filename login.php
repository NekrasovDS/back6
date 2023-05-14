<?php
header('Content-Type: text/html; charset=UTF-8');
session_start();
if (!empty($_SESSION['login'])) {
  session_destroy();
  header('Location: ./');
}
$message;
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Задание 5 - логин скрин</title>
  <link rel="stylesheet" href="style.css"><script src="script.js"></script>
  </head>
  <div>
<form action="" method="post">
  <label>Логин<input name="login" /></label>
  <label>Пароль<input name="pass" /></label>
  <input type="submit" value="Войти" /></form></div>
<?php
if (!empty($_GET['none'])) {
  $txt="Таких данных в бд НЕТ";
    print"<div>" . $txt . "<div>";}}
else {
  $user = 'u52806';
  $pass = '7974759';
  $db = new PDO('mysql:host=localhost;dbname=u52806', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
  $login_id = $_POST['login'];
  $pass = md5($_POST['pass']);
  $stmt = $db->prepare("SELECT user_id FROM login_data WHERE login_id = ? AND pass = ?");
  $stmt->execute([$login_id, $pass]);
  $user_id = $stmt ->fetch(PDO::FETCH_COLUMN);
  if($user_id){
    $_SESSION['login'] = $_POST['login'];
    $_SESSION['uid'] = $user_id;
    $_COOKIE[session_name()] = "session_true";
    header('Location: ./');}
  else{
    header('Location: ?none=1');}}
?>
