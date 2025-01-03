<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-light p-2">
            <li class="breadcrumb-item"><a href="./"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="user/cabinet"><?php echoLang('tpl_cabinet'); ?></a></li>
            <li class="breadcrumb-item"><a href="user/orders"><?php echoLang('tpl_orders'); ?></a></li>
            <li class="breadcrumb-item active"><?= sprintf(getLang('user_order_order_num'), $order['id']) ?></li>
        </ol>
    </nav>
</div>


<div class="container py-3">
    <div class="row">

        <div class="col-lg-12 category-content">
            <h3 class="section-title"><?= sprintf(getLang('user_order_order_num'), $order['id']) ?></h3>
            <div>
                <p><?= getLang('user_order_created') . $order['created_at'] ?></p>
                <p><?= getLang('user_order_updated') . $order['updated_at'] ?></p>
                <p><?= getLang("user_order_status") . getLang("user_order_status_{$order['status']}")?></p>
                <?php if(!empty($order['note'])): ?>
                <p><?= getLang('user_order_note') . $order['note'] ?></p>
                <?php endif; ?>
            </div>
                <div class="table_responsive cart-table">
                    <table class="table text-start">
                        <thead>
                        <tr>
                            <th scope="col"><?= getLang('tpl_photo') ?></th>
                            <th scope="col"><?= getLang('tpl_product') ?></th>
                            <th scope="col"><?= getLang('tpl_quantity') ?></th>
                            <th scope="col"><?= getLang('tpl_price') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($orderProducts as $product): ?>
                            <tr>
                                <td>
                                    <a href="product/<?= $product['slug'] ?>">
                                        <img src="<?= PATH . $product['img'] ?>" alt="<?= $product['title'] ?>">
                                    </a>
                                </td>
                                <td><a href="product/<?= $product['slug'] ?>"><?= $product['title'] ?></a></td>
                                <td><?= $product['qty'] ?></td>
                                <td><?= $product['price'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3"
                                class="text-end"><?= getLang('tpl_total_quantity') ?>  <?= getLang('tpl_pcs') ?>:
                            </td>
                            <td class="cart-qty-basket"><?= $order['qty'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end"><?= getLang('tpl_total_price') ?>:</td>
                            <td class="cart-sum-basket">$<?= $order['total'] ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>

        </div>
    </div>
</div>