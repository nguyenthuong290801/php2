<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        if ($_SERVER['REQUEST_URI'] == '/') {
            echo "Home";
        } else {
            echo ucwords(substr($_SERVER['REQUEST_URI'], 1));
        }
        ?>
    </title>
</head>
<body>
<div>
    <?= '{{content}}'; ?>
</div>
</body>
</html>