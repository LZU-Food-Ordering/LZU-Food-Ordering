<?php
function process_payment($pay_details)
{
  // connect to payment gateway or
  // use gpg to encrypt and mail or
  // store in DB if you really want to

  return true;
}

function insert_order($order_details)
{
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
            customerid = '" . $conn->real_escape_string($customerid) . "'";

  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    // $customer = $result->fetch_object();
    // $customerid = $customer->customerid;
  } else {
    return false;
  }

  $date = date("Y-m-d");

  $query = "insert into orders values
            ('', '" . $conn->real_escape_string($_SESSION['total_price']) .
    "', '" . $conn->real_escape_string($date) . "', 'PARTIAL',
             '" . $conn->real_escape_string($ship_name) . "',
             '" . $conn->real_escape_string($ship_customerid) . "', '" . $conn->real_escape_string($dormitory) . "')";
  $result = $conn->query($query);
  if (!$result) {
    return false;
  }

  $query = "select orderid from orders where
               amount > (" . (float)$_SESSION['total_price'] . "-.001) and
               amount < (" . (float)$_SESSION['total_price'] . "+.001) and
               date = '" . $conn->real_escape_string($date) . "' and
               order_status = 'PARTIAL' and
               ship_name = '" . $conn->real_escape_string($ship_name) . "' and
               ship_customerid = '" . $conn->real_escape_string($ship_customerid) . "' and
               ship_dormitory = '" . $conn->real_escape_string($ship_dormitory) . "'";

  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    $order = $result->fetch_object();
    $orderid = $order->orderid;
  } else {
    return false;
  }

  // insert each food
  foreach ($_SESSION['cart'] as $foodid => $quantity) {
    $detail = get_food_details($foodid);
    $query = "delete from order_items where
              orderid = '" . $conn->real_escape_string($orderid) . "' and foodid = '" . $conn->real_escape_string($foodid) . "'";
    $result = $conn->query($query);
    $query = "insert into order_items values
              (" . $conn->real_escape_string($orderid) . ", " . $conn->real_escape_string($foodid) .
      ", " . $conn->real_escape_string($detail['price']) . ", " . $conn->real_escape_string($quantity) . ", 'PARTIAL')";
    $result = $conn->query($query);
    if (!$result) {
      return false;
    }
    $query = "select stock,status,title,rest from foods
              where foodid=" . $foodid;
    $result = $conn->query($query);
    if (!$result) {
      return false;
    }
    $obj = $result->fetch_object();
    $stock = $obj->stock;
    $foodtitle = $obj->title;
    $foodrest = $obj->rest;
    $foodstatus = $obj->status;
    if (($stock - $quantity) < 0 || $foodstatus == 0) {
      echo "Food " . $foodtitle . " by " . $foodrest . " has become unavailable!";
      return false;
    }
    $query = "update foods set stock=" . ($stock - $quantity) . "
              where foodid=" . $foodid;
    $result = $conn->query($query);
    if (!$result) {
      return false;
    }
    if (($stock - $quantity) == 0) {
      $query = "update foods set status=0
               where foodid=" . $foodid;
      $result = $conn->query($query);
      if (!$result) {
        return false;
      }
    }
  }

  // end transaction
  $conn->commit();
  $conn->autocommit(TRUE);

  return $orderid;
}

function update_order_status($orderid, $status)
{
  // change the status of order with orderid in the database

  $conn = db_connect();
  $query = "update orders
             set order_status='" . $conn->real_escape_string($status) . "'
             where orderid=" . $conn->real_escape_string($orderid);
  $result = @$conn->query($query);
  if (!$result) {
    return false;
  } else {
    $query = "update order_items
    set item_status='" . $conn->real_escape_string($status) . "'
    where orderid=" . $conn->real_escape_string($orderid);
    $result = @$conn->query($query);
    if (!$result)
      return false;
    else
      return true;
  }
}

