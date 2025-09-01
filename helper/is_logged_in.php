<?php
// is_logged_in.php
session_start();
if (isset($_SESSION['first_name'])) {
    echo json_encode(["status" => 'yes']);
} else {
    echo json_encode(["status" => 'no']);
}
