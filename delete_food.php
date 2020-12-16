<?php

// include function files for this application
require_once('food_sc_fns.php');
session_start();

do_html_header("Deleting food");
if (check_admin_user()) {
  if (isset($_POST['foodid'])) {
    $foodid = $_POST['foodid'];
    if (delete_food($foodid)) {
      echo "<p>food " . htmlspecialchars($foodid) . " was deleted.</p>";
    } else {
      echo "<p>food " . htmlspecialchars($foodid) . " could not be deleted.</p>";
    }
  } else {
    echo "<p>We need an foodid to delete a food.  Please try again.</p>";
  }
  display_button("admin.php", "Back to administration menu");
} else {
  echo "<p>You are not authorised to view this page.</p>";
}

do_html_footer();
