
<!-- modal read user -->
<div id="modal-read-user" class="reveal-modal large" data-reveal>

    <div class="row collapse">
        <div class="small-12 columns">
            <h4>Инфо о контакте</h4>
        </div>
    </div>

    <form action="/contact/update/" method="post">
        <!-- контейнер, куда будет вставляться ajax с запрашиваемым контактом -->
        <div id="read-user"></div>
        <div class="row">
            <div class="small-12">
                <input type="submit" class="button success" value="Редактировать">
                <a id="delete" href="/contact/delete/" class="button alert">Удалить</a>
            </div>
        </div>
    </form>

    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>
