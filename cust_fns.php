<?php

function get_cust() {
    // query database for the cust in customer
    if (!empty($_GET['key'])) {
       $key = $_GET['key'];
       $k = "name like '%$key%'";
   } else {
       $k = "1";
       $key = "";
   }
 
    $conn = db_connect();
    $query = "select * from customers where ".$k;
    $result = @$conn->query($query);
    if (!$result) {
      return false;
    }
    $num_cust = @$result->num_rows;
    if ($num_cust == 0) {
       return false;
    }
    $result = db_result_to_array($result);
    return $result;
 }

 
 function display_cust($custname)
 {
   //display all foods in the array passed in
   if (!empty($_GET['key']) && !is_array($custname)) {
     echo "<p>No customer currently available with the keyword: " . $_GET['key'] . "</p>";
   } else if (!is_array($custname)) {
     echo "<p>No customer currently available</p>";
   } else {
     echo "
     <form  align=\"left\" method=\"get\" action=\"cust_manage_form.php\">
     Search Customer by name:
     <input type=\"text\" name=\"key\">
     <input type=\"submit\">
     </form>";
     //create table
     echo "<table width=\"100%\" border=\"0\">";

     //create a table row for each cust
     foreach ($custname as $row) {
       $url = "show_food.php?name=" . urlencode($row['name']);
       echo "<tr><td>";
       $name = " name:".htmlspecialchars($row['name']) . " customerid:" . htmlspecialchars($row['customerid']) . " Dormitory:" . htmlspecialchars($row['dormitory']);
       do_html_url($url, $name);
       echo "</td></tr>";
     }

     echo "</table>";
   }

   echo "<hr />";
 }

