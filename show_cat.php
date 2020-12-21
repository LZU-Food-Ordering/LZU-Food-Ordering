<?php
include('food_sc_fns.php');
// The shopping cart needs sessions, so start one
session_start();

$catid = $_GET['catid'];
$name = get_merchant_name($catid);

do_html_header($name);

// get the food info out from db
$food_array = get_foods($catid);

display_foods($food_array);


// if logged in as admin, show add, delete food links
if (isset($_SESSION['admin_user'])) {
  // display_button("index.php", "Continue Shopping");
  display_button("admin.php", "Back to administration menu");
  display_button(
    "edit_merchant_form.php?catid=" . urlencode($catid),
    "edit-merchant",
    "Edit merchant"
  );
} else if (isset($_SESSION['rest_user'])) {
  display_button("admin.php", "Back to administration menu");
} else {
  display_button("index.php", "Continue Shopping");
}

do_html_footer();
