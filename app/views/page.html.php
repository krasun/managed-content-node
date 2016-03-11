<?php $view->extend('layout.html.php') ?>

<?php $view['slots']->start('title') ?><?php echo $this->escape($page->getTitle()) ?><?php $view['slots']->stop() ?>

<?php $view['slots']->start('content') ?>
<h1><?php echo $this->escape($page->getTitle()) ?></h1>
<?php echo $page->getContent() ?>
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




