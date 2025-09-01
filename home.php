<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Home PHP</title>
</head>

<body>
    <header>
        <!--new navbar--------------------------------->
        <nav class="navbar navbar-expand-md">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="img/piggy-bank.png" alt="Budget Buddy Logo" class="logo ml-3">
                    <span class="align-middle">
                        <h1 class="m-2 py-2 d-inline" style="white-space: nowrap;">Budget Buddy</h1>
                    </span>
                </a>
                <div class="collapse navbar-collapse" id="mainNavbar">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="btn mr-2" href="home.php" role="button">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn mr-2" href="profile.php" role="button">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn mr-2" href="register.php" role="button">Register</a>
                        </li>
                        <?php if (isset($_SESSION["is_logged_in"])) { ?>
                            <li class="nav-item">
                                <a class="btn mr-2" href="logout.php" role="button">Logout</a>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item">
                                <a class="btn mr-2" href="login.php" role="button">Login</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
        <!----------------------------------------------->
        <main>
            <?php
            if (isset($_SESSION["first_name"])) {
                $first_name = $_SESSION["first_name"];
            } else {
                $first_name = "Future User";
            }
            ?>
            <h1 class="text-center mt-4 mb-5"> Hello <?php echo $first_name; ?>, Welcome to Budget Buddy!</h1>
            <?php include "inc/upload.inc.php"; ?>

            <?php
            if (isset($_SESSION["is_logged_in"])) {
                require "inc/db_connect.inc.php";
                // fetch monthly income for the user
                $stmt = $db->prepare("SELECT monthly_income FROM user WHERE user_id = :user_id");
                $stmt->execute(['user_id' => $_SESSION['user_id']]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $monthly_income = $result ? $result['monthly_income'] : "0.00";

                // fetch expenses for the user
                $stmt = $db->prepare("SELECT amount, category, date, description FROM expenses WHERE user_id = :user_id ORDER BY date DESC");
                $stmt->execute(['user_id' => $_SESSION['user_id']]);
                $expenses = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // fetch all of the expenses for the user
                $stmt = $db->prepare("SELECT SUM(amount) AS total FROM expenses WHERE user_id = :user_id");
                $stmt->execute(['user_id' => $_SESSION['user_id']]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $expenses_sum = $result ? $result['total'] : "0.00";

                // calculate remaining budget
                $remaining = $monthly_income - $expenses_sum
            ?>
                <div class="row m-3">
                    <div class="col-md-8 col-lg-5">
                        <!-- monthly money section -->
                        <h2 class="ml-4">Monthly Money</h2>
                        <div class="monthly-money card shadow rounded m-3">
                            <!-- total monthly income -->
                            <div class="mb-3">
                                <div class="card shadow-sm p-3 rounded d-flex flex-row align-items-center justify-content-between">
                                    <span class="font-weight-bold text-success rounded px-3 py-2 mr-3">
                                        Total Monthly Income
                                    </span>
                                    <span class="bg-white border rounded px-4 py-2 font-weight-bold text-success" style="font-size:20px;">
                                        $<span id="total-income"><?php echo number_format($monthly_income, 2) ?></span>
                                    </span>
                                </div>
                            </div>
                            <!-- total monthly spending -->
                            <div class="mb-3">
                                <div class="card shadow-sm p-3 rounded d-flex flex-row align-items-center justify-content-between">
                                    <span class="font-weight-bold text-danger rounded px-3 py-2 mr-3">
                                        Total Monthly Spending
                                    </span>
                                    <span class="bg-white border rounded px-4 py-2 font-weight-bold text-danger" style="font-size:20px;">
                                        $<span id="total-spending"><?php echo number_format($expenses_sum, 2) ?></span>
                                    </span>
                                </div>
                            </div>
                            <div>
                                <div class="card shadow-sm p-3 rounded d-flex flex-row align-items-center justify-content-between">
                                    <span class="font-weight-bold rounded px-3 py-2 mr-3">
                                        Remaining Budget
                                    </span>
                                    <span class="bg-white border rounded px-4 py-2 font-weight-bold" style="font-size:20px;">
                                        $<span id="remaining-budget"><?php echo number_format($remaining, 2) ?></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- spending chart -->
                        <h2>Spending Chart</h2>

                    </div>
                </div>
                <div class="row m-3">
                    <div class="col-12">
                        <h2 class="ml-4">Recent Transactions</h2>
                        <div class="card shadow-sm p-3 mx-4 rounded">
                            <?php
                            foreach ($expenses as $expense) { ?>
                                <div class="mx-3"><?php echo date('m/d/y', strtotime($expense['date'])); ?></div>
                                <div class="card shadow-sm p-3 m-3 rounded d-flex flex-row align-items-center">
                                    <div class="px-3">Amount: $<?php echo number_format($expense['amount'], 2); ?></div>
                                    <div class="px-3">Category: <?php echo htmlspecialchars($expense['category']); ?></div>
                                    <div class="px-3">Description: <?php echo htmlspecialchars($expense['description']); ?></div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                </div>
            <?php } ?>

        </main>
        <?php include "inc/footer.inc.php" ?>
</body>

</html>