<?php $data['title'] = 'Danh sach sinh vien'; ?>
<?php $danhSachSinhVien = $data['danhSachSinhVien'] ?? $danhSachSinhVien ?? []; ?>

<h1>Danh sach sinh vien</h1>

<div class="toolbar">
    <a class="button secondary" href="/auth/logout">Dang xuat</a>
</div>

<?php if (!empty($danhSachSinhVien)): ?>
    <table>
        <thead>
            <tr>
                <?php foreach (array_keys($danhSachSinhVien[0]) as $column): ?>
                    <th><?php echo htmlspecialchars(ucfirst($column)); ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($danhSachSinhVien as $sinhVien): ?>
                <tr>
                    <?php foreach ($sinhVien as $value): ?>
                        <td><?php echo htmlspecialchars($value); ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Khong co du lieu sinh vien.</p>
<?php endif; ?>
