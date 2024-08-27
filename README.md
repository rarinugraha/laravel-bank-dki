# Bank DKI Middle & Senior Test

## Techstack

-   PHP (8.2)
-   Laravel (11)
-   PostgreSQL

## Installation

1. Clone the repo

```bash
git clone https://github.com/rarinugraha/laravel-bank-dki.git
```

2. Install all the dependencies using composer

```bash
composer install
```

3. Copy the example env file and make the required configuration changes in the .env file

```bash
cp .env.example .env
```

4. Generate a new application key

```bash
php artisan key:generate
```

5. Run migration & seeder

```bash
php artisan migrate:fresh --seed
```

6. Start the local development server

```bash
php artisan serve
```

You can now access the server at http://localhost:8000

## Pembuatan User

1. Setiap kantor cabang terdapat 2 user, 1 CS & 1 Supervisi.

2. Password wajib terdiri dari kombinasi huruf besar, huruf kecil, spesial karakter dan angka. Panjang karakter password minimal 8 (delapan) digit.

3. Saat user login namun mengalami gagal login sampai dengan 3 (tiga) kali, maka usernya akan terblokir dan tidak bisa login.
4. User yang lain dapat melakukan proses pembukaan blokir sehingga user yang terblokir dapat login kembali.

## Alur Pembukaan Rekening

1. CS: Input data nasabah.

2. Supervisi: Approve data nasabah.

3. Input data nasabah dari menu "Pembukaan Rekening".

4. Data yang akan diinput:
    - Nama sesuai KTP (tidak boleh mengandung angka dan symbol dan tidak boleh mengandung kata-kata/gelar tertentu seperti gelar Profesor dan Haji) (text, unique)

    - Tempat Lahir (text)
 
    - Tanggal Lahir (format tanggal yyyy-mm-dd)
 
    - Jenis Kelamin (Pilihan laki-laki/wanita)
    
    - Pekerjaan (foreign key)
        - Cara pengisian data pekerjaan menggunakan dropdown yang datanya berasal dari tabel master pekerjaan
 
    - Alamat (Provinsi, Kabupaten/Kota, Kecamatan, Kelurahan, Nama Jalan, RT dan RW)
        - Cara pengisian data alamat menggunakan dropdown dinamis dari masing-masing master data Provinsi, Kabupaten/Kota, Kecamatan, dan Kelurahan. Sedangkan untuk penginputan Nama Jalan sampai dengan RW inputan free text.
        - Buat 4 service API untuk menampilkan master data Provinsi, Kabupaten/Kota, Kecamatan dan Kelurahan yang akan dicoba akses melalui Postman.

    - Nominal Setor (hanya numerik, format standart rupiah)

5. Data yang sudah terinput akan berstatus "Menunggu Approval".

6. Supervisi sebagai approval dapat melakukan persetujuan pengajuan pembukaan rekening melalui Menu Approval Pembukaan Rekening dan dapat melihat semua data pengajuan dalam bentuk table.

7. Terdapat tombol “Approve” di bagian kanan masing masing row table yang akan mengubah status pengajuan dari “Menunggu Approval" menjadi “Disetujui".
    - Saat User Supervisi melakukan approval data, kirim notifikasi ke email CS sebagai informasi bahwa data sudah disetujui (penentuan subject dan body email dibebaskan. kepada masing-masing kandidat)

8. Pengguna dengan Role CS tidak dapat melakukan approval, dan hanya dapat melihat data pengajuan dengan statusnya.

## Dataset

Provinsi, Kabupaten/Kota, Kecamatan, Kelurahan: https://github.com/guzfirdaus/Wilayah-Administrasi-Indonesia/

Pekerjaan KTP: https://kitalulus.com/blog/seputar-kerja/jenis-pekerjaan-di-ktp/