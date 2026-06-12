<?php $data['title'] = 'Danh sach sinh vien'; ?>

<h1>Danh sach sinh vien</h1>

<div class="toolbar">
    <a class="button" href="../sinhvien/create">Them moi</a>
</div>

<?php $sinhviens = $data['sinhviens'] ?? []; ?>
<?php $primaryKey = $data['primaryKey'] ?? ''; ?>
<?php $currentPage = $data['currentPage'] ?? 1; ?>
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
                <th>Thao tac</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sinhviens as $sinhvien): ?>
                <tr>
                    <?php foreach ($sinhvien as $value): ?>
                        <td><?php echo htmlspecialchars($value); ?></td>
                    <?php endforeach; ?>
                    <td class="action-cell">
                        <?php if ($primaryKey !== '' && isset($sinhvien[$primaryKey])): ?>
                            <button
                                class="button secondary edit-button"
                                type="button"
                                data-sinhvien="<?php echo htmlspecialchars(json_encode($sinhvien), ENT_QUOTES, 'UTF-8'); ?>">
                                Sua
                            </button>
                            <form class="delete-form" action="?url=sinhvien/delete" method="post" onsubmit="return confirm('Ban co chac muon xoa sinh vien nay?');">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($sinhvien[$primaryKey]); ?>">
                                <input type="hidden" name="page" value="<?php echo htmlspecialchars($currentPage); ?>">
                                <button class="button danger" type="submit">Xoa</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php
        $totalPages = $data['totalPages'] ?? 1;
    ?>
    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php if ($currentPage > 1): ?>
                <a href="?url=sinhvien/index&page=<?php echo $currentPage - 1; ?>">Truoc</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a class="<?php echo $i === $currentPage ? 'active' : ''; ?>" href="?url=sinhvien/index&page=<?php echo $i; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
                <a href="?url=sinhvien/index&page=<?php echo $currentPage + 1; ?>">Sau</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="modal-backdrop" id="editModal">
        <div class="modal-box">
            <div class="modal-header">
                <h2>Chinh sua sinh vien</h2>
                <button class="modal-close" type="button" id="closeEditModal">x</button>
            </div>

            <form action="?url=sinhvien/update" method="post">
                <input type="hidden" name="id" id="edit-id">
                <input type="hidden" name="page" value="<?php echo htmlspecialchars($currentPage); ?>">

                <?php foreach (array_keys($sinhviens[0]) as $column): ?>
                    <?php $isLocked = $column === $primaryKey || strtolower($column) === 'msv'; ?>
                    <div class="form-group">
                        <label for="edit-<?php echo htmlspecialchars($column); ?>"><?php echo htmlspecialchars(ucfirst($column)); ?></label>
                        <input
                            type="text"
                            id="edit-<?php echo htmlspecialchars($column); ?>"
                            name="<?php echo htmlspecialchars($column); ?>"
                            data-field="<?php echo htmlspecialchars($column); ?>"
                            <?php echo $isLocked ? 'readonly' : ''; ?>>
                    </div>
                <?php endforeach; ?>

                <div class="actions">
                    <button type="submit">Luu</button>
                    <button class="button secondary" type="button" id="cancelEditModal">Huy</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function () {
            var modal = document.getElementById('editModal');
            var editId = document.getElementById('edit-id');
            var closeButton = document.getElementById('closeEditModal');
            var cancelButton = document.getElementById('cancelEditModal');
            var primaryKey = <?php echo json_encode($primaryKey); ?>;

            function closeModal() {
                modal.classList.remove('show');
            }

            document.querySelectorAll('.edit-button').forEach(function (button) {
                button.addEventListener('click', function () {
                    var sinhvien = JSON.parse(button.getAttribute('data-sinhvien'));

                    editId.value = sinhvien[primaryKey] || '';

                    modal.querySelectorAll('[data-field]').forEach(function (input) {
                        var field = input.getAttribute('data-field');
                        input.value = sinhvien[field] || '';
                    });

                    modal.classList.add('show');
                });
            });

            closeButton.addEventListener('click', closeModal);
            cancelButton.addEventListener('click', closeModal);

            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    closeModal();
                }
            });
        })();
    </script>
<?php else: ?>
    <p>Chua co du lieu sinh vien.</p>
<?php endif; ?>
