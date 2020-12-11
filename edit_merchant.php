<?php

// include function files for this application
require_once('food_sc_fns.php');
session_start();

do_html_header("Updating merchant");
if (check_admin_user() || check_rest_user()) {
  if (filled_out($_POST)) {
    if (update_merchant($_POST)) {
      echo "<p>merchant was updated.</p>";
    } else {
      echo "<p>merchant could not be updated.</p>";
    }
  } else {
    echo "<p>You have not filled out the form.  Please try again.</p>";
  }
  do_html_url("admin.php", "Back to administration menu");
} else {
  echo "<p>You are not authorised to view this page.</p>";
}
do_html_footer();
