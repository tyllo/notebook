<div class="row">
  <div class="small-12 columns"><h3>Заголовок</h3></div>
</div>
<div class="row collapse">
  <input type="text" placeholder="Введите имя для поиска">
  <ul class="small-block-grid-3 medium-block-grid-6 large-block-grid-8">
<?php for ($i=1;$i<40;$i++):?>
    <li>
      <a href="#" data-reveal-id="modal-show-user" data-id-user="<?=$i?>">
        <img class="th" src="http://style.imgbb.ru/st/img/user.png" />
      </a>
      <div class="hide-text">Имя</div>
      <div class="hide-text">Фамилия</div>
    </li>
<?php endfor; ?>
  </ul>
</div>
