<?php

require_once 'config/bootstrap.php';


$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);

$selObj = null;
$xabar = null;
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}



if ($id === false || $id <= 0) {
    $xabar = "Iltimos, idga musbat son kiriting!";
} else {
    $stmt = $pdo->prepare('
            Select id, title, description FROM projects WHERE id = :id
        ');



    $stmt->execute(['id' => $id]);

    $stmt->setFetchMode(PDO::FETCH_CLASS, Project::class);

    $selObj = $stmt->fetch();
    if ($selObj === false) {
        $xabar = 'Loyiha topilmadi';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $selObj instanceof Project) {
    if (isset($_SESSION['user_id']) == false) {
        header('Location:login.php', true, 303);
        exit;
    }
    if ($_SESSION['csrf_token'] == $_POST['csrf_token']) {
        $stmt = $pdo->prepare("DELETE FROM projects WHERE id = :id");
        $stmt->execute(['id' => $selObj->getId()]);
        header('Location: index.php', true, 303);
        exit;
    }
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <a href="index.php">
        <h4>Bosh sahifaga qaytish</h4>
    </a>

    <?php if ($xabar !== null): ?>
        <h2> <?= htmlspecialchars($xabar) ?> </h2>
    <?php else: ?>
        <h1><?= $selObj->getId() . '  ' .  htmlspecialchars($selObj->getTitle()) ?></h1>
        <p>
            <?= htmlspecialchars($selObj->getDescription()) ?>
        </p>
        <?php if (isset($_SESSION['user_id']) == false): ?>

            <a href="login.php"><?php echo "To'liq foydalanish uchunt tizimga kirish kerak"; ?></a>
        <?php else: ?>
            <form action="project_view.php?id=<?= $selObj->getId() ?>" method="POST" onsubmit="return confirm('O\'chirishga ishonchiz komilmi?')">
                <button name="delete" type="submit">
                    O'chirish</button>
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            </form>
            <a href="project_edit.php?id=<?= $selObj->getId() ?>">
                <h4>Loyihani tahrirlash</h4>
            </a>
        <?php endif; ?>
    <?php endif; ?>
</body>

</html>