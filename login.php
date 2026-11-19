<?php

require_once 'config/bootstrap.php';


session_start();
$pageTitle = 'Kirish sahifasi';

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

            header("Location: index.php", true, 303);
            exit;
        } else {
            $xabar = 'Login yoki parol xato!';
        }
    }
}

require_once './layout/header.php';

?>



<body class="flex min-h-screen items-center justify-center bg-gray-100 p-4">
    <div class="bg-white p-4 sm:p-6 rounded-lg shadow-md  max-w-sm">
        <h1 class="text-2xl font-bold text-center mb-6 text-blue-400">TIZIMGA KIRISH</h1>
        <?php if ($xabar !== null): ?>
            <div class="alert-error">
                <p><?= $xabar ?></p>
            </div>


        <?php endif; ?>
        <form action="login.php" method="POST" class="flex flex-col gap-4">
            <div>
                <label for="username" class="lb-text">Ismingizni kiriting: </label>
                <input type="text" name="username" id="username" class="field-input">
            </div>
            <div>
                <label for="password" class="lb-text">Parolingizni kiriting: </label>
                <input type="password" name="password" id="password" class="field-input">
            </div>
            <button type="submit" class="btn-primary"> Kirish</button>

        </form>
    </div>
</body>

</html>