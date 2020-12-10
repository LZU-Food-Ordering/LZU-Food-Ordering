<?php

// include function files for this application
require_once('food_sc_fns.php');
session_start();

do_html_header("Updating your details");
if (isset($_SESSION['admin_user'])) {
  if(isset($_POST['de_name'])){
    if(delete_cust($_POST['de_name'])) {
      echo "<p>Your details was deleted.</p>";
    } else {
      echo "<p>Your details could not be deleted.</p>";
    }
  }
  else if (isset($_POST)) {
    if(update_cust($_POST)) {
      echo "<p>Your details was updated.</p>";
    } else {
      echo "<p>Your details could not be updated.</p>";
    }
  } else {
    echo "<p>You have not filled out the form.  Please try again.</p>";
  }
  do_html_url("index.php", "Back to Home Page");
} 
else if (isset($_SESSION['cust_user'])) {
  if (isset($_POST)) {
    if(update_cust($_POST)) {
      echo "<p>Your details was updated.</p>";
    } else {
      echo "<p>Your details could not be updated.</p>";
    }
  } else {
    echo "<p>You have not filled out the form.  Please try again.</p>";
  }
  if(isset($_SESSION['cust_user'])){
    do_html_url("index.php", "Back to Home Page");
  }
  else if(isset($_SESSION['admin_user'])){
    do_html_url("admin.php", "Back to administration menu");
  }
} else {
  echo "<p>You are not authorised to view this page.</p>";
}
do_html_footer();
