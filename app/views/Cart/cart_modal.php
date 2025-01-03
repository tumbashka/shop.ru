<div class="modal-body" >
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
                        <td><a href="cart/delete?id=<?= $id ?>" class="del-item" data-id="<?= $id ?>"><i class="far fa-trash-alt"></i></a></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4" class="text-end"><?= getLang('tpl_total_quantity') ?>  <?= getLang('tpl_pcs') ?>: </td>
                    <td class="cart-qty"><?= $_SESSION['cart.qty'] ?></td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end"><?= getLang('tpl_total_price') ?>:</td>
                    <td class="cart-sum">$<?= $_SESSION['cart.sum'] ?></td>
                </tr>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <h4 class="text-center"><?= getLang('tpl_empty_cart') ?></h4>
    <?php endif; ?>
</div>
<div class="modal-footer">
    <?php if (!empty($_SESSION['cart'])): ?>
        <button type="button" id="clear-cart" class="btn btn-danger"><?= getLang('tpl_clear_cart') ?></button>
        <a href="cart/view" type="button" class="btn btn-primary"><?= getLang('tpl_place_an_order') ?></a>
    <?php endif; ?>
    <button type="button" class="btn btn-success ripple"
            data-bs-dismiss="modal"><?= getLang('tpl_continue_shopping') ?></button>
</div>