$(document).foundation();


//////////////// for calendar input //////////////
$('#datetimepicker').datetimepicker({
    lang:'ru',
    timepicker:false,
    format:'d/m/Y',
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
    var clone = $('#PhoneCollcetion').clone(true);
    // и вставим в контейнер
    $('#container').append(clone);
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
    var defaultOpt = $('#street option[value="default"]');
    $('#street').attr('disabled','disabled');
    // удалим всех потомков
    $('#street').children().remove();
    // и добавим default
    $('#street').append('<option name="default">...</option>')
    // если default то ничего не делаем
    if ($(this).val() ==='default') {
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
            $.each(streetArr, function(street_id, street_name){
                // результат нужно добавить в localStorage
                result = result +
                    '<option value="' + street_id + '">' +
                    street_name + '</option>';
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
$('a[data-id-user]').click(function(){
    // удалим ранее подгуженный contact
    $('#show-user').children().remove();
    var idUser = $(this).attr('data-id-user');
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
