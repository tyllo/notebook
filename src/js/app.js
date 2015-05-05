
//TODO: исправить спагетти-код!!!!

$(document).foundation();

// id контакта, который был подгружен для просмотра
var idUser = '';

//////////////// for calendar input //////////////
// http://xdsoft.net/jqplugins/datetimepicker/
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
var getStreets = function(url, val) {
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
            if(typeof val === 'undefined') {
                $('select[name="street"]').removeAttr('disabled');
            }
        },
        error: function(data){
            $(defaultOpt).text('oops, error server');
        }
    })
};
///////////// add new phone input ////////////////
$('a.add').click(function(e){
	e.preventDefault();
	if( $(this).attr('disabled') == 'disabled' ){
		return;
	};
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
    $('select[name="street"]').append('<option value="">...</option>');
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
$('a[data-reveal-id="modal-creat-user"]').click(function(e){
    e.preventDefault();
	$('form[name="creat-user"]').children().remove();
    $(cloneCreatForm).clone(true)
        .appendTo('form[name="creat-user"]');
    $('input[type="tel"]').mask('9 (999) 999-9999');
    // навешиваем обработчик даты datetimepicker
    datetimepickerset();
});
///////////////// contact/read ////////////////////
$('a[data-id-user]').click(function(e){
    e.preventDefault();
	/// спрячем кнопку
    $('input[type="submit"]').hide();
    $('#update').show();
    // удалим ранее подгуженный contact
    $('#read-user').children().remove();
    $('#read-user').append('<h3>Загрузка данны с сервера... </h3>');
    idUser = $(this).attr('data-id-user');
    var url = '/contact/read/'+idUser;
    $.ajax({
        url: url,
        type: 'POST',
        success: function(data){
            // TODO грамматно вынести в отдельную функцию
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
            // удалим кнопку добавить
            $('#read-user div:last').remove();
            // добавим полученный contact в модальное окно
            $('#modal-read-user input[name="name"]').val(contact.name);
            $('#modal-read-user input[name="surname"]').val(contact.surname);
            $('#modal-read-user input[name="patronymic"]').val(contact.patronymic);
            $('#modal-read-user input[value="' + contact.avatar + '"]')
            .attr("checked", "checked");
            $('#modal-read-user input[name="bith"]').val(contact.bith);
            $('#modal-read-user select[name="city"] option[value="' + contact.cid + '"]')
            .attr("selected", "selected");
            // get streets from ajax and set
            var url = '/get/street/' + contact.cid;

            $('select[name="street"]').append( getStreets(url, contact.sid) );
            // добавим телефоны
            $('.phoneCollcetion').remove();
            var len = $(contact.numbers).length;
            $.each(contact.numbers, function(key, val){
                var clone = $(clonePhoneCollcetion).clone(true);
                // у последнего телефона + убирать не будем
                if (key != len - 1) {
                    $(clone).find('a.add')
                        .removeClass('success')
                        .addClass('alert')
                        .children('i')
                        .removeClass('fa-plus')
                        .addClass('fa-minus');
                };
                $(clone).find('input[type="tel"]').val(val);
                $(clone).appendTo('.container-phone');
                // format phone number
                $('input[type="tel"]').mask('9 (999) 999-9999');
            });
            // а теперь деактивируем все инпуты
            $('#modal-read-user input').attr('disabled','disabled');
            $('#modal-read-user select').attr('disabled','disabled');
            $('#modal-read-user .avatar').hide();
            $('#modal-read-user a.add').attr('disabled','disabled');
        },
        error: function(data){
            $('#read-user').children().remove();
            $('#read-user').append('<h3>Не получилось загрузить,<br> ошибка на сервере</h3>');
        }
    })
});
/////////////// contact/update/$id ////////////////
$('#update').click(function(e){
    e.preventDefault();
	$(this).hide();
    // а теперь активируем все инпуты
    $('input').removeAttr('disabled');
    $('select').removeAttr('disabled');
    $('input[type="submit"]').show();
    $('a.add').removeAttr('disabled');
    $('.avatar').show();
});
/////////////// contact/delete/$id /////////////////
$('#delete').click(function(e){
    e.preventDefault();
	var href = $(this).attr('href');
    href = href + idUser;
    $(this).attr('href',href);
});
/////////////////////////////////////////////////

// клонируем поле для ввода
var cloneCreatForm = $('form[name="creat-user"]').children().clone(true);
// экземпляр input name=phone
var clonePhoneCollcetion = $('.phoneCollcetion').clone(true);