<?php
require_once('food_sc_fns.php');
session_start();
do_html_header("Change Password");

display_password_form();

if (check_admin_user() || check_rest_user()) {
   display_button("admin.php", "Back to administration menu");
} else {
   display_button("index.php", "Back to home page");
}
do_html_footer();
