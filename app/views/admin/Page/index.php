<!-- Default box -->
<div class="card">

    <div class="card-header">
        <a href="<?= ADMIN ?>/page/add" class="btn btn-default btn-flat"><i class="fas fa-plus"></i> Добавить страницу</a>
    </div>

    <div class="card-body">

        <?php if (!empty($pages)): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Наименование</th>
                        <td width="50"><i class="fas fa-pencil-alt"></i></td>
                        <td width="50"><i class="far fa-trash-alt"></i></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($pages as $page): ?>
                        <tr>
                            <td><?= $page['id'] ?></td>
                            <td>
                                <?= $page['title'] ?>
                            </td>
                            <td width="50">
                                <a class="btn btn-info btn-sm"
                                   href="<?= ADMIN ?>/page/edit?id=<?= $page['id'] ?>"><i
                                        class="fas fa-pencil-alt"></i></a>
                            </td>
                            <td width="50">
                                <a class="btn btn-danger btn-sm delete"
                                   href="<?= ADMIN ?>/page/delete?id=<?= $page['id'] ?>">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php if (count($pages) < $total): ?>
                <div class="row m-2">
                    <div class="col-md-12">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <p><?= $pagination ?></p>
                            </ul>
                        </nav>
                        <div class="text-center">
                            <p><?= count($pages) . " "
                                . num2word(count($pages), ['страница из','страницы из','страниц из'])
                                . " " . $total ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <p>Страниц не найдено...</p>
        <?php endif; ?>

    </div>
</div>
<!-- /.card -->
