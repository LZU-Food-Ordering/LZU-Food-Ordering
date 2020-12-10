<?php

// include function files for this application
require_once('food_sc_fns.php');
session_start();

do_html_header("customer management");
if (check_admin_user()) {
  $custname = get_cust();
  // get the food info out from db

  display_cust($custname);
  do_html_url("admin.php", "Back to administration menu");
} else {
  echo "<p>You are not authorized to enter the administration area.</p>";
}
do_html_footer();

