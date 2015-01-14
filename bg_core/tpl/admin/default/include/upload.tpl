			<div class="form-group">
				<a class="btn btn-success fileinput-button" id="upload_select">
					<span class="glyphicon glyphicon-upload"></span>
					{$lang.btn.upload}...
					<!-- The file input field used as target for the file upload widget -->
					<input id="attach_files" type="file" name="attach_files" multiple>
				</a>
			</div>

			<div id="progress_upload" class="progress">
				<div class="progress-bar progress-bar-info"></div>
			</div>

			<div id="attach_uploads" class="attach_uploads"></div>

			<script type="text/javascript">
			function upload_msg(_upload_name, _upload_msg) {
				_str_msg = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">" +
					"<span aria-hidden=\"true\">&times;</span>" +
					"<span class=\"sr-only\">Close</span>" +
				"</button>" +
				"<div class=\"alert_overflow\">" + _upload_name + "</div>" +
				"<div>" + _upload_msg + "</div>";

				return _str_msg;
			}

			$(document).ready(function(){
				var _arr_mime = new Array();
				{foreach $tplData.mimeRow as $_key=>$_value}
					_arr_mime[{$_key}] = "{$_value}";
				{/foreach}

				$("#attach_files").fileupload({
					formData: [
						{ name: "token_session", value: "{$common.token_session}" },
						{ name: "act_post", value: "submit" }
					],
					dataType: "json",
					url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=attach",
					add: function(e, data) {
						var goUpload = true;
						var obj_file = data.files[0];
						if (jQuery.inArray(obj_file.type, _arr_mime) >= 0) {
							if (obj_file.size > {$tplData.uploadSize}) {
								goUpload = false;
								_str_msg = upload_msg(obj_file.name, "{$alert.x070203} {$smarty.const.BG_UPLOAD_SIZE} {$smarty.const.BG_UPLOAD_UNIT}");
								data.context = $("<div/>").html(_str_msg).appendTo("#attach_uploads");
								data.context.attr("class", "alert alert-danger alert-dismissible");
							} else {
								_str_msg = upload_msg(obj_file.name, "{$lang.label.uploading}");
								data.context = $("<div/>").html(_str_msg).appendTo("#attach_uploads");
								data.context.attr("class", "alert alert-info alert-dismissible");
							}
						} else {
							goUpload = false;
							_str_msg = upload_msg(obj_file.name, "{$alert.x070202}");
							data.context = $("<div/>").html(_str_msg).appendTo("#attach_uploads");
							data.context.attr("class", "alert alert-danger alert-dismissible");
						}
						if (goUpload) {
							data.submit();
						}
						setTimeout("$('#attach_uploads').empty();", 20000);
					},
					done: function(e, data) {
						obj_data = data.result;
						if (obj_data.str_alert != "y070401") {
							_str_msg = upload_msg(obj_data.attach_name, obj_data.msg);
							data.context.html(_str_msg);
							data.context.attr("class", "alert alert-danger  alert-dismissible");
						} else {
							_str_msg = upload_msg(obj_data.attach_name, "{$lang.label.uploadSucc}");
							data.context.html(_str_msg);
							data.context.attr("class", "alert alert-success  alert-dismissible");
							{if isset($cfg.js_insert)}
								insertAttach(obj_data.attach_url, obj_data.attach_name, obj_data.attach_id, obj_data.attach_type, obj_data.attach_ext);
							{/if}
						}
						setTimeout("$('#attach_uploads').empty();", 5000);
					},
					progressall: function(e, data) {
						var _progress_percent = parseInt(data.loaded / data.total * 100, 10);
						$("#progress_upload .progress-bar").css("width", _progress_percent + "%");
					}
				});
			});
			</script>
