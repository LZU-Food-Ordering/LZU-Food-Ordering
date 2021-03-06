<?php

function do_html_header($title = '', $extra = '')
{
  // print an HTML header

  // declare the session variables we want access to inside the function
  if (empty($_SESSION['items'])) {
    $_SESSION['items'] = '0';
  }
  if (empty($_SESSION['total_price'])) {
    $_SESSION['total_price'] = '0.00';
  }
?>
  <html>

  <head>
    <title><?php echo htmlspecialchars($title); ?></title>
    <style>
      h2 {
        text-align: center;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 22px;
        color: orange;
        margin: 6px
      }

      table {
        margin: auto;
      }

      input,
      select,
      textarea {
        padding: 3px;
        border: 1px solid #ccc;
        border-radius: 4px;
        resize: vertical;
      }

      input[type=submit] {
        background-color: #4CAF50;
        color: white;
        padding: 3px 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
      }

      input[type=submit]:hover {
        background-color: #45a049;
      }

      button {
        background-color: #f44336;
        /* Green */
        border: none;
        color: white;
        border-radius: 10px;
        padding: 10px 16px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 13px;
        margin: 4px 2px;
        cursor: pointer;
        -webkit-transition-duration: 0.4s;
        /* Safari */
        transition-duration: 0.4s;
      }

      button:hover {
        box-shadow: 0 12px 16px 0 rgba(0, 0, 0, 0.24), 0 17px 50px 0 rgba(0, 0, 0, 0.19);
      }

      body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 13px
      }

      li,
      td {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 13px
      }

      hr {
        color: #BE4D30;
        width: 70%;
        text-align: center
      }

      a {
        font-family: 'Helvetica Neue', 'Helvetica', Arial, 'Hiragino Sans GB', 'Microsoft YaHei', sans-serif;
        text-decoration: none;
        -webkit-transition: color 1s, text-decoration 1s;
        transition: color 1s, text-decoration 1s;
      }

      a,
      a:visited {
        color: #009bdf;
      }

      a:hover,
      a:focus,
      a:active {
        color: rgb(147, 195, 199);
      }

      img {
        transition: opacity 1s, filter 1s, transform 1s, box-shadow 1s;
      }

      img:hover {
        transform: scale(1.1);
        box-shadow: 0px 0px 2px 2px #C0C1C0;
      }

      #title-head {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 60px;
        color: red;
        text-decoration: none;
      }

      #user_logo {
        width: 100px;
      }
    </style>
  </head>

  <body>
    <table width="100%" border="0" cellspacing="0" bgcolor="#E7AEA0">
      <tr>
        <td rowspan="2">
          <a id="title-head" href="index.php">兰大点餐平台</a>
        </td>
        <td align="right" valign="bottom">
          <?php
          if (isset($_SESSION['cust_user'])) {
            display_button('edit_cust_form.php', 'Update Details');
            display_button('cust_show_order.php', 'View Your Orders');
          }
          if (isset($_SESSION['admin_user'])) {
            echo "&nbsp;";
          } else if (isset($_SESSION['cust_user'])) {
            echo "Total Items = " . htmlspecialchars($_SESSION['items']);
          }
          ?>
        </td>
        <td align="right" rowspan="2" width="135">
          <?php
          if ($extra == 'admin') {
            if (isset($_SESSION['admin_user']) || isset($_SESSION['rest_user'])) {
              display_button('logout.php', 'Log Out');
            } else if (isset($_SESSION['cust_user'])) {
              display_button('logout_cust.php', 'Log Out');
              display_button('show_cart.php', 'View Your Shopping Cart');
            } else {
              display_button('login.php', 'Log In');
            }
          } else {
            if (isset($_SESSION['admin_user']) || isset($_SESSION['rest_user'])) {
              display_button('logout.php', 'Log Out');
            } else if (isset($_SESSION['cust_user'])) {
              display_button('logout_cust.php', 'Log Out');
              display_button('show_cart.php', 'View Your Shopping Cart');
            } else {
              display_button('cust_signup_form.php', 'Sign Up');
              display_button('cust_login.php', 'Log In');
            }
          }
          ?>
      </tr>
      <tr>
        <td align="right" valign="top">
          <?php
          if (isset($_SESSION['admin_user'])) {
            echo "&nbsp;";
          } else if (isset($_SESSION['cust_user'])) {
            echo "Total Price = ￥" . number_format($_SESSION['total_price'], 2);
          }
          ?>
        </td>
      </tr>
    </table>
    <?php
    if ($title) {
      do_html_heading($title);
    }
  }



  function do_html_footer()
  {
    // print an HTML footer
    ?>
    <footer>
      <p align="center">Copyright &copy; LZU Food Ordering Team @LZU-Food-Ordering</p>
    </footer>
  </body>

  </html>
<?php
  }

  function do_html_heading($heading)
  {
    // print heading
?>
  <h2><?php echo htmlspecialchars($heading); ?></h2>
<?php
  }

  function do_html_URL($url, $name)
  {
    // output URL as link and br
?>
  <a href="<?php echo htmlspecialchars($url); ?>"><?php echo $name; ?></a><br />
<?php
  }

  function display_merchants($cat_array)
  {
    //display all foods in the array passed in
    if (!is_array($cat_array)) {
      echo "<p>No restaurant currently available!</p>";
    } else {
      //create table
      echo "<table width=\"100%\" border=\"0\">";

      //create a table row for each food
      foreach ($cat_array as $row) {
        $url = "show_cat.php?catid=" . urlencode($row['catid']);
        echo "<tr><td>";
        if (@file_exists("images/res{$row['catid']}.jpg")) {
          $title = "<img src=\"images/res" . htmlspecialchars($row['catid']) . ".jpg\"
title=\"Name: " . htmlspecialchars($row['catname']) . " 
Phone: " . htmlspecialchars($row['phone']) . "
Address: " . htmlspecialchars($row['address']) . "\"
                  height=\"60px\" style=\"border: 1px solid black\"/>";
          do_html_url($url, $title);
        } else {
          echo "&nbsp;";
        }
        echo "</td><td>";
        $title = htmlspecialchars($row['catname']);
        do_html_url($url, $title);
        echo "</td></tr>";
      }

      echo "</table>";
    }

    echo "<hr />";
  }

  function display_recommend_merchants($cat_array)
  {
    //display all foods in the array passed in
    if (!is_array($cat_array)) {
      echo "<p>No restaurant currently available!</p>";
    } else {
      //create table
      echo "<table width=\"100%\" border=\"0\">";

      //create a table row for each food
      foreach ($cat_array as $row) {
        if ($row['recommend'] == 1) {
          $url = "show_cat.php?catid=" . urlencode($row['catid']);
          echo "<tr><td>";
          if (@file_exists("images/res{$row['catid']}.jpg")) {
            $title = "<img src=\"images/res" . htmlspecialchars($row['catid']) . ".jpg\"
title=\"Name: " . htmlspecialchars($row['catname']) . " 
Phone: " . htmlspecialchars($row['phone']) . "
Address: " . htmlspecialchars($row['address']) . "\"
                    height=\"60px\" style=\"border: 1px solid black\"/>";
            do_html_url($url, $title);
          } else {
            echo "&nbsp;";
          }
          echo "</td><td>";
          $title = htmlspecialchars($row['catname']);
          do_html_url($url, $title);
          echo "</td></tr>";
        }
      }

      echo "</table>";
    }

    echo "<hr />";
  }

  function action_on_merchants($cat_array, $action)
  {
    //display all foods in the array passed in
    if (!is_array($cat_array)) {
      echo "<p>No restaurant currently available!</p>";
    } else {
      //create table
      echo "<table width=\"100%\" border=\"0\">";

      //create a table row for each food
      foreach ($cat_array as $row) {
        $url = $action . ".php?catid=" . urlencode($row['catid']);
        echo "<tr><td>";
        if (@file_exists("images/res{$row['catid']}.jpg")) {
          $title = "<img src=\"images/res" . htmlspecialchars($row['catid']) . ".jpg\"
title=\"Name: " . htmlspecialchars($row['catname']) . " 
Phone: " . htmlspecialchars($row['phone']) . "
Address: " . htmlspecialchars($row['address']) . "\"
height=\"60px\" style=\"border: 1px solid black\"/>";
          do_html_url($url, $title);
        } else {
          echo "&nbsp;";
        }
        echo "</td><td>";
        $title = htmlspecialchars($row['catname']);
        do_html_url($url, $title);
        echo "</td></tr>";
      }

      echo "</table>";
    }

    echo "<hr />";
  }

  function display_cust_form($cust_array)
  {
    // This displays the customer form.
    // most of the form is in plain HTML with some
    // optional PHP bits throughout
?>
  <form method="post" action="edit_cust.php">
    <table border="0">
      <tr>
        <td>Student Card ID:</td>
        <td><input type="text" name="customerid" hidden="true" value="<?php echo htmlspecialchars($cust_array['customerid']); ?>" />
          <?php echo htmlspecialchars($cust_array['customerid']); ?></td>
      </tr>
      <tr>
        <td>Name:</td>
        <td><input type="text" required="true" name="name" value="<?php echo htmlspecialchars($cust_array['name']); ?>" /></td>
      </tr>
      <tr>
        <td>Delivery Address:</td>
        <td><input type="text" required="true" name="dormitory" value="<?php echo htmlspecialchars($cust_array['dormitory']); ?>" /></td>
      </tr>
      <tr>
        <td>Sex:</td>
        <td>
          <select name="sex">
            <option value="0" <?php if ($cust_array['sex'] == 0) echo "selected" ?>>--Please Select--</option>
            <option value="1" <?php if ($cust_array['sex'] == 1) echo "selected" ?>>Male</option>
            <option value="2" <?php if ($cust_array['sex'] == 2) echo "selected" ?>>Female</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>Age:</td>
        <td><input type="number" name="age" min="0" max="200" value="<?php echo htmlspecialchars($cust_array['age']); ?>" /></td>
      </tr>
      <tr>
        <td>Phone:</td>
        <td><input type="number" required="true" min="10000000000" max="999999999999" name="phone" value="<?php echo htmlspecialchars($cust_array['phone']); ?>" /></td>
      </tr>
      <tr>
        <td>QQ:</td>
        <td><input type="number" name="qq" min="100" max="9999999999999" value="<?php echo htmlspecialchars($cust_array['qq']); ?>" /></td>
      </tr>
      <tr>
        <td>Email:</td>
        <td><input type="email" name="email" value="<?php echo htmlspecialchars($cust_array['email']); ?>" /></td>
      </tr>
      <tr>
        <td><input type="submit" value="Update" /></td>
      </tr>
    </table>
  </form>
  <?php if (isset($_SESSION['admin_user'])) {
  ?>
    <form method="post" action="edit_cust.php">
      <tr>
        <td><input type="hidden" name="de_id" value=<?php echo $cust_array['customerid'] ?>></td>
      </tr>
      <tr>
        <td><input type="submit" value="Delete" /></td>
      </tr>
    </form>
  <?php
    }
  }

  function display_cust_signup_form()
  {
    // This displays the customer form.
    // most of the form is in plain HTML with some
    // optional PHP bits throughout
  ?>
  <form method="post" action="cust_signup.php">
    <table border="0">
      <tr>
        <td>Student Card ID:</td>
        <td><input type="text" name="customerid" required="true" oninput="value=value.replace(/[^\d]/g,'')" maxlength="12" value="" /></td>
      </tr>
      <tr>
        <td>Name:</td>
        <td><input type="text" required="true" name="name" value="" /></td>
      </tr>
      <tr>
        <td>Password:</td>
        <td><input type="password" required="true" name="password" value="" /></td>
      </tr>
      <tr>
        <td>Delivery Address:</td>
        <td><input type="text" required="true" name="dormitory" value="" /></td>
      </tr>
      <tr>
        <td>Sex:</td>
        <td>
          <select name="sex">
            <option value="0">--Please Select--</option>
            <option value="1">Male</option>
            <option value="2">Female</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>Age:</td>
        <td><input type="number" min="0" max="200" name="age" value="" /></td>
      </tr>
      <tr>
        <td>Phone:</td>
        <td><input type="number" min="10000000000" max="999999999999" required="true" name="phone" value="" /></td>
      </tr>
      <tr>
        <td>QQ:</td>
        <td><input type="number" min="100" max="9999999999999" name="qq" value="" /></td>
      </tr>
      <tr>
        <td>Email:</td>
        <td><input type="email" name="email" value="" /></td>
      </tr>
      <tr>
        <td><input type="submit" value="Sign Up" /></td>
      </tr>
    </table>
  </form>
<?php
  }

  function display_foods($food_array)
  {
    //display all foods in the array passed in
    if (!empty($_GET['key']) && !is_array($food_array)) {
      echo "<p>No foods currently available with the keyword: " . $_GET['key'] . "</p>";
    } else if (!is_array($food_array)) {
      echo "<p>No foods currently available in this merchant</p>";
    } else {
      echo "
      <form  align=\"right\" method=\"get\" action=\"show_cat.php\">
      Search Food:
      <input type=\"hidden\" name=\"catid\" value=\"" . $_GET['catid'] . "\">
      <input type=\"text\" name=\"key\">
      <input type=\"submit\">
      </form>";
      //create table
      echo "<table width=\"100%\" border=\"0\">";

      //create a table row for each food
      foreach ($food_array as $row) {
        $url = "show_food.php?foodid=" . urlencode($row['foodid']);
        echo "<tr><td>";
        if (@file_exists("images/{$row['foodid']}.jpg")) {
          $title = "<img src=\"images/" . htmlspecialchars($row['foodid']) . ".jpg\"
                  height=\"125\" style=\"border: 1px solid black\"/>";
          do_html_url($url, $title);
        } else {
          echo "&nbsp;";
        }
        echo "</td><td>";
        $title = htmlspecialchars($row['title']) . " by " . htmlspecialchars($row['rest']);
        do_html_url($url, $title);
        echo "</td></tr>";
      }

      echo "</table>";
    }

    echo "<hr />";
  }

  function display_food_details($food)
  {
    // display all details about this food
    if (is_array($food)) {
      echo "<table><tr>";
      //display the picture if there is one
      if (@file_exists("images/{$food['foodid']}.jpg")) {
        $size = GetImageSize("images/{$food['foodid']}.jpg");
        if (($size[0] > 0) && ($size[1] > 0)) {
          echo "<td><img src=\"images/" . htmlspecialchars($food['foodid']) . ".jpg\"
              height=\"125px\" style=\"border: 1px solid black\"/></td>";
        }
      }
      echo "<td><ul>";
      echo "<li><strong>Name:</strong> ";
      echo htmlspecialchars($food['title']);
      echo "</li><li><strong>Stock:</strong> ";
      echo htmlspecialchars($food['stock']);
      echo "</li><li><strong>Sold:</strong> ";
      echo htmlspecialchars(get_sold_amount($food['foodid']));
      echo "</li><li><strong>Provided by:</strong> ";
      echo htmlspecialchars($food['rest']);
      echo "</li><li><strong>Our Price:</strong> ";
      echo number_format($food['price'], 2);
      echo "</li><li><strong>Description:</strong> ";
      echo htmlspecialchars($food['description']);
      echo "</li><li><strong>Status:</strong> ";
      if ($food['status'] == 1) {
        echo "Available";
      } else {
        echo "Unavailable";
      }
      echo "</li></ul></td></tr></table>";
    } else {
      echo "<p>The details of this food cannot be displayed at this time.</p>";
    }
    echo "<hr />";
  }

  function display_checkout_form($cust_details)
  {
    //display the form that asks for name and address
?>
  <br />
  <table border="0" width="100%" cellspacing="0">
    <form action="purchase.php" method="post">
      <tr>
        <th colspan="2" bgcolor="#E7AEA0">Your Details</th>
      </tr>
      <tr>
        <td align=center> Name</td>
        <td><input type="text" name="name" value="<?php echo $cust_details['name']; ?>" maxlength="40" size="40" /></td>
      </tr>
      <tr>
        <td align=center>Student Card</td>
        <td><input type="text" name="customerid" value="<?php echo $cust_details['customerid']; ?>" maxlength="40" size="40" /></td>
      </tr>
      <tr>
        <td align=center>Delivery Address</td>
        <td><input type="text" name="dormitory" value="<?php echo $cust_details['dormitory']; ?>" maxlength="20" size="40" /></td>
      </tr>

      <td colspan="2" align="center">
        <p><strong>Please press Purchase to confirm
            your purchase, or Continue Shopping to add or remove items.</strong></p>
        <?php display_form_button("Purchase These Items"); ?>
      </td>
      </tr>
    </form>
  </table>
  <hr />
<?php
  }

  function display_pay_form($orderid)
  {
    //display form asking for credit card details
?>
  <table border="0" width="100%" cellspacing="0">
    <form action="process.php" method="post">
      <tr>
        <th colspan="2" bgcolor="#E7AEA0">Payment Details</th>
      </tr>
      <tr>
        <td>Type</td>
        <td><select name="pay_type">
            <option value="Wechat Pay">Wechat Pay</option>
            <option value="Alipay">Alipay</option>
          </select>
        </td>
      </tr>
      <tr>
        <td colspan="2" align="center">
          <input type="hidden" name="orderid" value="<?php echo $orderid; ?>">
          <p><strong>Please press Purchase to confirm your purchase.</strong></p>
          <?php display_form_button('Purchase These Items'); ?>
        </td>
      </tr>
  </table>
<?php
  }

  function display_cart($cart, $change = true, $images = 1)
  {
    // display items in shopping cart
    // optionally allow changes (true or false)
    // optionally include images (1 - yes, 0 - no)

    echo "<table border=\"0\" width=\"100%\" cellspacing=\"0\">
         <form action=\"show_cart.php\" method=\"post\">
         <tr><th colspan=\"" . (1 + $images) . "\" bgcolor=\"#E7AEA0\"></th>
         <th bgcolor=\"#E7AEA0\">Restaurant</th>
         <th bgcolor=\"#E7AEA0\">Price</th>
         <th bgcolor=\"#E7AEA0\">Quantity</th>
         <th bgcolor=\"#E7AEA0\">Total</th>
         </tr>";

    //display each item as a table row
    foreach ($cart as $foodid => $qty) {
      $food = get_food_details($foodid);
      echo "<tr>";


      if ($images == true) {
        echo "<td align=\"left\">";
        if (file_exists("images/{$foodid}.jpg")) {
          $size = GetImageSize("images/{$foodid}.jpg");
          if (($size[0] > 0) && ($size[1] > 0)) {
            echo "<img src=\"images/" . htmlspecialchars($foodid) . ".jpg\"
                  style=\"border: 1px solid black\"
                  height=\"42px\"/>";
          }
        } else {
          echo "&nbsp;";
        }
        echo "</td>";
      }


      echo "<td align=\"left\">
          <a href=\"show_food.php?foodid=" . urlencode($foodid) . "\">" . htmlspecialchars($food['title']) . "</a></td>
          <td align=\"center\">" . htmlspecialchars($food['rest']) . "</td>
          <td align=\"center\">￥" . number_format($food['price'], 2) . "</td>
          <td align=\"center\">";

      // if we allow changes, quantities are in text boxes
      if ($change == true) {
        echo "<input type=\"number\" name=\"" . htmlspecialchars($foodid) . "\" value=\"" . htmlspecialchars($qty) . "\" min=0 max=\"" . htmlspecialchars(get_stock($food['foodid'])) . "\" size=\"3\">";
      } else {
        echo $qty;
      }
      echo "</td><td align=\"center\">￥" . number_format($food['price'] * $qty, 2) . "</td></tr>\n";
    }
    // display total row
    echo "<tr>
        <th colspan=\"" . (4 + $images) . "\" bgcolor=\"#E7AEA0\">&nbsp;</th>
        <th align=\"center\" bgcolor=\"#E7AEA0\">
            ￥" . number_format($_SESSION['total_price'], 2) . "
        </th>
        </tr>";

    // display save change button
    if ($change == true) {
      echo "<tr>
          <td colspan=\"" . (2) . "\">&nbsp;</td>
          
          <td>&nbsp;</td>
          </tr></table>
          <div align=\"right\">
          <input type=\"hidden\" name=\"save\" value=\"true\"/>
          <input type=\"submit\" value=\"Save Changes\"/>
          </div>";
    }
    echo "</form>";
  }


  function display_login_form()
  {
    // dispaly form asking for name and password
?>
  <form method="post" action="admin.php">
    <table bgcolor="#E7AEA0">
      <tr>
        <td>Username:</td>
        <td><input type="text" name="username" /></td>
      </tr>
      <tr>
        <td>Password:</td>
        <td><input type="password" name="passwd" /></td>
      </tr>
      <tr>
        <td><input type="radio" name="category" value="admin" /> Administrator</td>
      </tr>
      <tr>
        <td><input type="radio" name="category" value="rest" checked /> Restaurant</td>
      </tr>
      <tr>
        <td colspan="2" align="center">
          <input type="submit" value="Log in" /></td>
      </tr>
      <tr>
    </table>
  </form>
<?php
  }

  function display_login_form_cust()
  {
    // dispaly form asking for name and password
?>
  <form method="post" action="cust.php">
    <table bgcolor="#E7AEA0">
      <tr>
        <td>Student Card ID:</td>
        <td><input type="number" min="1" max="999999999999" name="customerid" /></td>
      </tr>
      <tr>
        <td>Password:</td>
        <td><input type="password" name="passwd" /></td>
      </tr>
      <tr>
        <td colspan="2" align="center">
          <input type="submit" value="Log in" /></td>
      </tr>
      <tr>
    </table>
  </form>
<?php
  }

  function display_admin_menu()
  {
?>
  <br />
  <a href="index.php">Go to main site</a><br />
  <h3>Restaurant Management:</h3>
  <a href="insert_merchant_form.php">Add a new Restaurant</a><br />
  <a href="edit_merchant_form.php">Update a Restaurant</a><br />
  <a href="delete_merchant_form.php">Delete a Restaurant</a><br />
  <a href="cust_manage_form.php">
    <h3>Customer Management</h3>
  </a>
  <h3>Food Management:</h3>
  <a href="insert_food_form.php">Add a new food</a><br />
  <a href="index.php">Update, Delete food</a><br /><br />
  <a href="change_password_form.php">Change admin password</a><br />
<?php
  }

  function display_rest_menu()
  {
?>
  <br />
  <a href="index.php">Go to main site</a><br />
  <a href="edit_merchant_form.php">Edit your information</a><br />
  <h3>Food Management:</h3>
  <a href="insert_food_form.php">Add a new food</a><br />
  <?php
    $conn = db_connect();
    $query = "select catid from merchants where catname='" . $_SESSION['rest_user'] . "'";
    $catid = $conn->query($query)->fetch_object()->catid;
  ?>
  <a href="show_cat.php?catid=<?php echo $catid; ?>">Update, Delete food</a><br />
  <a href="show_order.php?catid=<?php echo $catid; ?>">
    <h3>Order Management</h3>
  </a>
  <a href="change_password_form.php">Change your password</a><br />
<?php
  }

  function display_button($target, $alt)
  {
    echo "<div align=\"right\"><a href=\"" . htmlspecialchars($target) . "\">
          <button type=\"button\">" . htmlspecialchars($alt) . "</button></a></div>";
  }

  function display_form_button($alt)
  {
    echo "<div align=\"right\"><input type=\"submit\"
           value=\"" . htmlspecialchars($alt) . "\"/></div>";
  }

?>