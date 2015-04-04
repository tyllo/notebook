<?php
require(__DIR__ . '/../bootstrap.php'); 
$tabs = '      ';
?>
<!doctype html>
<html class="no-js" lang="ru">
    <head>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Записная книжка</title>
			<?= Assests::getHead($tabs); ?>
    </head>
    <body>
		
			<?= Assests::getStart($tabs); ?>
			<?= Assests::getContent($tabs); ?>
			<?= Assests::getEnd($tabs); ?>
			<?= Assests::getEndScripts($tabs); ?>
    </body>
</html>
