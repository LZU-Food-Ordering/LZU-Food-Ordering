<?php

// include function files for this application
require_once('food_sc_fns.php');
session_start();

do_html_header("Edit merchant");
if (check_admin_user()) {
  if ($catname = get_merchant_name($_GET['catid'])) {
    $catid = $_GET['catid'];
    $cat = compact('catname', 'catid');
    display_merchant_form($cat);
  } else {
    echo "<p>Could not retrieve merchant details.</p>";
  }
  do_html_url("admin.php", "Back to administration menu");
} else {
  echo "<p>You are not authorized to enter the administration area.</p>";
}
do_html_footer();

?>
