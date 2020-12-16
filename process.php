<?php
include('food_sc_fns.php');
// The shopping cart needs sessions, so start one
session_start();

do_html_header('Checkout');

$pay_type = $_POST['pay_type'];
$orderid = $_POST['orderid'];

if (isset($_SESSION['cart']) && ($pay_type)) {
  //display cart, not allowing changes and without pictures
  display_cart($_SESSION['cart'], false, 0);
  unset($_SESSION['cart']);
  unset($_SESSION['total_price']);
  unset($_SESSION['items']);
  if (process_payment($_POST)) {
    update_order_status($orderid, "PAID");
    echo "<p>Thank you for shopping with us. Your order has been placed.</p>";
    display_button("index.php", "Continue Shopping");
  } else {
    echo "<p>Could not process your card. Please contact the card issuer or try again.</p>";
    display_button("purchase.php", "Back");
  }
} else {
  echo "<p>You did not fill in all the fields, please try again.</p><hr />";
  display_button("purchase.php", "Back");
}

do_html_footer();
