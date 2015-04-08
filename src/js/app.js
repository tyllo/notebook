$(document).foundation();

//////////////// for calendar input //////////////
function datetimepickerset(){
    $('.datetimepicker').datetimepicker({
        lang:'ru',
        timepicker:false,
        format:'Y-m-d',
        mask:true,
        closeOnDateSelect: 0,
        defaultDate:new Date(),
        dayOfWeekStart: 1,
    });
};
///////////////// set street from server //////////////////
var getStreets = function(url, val='') {
    var defaultOpt = $('select[name="street"] option[value=""]');
   $.ajax({
        url: url,
        type: 'POST',
        success: function(data){
            var streetArr = $.parseJSON(data);
            // pars option string
            var result = '';
            // установим значение начального option
            $(defaultOpt).text('...');
            $.each(streetArr, function(key,street){
                // alert (value);
                result = result +
                '<option value="' + street.id + '">' + street.name + '</option>';
            });
            $('select[name="street"]').append(result);
            $('select[name="street"] option[value="' + val + '"]')
            .attr("selected", "selected");
            delete window.result;
            // активируем поле street
            $('select[name="street"]').removeAttr('disabled');
        },
        error: function(data){
            $(defaultOpt).text('oops, error server');
        }
    })
};
///////////// add new phone input ////////////////
$('a.add').click(function(){
    if( $(this).hasClass('alert') ){
        // удалим input phone
        //  двойной parent - плохо ((
        $(this).parent().parent().remove();
        return;
    }
    // вставим клонированный phone в контейнер
    $(clonePhoneCollcetion).clone(true).appendTo('.container-phone');
    // поменяем классы в a и иконки i с + на -
    $(this)
        .removeClass('success')
        .addClass('alert')
        .children('i')
        .removeClass('fa-plus')
        .addClass('fa-minus');
});

////////////// for city input ////////////////////
// деактивируем поле street
$('select[name="street"]').attr('disabled','disabled');
// активируем поле city - WAF? O_o
$('select[name="city"]').removeAttr('disabled');

$('select[name="city"]').change(function() {
    // информер о подгрузки улиц
    var defaultOpt = $('select[name="street"] option[value=""]');
    $('select[name="street"]').attr('disabled','disabled');
    // удалим всех потомков
    $('select[name="street"]').children().remove();
    // и добавим default
    $('select[name="street"]').append('<option value="">...</option>')
    // если default то ничего не делаем
    if ($(this).val() ==='') {
        $('select[name="street"]').attr('disabled','disabled');
        $(defaultOpt).text('...');
        // выйдем
        return;
    };
    $(defaultOpt).text('Загрузка улиц...');
    var url = '/form/get/city/'+$(this).val();
    //запрос ajax
   $('select[name="street"]').append( getStreets(url) );
});

///////////// contact/creat/ info ////////////////
$('a[data-reveal-id="modal-creat-user"]').click(function(){
    $('form[name="creat-user"]').children().remove();
    $(cloneCreatForm).clone(true)
        .appendTo('form[name="creat-user"]');
    // навешиваем обработчик даты datetimepicker
    datetimepickerset();
});

//////////// contact/read/$id info //////////////
$('a[data-id-user]').click(function(){
    // удалим ранее подгуженный contact
    $('#read-user').children().remove();
    idUser = $(this).attr('data-id-user');
    var url = '/contact/read/'+idUser;
    $.ajax({
        url: url,
        type: 'POST',
        success: function(data){
            // добавим полученный contact в модальное окно
            $('#read-user').append(data);
        },
        error: function(data){
            $('#read-user').append('<h3>Не получилось загрузить,<br> ошибка на сервере</h3>');
        }
    })
});

//////////// contact/update/$id info ////////////
$('#update').click(function(){
    // удалим ранее подгуженный contact
    $('#update-user').children().remove();
    $('#update-user').append('<h3>Загрузка данны с сервера... </h3>');
    var url = '/contact/update/'+idUser;
    // добавим idUser к экшену
    $('#modal-update-user form').attr('action', url);
    $.ajax({
        url: url,
        type: 'POST',
        success: function(data){
            console.log(contact);
            var contact = $.parseJSON(data);
            // почистим
            $('#update-user').children().remove();
            // вставим чистый клон
            $(cloneCreatForm).clone(true).appendTo('#update-user');
            // навешиваем обработчик даты datetimepicker
            datetimepickerset();

            // добавим полученный contact в модальное окно
            $('input[name="name"]').val(contact.contact_name);
            $('input[name="surname"]').val(contact.contact_surname);
            $('input[name="patronymic"]').val(contact.contact_patronymic);
            $('input[value="' + contact.avatar + '"]')
            .attr("checked", "checked");
            $('input[name="date"]').val(contact.contact_date);
            $('select[name="city"] option[value="' + contact.city_id + '"]')
            .attr("selected", "selected");
            // get streets from ajax and set
            var url = '/form/get/city/' + contact.city_id;
            $('select[name="street"]').append( getStreets(url,contact.street_id) );
            // добавим телефоны
            $.each(contact.phoneArr, function(key,val){
                var clone = $(clonePhoneCollcetion).clone(true);
                $(clone).find('a.add')
                    .removeClass('success')
                    .addClass('alert')
                    .children('i')
                    .removeClass('fa-plus')
                    .addClass('fa-minus');
                $(clone).find('input[type="tel"]').val(val);
                $(clone).prependTo('.container-phone');
            });
        },
        error: function(data){
            $('#update-user').append('<h3>Не получилось загрузить,<br> ошибка на сервере</h3>');
        }
    })
});

/////////// contact/delete/$id info /////////////
$('#delete').click(function(){
    var href = $(this).attr('href');
    href = href + idUser;
    $(this).attr('href',href);
});

/////////////////////////////////////////////////

// id контакта, который был подгружен для просмотра
var idUser = '';
// клонируем поле для ввода
var cloneCreatForm = $('form[name="creat-user"]').children().clone(true);
// экземпляр input name=phone
var clonePhoneCollcetion = $('.phoneCollcetion').clone(true);
