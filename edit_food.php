<?php

// include function files for this application
require_once('food_sc_fns.php');
session_start();

do_html_header("Updating food");
if (check_admin_user()) {
  if (filled_out($_POST)) {
    $oldfoodid = $_POST['oldfoodid'];
    $foodid = $_POST['foodid'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $catid = $_POST['catid'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    if(update_food($oldfoodid, $foodid, $title, $author, $catid, $price, $description)) {
      echo "<p>food was updated.</p>";
    } else {
      echo "<p>food could not be updated.</p>";
    }
  } else {
    echo "<p>You have not filled out the form.  Please try again.</p>";
  }
  do_html_url("admin.php", "Back to administration menu");
} else {
  echo "<p>You are not authorised to view this page.</p>";
}

do_html_footer();

?>
