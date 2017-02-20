            <div class="panel panel-default bg-panel-dashed">
                <div class="panel-body">
                    <div class="form-group">
                        <a class="btn btn-default fileinput-button" id="upload_select">
                            <?php echo $this->lang["btn"]["browse"]; ?>
                        </a>

                        <button id="upload_begin" class="btn btn-primary">
                            <span class="glyphicon glyphicon-cloud-upload"></span>
                            <?php echo $this->lang["btn"]["upload"]; ?>
                        </button>
                    </div>

                    <!--用来存放文件信息-->
                    <div id="upload_list"></div>
                </div>
            </div>

            <script type="text/javascript">
            function upload_tpl(_key, _file, _msg) {
                var _str_tpl = "<div id=\"bg_" + _key + "\" class=\"alert alert-info alert-dismissible bg-margin-bottom\">" +
                    "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" +
                    "<div class=\"media bg-margin-bottom\">" +
                        "<div class=\"media-left\">" +
                            "<img src=\"\">" +
                        "</div>" +
                        "<div class=\"media-body\">" +
                            "<h4 class=\"media-heading\">" + _file + "</h4>" +
                            "<p class=\"bg-alert-text\">" +
                                "<i class=\"glyphicon glyphicon-cloud-upload\"></i>" +
                                " <span>" + _msg + "</span>" +
                            "</p>" +
                        "</div>" +
                    "</div>" +
                    "<div class=\"progress bg-progress\">" +
                        "<div class=\"progress-bar progress-bar-info progress-bar-striped active\" style=\"width: 10%\"></div>"+
                    "</div>" +
                "<div>";

                return _str_tpl;
            }

            function alert_process(_key, _class, _icon, _msg) {
                $("#bg_" + _key).removeClass("alert-info alert-danger alert-success");
                $("#bg_" + _key).addClass(_class);
                $("#bg_" + _key + " i").removeClass("glyphicon-refresh glyphicon-remove-sign glyphicon-ok-sign bg-spin");
                $("#bg_" + _key + " i").addClass(_icon);
                $("#bg_" + _key + " span").html(_msg);
            }

            function alert_fadeout(_key) {
                $("#bg_" + _key).slideUp("slow");
            }

            $(document).ready(function(){
                if (!WebUploader.Uploader.support()) {
                    alert("<?php echo $this->lang["label"]["needH5"]; ?>");
                }

                var obj_wu = new WebUploader.Uploader({
                    //附加表单数据
                    formData: {
                        <?php echo $this->common["tokenRow"]["name_session"]; ?>: "<?php echo $this->common["tokenRow"]["token"]; ?>",
                        act: "submit"
                    },
                    server: "<?php echo BG_URL_CONSOLE; ?>request.php?mod=attach", //文件接收服务端
                    pick: "#upload_select", //选择按钮

                    fileVal: "attach_files", //设置 file 域的 name
                    //允许的 mime
                    accept: {
                        title: "file",
                        mimeTypes: "<?php echo implode(",", $this->tplData["mimeRows"]); ?>"
                    },
                    fileNumLimit: <?php echo BG_UPLOAD_COUNT; ?>, //队列限制
                    fileSingleSizeLimit: <?php echo $this->tplData["uploadSize"]; ?>, //单个尺寸限制
                    resize: false //不压缩 image
                });

                $("#upload_begin").click(function(){
                    obj_wu.upload();
                });

                obj_wu.on("fileQueued", function(file){
                    _str_tpl = upload_tpl(file.id, file.name, "<?php echo $this->lang["label"]["waiting"]; ?>");

                    $("#upload_list").append(_str_tpl);
                    $("#bg_" + file.id + " .bg-progress").hide();

                    obj_wu.makeThumb(file, function(error, src) {
                        if (error) {
                            $(".media-left img").hide();
                        }

                        $("#bg_" + file.id + " .media-left img").attr("src", src);
                    }, 64, 64);

                    $(".close").click(function(){
                        obj_wu.removeFile(file, true);
                    });
                });

                obj_wu.on("error", function(error, size, file){
                    switch(error) {
                        case "F_EXCEED_SIZE":
                            alert(file.name + " <?php echo $this->rcode["x070203"]; ?> <?php echo BG_UPLOAD_SIZE; ?> <?php echo BG_UPLOAD_UNIT; ?>");
                        break;

                        case "Q_EXCEED_NUM_LIMIT":
                            alert(file.name + " <?php echo $this->rcode["x070204"]; ?> <?php echo BG_UPLOAD_COUNT; ?>");
                        break;

                        case "Q_TYPE_DENIED":
                            alert(file.name + " <?php echo $this->rcode["x070202"]; ?>");
                        break;
                    }
                });

                obj_wu.on("uploadProgress", function(file, percentage){
                    alert_process(file.id, "alert-info", "glyphicon-refresh bg-spin", "<?php echo $this->lang["label"]["uploading"]; ?>");

                    $("#bg_" + file.id + " .bg-progress").show();
                    $("#bg_" + file.id + " .bg-progress .progress-bar").text(percentage * 100 + "%");
                    $("#bg_" + file.id + " .bg-progress .progress-bar").css("width", percentage * 100 + "%");
                });

                obj_wu.on("uploadSuccess", function(file, result){
                    var _str_msg;
                    if (result.rcode == "y070401") {
                        alert_process(file.id, "alert-success", "glyphicon-ok-sign", "<?php echo $this->lang["label"]["uploadSucc"]; ?>");

                        <?php if (isset($cfg["js_insert"])) { ?>
                            insertAttach(result.attach_url, result.attach_name, result.attach_id, result.attach_type, result.attach_ext);
                        <?php } ?>
                    } else {
                        if (typeof result.msg == "undefined") {
                            _str_msg = "<?php echo $this->lang["label"]["returnErr"]; ?>";
                        } else {
                            _str_msg = result.msg;
                        }
                        alert_process(file.id, "alert-danger", "glyphicon-remove-sign", _str_msg);
                    }
                });

                obj_wu.on("uploadError", function(file, result){
                    alert_process(file.id, "alert-danger", "glyphicon-remove-sign", "Error&nbsp;status:&nbsp;" + result);
                });

                obj_wu.on("uploadComplete", function(file){
                    $("#bg_" + file.id + " .bg-progress").slideUp("slow");

                    setTimeout("alert_fadeout('" + file.id + "')", 5000);
                });
            });
            </script>
