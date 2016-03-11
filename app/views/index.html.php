<?php $view->extend('layout.html.php') ?>

<?php $view['slots']->start('content') ?>
    <div class="row index">
        <div class="col-lg-6">
            <?php $index = 0 ?>
            <?php foreach ($pageCategories as $pageCategory): ?>
                <?php if ($index < ceil(count($pageCategories) / 2)): ?>
                    <a href="/category/<?php echo $this->escape($pageCategory->getSlug()) ?>/"><h4><?php echo $this->escape($pageCategory->getTitle()) ?></h4></a>
                    <ul class="list-unstyled">
                        <?php foreach ($pages as $page): ?>
                            <?php if ($page->getPageCategory()->equals($pageCategory)): ?>
                                <li><a href="/<?php echo $this->escape($page->getPublishedAt()->format('Y/m/d') . '/' . $page->getSlug() . '/')  ?>"><?php echo $this->escape($page->getTitle()) ?></a> <span class="text-muted">(<?php echo $this->escape($view['time']->diff($page->getPublishedAt())) ?>)</span></li>
                            <?php endif?>
                        <?php endforeach ?>
                    </ul>
                <?php endif ?>
                <?php $index++ ?>
            <?php endforeach ?>
        </div>
        <?php if (count($pageCategories) > 1): ?>
            <div class="col-lg-6">
                <?php $index = 0 ?>
                <?php foreach ($pageCategories as $pageCategory): ?>
                    <?php if ($index >= ceil(count($pageCategories) / 2)): ?>
                        <a href="/category/<?php echo $this->escape($pageCategory->getSlug()) ?>/"><h4><?php echo $this->escape($pageCategory->getTitle()) ?></h4></a>
                        <ul class="list-unstyled">
                            <?php foreach ($pages as $page): ?>
                                <?php if ($page->getPageCategory()->equals($pageCategory)): ?>
                                    <li><a href="/<?php echo $this->escape($page->getPublishedAt()->format('Y/m/d') . '/' . $page->getSlug() . '/') ?>"><?php echo $this->escape($page->getTitle()) ?></a> <span class="text-muted">(<?php echo $this->escape($view['time']->diff($page->getPublishedAt())) ?>)</span></li>
                                <?php endif?>
                            <?php endforeach ?>
                        </ul>
                    <?php endif ?>
                    <?php $index++ ?>
                <?php endforeach ?>
            </div>
        <?php endif ?>
</div>
<?php $view['slots']->stop() ?>

