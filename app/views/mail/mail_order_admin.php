<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<table style="border: 1px solid #ddd; border-collapse: collapse; width: 100%;">
    <thead>
    <tr style="background: #f9f9f9;">
        <th style="padding: 8px; border: 1px solid #ddd;"><?= getLang('tpl_product'); ?></th>
        <th style="padding: 8px; border: 1px solid #ddd;"><?= getLang('tpl_quantity'); ?></th>
        <th style="padding: 8px; border: 1px solid #ddd;"><?= getLang('tpl_price'); ?></th>
        <th style="padding: 8px; border: 1px solid #ddd;"><?= getLang('tpl_total_price'); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($_SESSION['cart'] as $item): ?>
        <tr>
            <td style="padding: 8px; border: 1px solid #ddd;"><?= $item['title'] ?></td>
            <td style="padding: 8px; border: 1px solid #ddd;"><?= $item['qty'] ?></td>
            <td style="padding: 8px; border: 1px solid #ddd;"><?= $item['price'] ?></td>
            <td style="padding: 8px; border: 1px solid #ddd;"><?= $item['price'] * $item['qty'] ?></td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="3" style="padding: 8px; border: 1px solid #ddd;"><?= getLang('tpl_total_quantity'); ?></td>
        <td style="padding: 8px; border: 1px solid #ddd;"><?= $_SESSION['cart.qty'] ?></td>
    </tr>
    <tr>
        <td colspan="3" style="padding: 8px; border: 1px solid #ddd;"><?= getLang('tpl_total_price'); ?></td>
        <td style="padding: 8px; border: 1px solid #ddd;">$<?= $_SESSION['cart.sum'] ?></td>
    </tr>
    </tbody>
</table>

</body>
</html>
