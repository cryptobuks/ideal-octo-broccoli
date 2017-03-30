<!DOCTYPE html>
<html lang="en">
<head>
    <title>Satispay charge API example</title>
    <?php include '../header.php' ?>
</head>
<body>
<div class="container text-center">
    <div class="col-lg-4 col-lg-offset-4">
        <h1>Get Charge List</h1>
        <form class="form-horizontal" method="get" action="../../request.php">
            <div class="form-group">
                <label for="starting_after">Start After: </label>
                <input title="starting_after" name="starting_after" class="form-control" type="text">
                <label for="ending_before">End Before: </label>
                <input title="ending_before" name="ending_before" class="form-control" type="text">
                <label for="limit">Limit: </label>
                <input title="limit" name="limit" class="form-control" type="text">
                <input type="hidden" name="api_method" value="charges/list">
            </div>
            <fieldset>
                <input type="submit" class="btn btn-default" value="go ahead">
            </fieldset>
        </form>
    </div>
    <?php include '../dialog.php'; ?>
</div>
</body>
</html>
