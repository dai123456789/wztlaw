$(function(){

    widChange();
    $(".wztlaw_advantage_bd ul li").hover(function() {
        $(this).find(".wztlaw_advantage_bd_1").css({ "background-color": "#2b58ab", "color": "#fff" })
        $(this).find(".wztlaw_advantage_bd_2").css({ "background-color": "#2b58ab", "color": "#fff", "padding": "10px 40px 60px" })
    }, function() {
        $(this).find(".wztlaw_advantage_bd_1").css({ "background-color": "#fff", "color": "#111" })
        $(this).find(".wztlaw_advantage_bd_2").css({ "background-color": "#ff5e00", "color": "#fff", "padding": "40px" })
    })
    $(".wzt_lstdCarouse").hover(function() {
        $(".icon_LImgS").css({ "opacity": "0.5" })
        $(".icon_RImgS").css({ "opacity": "0.5" })
    },function() {
        $(".icon_LImgS").css({ "opacity": "0" })
        $(".icon_RImgS").css({ "opacity": "0" })
    })
    $(".icon_LImgS").hover(function() {
        $(".icon_LImgS").css({ "opacity": "0.5" })
        $(".icon_RImgS").css({ "opacity": "0.5" })
    },function() {
        $(".icon_LImgS").css({ "opacity": "0" })
        $(".icon_RImgS").css({ "opacity": "0" })
    })
    $(".icon_RImgS").hover(function() {
        $(".icon_LImgS").css({ "opacity": "0.5" })
        $(".icon_RImgS").css({ "opacity": "0.5" })
    },function() {
        $(".icon_LImgS").css({ "opacity": "0" })
        $(".icon_RImgS").css({ "opacity": "0" })
    })
    $(".ProductIntroduction").hover(function() {
        $(".icon_LImg").css({ "opacity": "0.5" })
        $(".icon_RImg").css({ "opacity": "0.5" })
    },function() {
        $(".icon_LImg").css({ "opacity": "0" })
        $(".icon_RImg").css({ "opacity": "0" })
    })
    // $(".zturn-item").click(function() {
    //     $(".wztlaw_zizhizz").css("display","block")
    //     $(".wztlaw_zizhitc").css("display","block")
    // })
    // $(".wztlaw_zizhizz").click(function() {
    //     $(".wztlaw_zizhizz").css("display","none")
    //     $(".wztlaw_zizhitc").css("display","none")
    // })
	$.fn.countTo = function (options) {
		options = options || {};
		
		return $(this).each(function () {
			// set options for current element
			var settings = $.extend({}, $.fn.countTo.defaults, {
				from:            $(this).data('from'),
				to:              $(this).data('to'),
				speed:           $(this).data('speed'),
				refreshInterval: $(this).data('refresh-interval'),
				decimals:        $(this).data('decimals')
			}, options);
			
			// how many times to update the value, and how much to increment the value on each update
			var loops = Math.ceil(settings.speed / settings.refreshInterval),
				increment = (settings.to - settings.from) / loops;
			
			// references & variables that will change with each update
			var self = this,
				$self = $(this),
				loopCount = 0,
				value = settings.from,
				data = $self.data('countTo') || {};
			
			$self.data('countTo', data);
			
			// if an existing interval can be found, clear it first
			if (data.interval) {
				clearInterval(data.interval);
			}
			data.interval = setInterval(updateTimer, settings.refreshInterval);
			
			// initialize the element with the starting value
			render(value);
			
			function updateTimer() {
				value += increment;
				loopCount++;
				
				render(value);
				
				if (typeof(settings.onUpdate) == 'function') {
					settings.onUpdate.call(self, value);
				}
				
				if (loopCount >= loops) {
					// remove the interval
					$self.removeData('countTo');
					clearInterval(data.interval);
					value = settings.to;
					
					if (typeof(settings.onComplete) == 'function') {
						settings.onComplete.call(self, value);
					}
				}
			}
			
			function render(value) {
				var formattedValue = settings.formatter.call(self, value, settings);
				$self.html(formattedValue);
			}
		});
	};
	
	$.fn.countTo.defaults = {
		from: 0,               // the number the element should start at
		to: 0,                 // the number the element should end at
		speed: 1000,           // how long it should take to count between the target numbers
		refreshInterval: 100,  // how often the element should be updated
		decimals: 0,           // the number of decimal places to show
		formatter: formatter,  // handler for formatting the value before rendering
		onUpdate: null,        // callback method for every time the element is updated
		onComplete: null       // callback method for when the element finishes updating
	};
	
	function formatter(value, settings) {
		return value.toFixed(settings.decimals);
	}



  // custom formatting example
  $('#count-number').data('countToOptions', {
	formatter: function (value, options) {
	  return value.toFixed(options.decimals).replace(/\B(?=(?:\d{3})+(?!\d))/g, '');
	}
  });
  
  // start all the timers
  $('.timer').each(count);  
  
  function count(options) {
	var $this = $(this);
	options = $.extend({}, options || {}, $this.data('countToOptions') || {});
	$this.countTo(options);
  }

    function widChange() {
        var maxLength = $(".wzt_navH .pc>ul>li").length;
        var pcHtml = "";
        $(".wzt_navH .pc>ul>li").each(function(index) {
            if (index > 5 && index < maxLength - 1) {
                $(".wzt_Header .pc .more").css("display", "block")
                pcHtml += "<li class='menu-item-has-children'>" + $(this).html() + "</li>"
                $(this).remove()
            }
        })
        $(".wzt_navH .pc .more ul").append(pcHtml);
        var maxXSLength = $(".wzt_navH .sm>ul>li").length
        $(".wzt_navH .sm>ul>li").each(function(index) {
            if (index > 3 && index < maxXSLength - 1) {
                $(".wzt_Header .sm .more").css("display", "block")
                $(".wzt_navH .sm .more ul").append("<li class='wzt_linumS'>" + $(this).html() + "</li>");
                $(this).remove()
            }

        })
        $(".wzt_linumS a").click(function() {
            $(this).next('ul').css("display") == "none" ? None($(this)) : have($(this))

        })

        function None(name) {

            name.next('ul').css("display", "block");
            name.parent().addClass('wzt_linumOpen')

        }

        function have(name) {

            name.next('ul').css("display", "none");
            name.parent().removeClass('wzt_linumOpen')
        }
        $(".wzt_icon").click(function() {
            $(".wzt_navListS>div>ul").css("display") == "none" ? $(".wzt_navListS>div>ul").css({"display":"block"}) : $(".wzt_navListS>div>ul").css({"display":"none"})
        })

        $(".wzt_Header .menu-item-has-children").mouseover(function() {

            $(this).children('ul').css("display", "block");
            $(this).addClass('wzt_linumOpen')

        })
        $(".wzt_Header .menu-item-has-children").mouseout(function() {

            $(this).children('ul').css("display", "none")
            $(this).removeClass('wzt_linumOpen')
        })
        
        


    }
    

})



