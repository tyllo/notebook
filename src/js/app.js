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
    // здесь хорошо бы localStorage проверить, 
    // вдруг уже подгружали улицы, незачем сервер нагружать
    var url = $('form[name="add-user"]').attr('action');
    //запрос ajax
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: 'get=street&city='+$(this).val(),
        success: function(data){
            var streetArr = $.parseJSON(data);
            // pars option string
            var result = '';
            // установим значение начального option
            $(defaultOpt).text('...');
            $.each(streetArr, function(key, street){
                // результат нужно добавить в localStorage
                result = result +
                    '<option name="' + street.id + '">' +
                    street.name + '</option>';
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

////////////////// get user info //////////////////
$('a[data-id-user]').click(function(){
    var idUser = $(this).attr('data-id-user');
    var url = '/add-user';
    $.ajax({
        url: url,
        type: 'POST',
        data: 'set=user&user=' + idUser,
        success: function(data){
            alert(data);
        },
        error: function(data){
            // error user
        }
    })
})


