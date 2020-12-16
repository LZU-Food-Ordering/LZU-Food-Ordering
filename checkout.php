<?php
//include our function set
include('food_sc_fns.php');

// The shopping cart needs sessions, so start one
session_start();

do_html_header("Checkout");

if (isset($_SESSION['cart']) && (array_count_values($_SESSION['cart']))) {
  display_cart($_SESSION['cart'], false, 0);
  if (isset($_SESSION['cust_user'])) {
    $cust_details = get_cust_details($_SESSION['cust_user']);
    display_checkout_form($cust_details);
  }
} else {
  echo "<p>There are no items in your cart</p>";
}

display_button("show_cart.php", "Continue Shopping");

do_html_footer();
