<?php $tabs = '      ' ?>
<!doctype html>
<html class="no-js" lang="ru">
    <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Записная книжка</title>
            <?= Help::get()->head($tabs); ?>
    </head>
    <body>
            <?= $before; ?>
            <?= $content; ?>
            <?= $after; ?>
            <?= Help::get()->end($tabs); ?>
    </body>
</html>