<?php
session_start();
require_once '../includes/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: anggota.php");
    exit();
}

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM anggota WHERE id_anggota = '$id'");
$data = mysqli_fetch_array($query);

if (!$data) {
    header("Location: anggota.php");
    exit();
}

$qrData = $data['id_anggota'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Cetak Kartu Anggota</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
/* Variabel warna */
:root {
    --primary: #2c3e50;    /* Warna utama - biru tua */
    --secondary: #3498db;   /* Warna sekunder - biru muda */
    --accent: #e74c3c;     /* Warna aksen - merah */
    --light: #ecf0f1;      /* Warna terang - abu-abu muda */
}

/* Reset CSS dasar */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Pengaturan halaman utama */
body {
    background: #f5f5f5;
    font-family: 'Poppins', sans-serif;
}

/* Pengaturan ukuran halaman A4 */
.page {
    width: 210mm;
    min-height: 297mm;
    padding: 20mm;
    margin: 0 auto;
    background: white;
}

/* Container kartu */
.card-container {
    width: 85.6mm;
    height: 53.98mm;
    margin: 10px;
    position: relative;
}

/* Desain dasar kartu */
.card {
    width: 100%;
    height: 100%;
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 3px 15px rgba(0,0,0,0.1);
    border: 1px solid var(--light);
}

/* Bagian depan kartu */
.card-front {
    background: linear-gradient(135deg, #ffffff 0%, var(--light) 100%);
    padding: 15px;
}

/* Bagian belakang kartu */
.card-back {
    background: linear-gradient(135deg, var(--primary) 0%, #34495e 100%);
    padding: 15px;
    color: white;
}

/* Header kartu */
.header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 15px;
    position: relative;
}

/* Garis bawah header */
.header::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, var(--secondary), transparent);
}

/* Logo sekolah */
.logo {
    width: 45px;
    height: 45px;
    margin-left: 5px;
}

/* Nama sekolah */
.school-name {
    font-size: 14px;
    font-weight: 600;
    color: var(--primary);
    line-height: 1.2;
    text-align: center;
    flex-grow: 1;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Informasi anggota */
.member-info {
    padding: 10px 0;
    width: 65%;
    float: left;
    position: relative;
}

/* Tabel informasi */
.info-table {
    width: 100%;
    font-size: 12px;
}

.info-table td {
    padding: 4px 0;
    color: var(--primary);
}

/* Kolom label tabel */
.info-table td:first-child {
    font-weight: 500;
    width: 85px;
    position: relative;
    padding-left: 12px;
}

/* Titik pada label tabel */
.info-table td:first-child::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 4px;
    background: var(--secondary);
    border-radius: 50%;
}

/* Bagian QR Code */
.qr-section {
    position: absolute;
    top: 65%;
    right: 15px;
    transform: translateY(-50%);
}

.qr-code {
    width: 75px;
    height: 75px;
}

/* Judul peraturan */
.rules-title {
    text-align: center;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 15px;
    color: white;
    position: relative;
    padding-bottom: 8px;
}

/* Garis bawah judul peraturan */
.rules-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 40px;
    height: 2px;
    background: var(--secondary);
}

/* Daftar peraturan */
.rules-list {
    list-style: none;
    padding-left: 25px;
    width: 65%;
}

.rules-list li {
    font-size: 8px;
    margin-bottom: 3px;
    padding-left: 12px;
    position: relative;
    line-height: 1.1;
    color: white;
}

.rules-list li:before {
    content: '•';
    position: absolute;
    left: 0;
    color: var(--secondary);
}

/* Bagian tanda tangan */
.signature-section {
    position: absolute;
    bottom: 25px;
    right: 15px;
    text-align: center;
}

.signature-img {
    width: 95px;
    height: auto;
    margin-bottom: -20px;
    filter: brightness(0) invert(1);
}

.signature-title {
    font-size: 9px;
    color: white;
    font-weight: 500;
}

/* Credit website */
.website-credit {
    position: absolute;
    bottom: 8px;
    left: 0;
    right: 0;
    text-align: center;
    font-size: 7px;
    font-weight: 500;
}

.card-front .website-credit {
    color: var(--primary);
}

.card-back .website-credit {
    color: rgba(255,255,255,0.7);
}

/* Pengaturan cetak */
@media print {
    @page {
        size: A4;
        margin: 20mm;
    }
    
    body {
        background: none;
    }
    
    .page {
        padding: 0;
        margin: 0;
        background: none;
    }
    
    .card-container {
        page-break-inside: avoid;
    }
}
</style>
</head>
<body>
    <div class="page">
        <!-- Front Card -->
        <div class="card-container">
            <div class="card card-front">
                <div class="header">
                    <img src="../assets/img/icon/logo.png" class="logo">
                    <div class="school-name">
                        PERPUSTAKAAN<br>
                        SMA NEGERI 1 CONTOH
                    </div>
                </div>

                <div class="member-info">
                    <table class="info-table">
                        <tr>
                            <td>ID Anggota</td>
                            <td>: <?= htmlspecialchars($data['id_anggota']) ?></td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>: <?= htmlspecialchars($data['nama']) ?></td>
                        </tr>
                        <tr>
                            <td>Kelas</td>
                            <td>: <?= htmlspecialchars($data['kelas']) ?></td>
                        </tr>
                    </table>
                </div>

                <div class="qr-section">
                    <img class="qr-code" src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= urlencode($qrData) ?>&format=png&margin=0">
                </div>

                <div class="website-credit">
                    www.persegi.com | Sistem Perpustakaan Sekolah Digital
                </div>
            </div>
        </div>

        <!-- Back Card -->
        <div class="card-container">
            <div class="card card-back">
                <div class="rules-title">PERATURAN PEMINJAMAN</div>
                <ul class="rules-list">
                    <li>Maksimal peminjaman 2 buku dalam waktu bersamaan</li>
                    <li>Durasi peminjaman maksimal 7 hari</li>
                    <li>Denda keterlambatan Rp1.000/hari/buku</li>
                    <li>Mengganti buku yang hilang/rusak</li>
                    <li>Kartu tidak dapat dipindahtangankan</li>
                    <li>Kartu berlaku selama menjadi siswa aktif</li>
                </ul>

                <div class="signature-section">
                    <img src="../assets/img/icon/ttd.png" class="signature-img">
                    <div class="signature-title">Kepala Perpustakaan</div>
                </div>

                <div class="website-credit">
                    www.persegi.com | Sistem Perpustakaan Digital
                </div>
            </div>
        </div>
    </div>
</body>
</html>