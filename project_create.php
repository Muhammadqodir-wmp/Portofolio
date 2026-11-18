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

            <h2 class="bg-red-100 border border-red-300 rounded-lg p-4 text-red-700"><?= htmlspecialchars($xabar) ?></h2>

        <?php endif; ?>

            <h1 class="text-2xl font-bold text-gray-900">Loyiha qo'shish</h1>
            <form action="project_create.php" method="post" class="mt-6 flex flex-col gap-5">
                    <div>
                         <label class="block text-sm font-medium text-gray-700" for="title">Loyiha nomini kiriting: </label>
                         <input class="mt-1 w-full border border-gray-300 rounded p-2 focus:outline-none focus:ring-blue-500 focus:ring-2" 
                         type="text" name="title" id="title" value="<?= htmlspecialchars($title); ?>"> <br>
            
                    </div>   
                <div>
                        <label class="block text-sm font-medium text-gray-700" for="description">Loyiha tavsifini kiriting: </label>
                        <textarea class="mt-1 w-full border border-gray-300 rounded focus:outline-none focus:ring-blue-500 focus:ring-2 p-3" name="description" id="description" rows="8" >
                        <?= htmlspecialchars($description);  ?>
                         </textarea> 
            </div>
                <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">Saqlash</button>
            </form>
        </section>
    </main>
<?php require_once "./layout/footer.php"; ?> 