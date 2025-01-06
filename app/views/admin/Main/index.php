<?php
/**
 * @var $allOrdersCount integer
 * @var $newOrdersCount integer
 * @var $userCount integer
 * @var $productCount integer
 * @var $categoriesCount integer
 */
?>
<!-- Default box -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Статистика</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>

        </div>
    </div>
    <div class="row">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-cyan">
                        <div class="inner">
                            <h3><?= $allOrdersCount ?></h3>
                            <p>Всего заказов</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <a href="<?= ADMIN ?>/order" class="small-box-footer">Подробнее <i
                                    class="fas fa-shopping-cart"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3><?= $newOrdersCount ?></h3>
                            <p>Новых заказов</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-cart-plus"></i>
                        </div>
                        <a href="<?= ADMIN ?>/order?status=0" class="small-box-footer">Подробнее <i
                                    class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3><?= $productCount ?></h3>
                            <p>Всего товаров</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-cubes"></i>
                        </div>
                        <a href="<?= ADMIN ?>/product" class="small-box-footer">Подробнее <i
                                    class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?= $userCount ?></h3>
                            <p>Всего пользователей</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="<?= ADMIN ?>/user" class="small-box-footer">Подробнее <i
                                    class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-12">
                    <!-- small box -->
                    <div class="small-box bg-pink">
                        <div class="inner">
                            <h3><?= $categoriesCount ?></h3>
                            <p>Количество категорий</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-th"></i>
                        </div>
                        <a href="<?= ADMIN ?>/category" class="small-box-footer">Подробнее <i
                                    class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- /.col -->
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">

    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
