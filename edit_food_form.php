<?php

// include function files for this application
require_once('food_sc_fns.php');
session_start();

do_html_header("Edit food details");
if (check_admin_user()) {
  if ($food = get_food_details($_GET['foodid'])) {
    display_food_form($food);
    do_html_url("upload_image.php?foodid=".$_GET['foodid'], "Edit image");
  } else {
    echo "<p>Could not retrieve food details.</p>";
  }
  do_html_url("admin.php", "Back to administration menu");
} else {
  echo "<p>You are not authorized to enter the administration area.</p>";
}
do_html_footer();
