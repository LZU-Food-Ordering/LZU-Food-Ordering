<?php

// include function files for this application
require_once('food_sc_fns.php');
session_start();

do_html_header("Sign up");
if (isset($_SESSION['cust_user'])) {
  echo "You have already logged in!\n";
  display_button("index.php", "Back to Home Page");
} else {
  display_cust_signup_form();
}
do_html_footer();
