<?php
// This file contains functions used by the admin interface
// for the LZU Food Ordering shopping cart.

function display_merchant_form($merchant = '')
{
  // This displays the merchant form.
  // This form can be used for inserting or editing merchants.
  // To insert, don't pass any parameters.  This will set $edit
  // to false, and the form will go to insert_merchant.php.
  // To update, pass an array containing a merchant.  The
  // form will contain the old data and point to update_merchant.php.
  // It will also add a "Delete merchant" button.

  // if passed an existing merchant, proceed in "edit mode"
  $edit = is_array($merchant);

  // most of the form is in plain HTML with some
  // optional PHP bits throughout
?>
  <h3>Please Confirm:</h3>
  <form method="post" action="<?php echo $edit ? 'edit_merchant.php' : 'insert_merchant.php'; ?>">
    <table border="0">
      <tr>
        <td>Restaurant Name:</td>
        <td><input type="text" name="catname" size="40" maxlength="40" value="<?php echo htmlspecialchars($edit ? $merchant['catname'] : ''); ?>" /></td>
      </tr>
      <?php
      if (check_admin_user()) {
      ?>
        <tr>
          <td>Password:</td>
          <td><input type="password" name="password" size="40" maxlength="40" value="" /></td>
        </tr>
      <?php
      }
      ?>
      <tr>
        <td>Phone:</td>
        <td><input type="number" name="phone" size="40" maxlength="40" value="<?php echo htmlspecialchars($edit ? $merchant['phone'] : ''); ?>" /></td>
      </tr>
      <tr>
        <td>Address:</td>
        <td><input type="text" name="address" size="40" maxlength="40" value="<?php echo htmlspecialchars($edit ? $merchant['address'] : ''); ?>" /></td>
      </tr>
      <?php
      if (check_admin_user()) {
      ?>
        <tr>
          <td>Recommend:</td>
          <td><select name="recommend">
              <option value="0" <?php if ($edit) if ($merchant['recommend'] == 0) echo "selected"; ?>>No</option>
              <option value="1" <?php if ($edit) if ($merchant['recommend'] == 1) echo "selected"; ?>>Yes</option>
            </select></td>
        </tr>
      <?php
      }
      ?>
      <tr>
        <td <?php if (!$edit) {
              echo "colspan=2";
            } ?> align="center">
          <?php
          if ($edit) {
            echo "<input type=\"hidden\" name=\"catid\" value=\"" . htmlspecialchars($merchant['catid']) . "\" />";
          }
          ?>
          <input type="submit" value="<?php echo $edit ? 'Update' : 'Add'; ?> Restaurant" />
  </form>
  </td>
  </tr>
  </table>
<?php
}

