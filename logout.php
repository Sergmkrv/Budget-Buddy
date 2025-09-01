<?php
// logout.php
// destroy the session and redirect to the home page
session_start();
session_destroy();
header("Location: home.php");
