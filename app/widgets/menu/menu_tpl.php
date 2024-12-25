<li class="nav-item <?= isset($category['children']) ? 'dropdown' : '' ?>">
    <a class="nav-link <?= isset($category['children']) ? 'dropdown-toggle' : '' ?>"
       href="category/<?= $category['slug'] ?>" <?= isset($category['children']) ?
        'data-bs-toggle="dropdown"' : '' ?>><?= $category['title'] ?></a>
    <?php if (isset($category['children'])): ?>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <?= $this->getMenuHTML($category['children']); ?>
        </ul>
    <?php endif; ?>
</li>
