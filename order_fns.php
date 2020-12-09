<?php
function process_card($card_details) {
  // connect to payment gateway or
  // use gpg to encrypt and mail or
  // store in DB if you really want to

  return true;
}

function insert_order($order_details) {
  // extract order_details out as variables
  extract($order_details);
  // set shipping address same as address
  $ship_name = $name;
  $ship_customerid = $customerid;
  $ship_dormitory = $dormitory;

  $conn = db_connect();

  // we want to insert the order as a transaction
  // start one by turning off autocommit
  $conn->autocommit(FALSE);

  // insert customer address
  $query = "select customerid from customers where
            customerid = '".$conn->real_escape_string($customerid)."'";

  $result = $conn->query($query);

  if($result->num_rows>0) {
    // $customer = $result->fetch_object();
    // $customerid = $customer->customerid;
  } else {
    $query = "insert into customers values
            (' " . $conn->real_escape_string($customerid) .
            "','". $conn->real_escape_string($name) ."','". $conn->real_escape_string($dormitory)."')";
            print_r($query);
    $result = $conn->query($query);

    if (!$result) {
       return false;
    }
  }

  $date = date("Y-m-d");

  $query = "insert into orders values
            ('', '". $conn->real_escape_string($_SESSION['total_price']) . 
             "', '". $conn->real_escape_string($date) ."', 'PARTIAL',
             '" . $conn->real_escape_string($ship_name)."',
             '". $conn->real_escape_string($ship_customerid) . "', '". $conn->real_escape_string($dormitory)."')";

  $result = $conn->query($query);
  if (!$result) {
    return false;
  }

  $query = "select orderid from orders where
               amount > (".(float)$_SESSION['total_price'] ."-.001) and
               amount < (". (float)$_SESSION['total_price']."+.001) and
               date = '".$conn->real_escape_string($date)."' and
               order_status = 'PARTIAL' and
               ship_name = '".$conn->real_escape_string($ship_name)."' and
               ship_customerid = '".$conn->real_escape_string($ship_customerid)."' and
               ship_dormitory = '".$conn->real_escape_string($ship_dormitory)."'";

  $result = $conn->query($query);

  if($result->num_rows>0) {
    $order = $result->fetch_object();
    $orderid = $order->orderid;
  } else {
    return false;
  }

  // insert each food
  foreach($_SESSION['cart'] as $foodid => $quantity) {
    $detail = get_food_details($foodid);
    $query = "delete from order_items where
              orderid = '". $conn->real_escape_string($orderid)."' and foodid = '". $conn->real_escape_string($foodid)."'";
    $result = $conn->query($query);
    $query = "insert into order_items values
              ('". $conn->real_escape_string($orderid) ."', '". $conn->real_escape_string($foodid) . 
              "', ". $conn->real_escape_string($detail['price']) .", " . $conn->real_escape_string($quantity). ")";
    $result = $conn->query($query);
    if(!$result) {
      return false;
    }
  }

  // end transaction
  $conn->commit();
  $conn->autocommit(TRUE);

  return $orderid;
}