function get_order_details($catid)
{
  $conn = db_connect();
  $query = "select * from order_items,foods
             where foods.foodid=order_items.foodid and
            catid=" . $conn->real_escape_string($catid);
  $result = @$conn->query($query);
  $num_cats = @$result->num_rows;
  if ($num_cats == 0) {
    return false;
  }
  $result = db_result_to_array($result);
  return $result;
}

function get_order_id_by_matching_order_items_name($key)
{
  $conn = db_connect();
  $query = "select distinct orders.orderid from order_items,orders,foods
             where foods.foodid=order_items.foodid and orders.orderid=order_items.orderid and
            foods.title like '%" . $conn->real_escape_string($key) . "%'";
  $result = @$conn->query($query);
  if (!$result) {
    return false;
  }
  $result = db_result_to_array($result);
  return $result;
}

function get_order_details_by_orderid($orderid)
{
  $conn = db_connect();
  $query = "select * from orders
             where orderid=" . $conn->real_escape_string($orderid);
  $result = @$conn->query($query);
  if (!$result) {
    return false;
  }
  $result = $result->fetch_assoc();
  return $result;
}

function get_order_details_cust($customerid)
{
  $conn = db_connect();
  $query = "select * from orders
             where ship_customerid=" . $conn->real_escape_string($customerid);
  $result = @$conn->query($query);
  $num_cats = @$result->num_rows;
  if ($num_cats == 0) {
    return false;
  }
  $result = db_result_to_array($result);
  return $result;
}

function get_order_items($orderid)
{
  $conn = db_connect();
  $query = "select * from order_items
             where orderid=" . $conn->real_escape_string($orderid);
  $result = @$conn->query($query);
  $num_cats = @$result->num_rows;
  if ($num_cats == 0) {
    return false;
  }
  $result = db_result_to_array($result);
  return $result;
}

function display_each_orders($food)
{
  echo "<table><tr>";
  //display the picture if there is one
  if (@file_exists("images/{$food['foodid']}.jpg")) {
    $size = GetImageSize("images/{$food['foodid']}.jpg");
    if (($size[0] > 0) && ($size[1] > 0)) {
      echo "<td><img src=\"images/" . htmlspecialchars($food['foodid']) . ".jpg\"
              height=\"125px\" style=\"border: 1px solid black\"/></td>";
    }
  }
  $order_array = get_order_details_by_orderid($food['orderid']);
  echo "<td><ul>";
  echo "<li><strong>Name:</strong> ";
  echo htmlspecialchars($food['title']);
  echo "</li><li><strong>Order id:</strong> ";
  echo htmlspecialchars($food['orderid']);
  echo "</li><li><strong>Item sold price:</strong> ";
  echo htmlspecialchars($food['item_price']);
  echo "</li><li><strong>Date:</strong> ";
  echo htmlspecialchars($order_array['date']);
  echo "</li><li><strong>Buyer Name:</strong> ";
  echo htmlspecialchars($order_array['ship_name']);
  echo "</li><li><strong>Buyer Student ID:</strong> ";
  echo htmlspecialchars($order_array['ship_customerid']);
  echo "</li><li><strong>Buyer Address:</strong> ";
  echo htmlspecialchars($order_array['ship_dormitory']);
  echo "</li><li><strong>Status:</strong> ";
  echo htmlspecialchars($food['item_status']);
  echo "</li></ul></td></tr><td>";
?>
  <form align="right" method="post" action="show_order.php?catid=<?php echo $food['catid']; ?>">
    <input type="hidden" name="foodid" value="<?php echo $food['foodid']; ?>">
    <input type="hidden" name="orderid" value="<?php echo $food['orderid']; ?>">
    Handle Orders:
    <select name="status">
      <option value="ACCEPT" <?php if ($food['item_status'] == 'ACCEPT') echo "hidden"; ?>>ACCEPT</option>
      <option value="DONE" <?php if ($food['item_status'] == 'DONE') echo "hidden"; ?>>DONE</option>
      <option value="CANCEL" <?php if ($food['item_status'] == 'CANCEL') echo "hidden"; ?>>CANCEL</option>
    </select>
    <input type="submit" value="Change">
  </form>
  </td>
  </table>
  <hr/>
  <?php
}

