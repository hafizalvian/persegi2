$(document).ready(function() {
    // Initialize DataTables with specific options
    $('#dataTable').DataTable({
        "pageLength": 10,
        "order": [[4, "desc"]], // Sort by tanggal_pinjam
        "language": {
            "search": "Pencarian:",
            "lengthMenu": "Tampilkan _MENU_ data",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            "infoEmpty": "Tidak ada data yang ditampilkan",
            "infoFiltered": "(difilter dari _MAX_ total data)",
            "zeroRecords": "Tidak ada data yang cocok",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            }
        }
    });

    // Form submission with enhanced validation
    $('#formPeminjaman').on('submit', function(e) {
        e.preventDefault();
        
        // Validate required fields
        if (!$('#id_anggota').val() || !$('#kode_buku').val() || !$('input[name="tanggal_kembali"]').val()) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Semua field harus diisi!'
            });
            return false;
        }

        // Submit form via AJAX
        $.ajax({
            url: 'proses_peminjaman.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            beforeSend: function() {
                Swal.fire({
                    title: 'Memproses...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
            },
            success: function(response) {
                if(response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan sistem'
                });
            }
        });
    });
});