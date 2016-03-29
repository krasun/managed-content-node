<?php $view->extend('layout.html.php') ?>

<?php $view['slots']->start('content') ?>
<div id="pages-by-category">
    <h1><?php echo $this->escape($pageCategory->getTitle()) ?></h1>
    <?php if (count($pages) > 0): ?>
        <ul>
        <?php foreach ($pages as $page): ?>
            <li>
                <a href="/<?php echo $this->escape($page->getPublishedAt()->format('Y/m/d') . '/' . $page->getSlug() . '/')  ?>"><?php echo $this->escape($page->getTitle()) ?></a>
                <span class="published">(<time><?php echo $this->escape($view['time']->diff($page->getPublishedAt())) ?></time>)</span>
            </li>
        <?php endforeach ?>
        </ul>
    <?php endif ?>
</div>
<?php $view['slots']->stop() ?>