function display_orders($food_array)
{
  if (!is_array($food_array)) {
    echo "<p>No orders currently available in this merchant</p>";
  } else {
  ?>
    <form align="right" method="get" action="show_order.php">
      <input type="hidden" name="catid" value="<?php echo $_GET['catid']; ?>">
      Search Orders by
      <select name="way">
        <option value="foodname">Food Name</option>
        <option value="orderid">Order ID</option>
      </select>:
      <input type="text" name="key">
      <input type="submit">
    </form>
    <h3>New Orders:</h3>
    <table width="100%" border="0">
    <?php
    //create a table row for each food
    foreach ($food_array as $food) {
      if ($food['item_status'] == "PAID") {
        if (!empty($_GET['key'])) {
          if ($_GET['way'] == "foodname" && strstr($food['title'], $_GET['key']) || $_GET['way'] == "orderid" && strstr(strval($food['orderid']), $_GET['key']))
            display_each_orders($food);
        } else {
          display_each_orders($food);
        }
      }
    }
    echo "<h3>Handling Orders:</h3>";
    foreach ($food_array as $food) {
      if ($food['item_status'] == "ACCEPT") {
        if (!empty($_GET['key'])) {
          if ($_GET['way'] == "foodname" && strstr($food['title'], $_GET['key']) || $_GET['way'] == "orderid" && strstr(strval($food['orderid']), $_GET['key']))
            display_each_orders($food);
        } else {
          display_each_orders($food);
        }
      }
    }
    echo "<h3>Handled Orders:</h3>";
    foreach ($food_array as $food) {
      if ($food['item_status'] == "DONE" || $food['item_status'] == "CANCEL") {
        if (!empty($_GET['key'])) {
          if ($_GET['way'] == "foodname" && strstr($food['title'], $_GET['key']) || $_GET['way'] == "orderid" && strstr(strval($food['orderid']), $_GET['key']))
            display_each_orders($food);
        } else {
          display_each_orders($food);
        }
      }
    }
  }

  echo "<table />";
}

