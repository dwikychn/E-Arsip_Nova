<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Database\Exceptions\DatabaseException; 
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use FilesystemIterator;

class Backupdb extends Controller
{
    public function index()
    {
        // Memuat helper filesystem untuk fungsi write_file() dan lainnya
        helper('filesystem');

        // --- 1. KONEKSI KE DATABASE (Menangani error koneksi CI4) ---
        try {
            $db = \Config\Database::connect();
        } catch (DatabaseException $e) {
            log_message('error', 'Gagal koneksi database: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Tidak dapat terhubung ke database. Cek konfigurasi database Anda.');
        } catch (\Throwable $e) {
            log_message('error', 'Error saat koneksi database: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan umum saat mencoba koneksi database.');
        }

        // --- 2. BACKUP DATABASE MANUAL ---
        
        // **PERBAIKAN FOREIGN KEY (#1005):**
        // Tambahkan perintah untuk menonaktifkan pengecekan Foreign Key di awal file SQL.
        // Ini memastikan tabel dapat dibuat dan diisi datanya tanpa terhalang urutan.
        $backup = "SET FOREIGN_KEY_CHECKS = 0;\n\n"; 

        try {
            // Ambil daftar tabel
            $tables = $db->listTables();
        } catch (\Exception $e) {
            log_message('error', 'Gagal mengambil daftar tabel: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengambil daftar tabel database.');
        }

        foreach ($tables as $table) {
            // A. Struktur tabel (DROP dan CREATE)
            $query = $db->query("SHOW CREATE TABLE `" . $db->escapeString($table) . "`")->getRowArray();
            $backup .= "-- Struktur tabel `" . $db->escapeString($table) . "`\n";
            $backup .= "DROP TABLE IF EXISTS `" . $db->escapeString($table) . "`;\n";
            $backup .= $query['Create Table'] . ";\n\n";

            // B. Data tabel (INSERT INTO)
            $rows = $db->query("SELECT * FROM `" . $db->escapeString($table) . "`")->getResultArray();
            
            if (!empty($rows)) {
                $backup .= "-- Data untuk tabel `" . $db->escapeString($table) . "`\n";
                foreach ($rows as $row) {
                    
                    // **PERBAIKAN SINTAKS SQL (#1064):**
                    // Gunakan $db->escape() yang sudah secara otomatis menambahkan single quotes ('') 
                    // tanpa perlu menambahkan kutip ekstra.
                    $vals = array_map(function ($val) use ($db) {
                        // Menggunakan $db->escape() untuk nilai non-NULL
                        return isset($val) ? $db->escape($val) : 'NULL'; 
                    }, array_values($row));

                    $backup .= "INSERT INTO `" . $db->escapeString($table) . "` VALUES (" . implode(', ', $vals) . ");\n";
                }
            }
            $backup .= "\n\n";
        }
        
        // **PERBAIKAN FOREIGN KEY (#1005):**
        // Aktifkan kembali pengecekan Foreign Key di akhir file SQL
        $backup .= "SET FOREIGN_KEY_CHECKS = 1;"; 

        // --- 3. SIMPAN FILE SQL SEMENTARA ---
        $date = date('Y-m-d_H-i-s');
        $sqlFileName = "backup_{$date}.sql";
        $sqlFile = WRITEPATH . $sqlFileName;
        
        if (!write_file($sqlFile, $backup)) {
             log_message('error', 'Gagal menulis file SQL ke direktori WRITEPATH.');
             return redirect()->back()->with('error', 'Gagal menyimpan file SQL backup sementara.');
        }

        // --- 4. ZIP Database + Folder Uploads ---
        $zipFileName = "E-Arsip_Backup_{$date}.zip";
        $zipFile = WRITEPATH . $zipFileName;
        $zip = new ZipArchive();

        if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            log_message('error', 'Gagal membuat file ZIP.');
            @unlink($sqlFile); // Hapus SQL sementara jika gagal ZIP
            return redirect()->back()->with('error', 'Gagal membuat file ZIP. Pastikan ekstensi zip diaktifkan.');
        }

        // Tambahkan file SQL ke dalam ZIP
        $zip->addFile($sqlFile, 'database/backup.sql');

        // Tambahkan folder uploads (rekursif)
        $uploadsPath = FCPATH . 'uploads';
        if (is_dir($uploadsPath)) {
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($uploadsPath, FilesystemIterator::SKIP_DOTS),
                RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    // Membuat path relatif di dalam ZIP
                    $relativePath = 'uploads/' . substr($filePath, strlen($uploadsPath) + 1); 
                    $zip->addFile($filePath, $relativePath);
                }
            }
        }

        $zip->close();

        // --- 5. CLEANUP DAN DOWNLOAD ---
        // Hapus file SQL sementara setelah di-zip
        @unlink($sqlFile);

        // Download file ZIP
        return $this->response->download($zipFile, null)->setFileName($zipFileName);
    }
}