function delete_merchant_form()
{
?>
  <h3>Please Confirm:</h3>
  <td>
    <form method=post action=delete_merchant.php>
      <tr>
        <td>Restaurant Name:</td>
        <td><input type="text" name="catname" size="40" maxlength="40" <?php echo "value=\"" . htmlspecialchars(get_merchant_name($_GET['catid'])) . "\" />"; ?> </td> </tr> <input type=submit value="Delete Restaurant">
    </form>
  </td>
<?php
}
function display_food_form($food = '')
{
  // This displays the food form.
  // It is very similar to the merchant form.
  // This form can be used for inserting or editing foods.
  // To insert, don't pass any parameters.  This will set $edit
  // to false, and the form will go to insert_food.php.
  // To update, pass an array containing a food.  The
  // form will be displayed with the old data and point to update_food.php.
  // It will also add a "Delete food" button.


  // if passed an existing food, proceed in "edit mode"
  $edit = is_array($food);

  // most of the form is in plain HTML with some
  // optional PHP bits throughout
?>
  <form method="post" action="<?php echo $edit ? 'edit_food.php' : 'insert_food.php'; ?>">
    <table border="0">
      <tr>
        <td>Name:</td>
        <?php
        if ($edit) {
        ?>
          <input type="hidden" name="foodid" value="<?php echo htmlspecialchars($food['foodid']); ?>" />
        <?php
        }
        ?>
        <td><input type="text" name="title" value="<?php echo htmlspecialchars($edit ? $food['title'] : ''); ?>" /></td>
      </tr>
      <tr>
        <td>Stock:</td>
        <td><input type="number" name="stock" min=0 value="<?php echo htmlspecialchars($edit ? $food['stock'] : ''); ?>" /></td>
      </tr>
      <tr>
        <td>Status:</td>
        <td>
          <select name="status">
            <option value="0" <?php if ($edit) if ($food['status'] == 0) echo "selected" ?>>Unavailable</option>
            <option value="1" <?php if ($edit) if ($food['status'] == 1) echo "selected" ?>>Available</option>
          </select>
        </td>
      </tr>
      <?php
      if (check_admin_user()) {
      ?>
        <tr>
          <td>Restaurant:</td>
          <td><select name="catid">
              <?php
              // list of possible merchants comes from database
              $cat_array = get_merchants();
              foreach ($cat_array as $thiscat) {
                echo "<option value=\"" . htmlspecialchars($thiscat['catid']) . "\"";
                // if existing food, put in current catgory
                if (($edit) && ($thiscat['catid'] == $food['catid'])) {
                  echo " selected";
                }
                echo ">" . htmlspecialchars($thiscat['catname']) . "</option>";
              }
              ?>
            </select>
          </td>
        </tr>
      <?php
      } else {
        $conn = db_connect();
        $query = "select catid from merchants where catname='" . $_SESSION['rest_user'] . "'";
        $catid = $conn->query($query)->fetch_object()->catid;
        echo "<input type=\"hidden\" name=\"catid\" value=" . htmlspecialchars($catid) . ">";
      }
      ?>
      <tr>
        <td>Price:</td>
        <td><input type="number" name="price" min=0 value="<?php echo htmlspecialchars($edit ? $food['price'] : ''); ?>" /></td>
      </tr>
      <tr>
        <td>Description:</td>
        <td><textarea rows="3" cols="50" name="description"><?php echo htmlspecialchars($edit ? $food['description'] : ''); ?></textarea></td>
      </tr>
      <tr>
        <td <?php if (!$edit) {
              echo "colspan=2";
            } ?> align="center">
          <?php
          if ($edit)
            // we need the old foodid to find food in database
            // if the foodid is being updated
            echo "<input type=\"hidden\" name=\"oldfoodid\"
                    value=\"" . htmlspecialchars($food['foodid']) . "\" />";
          ?>
          <input type="submit" value="<?php echo $edit ? 'Update' : 'Add'; ?> food" />
  </form>
  </td>
  <?php
  if ($edit) {
    echo "<td>
                   <form method=\"post\" action=\"delete_food.php\">
                   <input type=\"hidden\" name=\"foodid\"
                    value=\"" . htmlspecialchars($food['foodid']) . "\" />
                   <input type=\"submit\" value=\"Delete food\"/>
                   </form></td>";
  }
  ?>
  </td>
  </tr>
  </table>
  </form>
<?php
}

function display_password_form()
{
  // displays html change password form
?>
  <br />
  <form action="change_password.php" method="post">
    <table width="250" cellpadding="2" cellspacing="0" bgcolor="#E7AEA0">
      <tr>
        <td>Old password:</td>
        <td><input type="password" name="old_passwd" size="16" maxlength="16" /></td>
      </tr>
      <tr>
        <td>New password:</td>
        <td><input type="password" name="new_passwd" size="16" maxlength="16" /></td>
      </tr>
      <tr>
        <td>Repeat new password:</td>
        <td><input type="password" name="new_passwd2" size="16" maxlength="16" /></td>
      </tr>
      <tr>
        <td colspan=2 align="center"><input type="submit" value="Change password">
        </td>
      </tr>
    </table>
    <br />
  <?php
}

