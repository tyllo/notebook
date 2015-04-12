
<!-- modal creat user -->
<div id="modal-creat-user" class="reveal-modal large" data-reveal>

    <div class="row collapse">
        <div class="small-12 columns">
            <h4>Добавить новый контакт</h4>
        </div>
    </div>

    <form name="creat-user" action="/contact/creat" method="post">
        <!-- ############# avatar ################ -->
        <div class="row avatar">
            <div class="small-12 columns">
                <ul class="small-block-grid-4 medium-block-grid-8 large-block-grid-12">
                  <li>
                    <label>
                        <input type="radio" name="avatar" value="avatar-1" checked="checked">
                        <img src="/images/avatar-svg/placeholder.gif" class="avatar-1">
                    </label>
                  </li>
                  <?php $i=2; while($i<25):?>
                  <li>
                    <label tyle="position: relative">
                        <input type="radio" name="avatar" value="<?= "avatar-$i"?>">
                        <img src="/images/avatar-svg/placeholder.gif" class="avatar-<?=$i?>">
                    </label>
                  </li>
                  <?php $i++; endwhile; ?>
                </ul>
            </div>
        </div>
        <!-- ############# name ################ -->
        <div class="row collapse">
            <div class="small-1 columns">
                <span class="prefix"><i class="fa fa-user fa-fw"></i></span>
            </div>
            <div class="small-11 medium-3 columns">
                <input name="name" type="text" placeholder="Имя" required>
            </div>

            <div class="small-1 show-for-small columns">
                <span class="prefix"><i class="fa fa-user"></i></span>
            </div>
            <div class="small-11 medium-4 columns">
                <input name="surname" type="text" placeholder="Фамилия">
            </div>

            <div class="small-1 show-for-small columns">
                <span class="prefix"><i class="fa fa-user"></i></span>
            </div>
            <div class="small-11 medium-4 columns">
                <input name="patronymic" type="text" placeholder="Отчество">
            </div>
        </div>
        <!-- ############# phone ############### -->
        <div class="container-phone">
            <div class="row phoneCollcetion collapse">
                <div class="small-1 columns">
                    <span class="prefix"><i class="fa fa-phone"></i></span>
                </div>
                <div class="small-10 medium-10 columns">
                    <input name="number[]" type="tel" placeholder="Телефон" style="width:100%">
                </div>
                <div class="small-1 columns">
                    <a class="button postfix success add" href="#">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
            </div>
        </div>
        <!-- ############# street ############## -->
        <div class="row collapse">
            <div class="small-12 medium-6 columns">
                <div class="row collapse">
                    <div class="small-1 medium-2 columns">
                        <span class="prefix"><i class="fa fa-map-marker"></i></span>
                    </div>
                    <div class="small-11 medium-10 columns">
                            <label>
                            <select name="city" required>
                                <option value="">...</option>
                                <?php foreach ($citys as $city):?>
                                <option value="<?=$city['id']?>"><?=$city['name']?></option>
                                <?php endforeach;?>
                            </select>
                        </label>
                    </div>
                </div>
            </div>
            <div class="small-12 medium-6 columns">
                <div class="row collapse">
                    <div class="small-1 medium-2 columns">
                        <span class="prefix"><i class="fa fa-street-view"></i></span>
                    </div>
                    <div class="small-11 medium-10 columns">
                        <label>
                            <select name="street" required>
                                <option value="">...</option>
                            </select>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <!-- ############# date ################ -->
        <div class="row collapse">
            <div class="small-1 columns">
                <span class="prefix"><i class="fa fa-calendar"></i></span>
            </div>
            <div class="small-11 columns">
                <input name="bith" type="date" class="datetimepicker">
            </div>
        </div>
        <!-- ############ button ############### -->
        <div class="row collapse">
            <div class="small-12 medium-4 columns">
                <input type="submit" class="button" value="Добавить" style="width:100%">
            </div>
        </div>
    </form>

    <!-- ############ close modal ############### -->
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>

</div>
