<!-- cart.php -->



<?php
//start session
session_start();
//get menu items

//get cart class
require_once 'index.php';
//get header
require_once 'header.php';
//get cart class
require_once 'cart.php';
?>

<?php
//if cart is not empty

if (!empty($_SESSION['cart'])) {
    //get cart
    $cart = $_SESSION['cart'];
    //create new cart
    $cart = new Cart($cart);
    //get subtotal
    $cart->subtotal();
    //get tax
    $cart->tax();
    //get total
    $cart->total();
    //loop through cart items
    foreach ($cart->items as $item) {
        //display item
        echo $item->name . ' - ' . $item->quantity . ' - ' . $item->price . ' - ' . $item->addon . '<br>';
    }
    //display subtotal
    echo 'Subtotal: ' . $cart->subtotal . '<br>';
    //display tax
    echo 'Tax: ' . $cart->tax . '<br>';
    //display total
    echo 'Total: ' . $cart->total . '<br>';
}

?>
