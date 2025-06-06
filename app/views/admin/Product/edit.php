<!-- Default box -->
<div class="card">

    <div class="card-body">

        <form action="" method="post">

            <div class="form-group">
                <label class="required" for="category_id">Категория</label>
                <?php new \app\widgets\menu\Menu([
                    'cacheTime' => 0,
                    'cacheKey' => 'admin_menu_select',
                    'class' => 'form-control',
                    'container' => 'select',
                    'attrs' => [
                        'name' => 'category_id',
                        'id' => 'category_id',
                        'required' => 'required',
                    ],
                    'tpl' => APP . '/widgets/menu/admin_select_tpl.php',
                ]) ?>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="required" for="price">Цена</label>
                        <input type="text" name="price" class="form-control" id="price" placeholder="Цена"
                               value="<?= $product['price'] ?>">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="old_price">Старая цена</label>
                        <input type="text" name="old_price" class="form-control" id="old_price"
                               placeholder="Старая цена" value="<?= $product['old_price'] ?>">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="status"
                           name="status" <?= $product['status'] ? 'checked' : '' ?>>
                    <label for="status" class="custom-control-label">Показывать на сайте</label>
                </div>
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="hit"
                           name="hit" <?= $product['hit'] ? 'checked' : '' ?>>
                    <label for="hit" class="custom-control-label">Хит</label>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">

                    <div class="form-group">
                        <label for="is_download">Прикрепите загружаемый файл, чтобы товар стал цифровым</label>
                        <?php if (!empty($product_digital['digital_id'])): ?>
                            <p class="clear-download">
                                <span class="btn btn-danger">Обычный товар</span>
                            </p>
                        <?php endif; ?>
                        <select name="is_download" class="form-control select2 is-download" id="is_download"
                                style="width: 100%;">
                            <?php if (!empty($product_digital['digital_id'])): ?>
                                <option value="<?= $product_digital['digital_id'] ?>"
                                        selected><?= $digital_description['name'] ?></option>

                            <?php endif; ?>
                        </select>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">Основное фото</h3>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-success" id="add-base-img" onclick="popupBaseImage(); return false;">
                                Загрузить
                            </button>
                            <div id="base-img-output" class="upload-images base-image">
                                <div class="product-img-upload">
                                    <img src="<?= $product['img'] ?>">
                                    <input type="hidden" name="img" value="<?= $product['img'] ?>">
                                    <?php if ($product['img'] != NO_IMAGE): ?>
                                        <button class="del-img btn btn-app bg-danger"><i class="far fa-trash-alt"></i>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">Дополнительные фото</h3>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-success" id="add-gallery-img"
                                    onclick="popupGalleryImage(); return false;">Загрузить
                            </button>
                            <div id="gallery-img-output" class="upload-images gallery-image">
                                <?php if (!empty($product_gallery)): ?>
                                    <?php foreach ($product_gallery as $item): ?>
                                        <div class="product-img-upload">
                                            <img src="<?= $item['img'] ?>">
                                            <input type="hidden" name="gallery[]"
                                                   value="<?= $item['img'] ?>">
                                            <button class="del-img btn btn-app bg-danger"><i
                                                        class="far fa-trash-alt"></i></button>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>


            <div class="card card-info card-outline card-tabs">
                <div class="card-header p-0 pt-1 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                        <?php foreach (\tumba\App::$appReg->getProperty('languages') as $k => $lang): ?>
                            <li class="nav-item">
                                <a class="nav-link <?php if ($lang['base']) echo 'active' ?>" data-toggle="pill"
                                   href="#<?= $k ?>">
                                    <img src="<?= PATH ?>/assets/img/languages/<?= $k ?>.png" alt="">
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content">
                        <?php $baseLang = \tumba\App::$appReg->getProperty('language');

                        ?>

                        <?php foreach ($product_description as $langId => $item): ?>
                            <?php foreach (\tumba\App::$appReg->getProperty('languages') as $langCode => $lang) {
                                if ($lang['id'] == $langId) {
                                    $code = $langCode;
                                }
                            }

                            ?>

                            <div class="tab-pane fade <?php if ($baseLang['id'] == $langId) echo 'active show'; ?>"
                                 id="<?= $code ?>">

                                <div class="form-group">
                                    <label class="required" for="title">Наименование</label>
                                    <input type="text" name="product_description[<?= $langId ?>][title]"
                                           class="form-control" id="title" placeholder="Наименование товара"
                                           value="<?= h($item['title']) ?>">
                                </div>

                                <div class="form-group">
                                    <label for="description">Мета-описание</label>
                                    <input type="text" name="product_description[<?= $langId ?>][description]"
                                           class="form-control" id="description" placeholder="Мета-описание"
                                           value="<?= h($item['description']) ?>">
                                </div>

                                <div class="form-group">
                                    <label for="keywords">Ключевые слова</label>
                                    <input type="text" name="product_description[<?= $langId ?>][keywords]"
                                           class="form-control" id="keywords" placeholder="Ключевые слова"
                                           value="<?= h($item['keywords']) ?>">
                                </div>

                                <div class="form-group">
                                    <label for="excerpt" class="required">Краткое описание</label>
                                    <input type="text" name="product_description[<?= $langId ?>][excerpt]"
                                           class="form-control" id="excerpt" placeholder="Краткое описание"
                                           value="<?= h($item['excerpt']) ?>">
                                </div>

                                <div class="form-group">
                                    <label for="content">Описание товара</label>
                                    <textarea name="product_description[<?= $langId ?>][content]"
                                              class="form-control editor" id="content" rows="3"
                                              placeholder="Описание товара"><?= h($item['content']) ?></textarea>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <!-- /.card -->
            </div>

            <button type="submit" class="btn btn-primary">Сохранить</button>

        </form>

    </div>

