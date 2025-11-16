<?php
// Simple admin UI for guides (UNPROTECTED) - secure this before use
require_once __DIR__ . '/../db.php';
include __DIR__ . '/../header.php';

// Fetch guides
$guides = [];
if (isset($pdo) && $pdo) {
    $guides = $pdo->query('SELECT * FROM guides ORDER BY sort_order, created_at DESC')->fetchAll();
}
?>
<div class="max-w-6xl mx-auto p-8">
    <h1 class="text-2xl font-bold mb-4">Admin: Guides</h1>

    <p class="mb-4 text-sm text-yellow-300">Warning: This admin page is not protected. Add authentication before exposing.</p>

    <h2 class="text-lg font-semibold mt-6">Create New Guide</h2>
    <form method="POST" action="save_guide.php" class="space-y-4 mt-2">
        <input name="title" placeholder="Title" class="w-full p-2 bg-gray-800 text-white" />
        <input name="slug" placeholder="slug (url-friendly)" class="w-full p-2 bg-gray-800 text-white" />
        <textarea name="content" rows="6" placeholder="Full content HTML or markdown" class="w-full p-2 bg-gray-800 text-white"></textarea>
        <label><input type="checkbox" name="is_published" value="1" checked /> Published</label>
        <button class="btn-gradient px-4 py-2 rounded">Save Guide</button>
    </form>

    <h2 class="text-lg font-semibold mt-8">Existing Guides</h2>
    <table class="w-full mt-4 bg-gray-800 text-left rounded">
        <thead>
            <tr><th class="p-2">ID</th><th>Title</th><th>Published</th><th>Actions</th></tr>
        </thead>
        <tbody>
            <?php foreach ($guides as $g): ?>
                <tr>
                    <td class="p-2"><?php echo htmlspecialchars($g['id']); ?></td>
                    <td class="p-2"><?php echo htmlspecialchars($g['title']); ?></td>
                    <td class="p-2"><?php echo $g['is_published'] ? 'Yes' : 'No'; ?></td>
                    <td class="p-2"><a href="save_guide.php?id=<?php echo $g['id']; ?>">Edit</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
