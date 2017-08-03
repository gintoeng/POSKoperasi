$(document).ready(function(){
//  TweenLite.to($("#caption"),2,{css:{top:0},delay:1, ease:Power2.easeOut});
  TweenLite.to($("#btn1"),2,{css:{left:0},delay:0.2, ease:Power2.easeOut});
  TweenLite.to($("#btn2"),2,{css:{left:20},delay:0.4, ease:Power2.easeOut});
  TweenLite.to($("#btn3"),2,{css:{left:40},delay:0.8, ease:Power2.easeOut});
  TweenLite.to($("#btn4"),2,{css:{left:0},delay:1, ease:Power2.easeOut});
  TweenLite.to($("#btn5"),2,{css:{left:20},delay:1.50, ease:Power2.easeOut});
  TweenLite.to($("#btn6"),2,{css:{left:40},delay:1.80, ease:Power2.easeOut});
  
  });

jQuery(document).ready(function() {
  jQuery('.tabs .tab-links a').on('click', function(e)  {
    var currentAttrValue = jQuery(this).attr('href');

    // Show/Hide Tabs
    jQuery('.tabs ' + currentAttrValue).show().siblings().hide();

    // Change/remove current tab to active
    jQuery(this).parent('li').addClass('active').siblings().removeClass('active');

    e.preventDefault();
  });
});