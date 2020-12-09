<?php

// include function files for this application
require_once('food_sc_fns.php');
session_start();

do_html_header("Update your Details");
if (isset($_SESSION['cust_user'])) {
    if ($cust_array = get_cust_details($_SESSION['cust_user'])) {
      display_cust_form($cust_array);
    } else {
      echo "<p>Could not retrieve your details.</p>";
    }
  do_html_url("change_password_form.php", "Change your password");
  do_html_url("index.php", "Back to Home Page");
} else {
  echo "<p>Please login as a customer.</p>";
}
do_html_footer();
