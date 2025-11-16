<?php
require_once __DIR__ . '/../db.php';
include __DIR__ . '/../header.php';

$hotlines = [];
if (isset($pdo) && $pdo) {
    $hotlines = $pdo->query('SELECT * FROM hotlines ORDER BY sort_order, created_at DESC')->fetchAll();
}
?>
<div class="max-w-6xl mx-auto p-8">
    <h1 class="text-2xl font-bold mb-4">Admin: Hotlines</h1>
    <p class="mb-4 text-sm text-yellow-300">Warning: This admin page is not protected. Add authentication before exposing.</p>

    <h2 class="text-lg font-semibold mt-6">Create New Hotline</h2>
    <form method="POST" action="save_hotline.php" class="space-y-4 mt-2">
        <input name="name" placeholder="Agency name" class="w-full p-2 bg-gray-800 text-white" />
        <input name="phone" placeholder="Phone number" class="w-full p-2 bg-gray-800 text-white" />
        <input name="category" placeholder="Category (Police, Fire...)" class="w-full p-2 bg-gray-800 text-white" />
        <input name="icon" placeholder="FontAwesome class (e.g., fa-phone)" class="w-full p-2 bg-gray-800 text-white" />
        <label><input type="checkbox" name="is_active" value="1" checked /> Active</label>
        <button class="btn-gradient px-4 py-2 rounded">Save Hotline</button>
    </form>

    <h2 class="text-lg font-semibold mt-8">Existing Hotlines</h2>
    <table class="w-full mt-4 bg-gray-800 text-left rounded">
        <thead>
            <tr><th class="p-2">ID</th><th>Name</th><th>Phone</th><th>Category</th><th>Active</th></tr>
        </thead>
        <tbody>
            <?php foreach ($hotlines as $h): ?>
                <tr>
                    <td class="p-2"><?php echo htmlspecialchars($h['id']); ?></td>
                    <td class="p-2"><?php echo htmlspecialchars($h['name']); ?></td>
                    <td class="p-2"><?php echo htmlspecialchars($h['phone']); ?></td>
                    <td class="p-2"><?php echo htmlspecialchars($h['category']); ?></td>
                    <td class="p-2"><?php echo $h['is_active'] ? 'Yes' : 'No'; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
