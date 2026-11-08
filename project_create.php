<?php

require_once 'config/bootstrap.php';

$xabar = null;

session_start();

if (isset($_SESSION['user_id'])==false) {
    header("Location: login.php", true, 303);
    exit;
} else {
    $title = '';
    $description = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');


        if ($title === '') {
            $xabar = 'Loyiha sarlavhasini kiriting! ';
        } else if ($description === '') {
            $xabar = "Loyiha haqida ma'lumotni kiriting! ";
        } else {
            $stmt = $pdo->prepare('
    INSERT into  projects (title, description) values (:title , :description)
    ');

            $stmt->execute([
                'title' => $title,
                'description' => $description,
            ]);

            header('Location: index.php', true, 303);
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loyiha yaratish</title>
</head>

<body>

    <?php if (!$xabar == null): ?>

        <h2><?= htmlspecialchars($xabar) ?></h2>

    <?php endif; ?>

    <div>
        <h1>Loyiha qo'shish</h1>
        <form action="project_create.php" method="post">
            <label for="title">Loyiha nomini kiriting: </label>
            <input type="text" name="title" id="title" value="<?= htmlspecialchars($title); ?>"> <br>
            <label for="description">Loyiha tavsifini kiriting: </label>
            <textarea name="description" id="description" rows="30" cols="100">
                <?= htmlspecialchars($description); ?>
            </textarea>
            <button type="submit">Saqlash</button>
        </form>
    </div>

</body>

</html>