<?php
include 'config/database.php';

$message = '';

if(isset($_POST['register'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    $check = mysqli_query($db, "SELECT * FROM users WHERE email='$email'");
    if(mysqli_num_rows($check) > 0){
        $message = "Email sudah terdaftar!";
    } else {
        $insert = mysqli_query($db, "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')");
        if($insert){
            $message = "Registrasi berhasil! Silakan login.";
        } else {
            $message = "Terjadi kesalahan: " . mysqli_error($db);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Registrasi</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-yellow-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Daftar Akun</h2>
        <?php if($message) echo "<p class='mb-4 text-blue'>$message</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" class="w-full p-2 mb-4 border rounded" required>
            <input type="email" name="email" placeholder="Email" class="w-full p-2 mb-4 border rounded" required>
            <input type="password" name="password" placeholder="Password" class="w-full p-2 mb-4 border rounded" required>
            <button type="submit" name="register" class="w-full p-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition">Daftar</button>
        </form>
        <p class="mt-4 text-center">Sudah punya akun? <a href="login.php" class="text-yellow-700 font-semibold">Login</a></p>
    </div>
</body>
</html>
