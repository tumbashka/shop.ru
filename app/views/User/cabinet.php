<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2">
            <li class="breadcrumb-item"><a href="./"><i class="fa fa-home"></i></a></li>
            <li class="breadcrumb-item active"><?= getLang('tpl_cabinet'); ?></li>
        </ol>
    </nav>
</div>
<div class="container py-3">
    <div class="row">
        <div class="col-12">
            <h1 class="section-title"><?= getLang('tpl_cabinet'); ?></h1>
        </div>
        <div class="text-center">
            <h5><?=getLang('user_cabinet_welcome') ?> <?= $_SESSION['user']['name'] ?>!</h5>
        </div>
        <?php $this->getPart('parts/cabinet_sidebar'); ?>
        <div class="col-md-9 order-md-1">
            <ul class="list-unstyled">
                <li><a href="user/orders"><?= getLang('tpl_orders'); ?></a></li>
                <li><a href="user/files"><?= getLang('tpl_orders_files'); ?></a></li>
                <li><a href="user/credentials"><?= getLang('tpl_user_credentials'); ?></a></li>
                <li><a href="user/logout"><?= getLang('tpl_logout'); ?></a></li>
            </ul>
        </div>
    </div>
</div>