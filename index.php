<?php
  include_once 'food_sc_fns.php';
  // The shopping cart needs sessions, so start one
  session_start();
  do_html_header("Welcome to LZU Food Ordering");

  echo "<p>Please choose a Restaurant:</p>";

  // get merchants out of database
  $cat_array = get_merchants();

  // display as links to cat pages
  display_merchants($cat_array);

  // if logged in as admin, show add, delete, edit cat links
  if(isset($_SESSION['admin_user'])) {
    display_button("admin.php", "admin-menu", "Admin Menu");
  }
  do_html_footer();
?>
