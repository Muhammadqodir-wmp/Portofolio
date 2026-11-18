<nav class="bg-white border-b border-gray-200">
    <div class="max-w-4xl mx-auto p-4 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="#" class="text-sm font-medium text-gray-600 hover:text-blue-600">Havola 1</a>

        </div>
        <p class="text-xl font-bold  text-blue-600">M Portofolio</p>
        <?php if (isset($_SESSION['user_id'])): ?>
            <form action="index.php">
                <input type="hidden" name="chiqish">
                <button type="submit">Chiqish</button>
            </form>
        <?php else: ?>
            <a href="login.php">Kirish</a>

        <?php endif; ?>
    </div>

</nav>