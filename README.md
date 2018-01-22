# Aplikasi sederhana manajemen surat dengan PHP MySQLi

Aplikasi ini untuk mengelola pencatatan surat masuk dan surat keluar (disposisi). Dilengkapi beberapa fitur, antara lain :

- Cetak disposisi surat masuk
- Cetak agenda surat masuk dan keluar berdasarkan tanggal tertentu
- Upload lampiran file surat, baik file scan/gambar(.JPG, .PNG) serta file dokumen (.DOC, .DOCX dan .PDF)
- Fitur galeri file lampiran yang diupload
- Upload kode klasifikasi surat format *.CSV (file excel)
- Multilevel user
- Fitur backup dan restore database

Aplikasi ini dibuat dengan bahasa pemrograman <a href="http://php.net/" target="_blank">PHP</a> dan database <a href="https://en.wikipedia.org/wiki/MySQLi" target="_blank">MySQLi</a> dengan style <a href="https://en.wikipedia.org/wiki/Procedural_programming" target="_blank">prosedural</a>. Sedangkan cssnya menggunakan <a href="http://materializecss.com/" target="_blank">Materializecss</a> dan <a href="https://www.google.com/design/icons/" target="_blank">Google Material Icons</a>.

Untuk menggunakan aplikasi ini silakan lakukan beberapa konfigurasi terlebih dahulu.

- Konfigurasi database sistem: buka folder **include** -> **config.php** lalu setting databasenya.
- Konfigurasi kode klasifikasi surat: buka file **kode.php** lalu setting databasenya.
- Konfigurasi fitur backup database: buka file **backup.php** lalu setting databasenya.
- Konfigurasi fitur restore database: buka file **restore.php** lalu setting databasenya.

Untuk tampilan terbaik, gunakan browser Google Chrome versi terbaru.

Inspired by Nur Akhwam.
