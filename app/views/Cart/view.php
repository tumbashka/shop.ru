<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light shadow-sm p-2">
            <li class="breadcrumb-item">
                <a href="<?= base_url() ?>">
                    <i class="fas fa-home"></i>
                </a>
            </li>
            <li class="breadcrumb-item active">
                <?= getLang('tpl_cart') ?>
            </li>
        </ol>
    </nav>
</div>


<div class="container py-3">
    <div class="row">

        <div class="col-lg-12 category-content">
            <h3 class="section-title"><?= getLang('tpl_cart') ?></h3>

            <?php if (!empty($_SESSION['cart'])): ?>
                <div class="table_responsive cart-table">
                    <table class="table text-start">
                        <thead>
                        <tr>
                            <th scope="col"><?= getLang('tpl_photo') ?></th>
                            <th scope="col"><?= getLang('tpl_product') ?></th>
                            <th scope="col"><?= getLang('tpl_quantity') ?></th>
                            <th scope="col"><?= getLang('tpl_price') ?></th>
                            <th scope="col"><i class="far fa-trash-alt"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                            <tr>
                                <td>
                                    <a href="product/<?= $item['slug'] ?>">
                                        <img src="<?= PATH . $item['img'] ?>" alt="<?= $item['title'] ?>">
                                    </a>
                                </td>
                                <td><a href="product/<?= $item['slug'] ?>"><?= $item['title'] ?></a></td>
                                <td><?= $item['qty'] ?></td>
                                <td><?= $item['price'] ?></td>
                                <td><a href="cart/delete?id=<?= $id ?>" class="del-item" data-id="<?= $id ?>"><i
                                                class="far fa-trash-alt"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="4"
                                class="text-end"><?= getLang('tpl_total_quantity') ?>  <?= getLang('tpl_pcs') ?>:
                            </td>
                            <td class="cart-qty-basket"><?= $_SESSION['cart.qty'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end"><?= getLang('tpl_total_price') ?>:</td>
                            <td class="cart-sum-basket">$<?= $_SESSION['cart.sum'] ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <form class="row g-3" method="post" action="cart/checkout">
                    <?php if (!isset($_SESSION['user'])): ?>
                        <div class="col-md-6 offset-md-3">
                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control" id="email"
                                       placeholder="name@example.com"
                                       value="<?= sessionFormData('email') ?>" required>
                                <label class="required" for="email"><?= getLang('cart_view_email_input') ?></label>
                            </div>
                        </div>

                        <div class="col-md-6 offset-md-3">
                            <div class="form-floating mb-3">
                                <input type="password" name="password" class="form-control" id="password"
                                       placeholder="password" required>
                                <label class="required"
                                       for="password"><?= getLang('cart_view_password_input') ?></label>
                            </div>
                        </div>

                        <div class="col-md-6 offset-md-3">
                            <div class="form-floating mb-3">
                                <input type="text" name="name" class="form-control" id="name" placeholder="Name"
                                       value="<?= sessionFormData('name') ?>" required>
                                <label class="required" for="name"><?= getLang('cart_view_name_input') ?></label>
                            </div>
                        </div>

                        <div class="col-md-6 offset-md-3">
                            <div class="form-floating mb-3">
                                <input type="text" name="address" class="form-control" id="address"
                                       placeholder="Address"
                                       value="<?= sessionFormData('address') ?>" required>
                                <label class="required" for="address"><?= getLang('cart_view_address_input') ?></label>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="col-md-6 offset-md-3">
                        <div class="form-floating mb-3">
                        <textarea name="note" class="form-control" id="note" placeholder="Leave a comment here"
                                  id="note"
                                  style="height: 100px"><?= sessionFormData('address') ?></textarea>
                            <label for="note"><?= getLang('cart_view_note_input') ?></label>
                        </div>
                    </div>

                    <div class="col-md-6 offset-md-3">
                        <button type="submit"
                                class="btn btn-danger"><?= getLang('cart_view_place_order_btn') ?></button>
                    </div>
                </form>

            <?php else: ?>
                <h4 class="text-center"><?= getLang('tpl_empty_cart') ?></h4>
            <?php endif; ?>

            <?php
            if (isset($_SESSION['form_data'])) {
                unset($_SESSION['form_data']);
            }
            ?>

        </div>
    </div>
</div>