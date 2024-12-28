<?php
/**
 * @var $this \tumba\View
 * @var $products array
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
            <li class="breadcrumb-item active">
                <?= getLang('wishlist_index_title') ?>
            </li>
        </ol>
    </nav>
</div>


<div class="container py-3">
    <div class="row">

        <div class="col-lg-12 category-content">
            <h3 class="section-title"><?= getLang('wishlist_index_title') ?></h3>
            <div class="row">
                <?php if (!empty($products)): ?>
                    <?php $this->getPart('parts/products_loop', compact('products')); ?>
                <?php else: ?>
                    <div class="empty-category">
                        <h4 class="text-center"> <?= getLang('wishlist_index_not_found') ?></h4>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
