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
////////////// format phone number ///////////////////
$('input[type="tel"]').mask('9 (999) 999-9999');

///////////////// set street from server ////////////
var getStreets = function(url, val='') {
    var defaultOpt = $('select[name="street"] option[value=""]');
   $.ajax({
        url: url,
        type: 'POST',
        success: function(data){
            var streets = $.parseJSON(data);
            // pars option string
            var result = '';
            // установим значение начального option
            $(defaultOpt).text('...');
            $.each(streets, function(key,street){
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
    // format phone number
    $('input[type="tel"]').mask('9 (999) 999-9999');
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
    var url = '/get/street/'+$(this).val();
    //запрос ajax
   $('select[name="street"]').append( getStreets(url) );
});

///////////////// contact/creat/ ////////////////////
$('a[data-reveal-id="modal-creat-user"]').click(function(){
    $('form[name="creat-user"]').children().remove();
    $(cloneCreatForm).clone(true)
        .appendTo('form[name="creat-user"]');
        $('input[type="tel"]').mask('9 (999) 999-9999');
    // навешиваем обработчик даты datetimepicker
    datetimepickerset();
});

///////////////// contact/read ////////////////////
$('a[data-id-user]').click(function(){
    // удалим ранее подгуженный contact
    $('#read-user').children().remove();
    $('#read-user').append('<h3>Загрузка данны с сервера... </h3>');
    idUser = $(this).attr('data-id-user');
    var url = '/contact/read/'+idUser;
    $.ajax({
        url: url,
        type: 'POST',
        success: function(data){
            $('#read-user').children().remove();
            // вставим id user в форму для правильного update
            var url = '/contact/update/'+idUser;
            $('#modal-read-user form').attr('action',url);
            var contact = $.parseJSON(data);
            // вставим чистый клон
            $(cloneCreatForm).clone(true).appendTo('#read-user');
            $('input[type="tel"]').mask('9 (999) 999-9999');
            // навешиваем обработчик даты datetimepicker
            datetimepickerset();
            // удалим кнопку
            $('#read-user div:last').remove();
            // добавим полученный contact в модальное окно
            $('input[name="name"]').val(contact.name);
            $('input[name="surname"]').val(contact.surname);
            $('input[name="patronymic"]').val(contact.patronymic);
            $('input[value="' + contact.avatar + '"]')
            .attr("checked", "checked");
            $('input[name="bith"]').val(contact.bith);
            $('select[name="city"] option[value="' + contact.cid + '"]')
            .attr("selected", "selected");
            // get streets from ajax and set
            var url = '/get/street/' + contact.cid;

            $('select[name="street"]').append( getStreets(url, contact.sid) );
            // добавим телефоны
            $.each(contact.numbers, function(key, val){
                var clone = $(clonePhoneCollcetion).clone(true);
                $(clone).find('a.add')
                    .removeClass('success')
                    .addClass('alert')
                    .children('i')
                    .removeClass('fa-plus')
                    .addClass('fa-minus');
                $(clone).find('input[type="tel"]').val(val);
                $(clone).prependTo('.container-phone');
                // format phone number
                $('input[type="tel"]').mask('9 (999) 999-9999');
            });
        },
        error: function(data){
            $('#read-user').children().remove();
            $('#read-user').append('<h3>Не получилось загрузить,<br> ошибка на сервере</h3>');
        }
    })
});
/////////////// contact/update/$id ////////////////
// $('#update').click(function(){
// });

/////////////// contact/delete/$id /////////////////
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

$('input[type="tel"]').mask('9 (999) 999-9999');
