<?php

require_once 'config/bootstrap.php';

$pageTitle = 'Bosh sahifa';

session_start();



if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['chiqish'])) {
        unset($_SESSION['user_id']);
    }
}



$info = "Men Abuhalilov Muhammadqodir, PHP oop kursidan keyin amaliy mashg'ulot 
o'tkazyapman.";

$skills = ['Mysql-b', "PHP", 'Laravel-b'];

$services =  ["Web sayt tayyorlash", "Telegram bot qilish"];

$men = null;

$stmt = $pdo->query('
Select id, title, description FROM projects
');

$projects = $stmt->fetchAll(PDO::FETCH_CLASS, Project::class);



try {
    $men = new Profile('Muhammadqodir', $info, $skills, $services);
} catch (Exception $e) {
    $xabar =  "Afsuski, obyekt yaratilmadi! " . $e->getMessage();
}

try {
    $men->changeName("");
} catch (Exception $e) {
    $xabar = "Afsuski, ism o'zgartirilmadi! " . $e->getMessage();
}


date_default_timezone_set('Asia/Tashkent');
require_once "./layout/header.php";

?>


<body class="bg-gray-100 min-h-screen">

    <?php require_once "./layout/navbar.php"; ?>

    <main class="max-w-4xl mx-auto p-4 sm:p-8">
        <?php if ($men !== null): ?>
            <section class="bg-white rounded-xl  shadow-sm p-6 sm:p-8 mb-8">
                <h1 class="text-3xl font-bold text-gray-900 text-center">Assalomu alaykum, <?= htmlspecialchars($men->getName()) ?> portofoliosiga xush kelibsiz!</h1>
                <div>
                    <p class="mt-4 text-gray-600 leading-7">Mening haqimda qisqacha ma'lumot: <br>
                        <?= $men->info ?>
                    </p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">


                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-5">
                        <h4 class="text-lg font-semibold text-gray-900 mb-3"> Mening skillarim: </h4>
                        <ul class="space-y-2 "> <?php foreach ($men->skills as $skill): ?>

                                <li class="text-gray-700"><?= $skill ?></li>
                            <?php endforeach ?>
                        </ul>

                    </div>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-5">
                        <h4 class="text-lg font-semibold text-gray-900 mb-3"> Mening taklif eta oladigan xizmatlarim: </h4>
                        <ul class="space-y-2 "><?php foreach ($men->services as $servis): ?>
                                <li class="text-gray-700"><?= $servis ?></li>
                            <?php endforeach ?>
                        </ul>

                    </div>
                </div>
            </section>
        <?php else: ?>
            <?= htmlspecialchars($xabar); ?>
            <h3>Profil ma'lumotlari ko'rsatilmadi</h3>
        <?php endif; ?>
        <section class="">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Loyihalarim</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 ">
                <?php foreach ($projects as $project): ?>
                    <article class="bg-white border border-gray-200 rounded-xl p-6 transition hover:shadow-md">

                        <a href="project_view.php?id=<?= $project->getId() ?>">
                            <h2 class="text-xl font-semibold text-blue-600 hover:text-blue-700"><?= $project->getId() . ' ' . htmlspecialchars($project->getTitle()) ?></h2>
                        </a>
                        <p class="mt-3 text-gray-600 leading-7"><?= htmlspecialchars($project->getDescription()) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <?php require_once "./layout/footer.php"; ?>