function opiu(id) { return document.getElementById(id); }
var liHeights;

function addLoadEvent(func) {
    var oldonload = window.onload;
    if (typeof window.onload != 'function') {
        window.onload = func;
    } else {
        window.onload = function() {
            oldonload();
            func();
        }
    }
}

function moveElement(elementID, final_x, final_y, interval) {
    if (!document.getElementById) return false;
    if (!document.getElementById(elementID)) return false;
    var elem = document.getElementById(elementID);
    if (elem.movement) {
        clearTimeout(elem.movement);
    }
    if (!elem.style.left) {
        elem.style.left = "0px";
    }
    if (!elem.style.top) {
        elem.style.top = "0px";
    }
    var xpos = parseInt(elem.style.left);
    var ypos = parseInt(elem.style.top);
    if (xpos == final_x && ypos == final_y) {
        return true;
    }
    if (xpos < final_x) {
        var dist = Math.ceil((final_x - xpos) / 10);
        xpos = xpos + dist;
    }
    if (xpos > final_x) {
        var dist = Math.ceil((xpos - final_x) / 10);
        xpos = xpos - dist;
    }
    if (ypos < final_y) {
        var dist = Math.ceil((final_y - ypos) / 10);
        ypos = ypos + dist;
    }
    if (ypos > final_y) {
        var dist = Math.ceil((ypos - final_y) / 10);
        ypos = ypos - dist;
    }
    elem.style.left = xpos + "px";
    elem.style.top = ypos + "px";
    var repeat = "moveElement('" + elementID + "'," + final_x + "," + final_y + "," + interval + ")";
    elem.movement = setTimeout(repeat, interval);
}