function display_picture_form($location)
{
  ?>
  </form>
  <br />
  <form method="post" action="upload_image.php" enctype="multipart/form-data">
    <table width="250" cellpadding="2" cellspacing="0" bgcolor="#E7AEA0">
      <tr>
        <td>
          <?php
          if (@file_exists($location)) {
            echo "<img id='user_logo' src='$location'>";
          } else {
            echo "You haven't uploaded a picture for it!";
          }
          ?>
        </td>
      </tr>
      <tr>
        <td>
          <input type="hidden" name="MAX_FILE_SIZE" value="41943040">
        </td>
      </tr>
      <tr>
        <td>
          <input type="hidden" name="location" value="<?php echo $location; ?>">
        </td>
      </tr>
      <tr>
        <td>
          <input type="file" name="upfile">
        </td>
      </tr>
      <tr>
        <td>
          <input type="submit" value="Upload File">
        </td>
      </tr>
    </table>
    <br />
  <?php
}

function insert_merchant($cat_array)
{
  // inserts a new merchant into the database

  $conn = db_connect();

  // check merchant does not already exist
  $query = "select *
             from merchants
             where catname='" . $conn->real_escape_string($cat_array['catname']) . "'";
  $result = $conn->query($query);
  if ((!$result) || ($result->num_rows != 0)) {
    return false;
  }

  // insert new merchant
  $query = "INSERT INTO `merchants`(`catid`, `catname`, `phone`, `address`, `recommend`, `password`) 
            VALUES (NULL,
                    '" . $conn->real_escape_string($cat_array['catname']) . "',
                    '" . $conn->real_escape_string($cat_array['phone']) . "',
                    '" . $conn->real_escape_string($cat_array['address']) . "',
                    " . $conn->real_escape_string($cat_array['recommend']) . ",
                    sha1('" . $conn->real_escape_string($cat_array['password']) . "'))";
  $result = $conn->query($query);
  if (!$result) {
    return false;
  } else {
    return true;
  }
}

