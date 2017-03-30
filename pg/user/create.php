<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User API Exampe</title>
    <?php include '../header.php' ?>
</head>
<body>
    <div class="container text-center">
        <h1>Create User</h1>
        <div class="col-lg-4 col-lg-offset-4 form-container">
            <form class="form-horizontal" method="post" action="../../request.php">
                <div class="form-group">
                    <label for="phone_number">Phone number</label>
                    <input title="phone_number" name="phone_number" class="form-control" type="text">
                    <input type="hidden" name="api_method" value="users/create">
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