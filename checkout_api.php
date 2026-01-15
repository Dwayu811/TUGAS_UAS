<?php
session_start();
include 'config/database.php';


if (!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}
$buyer_id = $_SESSION['user_id'];
$total_bayar_akhir = 0;
$order_id_display = "VNTG-" . strtoupper(uniqid());

foreach ($_SESSION['cart'] as $product_id => $qty) {
    
    $product_query = mysqli_query($db, "SELECT seller_id, new_price FROM products WHERE id = '$product_id'");
    $p = mysqli_fetch_assoc($product_query);
    
    if ($p) {
        $seller_id = $p['seller_id'];
        $price = $p['new_price'];
        $subtotal = $price * $qty;
        $total_bayar_akhir += $subtotal;

        $query_order = "INSERT INTO orders (buyer_id, seller_id, product_id, total_price, status) 
                        VALUES ('$buyer_id', '$seller_id', '$product_id', '$subtotal', 'Pending')";
        
        mysqli_query($db, $query_order);
    }
}

unset($_SESSION['cart']);


header("Location: waiting_payment.php?order_id=$order_id_display&total=$total_bayar_akhir");
exit();
?>