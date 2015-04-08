$(document).foundation();


//////////////// for calendar input //////////////
$('#datetimepicker').datetimepicker({
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
    // клонируем форму с inpute type=phone
    // и вставим в контейнер
    $('#PhoneCollcetion').clone(true)
        .val(null).appendTo('#container');
    // удалим id оригинльного контейнера
    $('#PhoneCollcetion').removeAttr('id').off();
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
$('#street').attr('disabled','disabled');

    $('#city').change(function() {
    // информер о подгрузки улиц
    var defaultOpt = $('#street option[value=""]');
    $('#street').attr('disabled','disabled');
    // удалим всех потомков
    $('#street').children().remove();
    // и добавим default
    $('#street').append('<option value="">...</option>')
    // если default то ничего не делаем
    if ($(this).val() ==='') {
        $('#street').attr('disabled','disabled');
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
            $('#street').append(result);
            delete window.result;
            // активируем поле street
            $('#street').removeAttr('disabled');
        },
        error: function(data){
            $(defaultOpt).text('oops, error server');
        }
    })
})

////////////////// contact/read/$id info //////////////////
var idUser = '';
$('a[data-id-user]').click(function(){
    // удалим ранее подгуженный contact
    $('#show-user').children().remove();
    idUser = $(this).attr('data-id-user');
    var url = '/contact/read/'+idUser;
    $.ajax({
        url: url,
        type: 'POST',
        success: function(data){
            // добавим полученный contact в модальное окно
            $('#show-user').append(data);
        },
        error: function(data){
            $('#show-user').append('<h3>Не получилось загрузить,<br> ошибка на сервере</h3>');
        }
    })
})

////////////////// contact/update/$id info //////////////////
$('#update').click(function(){
    // удалим ранее подгуженный contact
    $('#update-user').children().remove();
    var url = '/contact/update/'+idUser;
    $.ajax({
        url: url,
        type: 'POST',
        success: function(data){
            // добавим полученный contact в модальное окно
            $('#show-user').append(data);
        },
        error: function(data){
            $('#show-user').append('<h3>Не получилось загрузить,<br> ошибка на сервере</h3>');
        }
    })
})

////////////////// contact/delete/$id info //////////////////
$('#delete').click(function(){
    var href = $(this).attr('href');
    href = href + idUser;
    $(this).attr('href',href);
    alert(href);
})
