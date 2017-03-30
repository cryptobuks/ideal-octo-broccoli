<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Charges API Exampe</title>
        <?php include '../header.php' ?>
    </head>
    <body>
        <div class="container text-center">
            <h1>Get Charge by ID</h1>
            <div class="col-lg-4 col-lg-offset-4">
                <form class="form-horizontal" method="get" action="../../request.php">
                    <div class="form-group">
                        <label for="id">Charge ID</label>
                        <input title="id" name="id" class="form-control" type="text" required>
                        <input type="hidden" name="api_method" value="charges/get">
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