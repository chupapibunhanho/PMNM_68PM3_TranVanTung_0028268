<?php $data['title'] = 'Them lop hoc'; ?>

<div class="page-card">
<h1>Them lop hoc</h1>

<?php if (!empty($data['errors'])): ?>
    <?php foreach ($data['errors'] as $error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endforeach; ?>
<?php endif; ?>

<form action="../lophoc/create" method="post">
    <div class="form-group">
        <label for="create-malop">Ma lop</label>
        <input type="text" id="create-malop" name="malop" required>
    </div>
    <div class="form-group">
        <label for="create-tenlop">Ten lop</label>
        <input type="text" id="create-tenlop" name="tenlop" required>
    </div>
    <div class="form-group">
        <label for="create-namhoc">Nam hoc</label>
        <input type="text" id="create-namhoc" name="namhoc">
    </div>

    <div class="actions">
        <button type="submit">Them</button>
        <a class="button secondary" href="../lophoc/index">Quay lai</a>
    </div>
</form>
</div>
