<?php
/**
 * @var $this \tumba\View
 * @var $products array
 * @var $s string
 * @var $countProducts int
 * @var $pagination \tumba\Pagination
 *
 */


?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light shadow-sm p-2">
            <li class="breadcrumb-item">
                <a href="<?= base_url() ?>">
                    <i class="fas fa-home"></i>
                </a>
            </li>
            <li class="breadcrumb-item">
                <?= getLang('search_index_search') ?>
            </li>
        </ol>
    </nav>
</div>


<div class="container py-3">
    <div class="row">

        <div class="col-lg-12 category-content">
            <h3 class="section-title"><?= getLang('search_index_search') . ': ' . h($s) ?></h3>
            <div class="row">
                <?php if (!empty($products)): ?>
                    <?php $this->getPart('parts/products_loop', compact('products')); ?>
                <?php else: ?>
                    <div class="empty-category">
                        <h4 class="text-center"> <?= getLang('search_index_nothing_was_found') ?></h4>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (!empty($products) && count($products) < $countProducts): ?>
                <div class="row">
                    <div class="col-md-12">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <p><?= $pagination ?></p>
                            </ul>
                        </nav>
                        <div class="text-center">
                            <p><?= count($products) . " "
                                . num2word(count($products), getLang('tpl_total_pagination'))
                                . " " . $countProducts ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </div>

    </div>
</div>
