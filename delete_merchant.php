<?php

// include function files for this application
require_once('food_sc_fns.php');
session_start();

do_html_header("Deleting merchant");
if (check_admin_user()) {
  if (isset($_POST['catid'])) {
    if(delete_merchant($_POST['catid'])) {
      echo "<p>merchant was deleted.</p>";
    } else {
      echo "<p>merchant could not be deleted.<br />
            This is usually because it is not empty.</p>";
    }
  } else {
    echo "<p>No merchant specified.  Please try again.</p>";
  }
  do_html_url("admin.php", "Back to administration menu");
} else {
  echo "<p>You are not authorised to view this page.</p>";
}
do_html_footer();

?>
