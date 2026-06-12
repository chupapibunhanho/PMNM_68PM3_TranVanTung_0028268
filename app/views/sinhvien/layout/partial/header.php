<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($data['title'] ?? 'Quan ly sinh vien'); ?></title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            color: #222;
            background: #f5f7fb;
        }

        .topbar {
            width: 100%;
            height: 56px;
            background: #f58220;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 24px;
        }

        .logout-button {
            padding: 8px 14px;
            border: 1px solid #fff;
            border-radius: 4px;
            background: #fff;
            color: #c45e00;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .logout-button:hover {
            background: #fff4e8;
        }

        .page-content {
            width: min(1100px, calc(100% - 32px));
            margin: 28px auto;
        }

        h1 {
            margin: 0 0 18px;
            text-align: center;
        }

        .toolbar,
        .actions {
            display: flex;
            gap: 10px;
            justify-content: center;
            align-items: center;
            margin: 18px 0;
        }

        .button,
        button {
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

        .button.danger {
            border-color: #dc3545;
            background: #dc3545;
        }

        .button.danger:hover {
            background: #bb2d3b;
        }

        .action-cell {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .notice,
        .error {
            max-width: 720px;
            padding: 10px 12px;
            margin: 0 auto 16px;
            border: 1px solid #ffc107;
            background: #fff3cd;
            color: #664d03;
        }

        .error {
            border-color: #dc3545;
            background: #f8d7da;
            color: #842029;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
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

        .pagination {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: center;
            margin: 18px 0;
        }

        .pagination a {
            min-width: 34px;
            padding: 8px 11px;
            border: 1px solid #198754;
            border-radius: 4px;
            color: #198754;
            background: #fff;
            text-align: center;
            text-decoration: none;
            font-size: 14px;
        }

        .pagination a.active,
        .pagination a:hover {
            color: #fff;
            background: #198754;
        }

        form {
            max-width: 520px;
            margin: 0 auto;
        }

        .delete-form {
            max-width: none;
            margin: 0;
        }

        .modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 20;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: rgba(0, 0, 0, 0.45);
        }

        .modal-backdrop.show {
            display: flex;
        }

        .modal-box {
            width: min(560px, 100%);
            max-height: calc(100vh - 48px);
            overflow: auto;
            padding: 18px;
            border-radius: 6px;
            background: #fff;
            box-shadow: 0 18px 45px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 20px;
        }

        .modal-close {
            width: 34px;
            height: 34px;
            padding: 0;
            border-color: #777;
            background: #777;
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
            padding: 9px 10px;
            border: 1px solid #bbb;
            border-radius: 4px;
        }

        input[readonly] {
            color: #222;
            background: #fff;
            cursor: not-allowed;
        }

        p {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="topbar">
        <?php if (!empty($_SESSION['username'])): ?>
            <a class="logout-button" href="../auth/logout">Dang xuat</a>
        <?php endif; ?>
    </div>
    <main class="page-content">
