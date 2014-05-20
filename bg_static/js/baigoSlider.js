/*
v1.0.0 jQuery baigoSlider plugin 表单全选插件
(c) 2013 baigo studio - http://baigo.nbfone.com/jQuery/baigoSlider/
License: http://www.opensource.org/licenses/mit-license.php
*/

(function($){
	$.fn.baigoSlider = function(options){

		var _thisSlider   = this;
		var _sliderId     = _thisSlider[0].id;
		var _sliderItems  = $("#" + _sliderId + " > li");
		var _slider_count = _sliderItems.size();
		var _slider_index = 1;
		var _stop;

		$("#" + _sliderId).mouseover(function(){
			_stop = true;
        });

		$("#" + _sliderId).mouseout(function(){
			_stop = false;
        });

		var defaults = {
			timeFade: 1000, //淡入时间
			timeSlider: 5000 //间隔时间
		};

		var opts = $.extend(defaults, options);

		$("#" + _sliderId + " > li:gt(0)").hide();

		/*------幻灯调用------
		@slider_index 当前元素索引
		*/
		var sliderDo = function(slider_index) {
			$("#" + _sliderId + " > li").hide();
			$("#" + _sliderId + " > li:eq(" + slider_index + ")").fadeIn(opts.timeFade);
		}

		setInterval(function(){
			if (!_stop) {
				sliderDo(_slider_index);
				if (_slider_index < _slider_count - 1) {
					_slider_index++;
				} else {
					_slider_index = 0;
				}
			}
		}, opts.timeSlider);
	}
})(jQuery);