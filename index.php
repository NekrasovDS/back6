<?php

header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $messages = array();
    $messages[8] = '';
    $messages[9] = '';
    if (!empty($_COOKIE['save'])) {
      setcookie('save', '', 100000);
      setcookie('login', '', 100000);
      setcookie('pass', '', 100000);
      $messages[8] = '<div style="text-align: center; margin: 4px;">Спасибо, результаты сохранены.</div>';
      if (!empty($_COOKIE['pass'])) {
        $messages[9] = sprintf('Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
          и паролем <strong>%s</strong> для изменения данных.',
          strip_tags($_COOKIE['login']),
          strip_tags($_COOKIE['pass']));
      }
    }

    $errors = array();
    $errors['fio'] = !empty($_COOKIE['fio_error']);
    $errors['email'] = !empty($_COOKIE['email_error']);
    $errors['birthday'] = !empty($_COOKIE['birthday_error']);
    $errors['gender'] = !empty($_COOKIE['gender_error']);
    $errors['limbs'] = !empty($_COOKIE['limbs_error']);
    $errors['biography'] = !empty($_COOKIE['biography_error']);

    $errors['ability'] = !empty($_COOKIE['ability_error']);
    $errors['contract'] = !empty($_COOKIE['contract_error']);

    if ($errors['fio']) {
      setcookie('fio_error', '', 100000);
      $messages[0] = '<div class="error_text">Поле с именем не должно быть пустым.</div>';
    }
    if ($errors['email']) {
        setcookie('email_error', '', 100000);
        $messages[1] = '<div class="error_text">Заполните почту в формате email@example.com.</div>';
    }
    if ($errors['birthday']) {
        setcookie('birthday_error', '', 100000);
        $messages[2] = '<div class="error_text">Выберите дату.</div>';
    }
    if ($errors['gender']) {
      setcookie('gender_error', '', 100000);
      $messages[3] = '<div class="error_text">Выберите свой гендер.</div>';
  }
  if ($errors['limbs']) {
    setcookie('limbs_error', '', 100000);
    $messages[4] = '<div class="error_text">Выберите количество конечностей.</div>';
  }
    if ($errors['biography']) {
      setcookie('biography_error', '', 100000);
      $messages[6] = '<div class="error_text">Поле с биографией не должно быть пустым.</div>';
    }
    if ($errors['ability']) {
      setcookie('ability_error', '', 100000);
      $messages[5] = '<div class="error_text">Должна быть выбрана хотя бы одна способность.</div>';
    }
    if ($errors['contract']) {
      setcookie('contract_error', '', 100000);
      $messages[7] = '<div class="error_text">Вы должны согласиться с условиями , прежде чем продолжить.</div>';
    }



    if (!empty($_COOKIE[session_name()]) &&
        session_start() && !empty($_SESSION['login'])) {
      $user = 'u20945';
      $pass = '1388111';
      $db = new PDO('mysql:host=localhost;dbname=u20945', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
      $stmt = $db->prepare("SELECT * FROM user WHERE user_id = ?");
      $stmt->execute([$_SESSION['uid']]);
      $row = $stmt ->fetch(PDO::FETCH_ASSOC);

      $values = array();
      $values['fio'] = $row["fio"];
      $values['email'] = $row["user_email"];
      $values['birthday'] = $row["user_birthday"];
      $values['gender'] = $row["user_gender"];
      $values['limbs'] = $row["user_limb_count"];
      $values['biography'] = $row["user_biography"];
      $stmt = $db->prepare("SELECT abil_id FROM link WHERE userr_id = ?");
      $stmt->execute([$_SESSION['uid']]);
      $ability = $stmt->fetchAll(PDO::FETCH_COLUMN);
      $messages[10] = 'Вход с логином %s, uid %d';
    }
    else {
      $values = array();
      $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
      $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
      $values['birthday'] = empty($_COOKIE['birthday_value']) ? '' : $_COOKIE['birthday_value'];
      $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
      $values['limbs'] = empty($_COOKIE['limbs_value']) ? '' : $_COOKIE['limbs_value'];
      $values['biography'] = empty($_COOKIE['biography_value']) ? '' : $_COOKIE['biography_value'];

      $ability = array();
      $ability = empty($_COOKIE['ability_values']) ? array() : unserialize($_COOKIE['ability_values'], ["allowed_classes" => false]);
    }
    
    include('form.php');
  }
