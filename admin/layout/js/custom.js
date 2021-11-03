/*global $, alert, console*/

$(function () {

    'use strict';

    var dataInDashboard = $('.dashboard-main').data('class'); // dataclass = ""

    $('.dashboard-nav li.' +  $('.dashboard-main').data('class') + ' a').addClass('active') .parent().siblings().children().removeClass("active");


});
