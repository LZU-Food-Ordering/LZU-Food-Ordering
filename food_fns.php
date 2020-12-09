<?php
function calculate_shipping_cost() {
  // as we are shipping products all over the world
  // via teleportation, shipping is fixed
  return 20.00;
}

function get_merchants() {
   // query database for a list of merchants
   $conn = db_connect();
   $query = "select * from merchants";
   $result = @$conn->query($query);
   if (!$result) {
     return false;
   }
   $num_cats = @$result->num_rows;
   if ($num_cats == 0) {
      return false;
   }
   $result = db_result_to_array($result);
   return $result;
}

function get_merchant_name($catid) {
   // query database for the name for a merchant id
   $conn = db_connect();
   $query = "select catname from merchants
             where catid = '".$conn->real_escape_string($catid)."'";
   $result = @$conn->query($query);
   if (!$result) {
     return false;
   }
   $num_cats = @$result->num_rows;
   if ($num_cats == 0) {
      return false;
   }
   $row = $result->fetch_object();
   return $row->catname;
}


function get_foods($catid) {
   // query database for the foods in a merchant
   if ((!$catid) || ($catid == '')) {
     return false;
   }

   $conn = db_connect();
   $query = "select * from foods where catid = '".$conn->real_escape_string($catid)."'";
   $result = @$conn->query($query);
   if (!$result) {
     return false;
   }
   $num_foods = @$result->num_rows;
   if ($num_foods == 0) {
      return false;
   }
   $result = db_result_to_array($result);
   return $result;
}

function get_food_details($foodid) {
  // query database for all details for a particular food
  if ((!$foodid) || ($foodid=='')) {
     return false;
  }
  $conn = db_connect();
  $query = "select * from foods where foodid='".$conn->real_escape_string($foodid)."'";
  $result = @$conn->query($query);
  if (!$result) {
     return false;
  }
  $result = @$result->fetch_assoc();
  return $result;
}

function calculate_price($cart) {
  // sum total price for all items in shopping cart
  $price = 0.0;
  if(is_array($cart)) {
    $conn = db_connect();
    foreach($cart as $foodid => $qty) {
      $query = "select price from foods where foodid='".$conn->real_escape_string($foodid)."'";
      $result = $conn->query($query);
      if ($result) {
        $item = $result->fetch_object();
        $item_price = $item->price;
        $price +=$item_price*$qty;
      }
    }
  }
  return $price;
}

function calculate_items($cart) {
  // sum total items in shopping cart
  $items = 0;
  if(is_array($cart))   {
    foreach($cart as $foodid => $qty) {
      $items += $qty;
    }
  }
  return $items;
}
?>
