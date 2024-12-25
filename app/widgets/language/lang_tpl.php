<div class="dropdown d-inline-block">
    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
        <img src="<?= PATH ?>/assets/img/languages/<?= $this->language['code'] ?>.png"
             alt="<?= $this->language['title'] ?>">
    </a>
    <ul class="dropdown-menu" id="languages">
        <?php foreach ($this->languages as $code => $language): ?>
        <?php if($code == $this->language['code']) continue; ?>
            <li>
                <button class="dropdown-item" data-langcode="<?=$code ?>">
                    <img src="<?= PATH ?>/assets/img/languages/<?=$code ?>.png" alt="<?=$language['title'] ?>">
                    <?=$language['title'] ?>
                </button>
            </li>
        <?php endforeach; ?>
    </ul>
</div>