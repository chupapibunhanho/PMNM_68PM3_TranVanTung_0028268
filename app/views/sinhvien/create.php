<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Them sinh vien</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 32px;
            color: #222;
        }

        form {
            max-width: 520px;
        }

        .form-group {
            margin-bottom: 14px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
        }

        input {
            width: 100%;
            box-sizing: border-box;
            padding: 9px 10px;
            border: 1px solid #bbb;
            border-radius: 4px;
        }

        .actions {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-top: 18px;
        }

        button,
        .button {
            display: inline-block;
            padding: 9px 14px;
            border: 1px solid #146c43;
            border-radius: 4px;
            background: #198754;
            color: #fff;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .button.secondary {
            border-color: #777;
            background: #777;
        }

        .error {
            max-width: 520px;
            padding: 10px 12px;
            margin-bottom: 16px;
            border: 1px solid #dc3545;
            background: #f8d7da;
            color: #842029;
        }
    </style>
</head>
<body>
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
</body>
</html>
