<?php
  include ('food_sc_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();

  $customerid = $_GET['customerid'];

  // get this food out of database
  $details = get_cust_details($customerid);
  do_html_header('Customer Management');
  // if logged in as admin, show edit customer links
  if(check_admin_user()) {
    display_cust_details($details);
    $conn = db_connect(); 
    display_button("edit_cust_item_form.php?customerid=".$conn->real_escape_string($customerid), "edit-item", "Edit Customer");
    display_button("admin.php", "admin-menu", "Admin Menu");
  } else {
    echo "<p>You are not authorized to enter the administration area.</p>";
  }
  do_html_footer();
