<?php $view->extend('layout.html.php') ?>

<?php $view['slots']->start('content') ?>
    <?php foreach ($pageCategories as $pageCategory): ?>
        <div><?php echo $this->escape($pageCategory->getTitle()) ?></div>
        <?php foreach ($pages as $page): ?>
            <?php if ($page->getPageCategory()->equals($pageCategory)): ?>
                <div><?php echo $this->escape($page->getTitle()) ?></div>
            <?php endif?>
        <?php endforeach ?>
    <?php endforeach ?>
<?php $view['slots']->stop() ?>

