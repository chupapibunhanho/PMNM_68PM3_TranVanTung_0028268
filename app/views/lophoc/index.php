<?php $lophocs = $data['lophocs'] ?? []; ?>
<?php $currentPage = $data['currentPage'] ?? 1; ?>
<?php $totalPages = $data['totalPages'] ?? 1; ?>
<?php $filters = $data['filters'] ?? ['malop' => '']; ?>
<?php $data['title'] = 'Danh sach lop hoc'; ?>

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
        <a class="active" href="../lophoc/index">Lop hoc</a>
    </aside>

    <section class="dashboard-main">
        <h1>Danh sach lop hoc</h1>

<?php if (!empty($data['dbError'])): ?>
    <div class="notice"><?php echo htmlspecialchars($data['dbError']); ?></div>
<?php endif; ?>
<?php if (!empty($_GET['error'])): ?>
    <?php
        $errorMessages = [
            'create_lophoc' => 'Khong the them lop hoc. Vui long kiem tra lai ma lop.',
            'update_lophoc' => 'Khong the cap nhat lop hoc. Vui long kiem tra lai du lieu.',
            'delete_lophoc' => 'Khong the xoa lop hoc. Lop nay co the dang co sinh vien.',
        ];
    ?>
    <?php if (isset($errorMessages[$_GET['error']])): ?>
        <div class="error"><?php echo htmlspecialchars($errorMessages[$_GET['error']]); ?></div>
    <?php endif; ?>
<?php endif; ?>

    <form class="search-form" action="../lophoc/index" method="get">
        <div class="form-group">
            <label for="search-lophoc-malop">Ma lop</label>
            <input
                type="text"
                id="search-lophoc-malop"
                name="malop"
                value="<?php echo htmlspecialchars($filters['malop'] ?? ''); ?>">
        </div>
        <div class="search-actions">
            <button type="submit">Tim</button>
            <a class="button secondary" href="../lophoc/index">Xoa loc</a>
        </div>
    </form>

    <div class="toolbar">
        <a class="button" href="../lophoc/create">Them moi</a>
    </div>

    <?php if (!empty($lophocs)): ?>
        <table>
            <thead>
                <tr>
                    <th>Ma lop</th>
                    <th>Ten lop</th>
                    <th>Nam hoc</th>
                    <th>Thao tac</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lophocs as $lopHoc): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($lopHoc['malop']); ?></td>
                        <td>
                            <a href="../sinhvien/index?lop=<?php echo urlencode($lopHoc['malop']); ?>">
                                <?php echo htmlspecialchars($lopHoc['tenlop']); ?>
                            </a>
                        </td>
                        <td><?php echo htmlspecialchars($lopHoc['namhoc']); ?></td>
                        <td class="action-cell">
                            <button
                                class="button secondary edit-lophoc-button"
                                type="button"
                                data-lophoc="<?php echo htmlspecialchars(json_encode($lopHoc), ENT_QUOTES, 'UTF-8'); ?>">
                                Sua
                            </button>
                            <form class="delete-form" action="../lophoc/delete" method="post" onsubmit="return confirm('Ban co chac muon xoa lop hoc nay?');">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($lopHoc['malop']); ?>">
                                <input type="hidden" name="page" value="<?php echo htmlspecialchars($currentPage); ?>">
                                <input type="hidden" name="search_malop" value="<?php echo htmlspecialchars($filters['malop'] ?? ''); ?>">
                                <button class="button danger" type="submit">Xoa</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if ($totalPages > 1): ?>
            <?php
                $lopHocQuery = array_filter([
                    'malop' => $filters['malop'] ?? '',
                ], function ($value) {
                    return $value !== '';
                });
            ?>
            <div class="pagination">
                <?php if ($currentPage > 1): ?>
                    <?php $lopHocQuery['page'] = $currentPage - 1; ?>
                    <a href="../lophoc/index?<?php echo htmlspecialchars(http_build_query($lopHocQuery)); ?>">Truoc</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <?php $lopHocQuery['page'] = $i; ?>
                    <a class="<?php echo $i === $currentPage ? 'active' : ''; ?>" href="../lophoc/index?<?php echo htmlspecialchars(http_build_query($lopHocQuery)); ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <?php $lopHocQuery['page'] = $currentPage + 1; ?>
                    <a href="../lophoc/index?<?php echo htmlspecialchars(http_build_query($lopHocQuery)); ?>">Sau</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <p>Chua co du lieu lop hoc.</p>
    <?php endif; ?>



    <div class="modal-backdrop" id="editLopHocModal">
        <div class="modal-box">
            <div class="modal-header">
                <h2>Chinh sua lop hoc</h2>
                <button class="modal-close" type="button" id="closeEditLopHocModal">x</button>
            </div>

            <form action="../lophoc/update" method="post">
                <input type="hidden" name="id" id="edit-lophoc-id">
                <input type="hidden" name="page" value="<?php echo htmlspecialchars($currentPage); ?>">
                <input type="hidden" name="search_malop" value="<?php echo htmlspecialchars($filters['malop'] ?? ''); ?>">
                <div class="form-group">
                    <label for="edit-lophoc-malop">Ma lop</label>
                    <input type="text" id="edit-lophoc-malop" data-lophoc-field="malop" readonly>
                </div>
                <div class="form-group">
                    <label for="edit-lophoc-tenlop">Ten lop</label>
                    <input type="text" id="edit-lophoc-tenlop" name="tenlop" data-lophoc-field="tenlop" required>
                </div>
                <div class="form-group">
                    <label for="edit-lophoc-namhoc">Nam hoc</label>
                    <input type="text" id="edit-lophoc-namhoc" name="namhoc" data-lophoc-field="namhoc">
                </div>

                <div class="actions">
                    <button type="submit">Luu</button>
                    <button class="button secondary" type="button" id="cancelEditLopHocModal">Huy</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function () {
            var editModal = document.getElementById('editLopHocModal');
            var closeEditButton = document.getElementById('closeEditLopHocModal');
            var cancelEditButton = document.getElementById('cancelEditLopHocModal');
            var editId = document.getElementById('edit-lophoc-id');

            function closeEditModal() {
                editModal.classList.remove('show');
            }

            closeEditButton.addEventListener('click', closeEditModal);
            cancelEditButton.addEventListener('click', closeEditModal);

            document.querySelectorAll('.edit-lophoc-button').forEach(function (button) {
                button.addEventListener('click', function () {
                    var lopHoc = JSON.parse(button.getAttribute('data-lophoc'));
                    editId.value = lopHoc.malop || '';

                    editModal.querySelectorAll('[data-lophoc-field]').forEach(function (input) {
                        var field = input.getAttribute('data-lophoc-field');
                        input.value = lopHoc[field] || '';
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
