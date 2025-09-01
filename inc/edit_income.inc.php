<?php
session_start();
include "inc/db_connect.inc.php";
$error_bucket = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST["new_income"])) {
        array_push($error_bucket, "A monthly income is required.");
    } else {
        $new_income = $_POST["new_income"];
    }
    if (count($error_bucket) == 0) {
        $sql = "UPDATE user SET monthly_income = :monthly_income WHERE user_id = :user_id";
        $stmt = $db->prepare($sql);
        $stmt->execute(["monthly_income" => $new_income, "user_id" => $_SESSION['user_id']]);
        if ($stmt->rowCount() == 0) {
            echo '<div class="alert alert-danger" role="alert">
            I am sorry, but I could not save that record for you.</div>';
        } else {
            header("Location: profile.php");
            exit;
        }
    } else {
        display_error_bucket($error_bucket);
    }
}
?>

<!--register form-->
<div class="change-form mt-5 mb-5" style="display: none;">
    <h1 class="text-center fw-bold">Change Income</h1>
    <div class="form-container d-flex justify-content-center">
        <form action="profile.php" method="POST" class="form border rounded-3 p-3 shadow mt-2 col-6 shadow-md">
            <label class="col-form-label fw-bold" for="new_income">New Monthly Income</label>
            <input class="form-control" type="float" id="new_income" name="new_income" step="0.01" min="0">
            <br><br>
            <input type="submit" id="edit-income-button" class="btn btn-light fw-bold mb-1 shadow">
        </form>

    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
<script src="css/bootstrap.min.css"></script>