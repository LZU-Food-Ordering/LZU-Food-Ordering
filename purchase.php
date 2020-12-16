<?php

include('food_sc_fns.php');
// The shopping cart needs sessions, so start one
session_start();

do_html_header("Checkout");

// create short variable names
$name = $_POST['name'];
$dormitory = $_POST['dormitory'];
$customerid = $_POST['customerid'];

// if filled out
if (isset($_SESSION['cart']) && ($name) && ($dormitory) && ($customerid)) {
  // able to insert into database
  $orderid = insert_order($_POST);
  if ($orderid != false) {
    //display cart, not allowing changes and without pictures
    display_cart($_SESSION['cart'], false, 0);

    //get pay details
    display_pay_form($orderid);

    display_button("show_cart.php", "Continue Shopping");
  } else {
    echo "<p>Could not store data, please try again.</p>";
    display_button('checkout.php', 'Back');
  }
} else {
  echo "<p>You did not fill in all the fields, please try again.</p><hr />";
  display_button('checkout.php', 'Back');
}

do_html_footer();
