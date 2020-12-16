<?php

// include function files for this application
require_once('food_sc_fns.php');
session_start();

do_html_header("Edit food details");
if (check_admin_user() || check_rest_user()) {
  if ($food = get_food_details($_GET['foodid'])) {
    display_food_form($food);
    display_button("upload_image.php?foodid=" . $_GET['foodid'], "Edit image");
  } else {
    echo "<p>Could not retrieve food details.</p>";
  }
  display_button("admin.php", "Back to administration menu");
} else {
  echo "<p>You are not authorized to enter the administration area.</p>";
}
do_html_footer();
