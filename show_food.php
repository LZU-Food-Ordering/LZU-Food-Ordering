<?php
include('food_sc_fns.php');
// The shopping cart needs sessions, so start one
session_start();

$foodid = $_GET['foodid'];

// get this food out of database
$food = get_food_details($foodid);
do_html_header($food['title']);
display_food_details($food);

// set url for "continue button"
$target = "index.php";
if ($food['catid']) {
  $target = "show_cat.php?catid=" . urlencode($food['catid']);
}

// if logged in as admin, show edit food links
if (check_admin_user()) {
  display_button("edit_food_form.php?foodid=" . urlencode($foodid), "Edit Item");
  display_button("admin.php", "Admin Menu");
} else if (check_rest_user()) {
  $conn = db_connect();
  $query = "select catid from merchants where catname='" . $_SESSION['rest_user'] . "'";
  $catid = $conn->query($query)->fetch_object()->catid;
  if ($food['catid'] == $catid)
    display_button("edit_food_form.php?foodid=" . urlencode($foodid), "Edit Item");
  display_button("admin.php", "Admin Menu");
} else if (check_cust_user() && $food['status'] == 1) {
  display_button(
    "show_cart.php?new=" . urlencode($foodid),
    "Add " . htmlspecialchars($food['title']) . " To My Shopping Cart"
  );
}
display_button($target, "Continue");

do_html_footer();
