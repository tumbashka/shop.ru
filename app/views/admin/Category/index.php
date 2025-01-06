<?php
/**
 * @var $allOrdersCount integer
 * @var $newOrdersCount integer
 * @var $userCount integer
 * @var $productCount integer
 */
?>
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <a href="<?= ADMIN ?>/category/add" class="btn btn-default btn-flat"><i class="fas fa-plus"></i> Добавить
            категорию</a>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>

        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <?php new \app\widgets\menu\Menu([
                    'cacheTime' => 0,
                    'cacheKey' => 'admin_menu',
                    'class' => 'table table-bordered',
                    'tpl' => APP.'/widgets/menu/admin_table_tpl.php',
                    'container' => 'table',
                ]
            )?>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">


    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
