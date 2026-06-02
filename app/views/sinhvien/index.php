<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sach sinh vien</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 32px;
            color: #222;
        }

        .toolbar {
            margin-bottom: 16px;
        }

        .button {
            display: inline-block;
            padding: 9px 14px;
            border: 1px solid #146c43;
            border-radius: 4px;
            background: #198754;
            color: #fff;
            text-decoration: none;
        }

        .notice {
            padding: 10px 12px;
            margin-bottom: 16px;
            border: 1px solid #ffc107;
            background: #fff3cd;
            color: #664d03;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 8px 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        th {
            background: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Danh sach sinh vien</h1>

    <div class="toolbar">
        <a class="button" href="../sinhvien/create">Them moi</a>
    </div>

    <?php $sinhviens = $data['sinhviens'] ?? []; ?>
    <?php if (!empty($data['dbError'])): ?>
        <div class="notice"><?php echo htmlspecialchars($data['dbError']); ?></div>
    <?php endif; ?>

    <?php if (!empty($sinhviens)): ?>
        <table>
            <thead>
                <tr>
                    <?php foreach (array_keys($sinhviens[0]) as $column): ?>
                        <th><?php echo htmlspecialchars(ucfirst($column)); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($sinhviens as $sinhvien): ?>
                    <tr>
                        <?php foreach ($sinhvien as $value): ?>
                            <td><?php echo htmlspecialchars($value); ?></td>
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
