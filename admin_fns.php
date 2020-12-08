<?php
// This file contains functions used by the admin interface
// for the LZU Food Ordering shopping cart.

function display_merchant_form($merchant = '') {
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
  <form method="post"
      action="<?php echo $edit ? 'edit_merchant.php' : 'insert_merchant.php'; ?>">
  <table border="0">
  <tr>
    <td>merchant Name:</td>
    <td><input type="text" name="catname" size="40" maxlength="40"
          value="<?php echo htmlspecialchars($edit ? $merchant['catname'] : ''); ?>" /></td>
   </tr>
  <tr>
    <td <?php if (!$edit) { echo "colspan=2";} ?> align="center">
      <?php
         if ($edit) {
            echo "<input type=\"hidden\" name=\"catid\" value=\"". htmlspecialchars($merchant['catid'])."\" />";
         }
      ?>
      <input type="submit"
       value="<?php echo $edit ? 'Update' : 'Add'; ?> merchant" /></form>
     </td>
     <?php
        if ($edit) {
          //allow deletion of existing merchants
          echo "<td>
                <form method=\"post\" action=\"delete_merchant.php\">
                <input type=\"hidden\" name=\"catid\" value=\"". htmlspecialchars($merchant['catid'])."\" />
                <input type=\"submit\" value=\"Delete merchant\" />
                </form></td>";
       }
     ?>
  </tr>
  </table>
<?php
}

