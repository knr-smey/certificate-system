<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error</title>
</head>
<body>
    <div style="text-align: center; margin-top: 50px; color: red;">
        <h2>Oops! Something went wrong.</h2>
        <p><?= isset($message) ? $message : 'Page not found.' ?></p> 
    </div>
</body>
</html>