function insert_food($food_array)
{
  // insert a new food into the database

  $conn = db_connect();

  // insert new food
  $query = "insert into foods values
            (NULL, '" . $conn->real_escape_string($food_array['title']) . "', " . $conn->real_escape_string($food_array['catid']) .
    ", " . $conn->real_escape_string($food_array['price']) . ", " . $conn->real_escape_string($food_array['stock']) .
    ", " . $conn->real_escape_string($food_array['status']) . ", '" . $conn->real_escape_string($food_array['description']) . "', '" . $conn->real_escape_string($food_array['rest']) . "')";

  $result = $conn->query($query);
  if (!$result) {
    return false;
  } else {
    return true;
  }
}

function update_merchant($cat_array)
{
  // change the name of merchant with catid in the database

  $conn = db_connect();
  $k = "";
  if (check_admin_user()) {
    $k = ",password=sha1('" . $conn->real_escape_string($cat_array['password']) . "'), recommend=" . $conn->real_escape_string($cat_array['recommend']);
  }
  $query = "update merchants
             set catname='" . $conn->real_escape_string($cat_array['catname']) . "',
                 phone='" . $conn->real_escape_string($cat_array['phone']) . "',
                 address='" . $conn->real_escape_string($cat_array['address']) . "'
                 $k
             where catid='" . $conn->real_escape_string($cat_array['catid']) . "'";
  $result = @$conn->query($query);
  if (!$result) {
    return false;
  } else {
    return true;
  }
}

function update_cust($detail_array)
{
  // change the name of merchant with catid in the database

  $conn = db_connect();

  $query = "update customers
             set name='" . $conn->real_escape_string($detail_array['name']) . "',
                 dormitory='" . $conn->real_escape_string($detail_array['dormitory']) . "',
                 sex=" . $conn->real_escape_string($detail_array['sex']) . ",
                 age=" . $conn->real_escape_string($detail_array['age']) . ",
                 phone='" . $conn->real_escape_string($detail_array['phone']) . "',
                 qq='" . $conn->real_escape_string($detail_array['qq']) . "',
                 email='" . $conn->real_escape_string($detail_array['email']) . "'
             where customerid='" . $conn->real_escape_string($detail_array['customerid']) . "'";
  $result = @$conn->query($query);
  if (!$result) {
    return false;
  } else {
    return true;
  }
}

function delete_cust($detail_array)
{
  // change the name of merchant with catid in the database

  $conn = db_connect();

  $query = "delete from customers
             where customerid='" . $conn->real_escape_string($detail_array) . "'";
  $result = @$conn->query($query);
  if (!$result) {
    return false;
  } else {
    return true;
  }
}

function cust_signup($detail_array)
{
  // change the name of merchant with catid in the database

  $conn = db_connect();

  if (empty($detail_array['sex'])) {
    $detail_array['sex'] = 0;
  }

  if (empty($detail_array['age'])) {
    $detail_array['age'] = 0;
  }

  if (empty($detail_array['qq'])) {
    $detail_array['qq'] = "";
  }

  if (empty($detail_array['email'])) {
    $detail_array['email'] = "";
  }

  $query = "INSERT INTO `customers`(`customerid`, `name`, `dormitory`, `password`, 
                                    `sex`, `age`, `phone`, `qq`, `email`) 
            VALUES ('" . $conn->real_escape_string($detail_array['customerid']) . "',
                    '" . $conn->real_escape_string($detail_array['name']) . "',
                    '" . $conn->real_escape_string($detail_array['dormitory']) . "',
                    sha1('" . $conn->real_escape_string($detail_array['password']) . "'),
                    " . $conn->real_escape_string($detail_array['sex']) . ",
                    " . $conn->real_escape_string($detail_array['age']) . ",
                    '" . $conn->real_escape_string($detail_array['phone']) . "',
                    '" . $conn->real_escape_string($detail_array['qq']) . "',
                    '" . $conn->real_escape_string($detail_array['email']) . "')";
  $result = @$conn->query($query);
  if (!$result) {
    return false;
  } else {
    return true;
  }
}

function update_food($food_array)
{
  // change details of food stored under $oldfoodid in
  // the database to new details in arguments

  $conn = db_connect();

  $query = "update foods
             set title = '" . $conn->real_escape_string($food_array['title']) . "',
             rest = '" . $conn->real_escape_string($food_array['rest']) . "',
             catid = " . $conn->real_escape_string($food_array['catid']) . ",
             price = " . $conn->real_escape_string($food_array['price']) . ",
             stock = " . $conn->real_escape_string($food_array['stock']) . ",
             status = " . $conn->real_escape_string($food_array['status']) . ",
             description = '" . $conn->real_escape_string($food_array['description']) . "'
             where foodid = " . $conn->real_escape_string($food_array['foodid']);

  $result = @$conn->query($query);
  if (!$result) {
    return false;
  } else {
    return true;
  }
}

function delete_merchant($catname)
{
  // Remove the merchant identified by catid from the db
  // If there are foods in the merchant, it will not
  // be removed and the function will return false.

  $conn = db_connect();

  // check if there are any foods in merchant
  // to avoid deletion anomalies
  $query = "select *
             from foods
             where catid=(select catid from merchants where catname='" . $conn->real_escape_string($catname) . "')";

  $result = @$conn->query($query);
  if ((!$result) || (@$result->num_rows > 0)) {
    return false;
  }

  $query = "delete from merchants
             where catname='" . $conn->real_escape_string($catname) . "'";
  $result = @$conn->query($query);
  if (!$result) {
    return false;
  } else {
    return true;
  }
}


function delete_food($foodid)
{
  // Deletes the food identified by $foodid from the database.

  $conn = db_connect();

  $query = "delete from foods
             where foodid='" . $conn->real_escape_string($foodid) . "'";
  $result = @$conn->query($query);
  if (!$result) {
    return false;
  } else {
    return true;
  }
}

  ?>