function display_food_form($food = '') {
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
  <form method="post"
        action="<?php echo $edit ? 'edit_food.php' : 'insert_food.php';?>">
  <table border="0">
  <tr>
    <td>foodid:</td>
    <td><input type="text" name="foodid"
         value="<?php echo htmlspecialchars($edit ? $food['foodid'] : ''); ?>" /></td>
  </tr>
  <tr>
    <td>food Title:</td>
    <td><input type="text" name="title"
         value="<?php echo htmlspecialchars($edit ? $food['title'] : ''); ?>" /></td>
  </tr>
  <tr>
    <td>food Author:</td>
    <td><input type="text" name="author"
         value="<?php echo htmlspecialchars($edit ? $food['author'] : ''); ?>" /></td>
   </tr>
   <tr>
      <td>merchant:</td>
      <td><select name="catid">
      <?php
          // list of possible merchants comes from database
          $cat_array=get_merchants();
          foreach ($cat_array as $thiscat) {
               echo "<option value=\"".htmlspecialchars($thiscat['catid'])."\"";
               // if existing food, put in current catgory
               if (($edit) && ($thiscat['catid'] == $food['catid'])) {
                   echo " selected";
               }
               echo ">".htmlspecialchars($thiscat['catname'])."</option>";
          }
          ?>
          </select>
        </td>
   </tr>
   <tr>
    <td>Price:</td>
    <td><input type="text" name="price"
               value="<?php echo htmlspecialchars($edit ? $food['price'] : ''); ?>" /></td>
   </tr>
   <tr>
     <td>Description:</td>
     <td><textarea rows="3" cols="50"
          name="description"><?php echo htmlspecialchars($edit ? $food['description'] : ''); ?></textarea></td>
    </tr>
    <tr>
      <td <?php if (!$edit) { echo "colspan=2"; }?> align="center">
         <?php
            if ($edit)
             // we need the old foodid to find food in database
             // if the foodid is being updated
             echo "<input type=\"hidden\" name=\"oldfoodid\"
                    value=\"".htmlspecialchars($food['foodid'])."\" />";
         ?>
        <input type="submit"
               value="<?php echo $edit ? 'Update' : 'Add'; ?> food" />
        </form></td>
        <?php
           if ($edit) {
             echo "<td>
                   <form method=\"post\" action=\"delete_food.php\">
                   <input type=\"hidden\" name=\"foodid\"
                    value=\"".htmlspecialchars($food['foodid'])."\" />
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

function display_password_form() {
// displays html change password form
?>
   <br />
   <form action="change_password.php" method="post">
   <table width="250" cellpadding="2" cellspacing="0" bgcolor="#cccccc">
   <tr><td>Old password:</td>
       <td><input type="password" name="old_passwd" size="16" maxlength="16" /></td>
   </tr>
   <tr><td>New password:</td>
       <td><input type="password" name="new_passwd" size="16" maxlength="16" /></td>
   </tr>
   <tr><td>Repeat new password:</td>
       <td><input type="password" name="new_passwd2" size="16" maxlength="16" /></td>
   </tr>
   <tr><td colspan=2 align="center"><input type="submit" value="Change password">
   </td></tr>
   </table>
   <br />
<?php
}

function insert_merchant($catname) {
// inserts a new merchant into the database

   $conn = db_connect();

   // check merchant does not already exist
   $query = "select *
             from merchants
             where catname='".$conn->real_escape_string($catname)."'";
   $result = $conn->query($query);
   if ((!$result) || ($result->num_rows!=0)) {
     return false;
   }

   // insert new merchant
   $query = "insert into merchants values
            ('', '".$conn->real_escape_string($catname)."')";
   $result = $conn->query($query);
   if (!$result) {
     return false;
   } else {
     return true;
   }
}

function insert_food($foodid, $title, $author, $catid, $price, $description) {
// insert a new food into the database

   $conn = db_connect();

   // check food does not already exist
   $query = "select *
             from foods
             where foodid='".$conn->real_escape_string($foodid)."'";

   $result = $conn->query($query);
   if ((!$result) || ($result->num_rows!=0)) {
     return false;
   }

   // insert new food
   $query = "insert into foods values
            ('".$conn->real_escape_string($foodid) ."', '". $conn->real_escape_string($author) . 
             "', '". $conn->real_escape_string($title) ."', '". $conn->real_escape_string($catid) . 
              "', '". $conn->real_escape_string($price) ."', '" . $conn->real_escape_string($description) ."')";

   $result = $conn->query($query);
   if (!$result) {
     return false;
   } else {
     return true;
   }
}

function update_merchant($catid, $catname) {
// change the name of merchant with catid in the database

   $conn = db_connect();

   $query = "update merchants
             set catname='".$conn->real_escape_string($catname) ."'
             where catid='".$conn->real_escape_string($catid) ."'";
   $result = @$conn->query($query);
   if (!$result) {
     return false;
   } else {
     return true;
   }
}

function update_food($oldfoodid, $foodid, $title, $author, $catid,
                     $price, $description) {
// change details of food stored under $oldfoodid in
// the database to new details in arguments

   $conn = db_connect();

   $query = "update foods
             set foodid= '".$conn->real_escape_string($foodid)."',
             title = '".$conn->real_escape_string($title)."',
             author = '".$conn->real_escape_string($author)."',
             catid = '".$conn->real_escape_string($catid)."',
             price = '".$conn->real_escape_string($price)."',
             description = '".$conn->real_escape_string($description)."'
             where foodid = '".$conn->real_escape_string($oldfoodid)."'";

   $result = @$conn->query($query);
   if (!$result) {
     return false;
   } else {
     return true;
   }
}

function delete_merchant($catid) {
// Remove the merchant identified by catid from the db
// If there are foods in the merchant, it will not
// be removed and the function will return false.

   $conn = db_connect();

   // check if there are any foods in merchant
   // to avoid deletion anomalies
   $query = "select *
             from foods
             where catid='".$conn->real_escape_string($catid)."'";

   $result = @$conn->query($query);
   if ((!$result) || (@$result->num_rows > 0)) {
     return false;
   }

   $query = "delete from merchants
             where catid='".$conn->real_escape_string($catid)."'";
   $result = @$conn->query($query);
   if (!$result) {
     return false;
   } else {
     return true;
   }
}


function delete_food($foodid) {
// Deletes the food identified by $foodid from the database.

   $conn = db_connect();

   $query = "delete from foods
             where foodid='".$conn->real_escape_string($foodid)."'";
   $result = @$conn->query($query);
   if (!$result) {
     return false;
   } else {
     return true;
   }
}

?>
