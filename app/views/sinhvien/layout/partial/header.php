<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($data['title'] ?? 'Quản lý sinh viên'); ?></title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: #1f2937;
            background: #eef2f7;
        }

        .topbar {
            width: 100%;
            min-height: 64px;
            background: #0f766e;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 0 32px;
            box-shadow: 0 10px 28px rgba(15, 118, 110, 0.18);
        }

        .brand {
            color: #fff;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0;
            text-decoration: none;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-name {
            color: #d1fae5;
            font-size: 14px;
            font-weight: 600;
        }

        .logout-button {
            padding: 9px 14px;
            border: 1px solid rgba(255, 255, 255, 0.72);
            border-radius: 6px;
            background: #fff;
            color: #0f766e;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
        }

        .logout-button:hover {
            background: #ecfdf5;
        }

        .page-content {
            width: min(1240px, calc(100% - 32px));
            margin: 26px auto 42px;
        }

        h1 {
            margin: 0 0 18px;
            color: #111827;
            font-size: 28px;
            line-height: 1.2;
            text-align: left;
        }

        .toolbar,
        .actions {
            display: flex;
            gap: 10px;
            justify-content: flex-start;
            align-items: center;
            margin: 18px 0;
        }

        .button,
        button {
            display: inline-block;
            min-height: 38px;
            padding: 9px 15px;
            border: 1px solid #0f766e;
            border-radius: 6px;
            background: #0f766e;
            color: #fff;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            line-height: 1.25;
            transition: background 0.15s ease, border-color 0.15s ease, color 0.15s ease;
        }

        .button:hover,
        button:hover {
            border-color: #115e59;
            background: #115e59;
        }

        .button.secondary {
            border-color: #cbd5e1;
            background: #fff;
            color: #334155;
        }

        .button.secondary:hover {
            border-color: #94a3b8;
            background: #f8fafc;
        }

        .button.danger {
            border-color: #dc2626;
            background: #dc2626;
        }

        .button.danger:hover {
            border-color: #b91c1c;
            background: #b91c1c;
        }

        .action-cell {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .notice,
        .error {
            max-width: 720px;
            padding: 12px 14px;
            margin: 0 0 16px;
            border: 1px solid #f59e0b;
            border-radius: 6px;
            background: #fffbeb;
            color: #92400e;
        }

        .error {
            border-color: #fca5a5;
            background: #fef2f2;
            color: #991b1b;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: #fff;
            border: 1px solid #dbe3ef;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.05);
        }

        th,
        td {
            padding: 12px 14px;
            border-bottom: 1px solid #e5eaf2;
            text-align: left;
            vertical-align: middle;
        }

        th {
            color: #475569;
            background: #f8fafc;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
        }

        tr:last-child td {
            border-bottom: 0;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        td a {
            color: #0f766e;
            font-weight: 600;
            text-decoration: none;
        }

        td a:hover {
            text-decoration: underline;
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
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            color: #334155;
            background: #fff;
            text-align: center;
            text-decoration: none;
            font-size: 14px;
        }

        .pagination a.active,
        .pagination a:hover {
            color: #fff;
            border-color: #0f766e;
            background: #0f766e;
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
            background: rgba(15, 23, 42, 0.52);
        }

        .modal-backdrop.show {
            display: flex;
        }

        .modal-box {
            width: min(560px, 100%);
            max-height: calc(100vh - 48px);
            overflow: auto;
            padding: 22px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 24px 70px rgba(15, 23, 42, 0.25);
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
            border-color: #cbd5e1;
            background: #fff;
            color: #334155;
        }

        .form-group {
            margin-bottom: 14px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #475569;
            font-size: 13px;
            font-weight: 600;
        }

        input,
        select {
            width: 100%;
            min-height: 40px;
            padding: 9px 11px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background: #fff;
            color: #111827;
            font-size: 14px;
        }

        input:focus,
        select:focus {
            outline: 2px solid rgba(15, 118, 110, 0.18);
            border-color: #0f766e;
        }

        input[readonly] {
            color: #222;
            background: #fff;
            cursor: not-allowed;
        }

        p {
            color: #64748b;
            text-align: left;
        }

        .page-card {
            padding: 24px;
            border: 1px solid #dbe3ef;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 14px 34px rgba(15, 23, 42, 0.06);
        }

        @media (max-width: 720px) {
            .topbar {
                padding: 14px 16px;
                align-items: flex-start;
                flex-direction: column;
            }

            .topbar-actions {
                width: 100%;
                justify-content: space-between;
            }

            .page-content {
                width: min(100% - 20px, 1240px);
                margin-top: 16px;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="topbar">
        <a class="brand" href="../sinhvien/index">Quản lý sinh viên</a>
        <div class="topbar-actions">
            <?php if (!empty($_SESSION['username'])): ?>
                <span class="user-name"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <a class="logout-button" href="../auth/logout">Dang xuat</a>
            <?php endif; ?>
        </div>
    </div>
    <main class="page-content">
