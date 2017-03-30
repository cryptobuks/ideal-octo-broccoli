<?php
/**
 * Created by PhpStorm.
 * User: marco.bevilacqua
 * Date: 29/03/2017
 * Time: 15:43
 */
?>
<html>
    <head>
        <title>Satispay charge API example</title>
        <link rel="stylesheet" href="../../css/bootstrap.css">
    </head>
    <body>
        <div class="container text-center">
            <h1>Create Refund</h1>
            <div class="col-lg-4 col-lg-offset-4">
                <form class="form-horizontal" method="post" action="../../request.php">ù
                <div class="form-group">
                    <label for="user_id">User Id</label>
                    <input title="user_id" name="user_id" class="form-control" type="text">
                </div>
                    <div class="form-group">
                        <label for="currency">Currency</label>
                        <select title="currency" name="currency" class="form-control">
                            <option value="">NO CURRENCY</option>
                            <option value="E" selected>EURO</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input name="amount" title="amount" class="form-control">
                        <input type="hidden" name="api_method" value="charge">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-default" value="go ahead">
                    </div>
            </form>
        </div>
    </body>
</html>
