<!DOCTYPE html>
<html>
    <head>
        <title></title>
    </head>
    <body>
        <div id="content">
            <?php if ($view['slots']->has('content')): ?>
                <?php $view['slots']->output('content') ?>
            <?php endif; ?>
        </div>
    </body>
</html>