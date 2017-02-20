    <?php if (isset($cfg["baigoClear"])) { ?>
        <!--表单 ajax 提交 js-->
        <script src="<?php echo BG_URL_STATIC; ?>lib/baigoClear/baigoClear.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg["baigoValidator"])) { ?>
        <!--表单验证 js-->
        <script src="<?php echo BG_URL_STATIC; ?>lib/baigoValidator/baigoValidator.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg["baigoSubmit"])) { ?>
        <!--表单 ajax 提交 js-->
        <script src="<?php echo BG_URL_STATIC; ?>lib/baigoSubmit/baigoSubmit.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg["tagmanager"])) { ?>
        <script src="<?php echo BG_URL_STATIC; ?>lib/typeahead/typeahead.min.js" type="text/javascript"></script>
        <script src="<?php echo BG_URL_STATIC; ?>lib/tagmanager/tagmanager.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg["upload"])) { ?>
        <script src="<?php echo BG_URL_STATIC; ?>lib/webuploader/webuploader.html5only.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg["reloadImg"])) { ?>
        <!--重新载入图片 js-->
        <script src="<?php echo BG_URL_STATIC; ?>lib/reloadImg.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg["baigoCheckall"])) { ?>
        <!--全选 js-->
        <script src="<?php echo BG_URL_STATIC; ?>lib/baigoCheckall/baigoCheckall.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg["tinymce"])) { ?>
        <!--html 编辑器-->
        <script src="<?php echo BG_URL_STATIC; ?>lib/tinymce/tinymce.min.js" type="text/javascript"></script>
        <script src="<?php echo BG_URL_STATIC; ?>lib/tinymce/jquery.tinymce.min.js" type="text/javascript"></script>
        <script type="text/javascript">
        tinyMCE.init({
            selector: "textarea.tinymce",
            language: "<?php echo $this->config["lang"]; ?>",
            resize: <?php if (fn_cookie("prefer_editor_resize") == "on") { ?>true<?php } else { ?>false<?php } ?>,
            plugins: ["table image insertdatetime lists advlist anchor link autolink charmap code textcolor colorpicker contextmenu media paste searchreplace visualblocks visualchars hr autosave<?php if (fn_cookie("prefer_editor_resize") == "on") { ?> autoresize<?php } ?>"],
            toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | forecolor backcolor | bullist numlist outdent indent | link image | code",
            convert_urls: false,
            remove_script_host: false
        });
        </script>
    <?php }

    if (isset($cfg["datepicker"])) { ?>
        <!--日历插件-->
        <script src="<?php echo BG_URL_STATIC; ?>lib/datetimepicker/jquery.datetimepicker.js" type="text/javascript"></script>
        <script type="text/javascript">
        var opts_datetimepicker = {
            lang: "<?php echo $this->config["lang"]; ?>",
            i18n: {
                <?php echo $this->config["lang"]; ?>: {
                    months: ["<?php echo $this->lang["digit"]["1"] . $this->lang["label"]["month"]; ?>", "<?php echo $this->lang["digit"]["2"] . $this->lang["label"]["month"]; ?>", "<?php echo $this->lang["digit"]["3"] . $this->lang["label"]["month"]; ?>", "<?php echo $this->lang["digit"]["4"] . $this->lang["label"]["month"]; ?>", "<?php echo $this->lang["digit"]["5"] . $this->lang["label"]["month"]; ?>", "<?php echo $this->lang["digit"]["6"] . $this->lang["label"]["month"]; ?>", "<?php echo $this->lang["digit"]["7"] . $this->lang["label"]["month"]; ?>", "<?php echo $this->lang["digit"]["8"] . $this->lang["label"]["month"]; ?>", "<?php echo $this->lang["digit"]["9"] . $this->lang["label"]["month"]; ?>", "<?php echo $this->lang["digit"]["10"] . $this->lang["label"]["month"]; ?>", "<?php echo $this->lang["digit"]["10"] . $this->lang["digit"]["1"] . $this->lang["label"]["month"]; ?>", "<?php echo $this->lang["digit"]["10"] . $this->lang["digit"]["2"] . $this->lang["label"]["month"]; ?>"],
            monthsShort: ["<?php echo $this->lang["digit"]["1"]; ?>", "<?php echo $this->lang["digit"]["2"]; ?>", "<?php echo $this->lang["digit"]["3"]; ?>", "<?php echo $this->lang["digit"]["4"]; ?>", "<?php echo $this->lang["digit"]["5"]; ?>", "<?php echo $this->lang["digit"]["6"]; ?>", "<?php echo $this->lang["digit"]["7"]; ?>", "<?php echo $this->lang["digit"]["8"]; ?>", "<?php echo $this->lang["digit"]["9"]; ?>", "<?php echo $this->lang["digit"]["10"]; ?>", "<?php echo $this->lang["digit"]["10"] . $this->lang["digit"]["1"]; ?>", "<?php echo $this->lang["digit"]["10"] . $this->lang["digit"]["2"]; ?>"],
                    dayOfWeek: ["<?php echo $this->lang["digit"]["0"]; ?>", "<?php echo $this->lang["digit"]["1"]; ?>", "<?php echo $this->lang["digit"]["2"]; ?>", "<?php echo $this->lang["digit"]["3"]; ?>", "<?php echo $this->lang["digit"]["4"]; ?>", "<?php echo $this->lang["digit"]["5"]; ?>", "<?php echo $this->lang["digit"]["6"]; ?>"]
                }
            },
            //timepicker: false,
            format: "Y-m-d H:i",
            step: 30,
            mask: true
        };
        var opts_datepicker = {
            lang: "<?php echo $this->config["lang"]; ?>",
            i18n: {
                <?php echo $this->config["lang"]; ?>: {
                    months: ["<?php echo $this->lang["digit"]["1"] . $this->lang["label"]["month"]; ?>", "<?php echo $this->lang["digit"]["2"] . $this->lang["label"]["month"]; ?>", "<?php echo $this->lang["digit"]["3"] . $this->lang["label"]["month"]; ?>", "<?php echo $this->lang["digit"]["4"] . $this->lang["label"]["month"]; ?>", "<?php echo $this->lang["digit"]["5"] . $this->lang["label"]["month"]; ?>", "<?php echo $this->lang["digit"]["6"] . $this->lang["label"]["month"]; ?>", "<?php echo $this->lang["digit"]["7"] . $this->lang["label"]["month"]; ?>", "<?php echo $this->lang["digit"]["8"] . $this->lang["label"]["month"]; ?>", "<?php echo $this->lang["digit"]["9"] . $this->lang["label"]["month"]; ?>", "<?php echo $this->lang["digit"]["10"] . $this->lang["label"]["month"]; ?>", "<?php echo $this->lang["digit"]["10"] . $this->lang["digit"]["1"] . $this->lang["label"]["month"]; ?>", "<?php echo $this->lang["digit"]["10"] . $this->lang["digit"]["2"] . $this->lang["label"]["month"]; ?>"],
            monthsShort: ["<?php echo $this->lang["digit"]["1"]; ?>", "<?php echo $this->lang["digit"]["2"]; ?>", "<?php echo $this->lang["digit"]["3"]; ?>", "<?php echo $this->lang["digit"]["4"]; ?>", "<?php echo $this->lang["digit"]["5"]; ?>", "<?php echo $this->lang["digit"]["6"]; ?>", "<?php echo $this->lang["digit"]["7"]; ?>", "<?php echo $this->lang["digit"]["8"]; ?>", "<?php echo $this->lang["digit"]["9"]; ?>", "<?php echo $this->lang["digit"]["10"]; ?>", "<?php echo $this->lang["digit"]["10"] . $this->lang["digit"]["1"]; ?>", "<?php echo $this->lang["digit"]["10"] . $this->lang["digit"]["2"]; ?>"],
                    dayOfWeek: ["<?php echo $this->lang["digit"]["0"]; ?>", "<?php echo $this->lang["digit"]["1"]; ?>", "<?php echo $this->lang["digit"]["2"]; ?>", "<?php echo $this->lang["digit"]["3"]; ?>", "<?php echo $this->lang["digit"]["4"]; ?>", "<?php echo $this->lang["digit"]["5"]; ?>", "<?php echo $this->lang["digit"]["6"]; ?>"]
                }
            },
            timepicker: false,
            format: "Y-m-d",
            mask: true
        };
        </script>
    <?php }

    if (isset($cfg["tooltip"])) { ?>
        <script type="text/javascript">
        $(document).ready(function(){
            $("[data-toggle='tooltip']").tooltip({
                html: true,
                template: "<div class='tooltip bg-tooltip'><div class='tooltip-arrow'></div><div class='tooltip-inner'></div></div>"
            });
        });
        </script>
    <?php }

    if (isset($this->tplData["adminLogged"]["rcode"]) && $this->tplData["adminLogged"]["rcode"] == "y020102") { ?>
        <div class="modal fade" id="msg_token">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <?php echo $this->lang["btn"]["ok"]; ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
        function tokenReload() {
            $.getJSON("<?php echo BG_URL_CONSOLE; ?>request.php?mod=token&act=make", function(result){
                if (result.rcode == "y020102") {
                    $("#box_pm_new").text(result.pm_count);
                } else {
                    $("#msg_token .modal-body").text(result.msg);
                    $("#msg_token").modal("show");
                }
            });
            setTimeout("tokenReload();", <?php echo BG_DEFAULT_TOKEN_RELOAD; ?>);
        }

        $(document).ready(function(){
            tokenReload();
        });
        </script>
    <?php } ?>

    <script src="<?php echo BG_URL_STATIC; ?>lib/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo BG_URL_STATIC; ?>lib/baigoAccordion/baigoAccordion.min.js" type="text/javascript"></script>

    <!--
    <?php echo PRD_CMS_POWERED; ?>
    <?php if (BG_DEFAULT_UI == "default") {
        echo PRD_CMS_NAME;
    } else {
        echo BG_DEFAULT_UI . " CMS";
    } ?>
    <?php echo PRD_CMS_VER; ?>
    -->

</body>
</html>