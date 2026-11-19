<?php

require_once 'config/bootstrap.php';

$pageTitle = 'Loyihani tahrirlash';

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

require_once "./layout/header.php";
?>

<body class="bg-gray-100 min-h-screen">

    <?php require_once "./layout/navbar.php" ?>
    <main class="max-w-2xl mx-auto p-4 sm:p-8">

        <?php if ($xabar !== null): ?>

            <h2 class="alert-error"><?= htmlspecialchars($xabar) ?></h2>
        <?php endif; ?>


        <?php if ($selObj instanceof Project): ?>
            <section class="bg-white border border-gray-200 rounded-xl p-6 sm:p-8 shadow-sm">
                <h1 class="text-2xl font-bold text-gray-900">Loyiha tahrirlash</h1>
                <form action="project_edit.php?id=<?= $selObj->getId() ?>" method="post" class="mt-6 flex flex-col gap-5">
                    <div class="">
                        <label for="title" class="lb-text">Loyiha nomini kiriting: </label>
                        <input type="text" name="title" id="title" value="<?= htmlspecialchars($title); ?>" class="field-input">

                    </div>
                    <div>
                        <label for="description" class="lb-text">Loyiha tavsifini kiriting: </label>
                        <textarea name="description" id="description" rows="8" class="field-textarea">
                        <?= htmlspecialchars($description); ?>
                        </textarea>
                    </div>
                    <button type="submit"  class="btn-primary">Saqlash</button>
                </form>
            </section>
            <?php endif; ?>
    </main>
    <?php require_once "./layout/footer.php"; ?>

 