$(document).ready(function() {
    $("img").lazyload({         
         placeholder : siteWebRoot + "/assets/img/grey.gif",
         effect: "fadeIn"
    });
    
    function addHintPopup() {
        var t = setTimeout(hideHintPopup, 2000, t);
        
        $('<div id="hintwindow"><p>Click the image to advance to the next one.</p></div>')
            .css({
                border: "5px solid #fff",
                padding: "10px",
                background: "#333",
                position: "fixed",
                top: "-300px",
                textAlign: "center",
                marginLeft: "20%",
                marginRight: "20%",
                width: "60%",
            })
            .appendTo('body')
            .animate({top: "30%"}, 500)
            .click(function () {
               hideHintPopup(); 
            });
         
        
    }
    
    function hideHintPopup(t) {
        $('div#hintwindow').fadeOut();
        clearTimeout(t);
    }
    
    /* 
     * If you change the markup in either the page templates
     * or the row templates, this following section might break.
     * You can then either try to modify this, or disable it
     */
    
    var allImg = $('div#gallery img').css('cursor', 'pointer');
    
    if (allImg.length > 0) {
        var marStr = $($('div#gallery img')[0]).css('margin-bottom');
        var marVal = Number(marStr.substr(0, marStr.length - 2));
        var imgMar;
        
        if (isNaN(marVal)) {                
            imgMar = 10;
        } else {
            imgMar = marVal;
        }
        
        // Forward scroll
        for (var i = 0; i < allImg.length - 1; i++) {
            var node = allImg[i];
            
            $(node).click(function() {
                var nodeY = $(this).offset().top;
                var nextY = 0;
                
                for (var j = 0; j < allImg.length; j++) {
                    if ($(allImg[j]).offset().top > nodeY) {
                        nextY = $(allImg[j]).offset().top;
                        break;
                    }
                }
                
                if (nextY > nodeY) {
                    $('html,body').animate({scrollTop: nextY - imgMar}, 200);
                }
            });
        }
        
        // Return to top from the last img
        $(allImg[allImg.length - 1]).click(function() {
            var nextY = $(allImg[0]).offset().top;
            $('html,body').animate({scrollTop: nextY - imgMar}, 500);
        });
    
        // Show advance hint only when showing galleries
        if ($('div#gallery').length != 0) {
            addHintPopup();
        }
    }
});

