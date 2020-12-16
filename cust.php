<?php

// include function files for this application
require_once('food_sc_fns.php');
session_start();

if (isset($_POST['customerid']) && isset($_POST['passwd'])) {
  // they have just tried logging in

  $customerid = $_POST['customerid'];
  $passwd = $_POST['passwd'];

  if (login_cust($customerid, $passwd)) {
    if (check_admin_user()) {
      unset($_SESSION['admin_user']);
    } else if (check_rest_user()) {
      unset($_SESSION['rest_user']);
    }
    // if they are in the database register the user id
    $_SESSION['cust_user'] = $customerid;
  } else {
    // unsuccessful login
    do_html_header("Problem:");
    echo "<p>You could not be logged in.<br/>
            You must be logged in to view this page.</p>";
    display_button('cust_login.php', 'Login');
    do_html_footer();
    exit;
  }
}



if (check_cust_user()) {
  header('Location:index.php');
  exit;
} else {
  do_html_header("Customer");
  echo "<p>You are not authorized to enter the administration area.</p>";
  do_html_footer();
}
