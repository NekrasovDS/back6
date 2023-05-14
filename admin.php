<?php
$user = 'u52806';
$pass = '7974759';
$db = new PDO('mysql:host=localhost;dbname=u52806', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
$stmt = $db->prepare("SELECT * FROM admin_data");
$stmt->execute();
$admin_data = $stmt ->fetch();
$flag=0;
if(($admin_data['admin_id']==$_SERVER['PHP_AUTH_USER'] && $admin_data['pass']==$_SERVER['PHP_AUTH_PW'])){
  $flag=1;
}
if($flag==0){
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="web_6"');
    print('<h1>401 Требуется авторизация</h1>');
    exit();
}
print('Вы успешно авторизовались');
?>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Панель администратора</title>
    <style>
    table {
      font-family: arial, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    td, th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }

    tr:nth-child(even) {
      background-color: #dddddd;
    }
    </style>
</head>
<body>
<form action="delete.php" method="post" accept-charset="UTF-8">
    <label>
        <input type="number" name="delete">
    </label>
    <input type="submit" style="margin-bottom : -1em"  class="buttonform" value="Удалить запись по ID">
</form>
<form action="change.php" method="post" accept-charset="UTF-8">
    <label>
        <input type="number" name="change">
    </label>
    <input type="submit" style="margin-bottom : -1em"  class="buttonform" value="Изменить запись по ID">
</form>
<?php

$stmt = $db->prepare("SELECT * from user JOIN link on user.user_id=link.userr_id join login_data on user.user_id=login_data.user_id;");
$stmt->execute();
print '<table>';
print '<tr><th>user_id</th><th>fio</th><th>e-mail</th><th>birthday</th><th>gender</th><th>limb count</th>
    <th>biography</th><th>Логин</th><th>Хэш пароля</th><th>Способность</th></tr>';
$cur_id='';
while($row = $stmt ->fetch(PDO::FETCH_ASSOC)){
    if($cur_id!=$row["user_id"]){
    $cur_id=$row["user_id"];
    print '<tr><td>';
    print $row["user_id"];
    print '</td><td>';
    print $row["fio"];
    print '</td><td>';
    print $row["user_email"];
    print '</td><td>';
    print $row["user_birthday"];
    print '</td><td>';
    print $row["user_gender"];
    print '</td><td>';
    print $row["user_limb_count"];
    print '</td><td>';
    print $row["user_biography"];
    print '</td><td>';
    print $row["login_id"];
    print '</td><td>';
    print $row["pass"];
    print '</td><td>';
  }
    switch ($row["abil_id"]){
      case 0: print 'fly';
        break;
      case 1: print 'read';
        break;
      case 2: print 'write';
    }
    print '<br>';
    if($cur_id!=$row["user_id"]){
    print '</td></tr>';
  }
}
print '</table>';

$request = "SELECT COUNT(abil_id) FROM link where abil_id='0'";
$result = $db ->prepare($request);
$result->execute();
$count_abil1 = $result->fetch()[0];
$request = "SELECT COUNT(abil_id) FROM link where abil_id='1'";
$result = $db ->prepare($request);
$result->execute();
$count_abil2 = $result->fetch()[0];
$request = "SELECT COUNT(abil_id) FROM link where abil_id='2'";
$result = $db ->prepare($request);
$result->execute();
$count_abil3 = $result->fetch()[0];
print '<h2>Статистика по способностям:</h2>';
print '<table class="table">';
print '<tr><th>fly</th><th>read</th><th>write</th></tr>';
print '<tr><td>';
print $count_abil1;
print '</td><td>';
print $count_abil2;
print '</td><td>';
print $count_abil3;
print '</td></tr>';
print '</table>';

print '<a href="./">form</a>';
?>
</body>
<html>
<?php
?>
