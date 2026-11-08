<?php

require_once 'config/bootstrap.php';


session_start();

$xabar = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($password == '') {
        $xabar =  'Parolni kiriting';
    } else if ($username == '') {
        $xabar = 'Ismingizni kiriting';
    } else {
        $stmt = $pdo->prepare('Select id, username, password from users where username = :username');

        $stmt->execute([
            'username' => $username
        ]);
        $natija = $stmt->fetch();
        if ($natija === false) {
            $xabar = "Mos foydalanuvchi topilmadi";
        } else  if (password_verify($password, $natija['password'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $natija['id'];

            header("Location: index.php", true, 303 );
            exit;
        } else {
            $xabar = 'Login yoki parol xato!';
        }
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login sahifasi</title>
</head>

<body>
    <?php if ($xabar !== null): ?>
        <div>
            <h1><?= $xabar ?></h1>
        </div>
    <?php endif; ?>
    <form action="login.php" method="POST">
        <label for="username">Ismingizni kiriting: </label>
        <input type="text" name="username"> <br>
        <label for="password">Parolingizni kiriting: </label>
        <input type="password" name="password">
        <button type="submit"> Kirish</button>
    </form>
</body>

</html>