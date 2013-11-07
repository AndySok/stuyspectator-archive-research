   function Popular(target) {
   	typeof target == "object" ? this.element = target : this.element = document.getElementById(target); if (!this.element) return false;  
   	this.ul = this.element.getElementsByTagName("ul")[0]; 
   	this.tabs = this.ul.getElementsByTagName("li");
   	this.tabContent = this.getTabContent();
   	this.bind();
   }

   Popular.prototype.getTabContent = function() {
   	tabContent= new Array();    
   	this.divs = this.element.getElementsByTagName("div");
   	for(var i = 0; i < this.divs.length; i++) {
           if (/tabContent/i.test(this.divs[i].className)) {
           tabContent.push(this.divs[i]);                        
   		}
   	}
   	return tabContent;
   }


   Popular.prototype.bind = function() {    
   	var o = this;
   	for(var i = 0; i < this.tabs.length; i++) {
   		this.tabs[i].onclick = function() { 
   		   if (this.className != 'selected') {
   		      o.open(this); return false;
   		      var a = this.getElementsByTagName("a")[0];
   		      if (a) a.onclick = function() { 
                    return false; 
               }
   		   }
   		} 
   	}
   }

   Popular.prototype.open = function(caller) {    
   	for(var i = 0; i < this.tabs.length; i++) {
   		var tab = this.tabs[i]; 
   		if (tab == caller) {  
   			this.collapse();
   			tab.className = "selected"
   			this.tabContent[i].style.display = "block";
   		}
   	}
   }

   Popular.prototype.collapse = function() {
   	for(var i = 0; i < this.tabs.length; i++) {    
   		this.tabs[i].className = "";
   		this.tabContent[i].style.display = "none";                 
   	}                                                                
   }
