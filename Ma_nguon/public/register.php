<?php
require __DIR__ . '/../src/Input.php';
$events = require __DIR__ . '/../data/events.php';
$result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = validateRegistration($_POST, $events);
}
require __DIR__ . '/../templates/header.php';
?>
<h2>Nhận dữ liệu form</h2>
<form method="post">
    <label>Sự kiện
        <select name="event_id">
            <?php foreach ($events as $event): ?>
                <option value="<?= $event['id'] ?>">
                    <?= e($event['title']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <label>Họ tên
        <input name="name" maxlength="120"
               value="<?= e(field($_POST, 'name')) ?>">
    </label><br>
    <label>Email
        <input name="email"
               value="<?= e(field($_POST, 'email')) ?>">
    </label><br>
    <button>Kiểm tra</button>
</form>
<?php if ($result !== null): ?>
    <?php if ($result['errors']): ?>
        <p><?= e(implode(', ', $result['errors'])) ?></p>
    <?php else: ?>
        <p>PREVIEW_OK: <?= e($result['data']['name']) ?>
            — <?= e($result['data']['email']) ?></p>
        <p>Chỉ xem trước; chưa lưu Session hoặc CSDL.</p>
    <?php endif; ?>
<?php endif; ?>
<?php require __DIR__ . '/../templates/footer.php'; ?>
