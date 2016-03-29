<!DOCTYPE html>
<html>
    <head>
        <meta charset="<?php echo $charset ?>" />

        <title><?php if ($view['slots']->has('title')) { echo $view['slots']->output('title'); } ?></title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

        <style type="text/css">
            body {
                padding-top: 20px;
                padding-bottom: 20px;
            }

            /* Everything but the jumbotron gets side spacing for mobile first views */
            .header,
            .marketing,
            .footer {
                padding-right: 15px;
                padding-left: 15px;
            }

            .header {
                padding-bottom: 20px;
                border-bottom: 1px solid #e5e5e5;
            }

            .header h3 {
                margin-top: 0;
                margin-bottom: 0;
                line-height: 40px;
            }

            .footer {
                padding-top: 19px;
                color: #777;
                border-top: 1px solid #e5e5e5;
            }

            @media (min-width: 768px) {
                .container {
                    max-width: 730px;
                }
            }
            .container-narrow > hr {
                margin: 30px 0;
            }

            .index {
                margin: 40px 0;
            }
            .index p + h4 {
                margin-top: 28px;
            }

            @media screen and (min-width: 768px) {
                .header,
                .index,
                .footer {
                    padding-right: 0;
                    padding-left: 0;
                }
                .header {
                    margin-bottom: 30px;
                }
            }

            a.index-link,
            a.index-link:link,
            a.index-link:hover,
            a.index-link:visited {
                text-decoration: none !important;
            }

            #page-meta {
                color: #999;
            }

            #page-content {
                margin: 20px 0;
            }

            #pages-in-same-category{
                padding-top: 10px;
            }

            #pages-in-same-category {
                border-top: 1px solid #e5e5e5;
            }

            #pages-by-category .published {
                color: #999;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <header class="header clearfix">
                <a href="/" class="index-link"><h3 class="text-muted"><?php echo $node['title'] ?></h3></a>
                <?php if ($node['description']): ?>
                    <p class="text-muted"><?php echo $node['description'] ?></p>
                <?php endif ?>
            </header>
            <?php if ($view['slots']->has('content')): ?>
                <?php $view['slots']->output('content') ?>
            <?php endif; ?>
            <footer class="footer">
                <?php echo $view->render('footer.html.php') ?>
            </footer>
        </div>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    </body>
</html>