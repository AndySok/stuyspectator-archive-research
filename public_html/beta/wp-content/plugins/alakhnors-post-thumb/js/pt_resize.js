
	var sw = screen.width;
	var newWidth = 200;
	if (sw > 800) newWidth = 300;
	if (sw > 1024) newWidth = 400;
	if (sw > 1280) newWidth = 500;
	
	$(document).ready(function() {
 		$("img").each(function(){
 		        if (this.width > newWidth)
				this.width = newWidth;
		});
	 });
	 