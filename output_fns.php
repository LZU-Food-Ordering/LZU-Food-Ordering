<?php

function do_html_header($title = '')
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
        font-family: Arial, Helvetica, sans-serif;
        font-size: 22px;
        color: red;
        margin: 6px
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
        color: #FF0000;
        width: 70%;
        text-align: center
      }

      a {
        color: #000000
      }
    </style>
  </head>

  <body>
    <table width="100%" border="0" cellspacing="0" bgcolor="#cccccc">
      <tr>
        <td rowspan="2">
          <a href="index.php"><img src="images/LZU-food-ordering.jpg" alt="foodorama" border="0" align="left" valign="bottom" height="55" width="325" /></a>
        </td>
        <td align="right" valign="bottom">
          <?php
          if (isset($_SESSION['cust_user'])) {
            display_button('edit_cust_form.php', 'edit-cust', 'Update Details');
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
          if (isset($_SESSION['admin_user'])) {
            display_button('logout.php', 'log-out', 'Log Out');
          } else if (isset($_SESSION['cust_user'])) {
            display_button('logout_cust.php', 'log-out', 'Log Out');
            display_button('show_cart.php', 'view-cart', 'View Your Shopping Cart');
          } else {
            display_button('cust_signup_form.php', 'sign-up', 'Sign Up');
            display_button('cust_login.php', 'log-in', 'Log In');
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
          <select name="sex" default="<?php echo htmlspecialchars($cust_array['sex']); ?>">
            <option value ="0">--Please Select--</option>
            <option value ="1">Male</option>
            <option value ="2">Female</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>Age:</td>
        <td><input type="number" name="age" value="<?php echo htmlspecialchars($cust_array['age']); ?>" /></td>
      </tr>
      <tr>
        <td>Phone:</td>
        <td><input type="number" required="true" name="phone" value="<?php echo htmlspecialchars($cust_array['phone']); ?>" /></td>
      </tr>
      <tr>
        <td>QQ:</td>
        <td><input type="number" name="qq" value="<?php echo htmlspecialchars($cust_array['qq']); ?>" /></td>
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
  <?php if(isset($_SESSION['admin_user'])){
    ?>
    <form method="post" action="edit_cust.php">
    <tr>
      <td><input type="hidden" name="de_id" value=<?php echo $cust_array['customerid']?>></td>
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
        <td><input type="text" name="customerid" required="true" oninput = "value=value.replace(/[^\d]/g,'')" maxlength="12" value="" /></td>
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
          <select name="sex" default="0">
            <option value ="0">--Please Select--</option>
            <option value ="1">Male</option>
            <option value ="2">Female</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>Age:</td>
        <td><input type="number" name="age" value="" /></td>
      </tr>
      <tr>
        <td>Phone:</td>
        <td><input type="number" required="true" name="phone" value="" /></td>
      </tr>
      <tr>
        <td>QQ:</td>
        <td><input type="number" name="qq" value="" /></td>
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
      echo htmlspecialchars($food['rest']);
      echo "</li><li><strong>Stock:</strong> ";
      echo htmlspecialchars($food['stock']);
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

  function display_checkout_form()
  {
    //display the form that asks for name and address
?>
  <br />
  <table border="0" width="100%" cellspacing="0">
    <form action="purchase.php" method="post">
      <tr>
        <th colspan="2" bgcolor="#cccccc">Your Details</th>
      </tr>
      <tr>
        <td align=center> Name</td>
        <td><input type="text" name="name" value="" maxlength="40" size="40" /></td>
      </tr>
      <tr>
        <td align=center>Student Card</td>
        <td><input type="text" name="customerid" value="" maxlength="40" size="40" /></td>
      </tr>
      <tr>
        <td align=center>dormitory</td>
        <td><input type="text" name="dormitory" value="" maxlength="20" size="40" /></td>
      </tr>

      <td colspan="2" align="center">
        <p><strong>Please press Purchase to confirm
            your purchase, or Continue Shopping to add or remove items.</strong></p>
        <?php display_form_button("purchase", "Purchase These Items"); ?>
      </td>
      </tr>
    </form>
  </table>
  <hr />
<?php
  }

  function display_shipping($shipping)
  {
    // display table row with shipping cost and total price including shipping
?>
  <table border="0" width="100%" cellspacing="0">
    <tr>
      <td align="left">Shipping</td>
      <td align="right"> <?php echo number_format($shipping, 2); ?></td>
    </tr>
    <tr>
      <th bgcolor="#cccccc" align="left">TOTAL INCLUDING SHIPPING</th>
      <th bgcolor="#cccccc" align="right">$ <?php echo number_format($shipping + $_SESSION['total_price'], 2); ?></th>
    </tr>
  </table><br />
<?php
  }

  function display_card_form($name)
  {
    //display form asking for credit card details
?>
  <table border="0" width="100%" cellspacing="0">
    <form action="process.php" method="post">
      <tr>
        <th colspan="2" bgcolor="#cccccc">Credit Card Details</th>
      </tr>
      <tr>
        <td>Type</td>
        <td><select name="card_type">
            <option value="VISA">VISA</option>
            <option value="MasterCard">MasterCard</option>
            <option value="American Express">American Express</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>Number</td>
        <td><input type="text" name="card_number" value="" maxlength="16" size="40"></td>
      </tr>
      <tr>
        <td>AMEX code (if required)</td>
        <td><input type="text" name="amex_code" value="" maxlength="4" size="4"></td>
      </tr>
      <tr>
        <td>Expiry Date</td>
        <td>Month
          <select name="card_month">
            <option value="01">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
          </select>
          Year
          <select name="card_year">
            <?php
            for ($y = date("Y"); $y < date("Y") + 10; $y++) {
              echo "<option value=\"" . $y . "\">" . $y . "</option>";
            }
            ?>
          </select>
      </tr>
      <tr>
        <td>Name on Card</td>
        <td><input type="text" name="card_name" value="<?php echo $name; ?>" maxlength="40" size="40"></td>
      </tr>
      <tr>
        <td colspan="2" align="center">
          <p><strong>Please press Purchase to confirm your purchase, or Continue Shopping to
              add or remove items</strong></p>
          <?php display_form_button('purchase', 'Purchase These Items'); ?>
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
         <tr><th colspan=\"" . (1 + $images) . "\" bgcolor=\"#cccccc\"></th>
         <th bgcolor=\"#cccccc\">Restaurant</th>
         <th bgcolor=\"#cccccc\">Price</th>
         <th bgcolor=\"#cccccc\">Quantity</th>
         <th bgcolor=\"#cccccc\">Total</th>
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
        echo "<input type=\"text\" name=\"" . htmlspecialchars($foodid) . "\" value=\"" . htmlspecialchars($qty) . "\" size=\"3\">";
      } else {
        echo $qty;
      }
      echo "</td><td align=\"center\">￥" . number_format($food['price'] * $qty, 2) . "</td></tr>\n";
    }
    // display total row
    echo "<tr>
        <th colspan=\"" . (4 + $images) . "\" bgcolor=\"#cccccc\">&nbsp;</th>
        <th align=\"center\" bgcolor=\"#cccccc\">
            ￥" . number_format($_SESSION['total_price'], 2) . "
        </th>
        </tr>";

    // display save change button
    if ($change == true) {
      echo "<tr>
          <td colspan=\"" . (2) . "\">&nbsp;</td>
          
          <td>&nbsp;</td>
          </tr>";
    }
    echo "</form></table>";
    echo "<div align=\"right\">
        <input type=\"hidden\" name=\"save\" value=\"true\"/>
        <input type=\"image\" src=\"images/save-changes.gif\"
        border=\"0\" alt=\"Save Changes\"/>
        </div>";
  }


  function display_login_form()
  {
    // dispaly form asking for name and password
?>
  <form method="post" action="admin.php">
    <table bgcolor="#cccccc">
      <tr>
        <td>Username:</td>
        <td><input type="text" name="username" /></td>
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

  function display_login_form_cust()
  {
    // dispaly form asking for name and password
?>
  <form method="post" action="cust.php">
    <table bgcolor="#cccccc">
      <tr>
        <td>Student Card ID:</td>
        <td><input type="number" name="customerid" /></td>
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
  <a href="insert_merchant_form.php">Add a new Restaurant</a><br />
  <a href="edit_merchant_form.php">Update a Restaurant</a><br />
  <a href="delete_merchant_form.php">Delete a Restaurant</a><br />
  <a href="cust_manage_form.php">Customer Management</a><br />
  <a href="insert_food_form.php">Add a new food</a><br />
  <a href="change_password_form.php">Change admin password</a><br />
<?php
  }

  function display_button($target, $image, $alt)
  {
    echo "<div align=\"right\"><a href=\"" . htmlspecialchars($target) . "\">
          <img src=\"images/" . htmlspecialchars($image) . ".gif\"
           alt=\"" . htmlspecialchars($alt) . "\" border=\"0\" height=\"50\"
           width=\"135\"/></a></div>";
  }

  function display_form_button($image, $alt)
  {
    echo "<div align=\"right\"><input type=\"image\"
           src=\"images/" . htmlspecialchars($image) . ".gif\"
           alt=\"" . htmlspecialchars($alt) . "\" border=\"0\" height=\"50\"
           width=\"135\"/></div>";
  }

?>