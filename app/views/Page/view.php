<?php
/**
 * @var $page array
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
                <?= $page['title'] ?>
            </li>
        </ol>
    </nav>
</div>


<div class="container py-3">
    <div class="row">

        <div class="col-lg-12 category-content">
            <h3 class="section-title"><?= $page['title'] ?></h3>
            <div class="row">
                <div class="col-md-12">
                    <p><?= $page['content'] ?></p>

                </div>
            </div>
        </div>
    </div>
</div>
