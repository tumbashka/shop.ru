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
                <li class="breadcrumb-item active"><?php echoLang('tpl_user_credentials'); ?></li>
            </ol>
        </nav>
    </div>

    <div class="container py-3">
        <div class="row">

            <div class="col-12">
                <h1 class="section-title"><?php echoLang('tpl_user_credentials'); ?></h1>
            </div>

            <?php $this->getPart('parts/cabinet_sidebar'); ?>

            <div class="col-md-9 order-md-1">

                <form class="row g-3" method="post">
                    <div class="col-md-6 offset-md-3">
                        <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control" id="email"
                                   placeholder="name@example.com" value="<?= h($_SESSION['user']['email']) ?>" disabled>
                            <label for="email"><?= getLang('tpl_signup_email_input'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-6 offset-md-3">
                        <div class="form-floating mb-3">
                            <input type="password" name="password" class="form-control" id="password"
                                   placeholder="password">
                            <label class="required" for="password"><?= getLang('tpl_signup_password_input') ?></label>
                        </div>
                    </div>

                    <div class="col-md-6 offset-md-3">
                        <div class="form-floating mb-3">
                            <input type="text" name="name" class="form-control" id="name" placeholder="Name"
                                   value="<?= h($_SESSION['user']['name']) ?>"">
                            <label class="required" for="name"><?= getLang('tpl_signup_name_input') ?></label>
                        </div>
                    </div>

                    <div class="col-md-6 offset-md-3">
                        <div class="form-floating mb-3">
                            <input type="text" name="address" class="form-control" id="address" placeholder="Address"
                                   value="<?= h($_SESSION['user']['address']) ?>">
                            <label class="required" for="address"><?= getLang('tpl_signup_address_input') ?></label>
                        </div>
                    </div>
                    <div class="col-md-6 offset-md-3">
                        <button type="submit" class="btn btn-danger"><?= getLang('user_credentials_save_btn') ?></button>
                    </div>
                </form>

            </div>
        </div>
    </div>

<?php
