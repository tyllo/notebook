<?php $tabs = '      ' ?>
<!doctype html>
<html class="no-js" lang="ru">
    <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Записная книжка</title>
            <?= Help::getHead($tabs); ?>
    </head>
    <body>
            <?= Help::getStart($tabs); ?>
            <?= Help::getContent($tabs); ?>
            <?= Help::getEnd($tabs); ?>
            <?= Help::getEndScripts($tabs); ?>
    </body>
</html>