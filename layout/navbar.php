<nav class="bg-white border-b border-gray-200">
    <div class="max-w-4xl mx-auto p-4 flex items-center justify-between">
        <div class="flex items-center gap-4">

            <a href="index.php">
                <p class="text-xl font-bold  text-blue-600 hover:text-blue-700">M Portofolio</p>
            </a>

        </div>
        <div class="flex items-center gap-4">
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="project_create.php" class="btn-primary"> Loyiha yaratish</a>
                <form action="index.php">
                    <input type="hidden" name="chiqish">
                    <button type="submit" class="btn-danger">Chiqish</button>
                </form>
            <?php else: ?>
                <a href="login.php" class="btn-primary">Kirish</a>

            <?php endif; ?>
        </div>

    </div>

</nav>