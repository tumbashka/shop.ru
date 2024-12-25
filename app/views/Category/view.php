<?php
/**
 * @var $this \tumba\View
 * @var $category array
 * @var $products array
 * @var $total int
 * @var $pagination \tumba\Pagination
 * @var $breadCrumbs string
 *
 */


?>
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light shadow-sm p-2">
            <?= $breadCrumbs ?>
        </ol>
    </nav>
</div>


<div class="container py-3">
    <div class="row">

        <div class="col-lg-12 category-content">
            <h3 class="section-title"><?= $category['title'] ?></h3>
            <?php if (!empty($category['content'])): ?>
                <div class="category-desc">
                    <?= $category['content'] ?>
                </div>
                <hr>
            <?php endif; ?>
            <?php if (!empty($products)): ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="input-sort"><?= getLang('category_view_sort') ?>
                                :</label>
                            <select class="form-select" id="input-sort">
                                <option value="sort=title_asc"
                                    <?php if (isset($_GET['sort']) && $_GET['sort'] == 'title_asc') echo 'selected' ?>>
                                    <?= getLang('category_view_sort_title_asc') ?>
                                </option>
                                <option value="sort=title_desc"
                                    <?php if (isset($_GET['sort']) && $_GET['sort'] == 'title_desc') echo 'selected' ?>>
                                    <?= getLang('category_view_sort_title_desc') ?>
                                </option>
                                <option value="sort=price_asc"
                                    <?php if (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') echo 'selected' ?>>
                                    <?= getLang('category_view_sort_price_asc') ?>
                                </option>
                                <option value="sort=price_desc"
                                    <?php if (isset($_GET['sort']) && $_GET['sort'] == 'price_desc') echo 'selected' ?>>
                                    <?= getLang('category_view_sort_price_desc') ?>
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="input-per-page"><?= getLang('category_view_show') ?>
                                :</label>
                            <select class="form-select" id="input-per-page">
                                <option value="per_page=5"<?php if (isset($_GET['per_page']) && $_GET['per_page'] == '5') echo ' selected' ?>>
                                    5
                                </option>
                                <option value="per_page=10"<?php if (isset($_GET['per_page']) && $_GET['per_page'] == '10') echo ' selected' ?>>
                                    10
                                </option>
                                <option value="per_page=20"<?php if (isset($_GET['per_page']) && $_GET['per_page'] == '20') echo ' selected' ?>>
                                    20
                                </option>
                                <option value="per_page=50"<?php if (isset($_GET['per_page']) && $_GET['per_page'] == '50') echo ' selected' ?>>
                                    50
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="row">
                <?php if (!empty($products)): ?>
                    <?php $this->getPart('parts/products_loop', compact('products')); ?>
                <?php else: ?>
                    <div class="empty-category">
                        <h4 class="text-center"> <?= getLang('category_view_no_products') ?></h4>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (!empty($products) && count($products) < $total): ?>
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
                                . " " . $total ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>