function classNormal(iFocusBtnID, iFocusTxID) {
    var iFocusBtns = opiu(iFocusBtnID).getElementsByTagName('li');
    // var iFocusTxs = opiu(iFocusTxID).getElementsByTagName('li');
    for (var i = 0; i < iFocusBtns.length; i++) {
        iFocusBtns[i].className = 'normal';
        // iFocusTxs[i].className = 'normal';
    }
}

function classCurrent(iFocusBtnID, iFocusTxID, n) {
    var iFocusBtns = opiu(iFocusBtnID).getElementsByTagName('li');
    // var iFocusTxs = opiu(iFocusTxID).getElementsByTagName('li');
    iFocusBtns[n].className = 'current';
    // iFocusTxs[n].className = 'current';
}

function iFocusChange() {
    if (!opiu('ifocus')) return false;
    opiu('ifocus').onmouseover = function() { atuokey = true };
    opiu('ifocus').onmouseout = function() { atuokey = false };
    var iFocusBtns = opiu('ifocus_btn').getElementsByTagName('li');
    var listLength = iFocusBtns.length;
    var liatHeight = 622;
    var liList = opiu('ifocus_btn').getElementsByTagName("li");

    liHeights = liatHeight / listLength - 5
        // liList.style.height = liatHeight / listLength + "px"
    for (let i = 0; i < listLength; i++) {
        liList[i].style.height = liatHeight / listLength - 5 + "px";
        let Heightnum = liatHeight * i
        iFocusBtns[i].onmouseover = function() {
            moveElement('ifocus_piclist', 0, -Heightnum, 5);
            classNormal('ifocus_btn', 'ifocus_tx');
            classCurrent('ifocus_btn', 'ifocus_tx', i);
        }
    }
}
setInterval('autoiFocus()', 5000);
var atuokey = false;

function autoiFocus() {
    if (!opiu('ifocus')) return false;
    if (atuokey) return false;
    var focusBtnList = opiu('ifocus_btn').getElementsByTagName('li');
    var listLength = focusBtnList.length;
    for (var i = 0; i < listLength; i++) {
        if (focusBtnList[i].className == 'current') var currentNum = i;
    }

    console.log(currentNum, listLength)
    for (let i = 0; i < listLength; i++) {
        var Heightnums = -(i + 1) * 622;

        if (currentNum == i && currentNum != listLength - 1) {
            moveElement('ifocus_piclist', 0, Heightnums, 5);
            classNormal('ifocus_btn', 'ifocus_tx');
            classCurrent('ifocus_btn', 'ifocus_tx', i + 1);
        }
        if (currentNum == listLength - 1) {
            moveElement('ifocus_piclist', 0, 0, 5);
            classNormal('ifocus_btn', 'ifocus_tx');
            classCurrent('ifocus_btn', 'ifocus_tx', 0);
        }
    }
    // if (currentNum == 0 && listLength != 1) {
    //     moveElement('ifocus_piclist', 0, -622, 5);
    //     classNormal('ifocus_btn', 'ifocus_tx');
    //     classCurrent('ifocus_btn', 'ifocus_tx', 1);
    // }
    // if (currentNum == 1 && listLength != 2) {
    //     moveElement('ifocus_piclist', 0, -1244, 5);
    //     classNormal('ifocus_btn', 'ifocus_tx');
    //     classCurrent('ifocus_btn', 'ifocus_tx', 2);
    // }
    // if (currentNum == 2 && listLength != 3) {
    //     moveElement('ifocus_piclist', 0, -1866, 5);
    //     classNormal('ifocus_btn', 'ifocus_tx');
    //     classCurrent('ifocus_btn', 'ifocus_tx', 3);
    // }
    // if (currentNum == 3) {
    //     moveElement('ifocus_piclist', 0, 0, 5);
    //     classNormal('ifocus_btn', 'ifocus_tx');
    //     classCurrent('ifocus_btn', 'ifocus_tx', 0);
    // }
    // if (currentNum == 1 && listLength == 2) {
    //     moveElement('ifocus_piclist', 0, 0, 5);
    //     classNormal('ifocus_btn', 'ifocus_tx');
    //     classCurrent('ifocus_btn', 'ifocus_tx', 0);
    // }
    // if (currentNum == 2 && listLength == 3) {
    //     moveElement('ifocus_piclist', 0, 0, 5);
    //     classNormal('ifocus_btn', 'ifocus_tx');
    //     classCurrent('ifocus_btn', 'ifocus_tx', 0);
    // }
}

addLoadEvent(iFocusChange);