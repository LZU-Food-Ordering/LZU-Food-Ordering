<?php

require_once('db_fns.php');

function login($username, $password, $cate)
{
  // check username and password with db
  // if yes, return true
  // else return false

  // connect to db
  if ($cate == 'admin') {
    $conn = db_connect();
    if (!$conn) {
      return 0;
    }

    // check if username is unique
    $result = $conn->query("select * from admin
                         where username='" . $conn->real_escape_string($username) . "'
                         and password = sha1('" . $conn->real_escape_string($password) . "')");
    if (!$result) {
      return 0;
    }

    if ($result->num_rows > 0) {
      return 1;
    } else {
      return 0;
    }
  } else if ($cate == 'rest') {
    $conn = db_connect();
    if (!$conn) {
      return 0;
    }
    // check if username is unique
    $result = $conn->query("select * from merchants
                         where catname='" . $conn->real_escape_string($username) . "'
                         and password = sha1('" . $conn->real_escape_string($password) . "')");
    if (!$result) {
      return 0;
    }

    if ($result->num_rows > 0) {
      return 1;
    } else {
      return 0;
    }
  }
}



function login_cust($username, $password)
{
  // check username and password with db
  // if yes, return true
  // else return false

  // connect to db
  $conn = db_connect();
  if (!$conn) {
    return 0;
  }

  // check if username is unique
  $result = $conn->query("select * from customers
                           where customerid='" . $conn->real_escape_string($username) . "'
                           and password = sha1('" . $conn->real_escape_string($password) . "')");
  if (!$result) {
    return 0;
  }

  if ($result->num_rows > 0) {
    return 1;
  } else {
    return 0;
  }
}

function check_admin_user()
{
  // see if somebody is logged in and notify them if not

  if (isset($_SESSION['admin_user'])) {
    return true;
  } else {
    return false;
  }
}

function check_rest_user()
{
  // see if somebody is logged in and notify them if not

  if (isset($_SESSION['rest_user'])) {
    return true;
  } else {
    return false;
  }
}

function check_cust_user()
{
  // see if somebody is logged in and notify them if not

  if (isset($_SESSION['cust_user'])) {
    return true;
  } else {
    return false;
  }
}

function change_password($username, $old_password, $new_password, $kind)
{
  // change password for username/old_password to new_password
  // return true or false

  // if the old password is right
  // change their password to new_password and return true
  // else return false
  if ($kind == "customers")
    $checkr = login_cust($username, $old_password);
  else if ($kind == "merchants")
    $checkr = login($username, $old_password, "rest");
  else
    $checkr = login($username, $old_password, "admin");
  if ($checkr) {

    if (!($conn = db_connect())) {
      return false;
    }

    $idname = "username";
    if ($kind == "customers")
      $idname = "customerid";
    else if ($kind == "merchants")
      $idname = "catname";

    $result = $conn->query("update $kind
                            set password = sha1('" . $conn->real_escape_string($new_password) . "')
                            where $idname = '" . $conn->real_escape_string($username) . "'");
    if (!$result) {
      return false;  // not changed
    } else {
      return true;  // changed successfully
    }
  } else {
    return false; // old password was wrong
  }
}
