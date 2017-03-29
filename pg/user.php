<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User API Exampe</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
</head>
<body>
    <div class="container text-center">
        <h1>Create User</h1>
        <div class="col-lg-4 col-lg-offset-4">
            <form class="form-horizontal" method="post" action="../request.php">
                <div class="form-group">
                    <label for="phone_number">Phone number</label>
                    <input title="phone_number" name="phone_number" class="form-control" type="text">
                    <input type="hidden" name="api_method" value="v1/users">
                </div>
                <fieldset>
                    <input type="submit" class="btn btn-default" value="go ahead">
                </fieldset>
            </form>
        </div>
    </div>
</body>
</html>