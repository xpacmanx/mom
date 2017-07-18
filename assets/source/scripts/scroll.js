$(function(){
  $('.slides .slide').each(function(i,e){
    var text = '';
    if ($(e).find('.title').length)
      text = '<span>'+$(e).find('.title').text()+'</span>';
    if (i == 0) {
      $('.nav').append('<li class="active">'+text+'</li>')
    } else {
      $('.nav').append('<li>'+text+'</li>')
    }
  });

})
$(document).on('click','.nav li',function(){
  var index = $(this).index();
  var top = $('.slides .slide').eq(index).offset().top;
  $('body').animate({
    scrollTop: top
  },200);
});

$(window).on('scroll', function(e){
  var top = $(this).scrollTop();
  $('[data-color]').each(function(i,e){
    if ($(e).offset().top - ($(window).height()/2) < top) {
      $('body').css('background',$(e).data('color'));
    }
  });
  $('.slide').each(function(i,e){
    if ($(e).offset().top - ($(window).height()/2) < top) {
      $('.nav li.active').removeClass('active');
      $('.nav li').eq($(e).index()).addClass('active');
    }
  });
});
