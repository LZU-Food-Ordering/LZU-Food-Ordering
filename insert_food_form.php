<?php

// include function files for this application
require_once('food_sc_fns.php');
session_start();

do_html_header("Add a food");
if (check_admin_user() || check_rest_user()) {
  display_food_form();
  display_button("admin.php", "Back to administration menu");
} else {
  echo "<p>You are not authorized to enter the administration area.</p>";
}
do_html_footer();
