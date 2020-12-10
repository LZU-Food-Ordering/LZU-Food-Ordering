<?php
  include ('food_sc_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();

  $name = $_GET['name'];

  // get this food out of database
  $names = get_cust_details($name);
  do_html_header('Customer Management');
  display_cust_details($names);
  $conn = db_connect(); 
  // if logged in as admin, show edit customer links
  if(check_admin_user()) {
    display_button("edit_cust_item_form.php?name=".$conn->real_escape_string($name), "edit-item", "Edit Customer");
    display_button("admin.php", "admin-menu", "Admin Menu");
  } 
  do_html_footer();
