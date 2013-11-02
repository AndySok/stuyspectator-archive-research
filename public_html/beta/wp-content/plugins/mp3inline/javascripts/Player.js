// Programmed by joep@joep-i.nl
// Feel free to use and modify this.

	function Player() {
		this.place = 'top';
		this.backward = 0;

        this.sound = new Sound();
		this.playing = false;
		this.loaded = false;
		this.frequency = 100;
		this.song = '';
		this.slide = 0;
		this.hidden = 1;
        this.slider = NaN;
		this.id = '';
		this.timeleft = 5;
		this.position = 0;
      	this.registerCallback();      
	}

	Player.prototype.sliding = function(position) {
		this.slide=1;
	    var duration =  this.sound.getDuration();

		var timeleft = (duration - (duration * position));
        if (this.backward == 0) {
		    timeleft = (duration * position);
        }
		var rest = (timeleft % 60000);
		var seconds = Math.round(rest/1000);
		var minutes = Math.round((timeleft - rest) / 60000);
		if (!(isNaN(minutes)) && !(isNaN(seconds))) {
			document.getElementById('handle1').innerHTML = sprintf("<span class='time'>%d:%02d</span>",minutes,seconds); 
		}
	}

	Player.prototype.change = function(position) {
		if (this.slide > 0) {
			this.sound.stop();
			this.slide = 0;
			this.setPosition(position);
		}
	}

    Player.prototype.registerCallback = function() {
   	   setInterval(this.onTimerEvent.bind(this), this.frequency);
    }

	Player.prototype.play = function(song,id) {

		if (this.playing) {
			if (this.song == song) {
                this.onSoundComplete();
            } else {
                this.onSoundComplete();

				this.id = id;
				this.song = song;

				this.sound.loadSound(song, true);
		  		document.getElementById(this.id).className = 'playing'; 
				this.playing = true;
			}
		} else {
			this.sound.loadSound(song, true);
			this.id = id;
			this.song = song;
			document.getElementById(this.id).className = 'playing'; 
			this.playing = true;
		}

        listitem = document.getElementById(id);
        if (this.playing) {
            showslider(id);
            slideobj = document.getElementById('slider');
            slideobj.style.width = (listitem.scrollWidth) + "px";
            slideobj.style.height = "2px";
            handleobj = document.getElementById('handle1');
            handleobj.style.height = (listitem.scrollHeight) + "px";

            if (isNaN(this.slider)) {
                this.slider = new Control.Slider('handle1','slider',{
                      sliderValue:0,
                      onSlide:function(v){player.sliding(v);},
                      onChange:function(v){player.change(v)}});
            }
            this.slider.handleLength = 30;
            this.slider.trackLength = listitem.scrollWidth;
        }
        listitem.blur();

		return false;
	}


   Player.prototype.setPosition = function(pos) {
   	var newpos = (this.duration*pos);
	this.sound.start(Math.round(newpos/1000),1);
   }

   Player.prototype.onTimerEvent = function() {
      if(this.playing) {
          var position = this.sound.getPosition();
          this.position = position;
          
          var duration =  this.sound.getDuration();
          this.duration = duration;

          var progress = position/duration;
		  this.timeleft = duration - position;

          position = this.position;
          if (this.backward == 1) {
            position = this.timeleft;
          }
          
		  var rest = (position % 60000);
		  var seconds = Math.round(rest/1000);
		  var minutes = Math.round((position - rest) / 60000);
		  if (seconds == 60) {
		    seconds = 0;
		  	minutes = minutes + 1;
		  }
		   if (!(isNaN(minutes)) && !(isNaN(seconds))) {
		      if (this.slide == 0) {
				  document.getElementById('handle1').innerHTML = sprintf("<span class='time'>%d:%02d</span>",minutes,seconds); 
			  }
			  if ((this.timeleft == 0) && (this.duration > 0)) {
				this.onSoundComplete();
			  }
		  }
		  if (this.slide == 0) {
		  	if (isNaN(progress)) {
				progress = 0
			}
		        this.slider.setValue(progress);
		  }
      }
   }

   Player.prototype.onSoundComplete = function() {
			document.getElementById(this.id).className = 'silent'; 
			hideslider();
			this.sound.start(0,1);
			this.sound.stop();
			this.hidden = 1;
			this.song = '';
			this.playing = false;
			this.id = '';
   }

   function showslider(id) {
        var div_slider = document.createElement('div')
        div_slider.id = 'slider';
        var div_handle = document.createElement('div')
        div_handle.id = 'handle1';
        Element.extend(div_slider);
        div_slider.appendChild(div_handle)
        document.body.appendChild(div_slider);

		listitem = document.getElementById(id);
		slideobj = document.getElementById('slider');
		handleobj = document.getElementById('handle1');
   		if (slideobj.style.visibility != 'visible') {
			slideobj.style.display = 'none';
			slideobj.style.visibility = 'visible';
		}
        var slidetop = getPos(listitem).y;
		slideobj.style.left = (getPos(listitem).x) + "px";
		slideobj.style.top = (slidetop) + "px";
		slideobj.style.position = "absolute";
        switch(player.place) {
            case 'top':
                handleobj.style.top = "-" + $(id).getDimensions().height + "px";
                break
            case 'bottom':
                handleobj.style.top = $(id).getDimensions().height + "px";
                break
            default:
                // leave it
        }
		if (slideobj.style.display == 'none') {
            slideobj.style.display = 'block';
		}

        if (player.hidden) {
            player.hidden = 0;
        }

   }

   function hideslider() {
		slideobj = document.getElementById('slider');
        if (slideobj) {
            if (slideobj.style.visibility == 'visible') {
                slideobj.style.display = 'none';
                slideobj.style.visibility = 'hidden';
                slideobj.style.left = "0px";
                slideobj.style.width = "0px";
                slideobj.style.top = "0px";
            }
        }
        slideobj.remove();
   }

    function getPos (obj) {
        var pos = {x: obj.offsetLeft||0, y: obj.offsetTop||0};
        while(obj = obj.offsetParent) {
            pos.x += obj.offsetLeft||0;
            pos.y += obj.offsetTop||0;
        }
        return pos;
    }


    Event.onDOMReady(function() {

        if (window.jQuery) {
            jQuery.noConflict();
        }

        var thelinks = $$('a');
        var count = 0;
        var mp3match = /mp3$/;
        player = new Player();

        thelinks.each(function(item) {
            if (item.href.match(mp3match)) {
                count += 1;
                item.id = "mp3inline" + count;
                item.className = "silent";
                item.onclick = function() { return player.play(item.href, item.id); }
            }
        });

    });