</div>
<!-- /.card -->

<script>
    function popupBaseImage() {
        CKFinder.popup({
            chooseFiles: true,
            onInit: function (finder) {
                finder.on('files:choose', function (evt) {
                    var file = evt.data.files.first();
                    const baseImgOutput = document.getElementById('base-img-output');
                    baseImgOutput.innerHTML = '<div class="product-img-upload"><img src="' + file.getUrl() + '"><input type="hidden" name="img" value="' + file.getUrl() + '"><button class="del-img btn btn-app bg-danger"><i class="far fa-trash-alt"></i></button></div>';
                });
                finder.on('file:choose:resizedImage', function (evt) {
                    const baseImgOutput = document.getElementById('base-img-output');
                    baseImgOutput.innerHTML = '<div class="product-img-upload"><img src="' + evt.data.resizedUrl + '"><input type="hidden" name="img" value="' + evt.data.resizedUrl + '"><button class="del-img btn btn-app bg-danger"><i class="far fa-trash-alt"></i></button></div>';
                });
            }
        });
    }
</script>

<script>
    function popupGalleryImage() {
        CKFinder.popup({
            chooseFiles: true,
            onInit: function (finder) {
                finder.on('files:choose', function (evt) {
                    var file = evt.data.files.first();
                    const galleryImgOutput = document.getElementById('gallery-img-output');

                    if (galleryImgOutput.innerHTML) {
                        galleryImgOutput.innerHTML += '<div class="product-img-upload"><img src="' + file.getUrl() + '"><input type="hidden" name="gallery[]" value="' + file.getUrl() + '"><button class="del-img btn btn-app bg-danger"><i class="far fa-trash-alt"></i></button></div>';
                    } else {
                        galleryImgOutput.innerHTML = '<div class="product-img-upload"><img src="' + file.getUrl() + '"><input type="hidden" name="gallery[]" value="' + file.getUrl() + '"><button class="del-img btn btn-app bg-danger"><i class="far fa-trash-alt"></i></button></div>';
                    }

                });
                finder.on('file:choose:resizedImage', function (evt) {
                    const baseImgOutput = document.getElementById('base-img-output');

                    if (galleryImgOutput.innerHTML) {
                        galleryImgOutput.innerHTML += '<div class="product-img-upload"><img src="' + file.getUrl() + '"><input type="hidden" name="gallery[]" value="' + file.getUrl() + '"><button class="del-img btn btn-app bg-danger"><i class="far fa-trash-alt"></i></button></div>';
                    } else {
                        galleryImgOutput.innerHTML = '<div class="product-img-upload"><img src="' + file.getUrl() + '"><input type="hidden" name="gallery[]" value="' + file.getUrl() + '"><button class="del-img btn btn-app bg-danger"><i class="far fa-trash-alt"></i></button></div>';
                    }

                });
            }
        });
    }
</script>

<script>
    // https://question-it.com/questions/3558262/kak-ja-mogu-sozdat-neskolko-redaktorov-s-imenem-klassa
    // https://ckeditor.com/docs/ckfinder/demo/ckfinder3/samples/ckeditor.html
    window.editors = {};
    document.querySelectorAll('.editor').forEach((node, index) => {
        ClassicEditor
            .create(node, {
                ckfinder: {
                    uploadUrl: '<?= PATH ?>/adminlte/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
                },
                toolbar: ['ckfinder', '|', 'heading', '|', 'bold', 'italic', '|', 'undo', 'redo', '|', 'link', 'bulletedList', 'numberedList', 'insertTable', 'blockQuote'],
                image: {
                    toolbar: ['imageTextAlternative', '|', 'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight'],
                    styles: [
                        'alignLeft',
                        'alignCenter',
                        'alignRight'
                    ]
                }
            })
            .then(newEditor => {
                window.editors[index] = newEditor
            })
            .catch(error => {
                console.error(error);
            });
    });

</script>
