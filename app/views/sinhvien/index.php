<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sach sinh vien</title>
</head>
<body>
    <h1>Danh sach sinh vien</h1>

    <?php if (!empty($data['sinhviens'])): ?>
        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <?php foreach (array_keys($data['sinhviens'][0]) as $column): ?>
                        <th><?php echo htmlspecialchars($column); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['sinhviens'] as $sinhvien): ?>
                    <tr>
                        <?php foreach ($sinhvien as $value): ?>
                            <td><?php echo htmlspecialchars((string) $value); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Chua co du lieu sinh vien.</p>
    <?php endif; ?>
</body>
</html>
