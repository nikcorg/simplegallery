$(document).ready(function() {
    $("img").lazyload({         
         placeholder : siteWebRoot + "/assets/img/grey.gif",
         effect: "fadeIn"
    });
    
    /* 
     * If you change the markup in either the page templates
     * or the row templates, this following section might break.
     * You can then either try to modify this, or disable it
     */
     
    $('div#gallery img').each(function (ind, el) {
        $(this).css('cursor', 'pointer');
        $(this).click(function() {
            var allImg = $('div#gallery img');
            var myTop  = $(this).offset().top;
            var marStr = $($('div#gallery img')[0]).css('margin-bottom');
            var marVal = Number(marStr.substr(0, marStr.length - 2));
            var imgMar;
            
            if (isNaN(marVal)) {                
                imgMar = 10;
            } else {
                imgMar = marVal;
            }
            
            for (var i = 0; i < allImg.length; i++) {
                var nextTop = $(allImg[i]).offset().top;
                
                if (nextTop > myTop) {
                    $('html,body').animate({scrollTop: nextTop - imgMar}, 100);
                    break;
                }
            }
        });
    });
});

