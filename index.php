<?php

if (empty($_SERVER['DOCUMENT_ROOT'])) {
    $_SERVER['DOCUMENT_ROOT'] = getcwd();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/style.css">
    <title>Parse rss</title>
</head>
<body>
<div class="container">
    <div class="form__block">
        <form action="/parser.php" method="POST">
            <p class="text_link">Ссылка на rss ленту:
                <label>
                    <input class="link_value" type="text" name="link"/>
                </label>
            </p>
            <input class="link_submit" type="submit" value="Parse">
        </form>
    </div>
</div>
</body>
</html>


