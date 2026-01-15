<?php
session_start();


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config/database.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (!isset($db)) {
        die("Kesalahan: Koneksi database tidak ditemukan.");
    }

    $user_id = $_SESSION['user_id'];
    
    $query_seller = mysqli_query($db, "SELECT id FROM sellers WHERE user_id = '$user_id'");
    $data_seller = mysqli_fetch_assoc($query_seller);

    if (!$data_seller) {
        $user_info = mysqli_query($db, "SELECT username FROM users WHERE id = '$user_id'");
        $u_data = mysqli_fetch_assoc($user_info);
        $s_name = $u_data['username'] ?? 'User_' . $user_id;
        
        $insert_s = mysqli_query($db, "INSERT INTO sellers (user_id, name) VALUES ('$user_id', '$s_name')");
        if (!$insert_s) {
            die("Gagal membuat data seller: " . mysqli_error($db));
        }
        $seller_id = mysqli_insert_id($db);
    } else {
        $seller_id = $data_seller['id'];
    }

    $nama_produk = mysqli_real_escape_string($db, $_POST['nama_produk']);
    $harga       = (int)$_POST['harga'];
    $kondisi     = mysqli_real_escape_string($db, $_POST['kondisi']);
    $deskripsi   = mysqli_real_escape_string($db, $_POST['deskripsi']);
    $category_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 1;

    if (isset($_FILES['gambar_utama']) && $_FILES['gambar_utama']['error'] === UPLOAD_ERR_OK) {
        
        $folder_tujuan = "uploads/products/"; 
        if (!is_dir($folder_tujuan)) {
            mkdir($folder_tujuan, 0777, true);
        }

        $ekstensi_u = strtolower(pathinfo($_FILES['gambar_utama']['name'], PATHINFO_EXTENSION));
        $nama_utama_baru = time() . '_main_' . uniqid() . '.' . $ekstensi_u;
        
        if (move_uploaded_file($_FILES['gambar_utama']['tmp_name'], $folder_tujuan . $nama_utama_baru)) {
            
            $sql = "INSERT INTO products 
                    (seller_id, name, price, new_price, discount_percent, image, description, kondisi, status, category_id, is_promo) 
                    VALUES 
                    ('$seller_id', '$nama_produk', '$harga', '$harga', 0, '$nama_utama_baru', '$deskripsi', '$kondisi', 'Active', '$category_id', 0)";
            
            if (mysqli_query($db, $sql)) {
                $product_id = mysqli_insert_id($db);

                if (isset($_FILES['gambar_detail']) && !empty($_FILES['gambar_detail']['name'][0])) {
                    $files = $_FILES['gambar_detail'];
                    foreach ($files['name'] as $key => $val) {
                        if ($files['error'][$key] === UPLOAD_ERR_OK) {
                            $ekstensi_d = strtolower(pathinfo($val, PATHINFO_EXTENSION));
                            $nama_det_baru = time() . '_detail_' . $key . '_' . uniqid() . '.' . $ekstensi_d;

                            if (move_uploaded_file($files['tmp_name'][$key], $folder_tujuan . $nama_det_baru)) {
                                mysqli_query($db, "INSERT INTO product_images (product_id, image_name) 
                                                   VALUES ('$product_id', '$nama_det_baru')");
                            }
                        }
                    }
                }

                echo "<script>
                        alert('Listing Berhasil Dipublikasikan!');
                        window.location='profile.php';
                      </script>";
                exit();

            } else {
                if (file_exists($folder_tujuan . $nama_utama_baru)) {
                    unlink($folder_tujuan . $nama_utama_baru);
                }
                die("Gagal simpan ke database: " . mysqli_error($db));
            }
        } else {
            die("Gagal memindahkan file ke folder uploads. Pastikan folder memiliki izin akses (Chmod 777).");
        }
    } else {
        die("Kesalahan: Gambar utama wajib diunggah.");
    }

} else {
    header("Location: jual_produk.php");
    exit();
}