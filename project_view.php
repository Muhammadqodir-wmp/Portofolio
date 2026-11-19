<?php

require_once 'config/bootstrap.php';
$pageTitle = "Loyiha taqdimoti";

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


require_once "./layout/header.php";

?>
<body class="bg-gray-100 min-h-screen">
    <?php 
    require_once "./layout/navbar.php"; ?>
    <main class="max-w-4xl mx-auto p-4 sm:p-8">

    <?php if ($xabar !== null): ?>
        <div class="alert-error">

            <h2 class="font-semibold"> <?= htmlspecialchars($xabar) ?> </h2>
        </div>
    <?php else: ?>
        <section class="bg-white border border-gray-200 rounded-xl p-6 sm:p-8 shadow-sm ">
        <h1 class="text-3xl font-bold text-gray-900"><?= $selObj->getId() . '  ' .  htmlspecialchars($selObj->getTitle()) ?></h1>
        <p class="mt-4 text-gray-600 leading-7">
            <?= htmlspecialchars($selObj->getDescription()) ?>
        </p>
        <?php if (isset($_SESSION['user_id']) == false): ?>
            <a href="login.php" class="mt-8 inline-flex bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"><?php echo "To'liq foydalanish uchunt tizimga kirish kerak"; ?></a>
            <?php else: ?>
              <div class="mt-8 flex flex-wrap items-center gap-3"> 
                  <form action="project_view.php?id=<?= $selObj->getId() ?>" method="POST" onsubmit="return confirm('O\'chirishga ishonchiz komilmi?')">
                    <button name="delete" type="submit" class="btn-danger">
                        O'chirish</button>
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                </form>
                <a href="project_edit.php?id=<?= $selObj->getId() ?>" class="btn-primary">
                    Loyihani tahrirlash
                </a>
              </div>
              <?php endif; ?>
              <?php endif; ?>
            </section>        
        </main>
    <?php require_once "./layout/footer.php"; ?>
