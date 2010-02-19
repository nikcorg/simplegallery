$(document).ready(function() {
    $("img").lazyload({         
         placeholder : siteWebRoot + "/assets/img/grey.gif",
         effect: "fadeIn"
    });
    
    function addHintPopup() {
        var t = setTimeout(hideHintPopup, 3500, t);
        
        $('<div id="hintwindow"><p>Click the image to advance to the next one.</p></div>')
            .css({
                top: '-300px'
            })
            .appendTo('body')
            .animate({top: "40%"}, 500)
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
            
            $(node).click(function(e) {
                var nodeY  = $(this).offset().top;
                var nextY  = 0;
                var anchor = "";

                // Find next Y-coordinate
                for (var j = 0; j < allImg.length; j++) {
                    if ($(allImg[j]).offset().top > nodeY) {
                        nextY  = $(allImg[j]).offset().top;
                        anchor = $(allImg[j]).parents('a').attr('href');
                        break;
                    }
                }
                
                // Scroll window
                if (nextY > nodeY) {
                    $('html,body').animate({scrollTop: nextY - imgMar}, 200);
                }
                
                // Update url
                document.location.hash = anchor;
                e.preventDefault();
                return false;
            });
        }
        
        // Return to top from the last img
        $(allImg[allImg.length - 1]).click(function(e) {
            var nextY = $(allImg[0]).offset().top;
            
            // Scroll window
            $('html,body').animate({scrollTop: nextY - imgMar}, 500);
            
            // Update url
            document.location.hash = $(allImg[0]).parents('a').attr('href');
            e.preventDefault();
            return false;
        });
    
        // Show advance hint only when showing galleries
        if ($('div#gallery').length != 0) {
            addHintPopup();
        }
    }
});

