<?php
include('food_sc_fns.php');
// The shopping cart needs sessions, so start one
session_start();

if (isset($_POST['foodid'])) {
  if (!handle_orders($_POST['foodid'], $_POST['orderid'], $_POST['status']))
    echo "Unable to handle order " . $_POST['orderid'] . " food " . $_POST['foodid'] . " into " . $_POST['status'];
}
$catid = $_GET['catid'];

// get this food out of database
$order_array = get_order_details($catid);
do_html_header("Order Management");
display_orders($order_array);

do_html_footer();
