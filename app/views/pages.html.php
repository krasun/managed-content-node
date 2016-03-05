<?php $view->extend('layout.html.php') ?>

<?php $view['slots']->start('content') ?>
    <div><?php echo $this->escape($pageCategory->getTitle()) ?></div>
    <?php foreach ($pages as $page): ?>
        <div><?php echo $this->escape($page->getTitle()) ?></div>
    <?php endforeach ?>
<?php $view['slots']->stop() ?>

