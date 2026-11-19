<?php

require_once 'config/bootstrap.php';

$xabar = null;
$pageTitle = "Loyiha yaratish";
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

require_once "./layout/header.php";
?>
<body class="bg-gray-100 min-h-screen">
    <?php require_once "./layout/navbar.php"; ?>
    <main class="max-w-2xl mx-auto p-4 sm:p-8">
        <section class="bg-white border border-gray-200 rounded-xl p-6 sm:p-8 shadow-sm">
        <?php if ($xabar !== null): ?>

            <h2 class="alert-error"><?= htmlspecialchars($xabar) ?></h2>

        <?php endif; ?>

            <h1 class="text-2xl font-bold text-gray-900">Loyiha qo'shish</h1>
            <form action="project_create.php" method="post" class="mt-6 flex flex-col gap-5">
                    <div>
                         <label class="lb-text" for="title">Loyiha nomini kiriting: </label>
                         <input class="field-input" 
                         type="text" name="title" id="title" value="<?= htmlspecialchars($title); ?>"> <br>
            
                    </div>   
                <div>
                        <label class="lb-text" for="description">Loyiha tavsifini kiriting: </label>
                        <textarea class="field-textarea" name="description" id="description" rows="8" >
                        <?= htmlspecialchars($description);  ?>
                         </textarea> 
            </div>
                <button type="submit" class="btn-primary">Saqlash</button>
            </form>
        </section>
    </main>
<?php require_once "./layout/footer.php"; ?> 