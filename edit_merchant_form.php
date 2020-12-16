<?php

// include function files for this application
require_once('food_sc_fns.php');
session_start();

do_html_header("Update a Restaurant");
if (check_admin_user()) {
  if (isset($_GET['catid'])) {
    if ($catname = get_merchant_name($_GET['catid'])) {
      $catid = $_GET['catid'];
      $cat = get_merchant_details($catid);
      display_merchant_form($cat);
      display_button("upload_image.php?catid=" . $_GET['catid'], "Edit image");
    } else {
      echo "<p>Could not retrieve merchant details.</p>";
    }
  } else {
    echo "<p>Please choose a Restaurant:</p>";

    // get merchants out of database
    $cat_array = get_merchants();

    // action on as links to cat pages
    action_on_merchants($cat_array, "edit_merchant_form");
  }
  display_button("admin.php", "Back to administration menu");
} else if (check_rest_user()) {
  $conn = db_connect();
  $query = "select catid from merchants where catname='" . $_SESSION['rest_user'] . "'";
  $catid = $conn->query($query)->fetch_object()->catid;
  $cat = get_merchant_details($catid);
  display_merchant_form($cat);
} else {
  echo "<p>You are not authorized to enter the administration area.</p>";
}
do_html_footer();
