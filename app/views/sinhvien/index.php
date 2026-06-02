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
<?php else: ?>
    <p>Chua co du lieu sinh vien.</p>
<?php endif; ?>
