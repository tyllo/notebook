$(document).foundation();

//////////////// for calendar input //////////////
$('.datetimepicker').datetimepicker({
    lang:'ru',
    timepicker:false,
    format:'Y-d-m',
    mask:true,
    closeOnDateSelect: 0,
    defaultDate:new Date(),
    dayOfWeekStart: 1,
});

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
    $('select[name="cstreet"]').children().remove();
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
            delete window.result;
            // активируем поле street
            $('select[name="street"]').removeAttr('disabled');
        },
        error: function(data){
            $(defaultOpt).text('oops, error server');
        }
    })
});

///////////// contact/creat/ info ////////////////

$('a[data-reveal-id="modal-creat-user"]').click(function(){
    $('form[name="creat-user"]').children().remove();
    $(cloneCreatForm).clone(true)
        .appendTo('form[name="creat-user"]');
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
    var url = '/contact/update/'+idUser;
    $(cloneCreatForm).clone(true).appendTo('#update-user');
    $.ajax({
        url: url,
        type: 'POST',
        success: function(data){
            // добавим полученный contact в модальное окно
           // $('#update-user').append(data);
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
