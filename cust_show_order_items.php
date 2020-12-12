<?php
include('food_sc_fns.php');
session_start();
do_html_header("Check Order Details");
if (check_cust_user()) {
  if (isset($_GET['orderid'])) {
    if (isset($_POST['foodid'])) {
      handle_orders($_POST['foodid'], $_GET['orderid'], "CANCEL");
    }
    $items_array = get_order_items($_GET['orderid']);
    display_order_items($items_array);
    echo "<a href=\"cust_show_order.php\"> Back to viewing orders page</a>";
  } else {
    echo "Please enter through viewing orders page!";
  }
} else {
  echo "Please log in as a customer!";
}
do_html_footer();
