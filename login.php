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
            <div class="bg-red-100 text-red-700 border border-red-300 rounded p-3 mb-4">
                <p><?= $xabar ?></p>
            </div>


        <?php endif; ?>
        <form action="login.php" method="POST" class="flex flex-col gap-4">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Ismingizni kiriting: </label>
                <input type="text" name="username" id="username" class="w-full border rounded p-2 focus:ring-2 focus:ring-blue-500 mt-1 border-gray-300 focus:outline-none">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Parolingizni kiriting: </label>
                <input type="password" name="password" id="password" class="w-full border rounded p-2 focus:ring-2 focus:ring-blue-500 border-gray-300 focus:outline-none ">
            </div>
            <button type="submit" class="bg-blue-600 text-white p-2 rounded hover:bg-blue-700"> Kirish</button>

        </form>
    </div>
</body>

</html>