<?php
/**
 * Created by PhpStorm.
 * User: marco.bevilacqua
 * Date: 29/03/2017
 * Time: 15:43
 */
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Satispay charge API example</title>
        <?php include '../header.php' ?>
    </head>
    <body>
        <div class="container text-center">
            <div class="col-lg-4 col-lg-offset-4">
                <h1>Create Charge</h1>
                <form class="form-horizontal" method="post" action="../../request.php">
                    <div class="form-group">
                        <label for="user_id">User Id</label>
                        <input title="user_id" name="user_id" class="form-control" type="text">
                    </div>
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select title="currency" name="currency" class="form-control">
                            <option value="">NO CURRENCY</option>
                            <option value="EUR" selected>EURO</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input name="amount" title="amount" class="form-control">
                        <input type="hidden" name="api_method" value="charges/create">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-default" value="go ahead">
                    </div>
                </form>
            </div>
            <?php include '../dialog.php'; ?>
        </div>
    </body>
</html>
