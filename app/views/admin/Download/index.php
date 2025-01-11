<!-- Default box -->
<div class="card">

    <div class="card-header">
        <a href="<?= ADMIN ?>/download/add" class="btn btn-default btn-flat"><i class="fas fa-plus"></i> Загрузить файл</a>
    </div>

    <div class="card-body">

        <?php if (!empty($files)): ?>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Наименование</th>
                    <th>Оригинальное имя</th>
                    <td width="50"><i class="far fa-trash-alt"></i></td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($files as $file): ?>
                    <tr>
                        <td>
                            <?= $file['name'] ?>
                        </td>
                        <td>
                            <?= $file['original_name'] ?>
                        </td>
                        <td width="50">
                            <a class="btn btn-danger btn-sm delete" href="<?= ADMIN ?>/download/delete?id=<?= $file['id'] ?>">
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <?php if (count($files) < $total): ?>
                <div class="row m-2">
                    <div class="col-md-12">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <p><?= $pagination ?></p>
                            </ul>
                        </nav>
                        <div class="text-center">
                            <p><?= count($files) . " "
                                . num2word(count($files), ['файл из','файла из','файлов из'])
                                . " " . $total ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <p>Файлов для загрузки не найдено...</p>
        <?php endif; ?>

    </div>
</div>
<!-- /.card -->



