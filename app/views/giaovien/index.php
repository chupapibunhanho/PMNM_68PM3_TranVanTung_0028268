<?php $giaoviens = $data['giaoviens'] ?? []; ?>
<?php $currentPage = $data['currentPage'] ?? 1; ?>
<?php $totalPages = $data['totalPages'] ?? 1; ?>
<?php $filters = $data['filters'] ?? ['mgv' => '', 'hoten' => '']; ?>
<?php $data['title'] = 'Danh sach giao vien'; ?>

<style>
    .dashboard-shell {
        display: grid;
        grid-template-columns: 132px minmax(0, 1fr);
        gap: 20px;
        align-items: start;
    }

    .control-panel {
        width: 132px;
        min-height: 240px;
        padding: 10px;
        border: 1px solid #dbe3ef;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.06);
    }

    .control-panel a {
        display: block;
        width: 100%;
        padding: 11px 8px;
        margin-bottom: 8px;
        border: 1px solid transparent;
        border-radius: 6px;
        color: #475569;
        background: transparent;
        text-align: left;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        line-height: 1.25;
    }

    .control-panel a.active,
    .control-panel a:hover {
        color: #0f766e;
        border-color: #ccfbf1;
        background: #ecfdf5;
    }

    .dashboard-main {
        min-width: 0;
        padding: 24px;
        border: 1px solid #dbe3ef;
        border-radius: 8px;
        background: #fff;
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.06);
    }

    .search-form {
        max-width: none;
        display: grid;
        grid-template-columns: repeat(6, minmax(0, 1fr));
        gap: 10px;
        align-items: end;
        margin: 0 0 18px;
        padding: 14px;
        border: 1px solid #dbe3ef;
        border-radius: 8px;
        background: #f8fafc;
    }

    .search-form .form-group {
        margin-bottom: 0;
    }

    .search-actions {
        display: flex;
        gap: 8px;
        align-items: center;
        grid-column: span 1;
    }

    .dashboard-main > h1 {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding-bottom: 14px;
        border-bottom: 1px solid #e5eaf2;
    }

    .toolbar {
        justify-content: flex-end;
        margin: 0 0 16px;
    }

    @media (max-width: 640px) {
        .dashboard-shell {
            grid-template-columns: 1fr;
        }

        .control-panel {
            width: 100%;
            min-height: 0;
            display: flex;
            gap: 8px;
        }

        .control-panel a {
            margin-bottom: 0;
            text-align: center;
        }

        .search-form {
            grid-template-columns: 1fr;
        }

        .dashboard-main {
            padding: 16px;
        }
    }
</style>

<div class="dashboard-shell">
    <aside class="control-panel">
        <a href="../sinhvien/index">Sinh vien</a>
        <a href="../lophoc/index">Lop hoc</a>
        <a class="active" href="../giaovien/index">Giao vien</a>
    </aside>

    <section class="dashboard-main">
        <h1>Danh sach giao vien</h1>

<?php if (!empty($data['dbError'])): ?>
    <div class="notice"><?php echo htmlspecialchars($data['dbError']); ?></div>
<?php endif; ?>
<?php if (!empty($_GET['error'])): ?>
    <?php
        $errorMessages = [
            'create_giaovien' => 'Khong the them giao vien. Vui long kiem tra lai ma.',
            'update_giaovien' => 'Khong the cap nhat giao vien. Vui long kiem tra lai du lieu.',
            'delete_giaovien' => 'Khong the xoa giao vien.',
        ];
    ?>
    <?php if (isset($errorMessages[$_GET['error']])): ?>
        <div class="error"><?php echo htmlspecialchars($errorMessages[$_GET['error']]); ?></div>
    <?php endif; ?>
