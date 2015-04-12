
<!-- modal read user -->
<div id="modal-read-user" class="reveal-modal large" data-reveal>

    <div class="row collapse">
        <div class="small-12 columns">
            <h4>Инфо о контакте</h4>
        </div>
    </div>

    <form name="read-user" action="/contact/update/" method="post">
        <!-- контейнер, куда будет вставляться ajax с запрашиваемым контактом -->
        <div id="read-user"></div>
        <!-- ############ button ############### -->
        <div class="row collapse">
            <div class="small-12 medium-6 columns">
                <a id="update" href="#" class="button success" style="width:100%;">Редактировать</a>
                <input type="submit" class="button" style="width:100%; display:none;" value="Изменить">
            </div>
            <div class="small-12 medium-6 columns">
                <a id="delete" href="/contact/delete/" class="button alert" style="width:100%">Удалить</a>
            </div>
        </div>
    </form>

    <!-- ############ close modal ############### -->
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
