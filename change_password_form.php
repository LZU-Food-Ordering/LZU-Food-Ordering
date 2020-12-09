<?php
 require_once('food_sc_fns.php');
 session_start();
 do_html_header("Change Password");
 check_admin_user();

 display_password_form();

 if(check_admin_user()){
    do_html_url("admin.php", "Back to administration menu");
 } else {
    do_html_url("index.php", "Back to home page");
 }
 do_html_footer();
