<?php
/**
 * @var $files array
 * @var $total int
 * @var $pagination \tumba\Pagination
 *
 */ ?>
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-light p-2">
                <li class="breadcrumb-item"><a href="./"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item"><a href="user/cabinet"><?php echoLang('tpl_cabinet'); ?></a></li>
                <li class="breadcrumb-item active"><?php echoLang('tpl_orders_files'); ?></li>
            </ol>
        </nav>
    </div>

    <div class="container py-3">
        <div class="row">

            <div class="col-12">
                <h1 class="section-title"><?php echoLang('tpl_orders_files'); ?></h1>
            </div>

            <?php $this->getPart('parts/cabinet_sidebar'); ?>

            <div class="col-md-9 order-md-1">

                <?php if (!empty($files)): ?>

                    <div class="table-responsive">
                        <table class="table text-start table-bordered">
                            <thead>
                            <tr>
                                <th scope="col"><?php echoLang('user_files_order_num'); ?></th>
                                <th scope="col"><?php echoLang('user_files_file'); ?></th>
                                <th scope="col"><?php echoLang('user_files_download_col'); ?></th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php foreach ($files as $file): ?>

                                <tr>
                                    <td>
                                        <a href="user/order?id=<?= $file['order_id'] ?>">
                                            <?= $file['order_id'] ?>
                                        </a>
                                    </td>
                                    <td><?= $file['name'] ?></td>
                                    <td>
                                        <a href="user/download?id=<?= $file['id'] ?>">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <p><?= count($files) . " "
                                . num2word(count($files), getLang('user_files_pagination'))
                                . " " . $total ?></p>
                            <?php if ($pagination->countPages > 1): ?>
                                <?= $pagination; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                <?php else: ?>
                    <p><?php echoLang('user_files_empty'); ?></p>
                <?php endif; ?>

            </div>
        </div>
    </div>

<?php