else {
    $errors = FALSE;
    if (empty($_POST['fio'])) {
      setcookie('fio_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else {
      setcookie('fio_value', $_POST['fio'], time() + 30 * 24 * 60 * 60);
    }
    if (!preg_match('/^[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]+$/', $_POST['email'])) {
        setcookie('email_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
      }
    else{
        setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
    }
    if (empty($_POST['birthday'])) {
        setcookie('birthday_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
      }
      else {
        setcookie('birthday_value', $_POST['birthday'], time() + 30 * 24 * 60 * 60);
      }
    if (!isset($_POST['gender'])) {
      setcookie('gender_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else {
      setcookie('gender_value', $_POST['gender'], time() + 30 * 24 * 60 * 60);
    }
    if (!isset($_POST['limbs'])) {
      setcookie('limbs_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else {
      setcookie('limbs_value', $_POST['limbs'], time() + 30 * 24 * 60 * 60);
    }
    if (empty($_POST['biography'])) {
      setcookie('biography_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else {
      setcookie('biography_value', $_POST['biography'], time() + 30 * 24 * 60 * 60);
    }
    if (!isset($_POST['ability'])) {
      setcookie('ability_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }
    else {

      setcookie('ability_values', serialize($_POST['ability']), time() + 30 * 24 * 60 * 60);
    }
    if (!isset($_POST['contract'])) {
      setcookie('contract_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
    }


if ($errors) {
    header('Location: index.php');
    exit();
  }
  else {
    // Удаляем Cookies с признаками ошибок.
    setcookie('fio_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('birthday_error', '', 100000);
    setcookie('gender_error', '', 100000);
    setcookie('limbs_error', '', 100000);
    setcookie('ability_error', '', 100000);
    setcookie('biography_error', '', 100000);
    setcookie('contract_error', '', 100000);
  }


 $user = 'u52806';
 $pass = '7974759';
 $db = new PDO('mysql:host=localhost;dbname=u52806', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

 if (!empty($_COOKIE[session_name()]) &&
     session_start() && !empty($_SESSION['login'])) {
   
   $stmt = $db->prepare("UPDATE user SET fio = ?, user_email = ?, user_birthday = ?, user_gender = ? , user_limb_count = ?, user_biography = ? WHERE user_id = ?");
   $stmt -> execute([$_POST['fio'],$_POST['email'],$_POST['birthday'],$_POST['gender'],$_POST['limbs'],$_POST['biography'],$_SESSION['uid']]);
   $stmt2 = $db->prepare("INSERT INTO link SET userr_id= ?, abil_id = ?");

   foreach ($_POST['ability'] as $s)
     $stmt2 -> execute([$_SESSION['uid'], $s]);
 }
 else {
   $login = uniqid('',true);
   $pass = rand(10,100);
   setcookie('login', $login);
   setcookie('pass', $pass);
   $stmt = $db->prepare("INSERT INTO user SET fio = ?, user_email = ?, user_birthday = ?, user_gender = ? , user_limb_count = ?, user_biography = ?");
   $stmt -> execute([$_POST['fio'],$_POST['email'],$_POST['birthday'],$_POST['gender'],$_POST['limbs'],$_POST['biography']]);
   $stmt2 = $db->prepare("INSERT INTO link SET userr_id= ?, abil_id = ?");
   $user_id = $db->lastInsertId();
   foreach ($_POST['ability'] as $s)
     $stmt2 -> execute([$user_id, $s]);

   $stmt = $db->prepare("INSERT INTO login_data SET login_id = ?, pass = ?, user_id = ?");
   $stmt -> execute([$login,md5($pass),$user_id]);
 }

setcookie('save', '1');

header('Location: ?save=1');
}
