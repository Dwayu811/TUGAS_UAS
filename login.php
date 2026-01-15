<?php
session_start();
include 'config/database.php';

$message = '';

if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = $_POST['password'];

    $check = mysqli_query($db, "SELECT * FROM users WHERE email='$email'");
    if(mysqli_num_rows($check) > 0){
        $user = mysqli_fetch_assoc($check);
        if(password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: index.php'); 
            exit;
        } else {
            $message = "Password salah!"; 
        } 
    } else {
        $message = "Email tidak ditemukan!";
    }
}
?> 
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login</title> 
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-yellow-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
        <?php if($message) echo "<p class='mb-4 text-red-500'>$message</p>"; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email" class="w-full p-2 mb-4 border rounded" required>
            <input type="password" name="password" placeholder="Password" class="w-full p-2 mb-4 border rounded" required>
            <button type="submit" name="login" class="w-full p-2 bg-yellow-600 text-white rounded hover:bg-yellow-700 transition">Login</button>
        </form>
        <p class="mt-4 text-center">Belum punya akun? <a href="register.php" class="text-yellow-700 font-semibold">Daftar</a></p>
    </div>
</body>
</html>
