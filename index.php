<?php

session_start();
$_SESSION["user"] = "Blanca Fussie";

include("includes/header.php");
include("includes/sendMoney.php");

?>

<div class="container mt-3">

    <?= "<p class='lead'>Welcome " . $_SESSION["user"] . ".</p>"?>

    <form action="" method="post" id="sendMoney" class="mb-3 mt-3">
        <div class="form-group">
            <label for="type">Type of transaction</label>
            <select class="form-control" id="type" name="type" required>
                <option value="Bank">Bank transfer</option>
                <option value="Swish">Swish</option>
            </select>
        </div>
        <div class="form-group">
            <label for="amount">Amount to send</label>
            <input class="form-control" placeholder="Amount" type="number" id="amount" name="amount" required>
        </div>
        <div class="form-group">
            <label for="id">Send money to: </label>
            <input class="form-control" placeholder="Recipient"type="number" id="toUser" name="toUser" required>
        </div>
        <button type="submit" class="btn btn-primary">Send</button>
    </form>

    <p class="lead" id="message"></p>

    <table id="userTable" class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Name</th>
                <th>Bank ID</th>
                <th>Phone Number</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

</div>



<?php include("includes/footer.php");
