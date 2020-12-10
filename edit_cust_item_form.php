<?php

// include function files for this application
require_once('food_sc_fns.php');
session_start();
$name = $_GET['name'];
$names=get_cust_details($name);
do_html_header("Edit a Customer");
if (check_admin_user()) {
  display_cust_form($names);
  do_html_url("admin.php", "Back to administration menu");
} else {
  echo "<p>You are not authorized to enter the administration area.</p>";
}
do_html_footer();
