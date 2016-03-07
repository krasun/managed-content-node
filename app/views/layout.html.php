<!DOCTYPE html>
<html>
    <head>
        <title><?php if ($view['slots']->has('title')) { echo $view['slots']->output('title'); } ?></title>
    </head>
    <body>
        <header>
            <div><a href="/">Homepage</a></div>
        </header>
        <div id="content">
            <?php if ($view['slots']->has('content')): ?>
                <?php $view['slots']->output('content') ?>
            <?php endif; ?>
        </div>
        <footer>
            <?php echo date('Y') ?>
        </footer>
    </body>
</html>