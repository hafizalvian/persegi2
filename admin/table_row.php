<tr>
    <td><?php echo $no++; ?></td>
    <td><?php echo $data['id']; ?></td>
    <td><?php echo $data['nama']; ?></td>
    <td><?php echo $data['nis']; ?></td>
    <td><?php echo $data['no_hp']; ?></td>
    <td><?php echo $data['alamat']; ?></td>
    <td>
        <div class="action-buttons">
            <a href="edit_anggota.php?id=<?php echo $data['id']; ?>" class="btn btn-action btn-edit" title="Edit">
                <i class="fas fa-edit"></i>
            </a>
            <a href="cetak_kartu.php?id=<?php echo $data['id']; ?>" class="btn btn-action btn-print" title="Cetak Kartu" target="_blank">
                <i class="fas fa-print"></i>
            </a>
            <a href="anggota.php?delete=<?php echo $data['id']; ?>" class="btn btn-action btn-delete" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ini?')">
                <i class="fas fa-trash"></i>
            </a>
        </div>
    </td>
</tr>