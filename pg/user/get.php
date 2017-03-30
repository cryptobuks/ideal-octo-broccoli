<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>User API Exampe</title>
        <?php include '../header.php' ?>
    </head>
    <body>
        <div class="container text-center">
            <h1>Get User by ID</h1>
            <div class="col-lg-4 col-lg-offset-4">
                <form class="form-horizontal" method="get" action="../../request.php">
                    <div class="form-group">
                        <label for="phone_number">User ID</label>
                        <input title="id" name="id" class="form-control" type="text">
                        <input type="hidden" name="api_method" value="users/get">
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