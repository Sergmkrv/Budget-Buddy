<?php
// logout_ajax.php
session_start();
session_destroy();
echo json_encode(['status' => 'success']);
