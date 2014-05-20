			<input id="upfile_obj" name="upfile_obj" type="file" multiple="true" />
			<script type="text/javascript">
			$(function(){
				//上传表单设置
				$("#upfile_obj").uploadify({
					formData: {
						token_session: "{$common.token_session}",
						token_cookie: "{$common.token_cookie}",
						act_post: "submit"
					},
					queueSizeLimit: "{$smarty.const.BG_UPFILE_COUNT}", //同时上传数
					fileSizeLimit: "{$smarty.const.BG_UPFILE_SIZE}{$smarty.const.BG_UPFILE_UNIT}", //上传大小
					fileTypeDesc: "{$lang.label.upfileMime}: {$tplData.upfileMime}", //允许类型提示
					fileTypeExts: "{$tplData.upfileMime}", //允许类型扩展名
					buttonText: "{$lang.href.upload}", //上传按钮
					swf: "{$smarty.const.BG_URL_ROOT}{$smarty.const.BG_NAME_STATIC}/{$smarty.const.BG_NAME_JS}/uploadify/uploadify.swf", //swf 路径
					uploader: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=upfile&ssid={$common.ssid}", //提交路径
					onSelectError: function(file, errorCode, errorMsg){ //选择错误
			            switch (errorCode) {
				            case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE: //空文件
			            		this.queueData.errorMsg = "{$alert.x070201}";
				            break;

				            case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE: //不允许
			            		this.queueData.errorMsg = "{$alert.x070202}";
				            break;

				            case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT: //太大
			            		this.queueData.errorMsg = "{$alert.x070203} {$smarty.const.BG_UPFILE_SIZE} {$smarty.const.BG_UPFILE_UNIT}";
				            break;

				            case SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED: //太多
			            		this.queueData.errorMsg = "{$alert.x070204} {$smarty.const.BG_UPFILE_COUNT}";
				            break;
			            }
			        },
			        onUploadSuccess: function(file, data, response){
						obj_data = jQuery.parseJSON(data);
						//alert(obj_data.upfile_url);

						if (obj_data.str_alert != "y070401") {
							alert(obj_data.msg + " " + obj_data.str_alert);
						} else {
							{if $smarty.get.act_get == "form"}
								insertHtml(obj_data.upfile_url, file.name, obj_data.upfile_id, obj_data.upfile_type, obj_data.upfile_ext);
							{/if}
						}
			        },
			        onQueueComplete: function(queueData){
						alert(queueData.uploadsSuccessful + " {$lang.label.uploadSucc}");
			        }
				});
			});
			</script>
