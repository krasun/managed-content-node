<?php $view->extend('layout.html.php') ?>

<?php $view['slots']->start('title') ?><?php echo $this->escape($page->getTitle()) ?><?php $view['slots']->stop() ?>

<?php $view['slots']->start('content') ?>
<article>
    <h1><?php echo $this->escape($page->getTitle()) ?></h1>

    <div id="page-meta">
        Опубликовано <time><?php echo $this->escape($view['time']->diff($page->getPublishedAt())) ?></time>,
        в категории - <a
            href="/category/<?php echo $this->escape($page->getPageCategory()->getSlug()) ?>/"><?php echo $this->escape($page->getPageCategory()->getTitle()) ?></a>.
    </div>
    <div id="page-content">
        <?php echo $page->getContent() ?>
    </div>
</article>
<?php if (count($pagesInSameCategory) > 1): ?>
    <aside id="pages-in-same-category">
        <h4>Из той же категории:</h4>
        <ul>
            <?php foreach ($pagesInSameCategory as $pageInSameCategory): ?>
                <?php if (!$pageInSameCategory->equals($page)): ?>
                    <li>
                        <a href="/<?php echo $this->escape($pageInSameCategory->getPublishedAt()->format('Y/m/d').'/'.$pageInSameCategory->getSlug().'/') ?>"><?php echo $this->escape($pageInSameCategory->getTitle()) ?></a>
                    </li>
                <?php endif ?>
            <?php endforeach ?>
        </ul>
    </aside>
<?php endif ?>
<?php $view['slots']->stop() ?>




