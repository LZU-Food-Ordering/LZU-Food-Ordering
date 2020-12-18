<?php

// include function files for this application
require_once('food_sc_fns.php');
session_start();
$userkind = "admin_user";
if (isset($_SESSION['rest_user']))
$userkind = "rest_user";
if (isset($_SESSION[$userkind]))
$old_user = $_SESSION[$userkind];  // store  to test if they *were* logged in
unset($_SESSION[$userkind]);
session_destroy();


// start output html
do_html_header("Logging Out",'admin');

if (!empty($old_user)) {
  echo "<p>Logged out.</p>";
  // display_button("login.php", "Login");
} else {
  // if they weren't logged in but came to this page somehow
  echo "<p>You were not logged in, and so have not been logged out.</p>";
  // display_button("login.php", "Login");
}

do_html_footer();
