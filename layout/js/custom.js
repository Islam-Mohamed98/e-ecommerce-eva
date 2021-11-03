/*global $, alert, console*/

$(function () {

    'use strict';
    if (document.getElementById("t-p") && document.getElementById("b-b")) {
      var totalPrice = document.getElementById("t-p").innerHTML;
      var balance = document.getElementById("b-b").innerHTML;
      var balanceAfter = document.getElementById("b-f");
      var balanceAfterNum = balance - totalPrice;
      balanceAfter.innerHTML = balanceAfterNum;
    }

    if (document.getElementById("order-carousel")) {
      $('#order-carousel div.carousel-item:first-child').addClass('active');
    }





    if (balanceAfterNum < 0 ) {
      $('.cart-page p.alert').addClass('alert-danger');
      $("#buy-cart-btn").attr("disabled", true);
    } else {
      $('.cart-page p.alert').addClass('alert-success');
      $("#buy-cart-btn").attr("disabled", false);
    }




    // Select Bettween Login and register

    $('.login .loginformdiv a').click(function() { // On A Click

        $(this).addClass('active').siblings().removeClass('active'); // Add Class Active To Clicked A and remove From Others
        $('.loginformdiv form').hide(); // hide all Forms
        $('.' + $(this).data('class')).fadeIn(100); // Show Form Which has Class matchwith data-class of A
    });


    // Hide Place Holder On Foucs

    $('[placeholder]').focus(function () {

        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    }).blur(function () {

        $(this).attr('placeholder', $(this).attr('data-text'));

    });



    /////////////////////

    $('.live').keyup(function () {

        $($(this).data('class')).text($(this).val());
    });

});
