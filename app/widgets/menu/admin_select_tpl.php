<?php
$parent_id = \tumba\App::$appReg->getProperty('parent_id');
$get_id = get('id');
$controller = \tumba\App::$appReg->getProperty('route')['controller'];
?>

<option value="<?= $id ?>" <?php if ($id == $parent_id) echo ' selected'; ?>
    <?php if ($get_id == $id && $controller == 'Category') echo ' disabled'; ?>>
    <?= $tab . $category['title'] ?>
</option>
<?php if (isset($category['children'])): ?>
    <?= $this->getMenuHtml($category['children'], '&nbsp;' . $tab . '-') ?>
<?php endif; ?>
