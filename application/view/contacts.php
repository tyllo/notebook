<?php
// наверно массив нужно иницилизироать в моделе, но здесь он пока удобнее
$color = ['#ff386a','#85bbeb','#68c496','#b34d1f','#ffd16d','#ffc55d',
          '#c34934','#487093','#ffd16d','#ff690f','#b6dbfb','#4d1b02','#ffa8bd'];
?>
<div class="row">
  <div class="small-12 columns">
  <br><?php if($contacts == []):?><h2>Заполните свою записную книжку!!</h2><?php endif;?>
  </div>
  <div class="small-12 columns">
    <ul class="small-block-grid-3 medium-block-grid-6 large-block-grid-8">
<?php foreach($contacts as $contact) :?>
      <li>
        <div class="panel">
          <a href="#" data-reveal-id="modal-read-user" data-id-user="<?=$contact['id']?>">
            <img class="th" src="<?=$contact['avatar']?>" style="background-color: <?=$color[rand(0,12)]?>"/>
          </a>
          <div class="hide-text"><?=$contact['name']?></div>
          <div class="hide-text"><?=$contact['surname']?></div>
        </div>
      </li>
 <?php endforeach; ?>
    </ul>
  </div>
</div>
