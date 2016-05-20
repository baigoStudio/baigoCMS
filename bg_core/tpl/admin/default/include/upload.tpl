            <div class="form-group">
                <a class="btn btn-success fileinput-button" id="upload_select">
                    <span class="glyphicon glyphicon-upload"></span>
                    {$lang.btn.upload}
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="attach_files" type="file" name="attach_files" multiple>
                </a>
            </div>

            <div class="form-group">
                <div id="progress_upload" class="progress">
                    <div class="progress-bar progress-bar-info progress-bar-striped active"></div>
                </div>
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
                var _arr_mimes = new Array();
                {foreach $tplData.mimeRows as $key=>$value}
                    _arr_mimes[{$key}] = "{$value}";
                {/foreach}

                var _attach_count = 0;

                $("#attach_files").fileupload({
                    formData: [
                        { name: "token_session", value: "{$common.token_session}" },
                        { name: "act_post", value: "submit" }
                    ],
                    url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=attach",
                    dataType: "json",
                    add: function(e, data) {
                        var goUpload = true;
                        var obj_file = data.files[0];
                        _attach_count++;
                        if (_attach_count > {$smarty.const.BG_UPLOAD_COUNT}) {
                            goUpload        = false;
                            _str_msg        = upload_msg(obj_file.name, "{$alert.x070204} {$smarty.const.BG_UPLOAD_COUNT}");
                            data.context    = $("<div/>").html(_str_msg).appendTo("#attach_uploads");
                            data.context.attr("class", "alert alert-danger alert-dismissible");
                        } else {
                            if (jQuery.inArray(obj_file.type, _arr_mimes) >= 0) {
                                if (obj_file.size > {$tplData.uploadSize}) {
                                    goUpload       = false;
                                    _str_msg       = upload_msg(obj_file.name, "{$alert.x070203} {$smarty.const.BG_UPLOAD_SIZE} {$smarty.const.BG_UPLOAD_UNIT}");
                                    data.context   = $("<div/>").html(_str_msg).appendTo("#attach_uploads");
                                    data.context.attr("class", "alert alert-danger alert-dismissible");
                                } else {
                                    _str_msg       = upload_msg(obj_file.name, "{$lang.label.uploading}");
                                    data.context   = $("<div/>").html(_str_msg).appendTo("#attach_uploads");
                                    data.context.attr("class", "alert alert-info alert-dismissible");
                                }
                            } else {
                                goUpload        = false;
                                _str_msg        = upload_msg(obj_file.name, "{$alert.x070202}");
                                data.context    = $("<div/>").html(_str_msg).appendTo("#attach_uploads");
                                data.context.attr("class", "alert alert-danger alert-dismissible");
                            }
                        }
                        if (goUpload) {
                            data.submit();
                        }
                        setTimeout("$('#attach_uploads').empty();", 20000);
                    },
                    done: function(e, data) {
                        obj_data = data.result;
                        if (obj_data.alert != "y070401") {
                            _str_msg = upload_msg(obj_data.attach_name, obj_data.msg);
                            data.context.html(_str_msg);
                            data.context.attr("class", "alert alert-danger alert-dismissible");
                        } else {
                            _str_msg = upload_msg(obj_data.attach_name, "{$lang.label.uploadSucc}");
                            data.context.html(_str_msg);
                            data.context.attr("class", "alert alert-success alert-dismissible");
                            {if isset($cfg.js_insert)}
                                insertAttach(obj_data.attach_url, obj_data.attach_name, obj_data.attach_id, obj_data.attach_type, obj_data.attach_ext);
                            {/if}
                        }
                        _attach_count = 0;
                        setTimeout("$('#attach_uploads').empty();", 5000);
                    },
                    progressall: function(e, data) {
                        var _progress_percent = parseInt(data.loaded / data.total * 100, 10);
                        $("#progress_upload .progress-bar").text(_progress_percent + "%");
                        $("#progress_upload .progress-bar").css("min-width", "20%");
                        $("#progress_upload .progress-bar").css("width", _progress_percent + "%");
                    }
                });
            });
            </script>
