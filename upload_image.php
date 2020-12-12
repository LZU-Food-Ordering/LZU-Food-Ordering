<?php

// include function files for this application
require_once('food_sc_fns.php');
session_start();

do_html_header("Upload your picture");
if (check_admin_user() || check_rest_user()) {
    $location = "";
    if (isset($_FILES['upfile'])) {
        $location = $_POST['location'];
        if ($_FILES['upfile']['error'] != 0) {
            echo "</br>Upload Failed: " . $_FILES['upfile']['error'] . "<br/>";
            exit;
        }
        if (is_uploaded_file($_FILES['upfile']['tmp_name'])) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $_FILES['upfile']['tmp_name']);
            if (strchr($mime, "/", true) == "image") {
                $is = move_uploaded_file($_FILES['upfile']['tmp_name'], $location);
                if (!$is) {
                    echo "<br>Unable to move to the specific destination!<br/>";
                    exit;
                } else {
                    echo "<br>Upload Succeed!<br/>";
                }
            } else {
                echo "<br/>The upload file is not in picture format!<br/>";
                exit;
            }
        }
    } else {
        if (isset($_GET['catid'])) {
            $location = "images/res" . $_GET['catid'] . ".jpg";
        } else if (isset($_GET['foodid'])) {
            $location = "images/" . $_GET['foodid'] . ".jpg";
        } else {
            echo "<br/>Please enter through editing page!<br/>";
            exit;
        }
    }
    display_picture_form($location);
    do_html_url("admin.php", "Back to administration menu");
} else {
    echo "<p>You are not authorized to enter the administration area.</p>";
}
do_html_footer();
