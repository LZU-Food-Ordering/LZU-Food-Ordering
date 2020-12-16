<?php

// include function files for this application
require_once('food_sc_fns.php');
session_start();

do_html_header("Updating your details");
if (isset($_SESSION['admin_user'])) {
  if (isset($_POST['de_id'])) {
    if (delete_cust($_POST['de_id'])) {
      echo "<p>The account was deleted.</p>";
    } else {
      echo "<p>The account could not be deleted.</p>";
    }
  } else if (isset($_POST)) {
    if (update_cust($_POST)) {
      echo "<p>Your details was updated.</p>";
    } else {
      echo "<p>Your details could not be updated.</p>";
    }
  } else {
    echo "<p>You have not filled out the form.  Please try again.</p>";
  }
  display_button("index.php", "Back to Home Page");
} else if (isset($_SESSION['cust_user'])) {
  if (isset($_POST)) {
    if (update_cust($_POST)) {
      echo "<p>Your details was updated.</p>";
    } else {
      echo "<p>Your details could not be updated.</p>";
    }
  } else {
    echo "<p>You have not filled out the form.  Please try again.</p>";
  }
  if (isset($_SESSION['cust_user'])) {
    display_button("index.php", "Back to Home Page");
  } else if (isset($_SESSION['admin_user'])) {
    display_button("admin.php", "Back to administration menu");
  }
} else {
  echo "<p>You are not authorised to view this page.</p>";
}
do_html_footer();