function display_each_orders_cust($food)
{
  echo "<table><tr>";
  echo "<td><ul>";
  echo "<li><strong>Order ID:</strong> ";
  echo htmlspecialchars($food['orderid']);
  echo "</li><li><strong>Paid amount:</strong> ";
  echo htmlspecialchars($food['amount']);
  echo "</li><li><strong>Date:</strong> ";
  echo htmlspecialchars($food['date']);
  echo "</li><li><strong>Shipping Name:</strong> ";
  echo htmlspecialchars($food['ship_name']);
  echo "</li><li><strong>Shipping Student ID:</strong> ";
  echo htmlspecialchars($food['ship_customerid']);
  echo "</li><li><strong>Shipping Address:</strong> ";
  echo htmlspecialchars($food['ship_dormitory']);
  echo "</li><li><strong>Status:</strong> ";
  echo htmlspecialchars($food['order_status']);
  echo "</li></ul></td></tr><td>";
  echo "<a href=\"cust_show_order_items.php?orderid=" . htmlspecialchars($food['orderid']) . "\"> Check Items</a>";
    ?>
    <?php
    if ($food['order_status'] != 'CANCEL' && $food['order_status'] != 'DONE') {
    ?>
      <form align="right" method="post" action="cust_show_order.php">
        <input type="hidden" name="orderid" value="<?php echo $food['orderid']; ?>">

        Handle Orders:
        <select name="status">
          <option value="CANCEL">CANCEL</option>
          <option value="PAY" <?php if ($food['order_status'] != 'PARTIAL') echo "hidden"; ?>>PAY</option>
        </select>
        <input type="submit" value="Continue">
      </form>
    <?php
    }
    ?>
    </td>
    </table>
    <hr/>
    <?php
  }

  function display_orders_cust($food_array)
  {
    if (!is_array($food_array)) {
      echo "<p>No orders currently available in this merchant</p>";
    } else {
    ?>
      <form align="right" method="get" action="cust_show_order.php">
        Search Orders by
        <select name="way">
          <option value="foodname">Food Name</option>
          <option value="orderid">Order ID</option>
        </select>:
        <input type="text" name="key">
        <input type="submit">
      </form>
      <h3>Unpaid Orders:</h3>
      <table width="100%" border="0">
        <?php
        if (!empty($_GET['key'])) {
          if ($_GET['way'] == "foodname") {
            $order_ids = get_order_id_by_matching_order_items_name($_GET['key']);
          }
        }
        foreach ($food_array as $food) {
          if ($food['order_status'] == "PARTIAL") {
            if (!empty($_GET['key'])) {
              if ($_GET['way'] == "orderid" && strstr(strval($food['orderid']), $_GET['key']))
                display_each_orders_cust($food);
              else if ($_GET['way'] == "foodname") {
                if ($order_ids)
                  foreach ($order_ids as $orderid) {
                    if ($food['orderid'] == $orderid['orderid']) {
                      display_each_orders_cust($food);
                    }
                  }
              }
            } else {
              display_each_orders_cust($food);
            }
          }
        }
        echo "<h3>Pending Orders:</h3>";
        foreach ($food_array as $food) {
          if ($food['order_status'] == "PAID") {
            if (!empty($_GET['key'])) {
              if ($_GET['way'] == "orderid" && strstr(strval($food['orderid']), $_GET['key']))
                display_each_orders_cust($food);
              else if ($_GET['way'] == "foodname") {
                if ($order_ids)
                  foreach ($order_ids as $orderid) {
                    if ($food['orderid'] == $orderid['orderid']) {
                      display_each_orders_cust($food);
                    }
                  }
              }
            } else {
              display_each_orders_cust($food);
            }
          }
        }
        echo "<h3>Handling Orders:</h3>";
        foreach ($food_array as $food) {
          if ($food['order_status'] == "ACCEPT" || $food['order_status'] == "MIX") {
            if (!empty($_GET['key'])) {
              if ($_GET['way'] == "orderid" && strstr(strval($food['orderid']), $_GET['key']))
                display_each_orders_cust($food);
              else if ($_GET['way'] == "foodname") {
                if ($order_ids)
                  foreach ($order_ids as $orderid) {
                    if ($food['orderid'] == $orderid['orderid']) {
                      display_each_orders_cust($food);
                    }
                  }
              }
            } else {
              display_each_orders_cust($food);
            }
          }
        }
        echo "<h3>History Orders:</h3>";
        foreach ($food_array as $food) {
          if ($food['order_status'] == "DONE" || $food['order_status'] == "CANCEL") {
            if (!empty($_GET['key'])) {
              if (strstr(strval($food['orderid']), $_GET['key']))
                display_each_orders_cust($food);
              else if ($_GET['way'] == "foodname") {
                if ($order_ids)
                  foreach ($order_ids as $orderid) {
                    if ($food['orderid'] == $orderid['orderid']) {
                      display_each_orders_cust($food);
                    }
                  }
              }
            } else {
              display_each_orders_cust($food);
            }
          }
        }
      }

      echo "<table />";
    }

    function handle_orders_cust($orderid, $status)
    {
      // change the status of order with orderid in the database

      $conn = db_connect();
      $query = "update orders
              set order_status='" . $conn->real_escape_string($status) . "'
              where orderid=" . $conn->real_escape_string($orderid);
      $result = @$conn->query($query);
      if (!$result) {
        return false;
      } else {
        $query = "update order_items
              set item_status='" . $conn->real_escape_string($status) . "'
              where orderid=" . $conn->real_escape_string($orderid);
        $result = @$conn->query($query);
        if (!$result)
          return false;
        else {
          return true;
        }
      }
    }

    function handle_orders($foodid, $orderid, $status)
    {
      // change the status of order with orderid in the database

      $conn = db_connect();
      $query = "update order_items
              set item_status='" . $conn->real_escape_string($status) . "'
              where orderid=" . $conn->real_escape_string($orderid) . " and
              foodid=" . $conn->real_escape_string($foodid);
      $result = @$conn->query($query);
      if (!$result) {
        return false;
      } else {
        $query = "select item_status from order_items
              where orderid=" . $conn->real_escape_string($orderid);
        $result = @$conn->query($query);
        if (!$result)
          return false;
        else if ($result->num_rows == 1) {
        } else {
          $rowsnum = $result->num_rows;
          $result = db_result_to_array($result);
          $count = 0;
          foreach ($result as $row) {
            if ($row['item_status'] == $status)
              $count++;
          }
          if ($count == $rowsnum) {
          } else {
            $status = "MIX";
          }
        }
        $query = "update orders
      set order_status='" . $conn->real_escape_string($status) . "'
      where orderid=" . $conn->real_escape_string($orderid);
        $result = @$conn->query($query);
        if (!$result)
          return false;
        else
          return true;
      }
    }

    function display_order_items($items_array)
    {
      // display items in shopping cart
      // optionally allow changes (true or false)
      // optionally include images (1 - yes, 0 - no)
      echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\">
       <tr><th colspan=\"2\" bgcolor=\"#E7AEA0\"></th>
       <th bgcolor=\"#E7AEA0\">Action</th>
       <th bgcolor=\"#E7AEA0\">Restaurant</th>
       <th bgcolor=\"#E7AEA0\">Price</th>
       <th bgcolor=\"#E7AEA0\">Status</th>
       <th bgcolor=\"#E7AEA0\">Quantity</th>
       <th bgcolor=\"#E7AEA0\">Total</th>
       </tr>";
      $total_price = 0.00;
      //display each item as a table row
      foreach ($items_array as $item) {
        $total_price += $item['item_price'] * $item['quantity'];
        $food = get_food_details($item['foodid']);
        echo "<tr>";

        echo "<td align=\"left\">";
        if (file_exists("images/{$item['foodid']}.jpg")) {
          $size = GetImageSize("images/{$item['foodid']}.jpg");
          if (($size[0] > 0) && ($size[1] > 0)) {
            echo "<img src=\"images/" . htmlspecialchars($item['foodid']) . ".jpg\"
                  style=\"border: 1px solid black\"
                  height=\"42px\"/>";
          }
        } else {
          echo "&nbsp;";
        }
        echo "</td>";

        echo "<td align=\"left\">
        <a href=\"show_food.php?foodid=" . urlencode($item['foodid']) . "\">" . htmlspecialchars($food['title']) . "</a></td>";
        if ($item['item_status'] != 'CANCEL' && $item['item_status'] != 'DONE') {
        ?> <td align="center">
            <form method="post" action="cust_show_order_items.php?orderid=<?php echo $_GET['orderid']; ?>">
              <input type="hidden" name="foodid" value="<?php echo $item['foodid']; ?>">
              <input type="submit" value="Cancel">
            </form>
      <?php
        } else {
          echo "<td></td>";
        }
        echo "<td align=\"center\">" . htmlspecialchars($food['rest']) . "</td>
        <td align=\"center\">￥" . number_format($item['item_price'], 2) . "</td>
        <td align=\"center\">" . htmlspecialchars($item['item_status']) . "</td>
        <td align=\"center\">";

        echo $item['quantity'];
        echo "</td><td align=\"center\">￥" . number_format($item['item_price'] * $item['quantity'], 2) . "</td></tr>\n";
      }
      // display total row
      echo "<tr>
      <th colspan=\"7\" bgcolor=\"#E7AEA0\">&nbsp;</th>
      <th align=\"center\" bgcolor=\"#E7AEA0\">
          ￥" . number_format($total_price, 2) . "
      </th>
      </tr>";
    }
