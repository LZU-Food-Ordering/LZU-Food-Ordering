<?php

// include function files for this application
require_once('food_sc_fns.php');
session_start();

do_html_header("Updating food");
if (check_admin_user() || check_rest_user()) {
  if (filled_out($_POST)) {
    $_POST['rest'] = get_merchant_name($_POST['catid']);
    if (update_food($_POST)) {
      echo "<p>food was updated.</p>";
    } else {
      echo "<p>food could not be updated.</p>";
    }
  } else {
    echo "<p>You have not filled out the form.  Please try again.</p>";
  }
  display_button("admin.php", "Back to administration menu");
} else {
  echo "<p>You are not authorised to view this page.</p>";
}

do_html_footer();
