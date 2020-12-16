<?php

// include function files for this application
require_once('food_sc_fns.php');
session_start();

do_html_header("Signning up");
if (isset($_SESSION['cust_user'])) {
  echo "You have already logged in!\n";
  display_button("index.php", "Back to Home Page");
} else {
  if (isset($_POST)) {
    if (cust_signup($_POST)) {
      echo "<p>You have created an account.</p>";
    } else {
      echo "<p>Your account could not be created.</p>";
    }
  } else {
    echo "<p>You have not filled out the form.  Please try again.</p>";
  }
}
do_html_footer();
