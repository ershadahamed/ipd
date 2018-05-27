<style type="text/css">
.wrapper-dropdown-3 {
    /* Size and position */
    position: relative;
    width: 200px;
    margin: 0 auto;
    padding: 10px;
 
    /* Styles */
    background: #fff;
    border-radius: 7px;
    border: 1px solid rgba(0,0,0,0.15);
    box-shadow: 0 1px 1px rgba(50,50,50,0.1);
    cursor: pointer;
    outline: none;
 
    /* Font settings */
    font-weight: bold;
    color: #8AA8BD;
}

.wrapper-dropdown-3:after {
    content: "";
    width: 0;
    height: 0;
    position: absolute;
    right: 15px;
    top: 50%;
    margin-top: -3px;
    border-width: 6px 6px 0 6px;
    border-style: solid;
    border-color: #8aa8bd transparent;
}

.wrapper-dropdown-3 .dropdown {
  /* Size & position */
    position: absolute;
    top: 140%;
    left: 0;
    right: 0;
 
    /* Styles */
    background: white;
    border-radius: inherit;
    border: 1px solid rgba(0,0,0,0.17);
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
    font-weight: normal;
    transition: all 0.5s ease-in;
    list-style: none;
 
    /* Hiding */
    opacity: 0;
    pointer-events: none;
}
 
.wrapper-dropdown-3 .dropdown li a {
    display: block;
    padding: 10px;
    text-decoration: none;
    color: #8aa8bd;
    border-bottom: 1px solid #e6e8ea;
    box-shadow: inset 0 1px 0 rgba(255,255,255,1);
    transition: all 0.3s ease-out;
}
 
.wrapper-dropdown-3 .dropdown li i {
    float: right;
    color: inherit;
}
 
.wrapper-dropdown-3 .dropdown li:first-of-type a {
    border-radius: 7px 7px 0 0;
}
 
.wrapper-dropdown-3 .dropdown li:last-of-type a {
    border-radius: 0 0 7px 7px;
    border: none;
}
 
/* Hover state */
 
.wrapper-dropdown-3 .dropdown li:hover a {
    background: #f3f8f8;
}

.wrapper-dropdown-3 .dropdown:after {
    content: "";
    width: 0;
    height: 0;
    position: absolute;
    bottom: 100%;
    right: 15px;
    border-width: 0 6px 6px 6px;
    border-style: solid;
    border-color: #fff transparent;   
}
 
.wrapper-dropdown-3 .dropdown:before {
    content: "";
    width: 0;
    height: 0;
    position: absolute;
    bottom: 100%;
    right: 13px;
    border-width: 0 8px 8px 8px;
    border-style: solid;
    border-color: rgba(0,0,0,0.1) transparent;   
}

.wrapper-dropdown-3.active .dropdown {
    opacity: 1;
    pointer-events: auto;
}
</style>

<!-- jQuery if needed -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script><script type="text/javascript">
      
			
			function DropDown(el) {
				this.dd = el;
				this.placeholder = this.dd.children('span');
				this.opts = this.dd.find('ul.dropdown > li');
				this.val = '';
				this.index = -1;
				this.initEvents();
			}
			DropDown.prototype = {
				initEvents : function() {
					var obj = this;

					obj.dd.on('click', function(event){
						$(this).toggleClass('active');
						return false;
					});

					obj.opts.on('click',function(){
						var opt = $(this);
						obj.val = opt.text();
						obj.index = opt.index();
						obj.placeholder.text(obj.val);
					});
				},
				getValue : function() {
					return this.val;
				},
				getIndex : function() {
					return this.index;
				}
			}

			$(function() {

				var dd = new DropDown( $('#dd') );

				$(document).click(function() {
					// all dropdowns
					$('.wrapper-dropdown-3').removeClass('active');
				});

			});

		
    </script><script src="http://tympanus.net/codrops/adpacks/csscustom.js"></script>

<div id="dd" class="wrapper-dropdown-3" tabindex="1">
    <span>Transport</span>
    <ul class="dropdown">
        <li><a href="#"><i class="icon-envelope icon-large"></i>Classic mail</a></li>
        <li><a href="#"><i class="icon-truck icon-large"></i>UPS Delivery</a></li>
        <li><a href="#"><i class="icon-plane icon-large"></i>Private jet</a></li>
    </ul>
</div>