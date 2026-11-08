<?php

require_once 'config/bootstrap.php';

session_start();

if (isset($_SESSION['user_id']) == false) {
    header('Location: login.php', true, 303);
    exit;
} else {
    $selObj = null;
    $xabar = null;

    $id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);


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

    $title = '';
    $description = '';

    if ($selObj instanceof Project) {
        $title = $selObj->getTitle();
        $description = $selObj->getDescription();
    }

    if ($selObj instanceof Project && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');


        if ($title === '') {
            $xabar = 'Loyiha sarlavhasini kiriting! ';
        } else if ($description === '') {
            $xabar = "Loyiha haqida ma'lumotni kiriting! ";
        } else {
            $stmt = $pdo->prepare('
    UPDATE   projects 
    SET title = :title , description= :description
     WHERE id = :id
    ');

            $stmt->execute([
                'id' => $selObj->getId(),
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


    <?php if ($selObj instanceof Project): ?>
        <div>
            <h1>Loyiha tahrirlash</h1>
            <form action="project_edit.php?id=<?= $selObj->getId() ?>" method="post">
                <label for="title">Loyiha nomini kiriting: </label>
                <input type="text" name="title" id="title" value="<?= htmlspecialchars($title); ?>"> <br>
                <label for="description">Loyiha tavsifini kiriting: </label>
                <textarea name="description" id="description" rows="30" cols="100">
                    <?= htmlspecialchars($description); ?>
                </textarea>
                <button type="submit">Saqlash</button>
            </form>
        </div>
    <?php endif; ?>

</body>

</html>