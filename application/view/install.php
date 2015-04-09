
<!-- <div class="row">
    <div class="small-6 medium-4 small-centered columns">
        <ul class="small-block-grid-3">
            <li><img src="/images/avatar/avatar-3.png"></li>
            <li><img src="/images/avatar/avatar-13.png"></li>
            <li><img src="/images/avatar/avatar-23.png"></li>
        </ul>
    </div>
</div> -->
<div class="row">
    <div class="small-8 medium-6 small-centered columns">
        <br>
        <h5 style="text-align: center">
            <strong>Установить&nbsp;приложение "Записная&nbsp;книжка"</strong>
        </h5>
        <p>
            Создадим конфигурационный файл для доступа к базе данных:
            <kbd><?= APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'db.php'; ?></kbd>
        </p>
    </div>
</div>
<div class="row">
    <div class="small-8 medium-6 small-centered columns">
        <form name="creat-database" action="/install/creat" method="post">
            <!-- ############# username ################ -->
            <label>Имя пользователя для доступа к базе MYSQL
                <div class="row collapse">
                    <div class="small-1 columns">
                        <span class="prefix"><i class="fa fa-user-secret"></i></span>
                    </div>
                    <div class="small-11 columns">
                        <input name="username" type="text" placeholder="Username" required>
                    </div>
                </div>
            </label>
            <!-- ############# password ################ -->
            <label>Пароль для пользователя
                <div class="row collapse">
                    <div class="small-1 columns">
                        <span class="prefix"><i class="fa fa-key"></i></span>
                    </div>
                    <div class="small-11 columns">
                        <input name="password" type="text" placeholder="Password" required>
                    </div>
                </div>
            </label>
            <!-- ############# host ################ -->
            <label>Адрес доступа к базе данных
                <div class="row collapse">
                    <div class="small-1 columns">
                        <span class="prefix"><i class="fa fa-sitemap"></i></span>
                    </div>
                    <div class="small-11 columns">
                        <input name="host" type="text" placeholder="Host" required>
                    </div>
                </div>
            </label>
            <!-- ############# name database ################ -->
            <label>Имя создаваемой базы данных, которую вы создали для приложения и дали права для пользователя
                <div class="row collapse">
                    <div class="small-1 columns">
                        <span class="prefix"><i class="fa fa-database"></i></span>
                    </div>
                    <div class="small-11 columns">
                        <input name="database" type="text" placeholder="Name database" required>
                    </div>
                </div>
            </label>
            <!-- ############# button ################ -->
            <div class="row">
                <div class="small-12 columns">
                    <input type="submit" class="button" value="Cоздать" style="width:100%">
                </div>
            </div>
        </form>
    </div>
</div>
