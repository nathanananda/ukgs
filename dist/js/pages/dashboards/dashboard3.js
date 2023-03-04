/*
Template Name: Material Admin
Author: Wrappixel
Email: niravjoshi87@gmail.com
File: js
*/
$(function() {
  'use strict';
  // ==============================================================
  // Last month earning
  // ==============================================================
  var sparklineLogin = function() {
    $('.bandwidth').sparkline(
      [4, 5, 0, 10, 9, 12, 4, 9, 4, 5, 3, 10, 9, 12, 10, 9, 12, 4, 9],
      {
        type: 'bar',
        width: '100%',
        height: '70',
        barWidth: '2',
        resize: true,
        barSpacing: '6',
        barColor: 'rgba(255, 255, 255, 0.3)'
      }
    );
    $('.spark-count').sparkline(
      [4, 5, 0, 10, 9, 12, 4, 9, 4, 5, 3, 10, 9, 12, 10, 9, 12, 4, 9],
      {
        type: 'line',
        width: '100%',
        height: '70',
        barWidth: '2',
        resize: true,
        fillColor: 'transparent',
        lineColor: 'rgba(255, 255, 255, 0.6)'
      }
    );
  };
  var sparkResize;

  $(window).resize(function(e) {
    clearTimeout(sparkResize);
    sparkResize = setTimeout(sparklineLogin, 500);
  });
  sparklineLogin();

  // ==============================================================
  // Our Visitor
  // ==============================================================

});
