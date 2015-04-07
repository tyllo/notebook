
<div class="row">
  <br><!-- <div class="small-12 columns"><h3>Заголовок</h3></div> -->
</div>
<div class="row collapse">
  <ul class="small-block-grid-3 medium-block-grid-6 large-block-grid-8">
<?php foreach($contactArr as $contact) :?>
    <li>
      <a href="#" data-reveal-id="modal-show-user" data-id-user="<?=$contact['id']?>">
        <img class="th" src="/images/user.png" />
      </a>
      <div class="hide-text"><?=$contact['name']?></div>
      <div class="hide-text"><?=$contact['surname']?></div>
    </li>
<?php endforeach; ?>
  </ul>
</div>
