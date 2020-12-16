<?php

// include function files for this application
require_once('food_sc_fns.php');
session_start();

do_html_header("Delete a Restaurant");
if (check_admin_user()) {
  if (isset($_GET['catid'])) {
    delete_merchant_form();
  } else {
    echo "<p>Please choose a Restaurant:</p>";

    // get merchants out of database
    $cat_array = get_merchants();

    // action on as links to cat pages
    action_on_merchants($cat_array, "delete_merchant_form");
  }
  display_button("admin.php", "Back to administration menu");
} else {
  echo "<p>You are not authorized to enter the administration area.</p>";
}
do_html_footer();
