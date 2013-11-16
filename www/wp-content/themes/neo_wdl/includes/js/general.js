(function($) {
    $(document).ready(function() { 
    	
		$('#slides').cycle({ 
			fx:     'fade', 
			speed:  1000, 
			timeout: 5000, 
			pager:  '#nav div' 
		});
		$('#nav a:last').addClass("last"); 
		$('ul.sf-menu').superfish({ 
            delay:       200,                            // one second delay on mouseout 
            animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation 
            speed:       0,                          // faster animation speed 
            autoArrows:  false,                           // disable generation of arrow mark-up 
            dropShadows: false                            // disable drop shadows 
        });
        
    });
})(jQuery);