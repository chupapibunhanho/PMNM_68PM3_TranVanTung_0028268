<?php $data['title'] = 'Them giao vien'; ?>

<div class="page-card">
<h1>Them giao vien</h1>

<?php if (!empty($data['errors'])): ?>
    <?php foreach ($data['errors'] as $error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endforeach; ?>
<?php endif; ?>

<form action="../giaovien/create" method="post">
    <div class="form-group">
        <label for="create-mgv">Ma GV</label>
        <input type="text" id="create-mgv" name="mgv" required>
    </div>
    <div class="form-group">
        <label for="create-hoten">Ho ten</label>
        <input type="text" id="create-hoten" name="hoten" required>
    </div>
    <div class="form-group">
        <label for="create-ngaysinh">Ngay sinh</label>
        <input type="date" id="create-ngaysinh" name="ngaysinh">
    </div>

    <div class="actions">
        <button type="submit">Them</button>
        <a class="button secondary" href="../giaovien/index">Quay lai</a>
    </div>
</form>
</div>
