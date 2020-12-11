<?php
  include ('food_sc_fns.php');
  session_start();
  do_html_header("Order Management");
  if(check_cust_user()){
    $customerid = $_SESSION['cust_user'];
    if(isset($_POST['orderid'])){
      if($_POST['status']=="PAY"){
        $items_array = get_order_items($_POST['orderid']);
        display_order_items($items_array);
        display_pay_form($_POST['orderid']);
        exit;
      } else if(!handle_orders_cust($_POST['orderid'],$_POST['status']))
        echo "Unable to handle order ".$_POST['orderid']." into ".$_POST['status'];
    }
    
    $order_array = get_order_details_cust($customerid);
    display_orders_cust($order_array);
  } else {
    echo "Please log in as a customer!";
  }
  do_html_footer();
