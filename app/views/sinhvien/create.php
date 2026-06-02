<?php $data['title'] = 'Them sinh vien'; ?>

<h1>Them sinh vien</h1>

<?php if (!empty($data['errors'])): ?>
    <?php foreach ($data['errors'] as $error): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endforeach; ?>
<?php endif; ?>

<form action="../sinhvien/create" method="post">
    <?php foreach (($data['columns'] ?? []) as $column): ?>
        <?php
            $field = $column['Field'];
            $type = stripos($column['Type'] ?? '', 'date') !== false ? 'date' : 'text';
            $required = (($column['Null'] ?? 'YES') === 'NO') ? 'required' : '';
            $value = $_POST[$field] ?? '';
        ?>
        <div class="form-group">
            <label for="<?php echo htmlspecialchars($field); ?>">
                <?php echo htmlspecialchars(ucfirst($field)); ?>
            </label>
            <input
                type="<?php echo $type; ?>"
                id="<?php echo htmlspecialchars($field); ?>"
                name="<?php echo htmlspecialchars($field); ?>"
                value="<?php echo htmlspecialchars($value); ?>"
                <?php echo $required; ?>
            >
        </div>
    <?php endforeach; ?>

    <div class="actions">
        <button type="submit">Them</button>
        <a class="button secondary" href="../sinhvien/index">Quay lai</a>
    </div>
</form>
