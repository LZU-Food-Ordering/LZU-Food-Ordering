<?php

// include function files for this application
require_once('food_sc_fns.php');
session_start();

do_html_header("Adding a merchant");
if (check_admin_user()) {
  if (filled_out($_POST)) {
    if (insert_merchant($_POST)) {
      echo "<p>merchant \"" . htmlspecialchars($_POST['catname']) . "\" was added to the database.</p>";
    } else {
      echo "<p>merchant \"" . htmlspecialchars($_POST['catname']) . "\" could not be added to the database.</p>";
    }
  } else {
    echo "<p>You have not filled out the form.  Please try again.</p>";
  }
  display_button('admin.php', 'Back to administration menu');
} else {
  echo "<p>You are not authorised to view this page.</p>";
}

do_html_footer();
