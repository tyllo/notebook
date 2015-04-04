$(document).foundation();

////////////////// for calendar //////////////////
// 
$('#datetimepicker').datetimepicker({
  lang:'ru',
  timepicker:false,
  format:'d/m/Y',
  mask:true,
  closeOnDateSelect: 0,
  defaultDate:new Date(),
  dayOfWeekStart: 1,
});

///////////////// add new phone //////////////////
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
