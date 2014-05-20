/*
v0.0.9 jQuery baigoSubmit plugin 表单全选插件
(c) 2013 baigo studio - http://baigo.nbfone.com/baigoSubmit/
License: http://www.opensource.org/licenses/mit-license.php
*/

(function($){
	$.fn.baigoSubmit = function (options) {

		if(this.length == 0) {
			return this;
		}

		// support mutltiple elements
		if(this.length > 1){
			this.each(function(){
				$(this).baigoSubmit(options);
			});
			return this;
		}

    	var thisForm = $(this); //定义表单对象
		var el = this;

		var defaults = {
			width: 350,
			height: 220,
			class_ok: "baigoSubmit_y",
			class_err: "baigoSubmit_x",
			class_loading: "baigoSubmit_loading",
			btn_url: "",
			btn_text: "OK"
		};

		var opts = $.extend(defaults, options);

		//调用colorbox
		var callColorbox = function () {
			$.colorbox({ inline: true, href: "#ajax_box", scrolling: false, width: opts.width, height: opts.height });
		}

		var boxAppend = function () {
			$("body").append("<div class=\"baigoSubmit_box\">" +
				"<ul id=\"ajax_box\">" +
					"<li id=\"ajax_msg\">" +
						"<div id=\"msg_box\"></div>" +
					"</li>" +
					"<li id=\"ajax_alert\">" +
						"<div id=\"alert_box\"></div>" +
					"</li>" +
					"<li id=\"ajax_btn\">" +
						"<a href=\"" + opts.btn_url + "\" target=\"_top\">" + opts.btn_text + "</a>" +
					"</li>" +
				"</ul>" +
			"</div>");
		}

		//确认消息
		var formConfirm = function () {
			if (typeof opts.confirm_id == "undefined") {
				return true;
			} else {
				var _form_action = $("#" + opts.confirm_id).val();
				if (_form_action == opts.confirm_val) {
					if (confirm(opts.confirm_msg)) {
						return true;
					} else {
						return false;
					}
				} else {
					return true;
				}
			}
		}

		//ajax提交
		el.formSubmit = function () {
			boxAppend();
			if (formConfirm()) {
				$.ajax({
					url: opts.ajax_url, //url
					//async: false, //设置为同步
					type: "post",
					dataType: "json", //数据格式为json
					data: $(thisForm).serialize(),
					beforeSend: function(){
						$("#ajax_btn").hide();
						$("#msg_box").empty();
						$("#msg_box").attr("class", opts.class_loading);
						$("#msg_box").append("loading ..."); //填充消息内容
						callColorbox(); //输出消息
					}, //输出消息
					success: function(_result){ //读取返回结果
						var _image_pre = _result.alert.substr(0, 1);
						if (_image_pre == "x") {
							var _class = opts.class_err;
							$("#ajax_btn").hide();
						} else {
							var _class = opts.class_ok;
							$("#ajax_btn").show();
						}
						var _image = opts.img_url + "alert_" + _image_pre + ".png";
						$("#msg_box").empty();
						$("#msg_box").attr("class", _class);
						$("#msg_box").append(_result.msg); //填充消息内容
						$("#alert_box").empty();
						$("#alert_box").append(_result.alert);
						callColorbox(); //输出消息
					}
				});
			}
		}

		return this;
	}

})(jQuery);