<?php endif; ?>

    <form class="search-form" action="../giaovien/index" method="get">
        <div class="form-group">
            <label for="search-mgv">Ma giang vien</label>
            <input
                type="text"
                id="search-mgv"
                name="mgv"
                value="<?php echo htmlspecialchars($filters['mgv'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="search-hoten">Ho ten</label>
            <input
                type="text"
                id="search-hoten"
                name="hoten"
                value="<?php echo htmlspecialchars($filters['hoten'] ?? ''); ?>">
        </div>
        <div class="search-actions">
            <button type="submit">Tim</button>
            <a class="button secondary" href="../giaovien/index">Xoa loc</a>
        </div>
    </form>

    <div class="toolbar">
        <a class="button" href="../giaovien/create">Them moi</a>
    </div>

    <?php if (!empty($giaoviens)): ?>
        <table>
            <thead>
                <tr>
                    <th>Ma GV</th>
                    <th>Ho ten</th>
                    <th>Ngay sinh</th>
                    <th>Thao tac</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($giaoviens as $gv): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($gv['mgv']); ?></td>
                        <td><?php echo htmlspecialchars($gv['hoten']); ?></td>
                        <td><?php echo htmlspecialchars($gv['ngaysinh']); ?></td>
                        <td class="action-cell">
                            <button
                                class="button secondary edit-giaovien-button"
                                type="button"
                                data-giaovien="<?php echo htmlspecialchars(json_encode($gv), ENT_QUOTES, 'UTF-8'); ?>">
                                Sua
                            </button>
                            <form class="delete-form" action="../giaovien/delete" method="post" onsubmit="return confirm('Ban co chac muon xoa giao vien nay?');">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($gv['mgv']); ?>">
                                <input type="hidden" name="page" value="<?php echo htmlspecialchars($currentPage); ?>">
                                <input type="hidden" name="search_mgv" value="<?php echo htmlspecialchars($filters['mgv'] ?? ''); ?>">
                                <input type="hidden" name="search_hoten" value="<?php echo htmlspecialchars($filters['hoten'] ?? ''); ?>">
                                <button class="button danger" type="submit">Xoa</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if ($totalPages > 1): ?>
            <?php
                $gvQuery = array_filter([
                    'mgv' => $filters['mgv'] ?? '',
                    'hoten' => $filters['hoten'] ?? '',
                ], function ($value) {
                    return $value !== '';
                });
            ?>
            <div class="pagination">
                <?php if ($currentPage > 1): ?>
                    <?php $gvQuery['page'] = $currentPage - 1; ?>
                    <a href="../giaovien/index?<?php echo htmlspecialchars(http_build_query($gvQuery)); ?>">Truoc</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <?php $gvQuery['page'] = $i; ?>
                    <a class="<?php echo $i === $currentPage ? 'active' : ''; ?>" href="../giaovien/index?<?php echo htmlspecialchars(http_build_query($gvQuery)); ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <?php $gvQuery['page'] = $currentPage + 1; ?>
                    <a href="../giaovien/index?<?php echo htmlspecialchars(http_build_query($gvQuery)); ?>">Sau</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <p>Chua co du lieu giao vien.</p>
    <?php endif; ?>

    <div class="modal-backdrop" id="editGiaoVienModal">
        <div class="modal-box">
            <div class="modal-header">
                <h2>Chinh sua giao vien</h2>
                <button class="modal-close" type="button" id="closeEditGiaoVienModal">x</button>
            </div>

            <form action="../giaovien/update" method="post">
                <input type="hidden" name="id" id="edit-giaovien-id">
                <input type="hidden" name="page" value="<?php echo htmlspecialchars($currentPage); ?>">
                <input type="hidden" name="search_mgv" value="<?php echo htmlspecialchars($filters['mgv'] ?? ''); ?>">
                <input type="hidden" name="search_hoten" value="<?php echo htmlspecialchars($filters['hoten'] ?? ''); ?>">
                <div class="form-group">
                    <label for="edit-giaovien-mgv">Ma GV</label>
                    <input type="text" id="edit-giaovien-mgv" data-giaovien-field="mgv" readonly>
                </div>
                <div class="form-group">
                    <label for="edit-giaovien-hoten">Ho ten</label>
                    <input type="text" id="edit-giaovien-hoten" name="hoten" data-giaovien-field="hoten" required>
                </div>
                <div class="form-group">
                    <label for="edit-giaovien-ngaysinh">Ngay sinh</label>
                    <input type="date" id="edit-giaovien-ngaysinh" name="ngaysinh" data-giaovien-field="ngaysinh">
                </div>

                <div class="actions">
                    <button type="submit">Luu</button>
                    <button class="button secondary" type="button" id="cancelEditGiaoVienModal">Huy</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function () {
            var editModal = document.getElementById('editGiaoVienModal');
            var closeEditButton = document.getElementById('closeEditGiaoVienModal');
            var cancelEditButton = document.getElementById('cancelEditGiaoVienModal');
            var editId = document.getElementById('edit-giaovien-id');

            function closeEditModal() {
                editModal.classList.remove('show');
            }

            closeEditButton.addEventListener('click', closeEditModal);
            cancelEditButton.addEventListener('click', closeEditModal);

            document.querySelectorAll('.edit-giaovien-button').forEach(function (button) {
                button.addEventListener('click', function () {
                    var gv = JSON.parse(button.getAttribute('data-giaovien'));
                    editId.value = gv.mgv || '';

                    editModal.querySelectorAll('[data-giaovien-field]').forEach(function (input) {
                        var field = input.getAttribute('data-giaovien-field');
                        input.value = gv[field] || '';
                    });

                    editModal.classList.add('show');
                });
            });

            editModal.addEventListener('click', function (event) {
                if (event.target === editModal) {
                    closeEditModal();
                }
            });
        })();
    </script>
    </section>
</div>
