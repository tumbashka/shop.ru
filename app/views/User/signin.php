<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light shadow-sm p-2">
            <li class="breadcrumb-item">
                <a href="<?= base_url() ?>">
                    <i class="fas fa-home"></i>
                </a>
            </li>
            <li class="breadcrumb-item">
                <?= getLang('tpl_signin') ?>
            </li>
        </ol>
    </nav>
</div>


<div class="container py-3">
    <div class="row">

        <div class="col-lg-12 category-content">
            <h3 class="section-title"><?= getLang('tpl_signin') ?></h3>
            <form class="row g-3" method="post">

                <div class="col-md-6 offset-md-3">
                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com"
                               >
                        <label class="required" for="email"><?= getLang('tpl_signup_email_input') ?></label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3">
                    <div class="form-floating mb-3">
                        <input type="password" name="password" class="form-control" id="password" placeholder="password"
                               >
                        <label class="required" for="password"><?= getLang('tpl_signup_password_input') ?></label>
                    </div>
                </div>

                <div class="col-md-6 offset-md-3">
                    <button type="submit" class="btn btn-danger"><?= getLang('user_signin_signin_btn') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>