<?php
  include ('food_sc_fns.php');
  // The shopping cart needs sessions, so start one
  session_start();

  $foodid = $_GET['foodid'];

  // get this food out of database
  $food = get_food_details($foodid);
  do_html_header($food['title']);
  display_food_details($food);

  // set url for "continue button"
  $target = "index.php";
  if($food['catid']) {
    $target = "show_cat.php?catid=". urlencode($food['catid']);
  }

  // if logged in as admin, show edit food links
  if(check_admin_user()) {
    display_button("edit_food_form.php?foodid=". urlencode($foodid), "edit-item", "Edit Item");
    display_button("admin.php", "admin-menu", "Admin Menu");
    display_button($target, "continue", "Continue");
  } else {
    display_button("show_cart.php?new=". urlencode($foodid), "add-to-cart",
                   "Add ". htmlspecialchars($food['title']) ." To My Shopping Cart");
    display_button($target, "continue-shopping", "Continue Shopping");
  }

  do_html_footer();
?>
