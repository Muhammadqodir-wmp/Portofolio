<?php

require_once 'config/bootstrap.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    if (isset($_GET['chiqish'])) {
        unset($_SESSION['user_id']);
    }
}

if (isset($_SESSION['user_id'])) {
    echo  "Tizimga kirilgan!";
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muhammadqodir Portofolio</title>
</head>

<body>
    <a href="login.php">Kirish</a>
    <form action="index.php">
        <input type="hidden" name="chiqish">
        <button type="sumbit">Sessiyadan chiqish</button>
    </form>
    <?php if ($men !== null): ?>

        <h1>Assalomu alaykum, <?= htmlspecialchars($men->getName()) ?> portofoliosiga xush kelibsiz!</h1>
        <a href="project_create.php"> Loyiha yaratish</a>
        <div>
            <p>Mening haqimda qisqacha ma'lumot: <br>
                <?= $men->info ?>
            </p>
        </div>
        <h4> Mening skillarim: </h4>

        <div>
            <ul> <?php foreach ($men->skills as $skill): ?>

                    <li><?= $skill ?></li>
                <?php endforeach ?>
            </ul>

        </div>
        <h4> Mening taklif eta oladigan xizmatlarim: </h4>
        <div>
            <ul><?php foreach ($men->services as $servis): ?>
                    <li><?= $servis ?></li>
                <?php endforeach ?>
            </ul>

        </div>
    <?php else: ?>
        <?= htmlspecialchars($xabar); ?>
        <h3>Profil ma'lumotlari ko'rsatilmadi</h3>
    <?php endif; ?>
    <div>
        <h1>Loyihalarim</h1>
        <?php foreach ($projects as $project): ?>
            <article>

                <a href="project_view.php?id=<?= $project->getId() ?>">
                    <h2><?= $project->getId() . ' ' . htmlspecialchars($project->getTitle()) ?></h2>
                </a>
                <p><?= htmlspecialchars($project->getDescription()) ?></p>
            </article>
        <?php endforeach; ?>
    </div>

    <h6> &copy; <?= date("Y/m/d - H:i:s") ?></h6>
</body>

</html>