<?php

// include function files for this application
require_once('food_sc_fns.php');
session_start();
$customerid = $_GET['customerid'];
$details = get_cust_details($customerid);
do_html_header("Edit a Customer");
if (check_admin_user()) {
  display_cust_form($details);
  display_button("admin.php", "Back to administration menu");
} else {
  echo "<p>You are not authorized to enter the administration area.</p>";
}
do_html_footer();
