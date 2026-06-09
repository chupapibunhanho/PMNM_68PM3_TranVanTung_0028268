<?php $data['title'] = 'Danh sach sinh vien'; ?>

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

    <?php
        $currentPage = $data['currentPage'] ?? 1;
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
<?php else: ?>
    <p>Chua co du lieu sinh vien.</p>
<?php endif; ?>
