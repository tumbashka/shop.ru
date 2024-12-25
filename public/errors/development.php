<?php

/**
 * @var $errNo \tumba\ErrorHandler
 * @var $errStr \tumba\ErrorHandler
 * @var $errFile \tumba\ErrorHandler
 * @var $errLine \tumba\ErrorHandler
 * @var $errTrace \tumba\ErrorHandler
 */

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ошибка</title>
</head>
<body>

<h1>Произошла ошибка</h1>
<p><b>Код ошибки:</b> <?= $errNo ?></p>
<p><b>Текст ошибки:</b> <?= $errStr ?></p>
<p><b>Файл, в котором произошла ошибка:</b> <?= $errFile ?></p>
<p><b>Строка, в которой произошла ошибка:</b> <?= $errLine ?></p>
<p><b>Стек выполнения:</b></p><?= '<pre>' . print_r($errTrace, true) . '</pre>';?>

</body>
</html>
