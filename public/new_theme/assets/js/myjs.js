$(document).ready(function(){
  // Show Color Option
  $('.gear-check').click(function() {
    $('.color-option').fadeToggle();
  });

  $('.option-box .color-option ul li:nth-child(1)').click(function() {
    $('#kt_header, .kt-aside__brand, .kt-asid, .kt-aside-menu, .kt-aside-menu-wrapper').toggleClass('bg1').removeClass('bg2 bg3 bg4 bg5');
  });
  $('.option-box .color-option ul li:nth-child(2)').click(function() {
    $('#kt_header, .kt-aside__brand, .kt-asid, .kt-aside-menu, .kt-aside-menu-wrapper').toggleClass('bg2') .removeClass('bg1 bg3 bg4 bg5');
  });
  $('.option-box .color-option ul li:nth-child(3)').click(function() {
    $('#kt_header, .kt-aside__brand, .kt-asid, .kt-aside-menu, .kt-aside-menu-wrapper').toggleClass('bg3').removeClass('bg2 bg1 bg4 bg5');
  });
  $('.option-box .color-option ul li:nth-child(4)').click(function() {
    $('#kt_header, .kt-aside__brand, .kt-asid, .kt-aside-menu, .kt-aside-menu-wrapper').toggleClass('bg4').removeClass('bg2 bg3 bg1 bg5');
  });
  $('.option-box .color-option ul li:nth-child(5)').click(function() {
    $('#kt_header, .kt-aside__brand, .kt-asid, .kt-aside-menu, .kt-aside-menu-wrapper').toggleClass('bg5').removeClass('bg2 bg3 bg4 bg1');
  });


  // hide loader After Time
  $(".box-loader").fadeOut(1000)
});
