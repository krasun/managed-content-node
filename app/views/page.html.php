<?php $view->extend('layout.html.php') ?>

<?php $view['slots']->start('content') ?>
<div id="page">
    <h1><?php echo $this->escape($page->getTitle()) ?></h1>
    <div id="page-content">
        <?php echo $page->getContent() ?>
    </div>
    <div id="page-meta">
        published at: <?php echo $this->escape($view['time']->diff($page->getPublishedAt())) ?>
        category: <?php echo $this->escape($page->getPageCategory()->getTitle()) ?>
    </div>
</div>

<div id="pages-in-same-category">
    <div><?php $page->getPageCategory()->getTitle() ?></div>
    <?php foreach ($pagesInSameCategory as $pageInSameCategory): ?>
        <?php if (! $pageInSameCategory->equals($page)): ?>
            <div><?php echo $this->escape($pageInSameCategory->getTitle()) ?></div>
        <?php endif ?>
    <?php endforeach ?>
</div>
<?php $view['slots']->stop() ?>




