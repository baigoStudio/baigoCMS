    <?php if (isset($cfg['baigoClear'])) { ?>
        <!--表单 ajax 提交 js-->
        <script src="<?php echo BG_URL_STATIC; ?>lib/baigoClear/baigoClear.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['baigoValidator'])) { ?>
        <!--表单验证 js-->
        <script src="<?php echo BG_URL_STATIC; ?>lib/baigoValidator/baigoValidator.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['baigoSubmit'])) { ?>
        <!--表单 ajax 提交 js-->
        <script src="<?php echo BG_URL_STATIC; ?>lib/baigoSubmit/baigoSubmit.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['tagmanager'])) { ?>
        <script src="<?php echo BG_URL_STATIC; ?>lib/typeahead/typeahead.min.js" type="text/javascript"></script>
        <script src="<?php echo BG_URL_STATIC; ?>lib/tagmanager/tagmanager.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['upload'])) { ?>
        <script src="<?php echo BG_URL_STATIC; ?>lib/webuploader/webuploader.html5only.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['prism'])) { ?>
        <script src="<?php echo BG_URL_STATIC; ?>lib/prism/prism.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['baigoCheckall'])) { ?>
        <!--全选 js-->
        <script src="<?php echo BG_URL_STATIC; ?>lib/baigoCheckall/baigoCheckall.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['reloadImg'])) { ?>
        <!--重新载入图片 js-->
        <script type="text/javascript">
        $(document).ready(function(){
            $(".captchaBtn").click(function(){
                var imgSrc = "<?php echo BG_URL_CONSOLE; ?>index.php?mod=captcha&act=make&" + new Date().getTime() + "at" + Math.random();
                $(".captchaImg").attr('src', imgSrc);
            });
        });
        </script>
    <?php }

    if (isset($cfg['tinymce'])) { ?>
        <!--html 编辑器-->
        <script src="<?php echo BG_URL_STATIC; ?>lib/tinymce/tinymce.min.js" type="text/javascript"></script>
        <script src="<?php echo BG_URL_STATIC; ?>lib/tinymce/jquery.tinymce.min.js" type="text/javascript"></script>
        <script type="text/javascript">
        tinyMCE.init({
            selector: "textarea.tinymce",
            language: "<?php echo $this->config['lang']; ?>",
            resize: <?php if (isset($this->tplData['adminLogged']['admin_prefer']['editor']['resize']) && $this->tplData['adminLogged']['admin_prefer']['editor']['resize'] == 'on') { ?>true<?php } else { ?>false<?php } ?>,
            plugins: ["table image insertdatetime lists advlist anchor link autolink charmap code textcolor colorpicker contextmenu media paste searchreplace visualblocks visualchars hr autosave<?php if (isset($this->tplData['adminLogged']['admin_prefer']['editor']['autosize']) && $this->tplData['adminLogged']['admin_prefer']['editor']['autosize'] == 'on') { ?> autoresize<?php } ?> fullscreen"],
            toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | forecolor backcolor | bullist numlist outdent indent | link image | code fullscreen",
            convert_urls: false,
            remove_script_host: false
        });
        </script>
    <?php }

    if (isset($cfg['datepicker'])) { ?>
        <!--日历插件-->
        <script src="<?php echo BG_URL_STATIC; ?>lib/datetimepicker/jquery.datetimepicker.js" type="text/javascript"></script>
        <script type="text/javascript">
        var opts_datetimepicker = {
            lang: "<?php echo $this->config['lang']; ?>",
            i18n: {
                <?php echo $this->config['lang']; ?>: {
                    months: ["<?php echo $this->lang['common']['date'][1], $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][2], $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][3], $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][4], $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][5], $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][6], $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][7], $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][8], $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][9], $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][10], $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][10], $this->lang['common']['date'][1], $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][10], $this->lang['common']['date'][2], $this->lang['common']['label']['month']; ?>"],
            monthsShort: ["<?php echo $this->lang['common']['date'][1]; ?>", "<?php echo $this->lang['common']['date'][2]; ?>", "<?php echo $this->lang['common']['date'][3]; ?>", "<?php echo $this->lang['common']['date'][4]; ?>", "<?php echo $this->lang['common']['date'][5]; ?>", "<?php echo $this->lang['common']['date'][6]; ?>", "<?php echo $this->lang['common']['date'][7]; ?>", "<?php echo $this->lang['common']['date'][8]; ?>", "<?php echo $this->lang['common']['date'][9]; ?>", "<?php echo $this->lang['common']['date'][10]; ?>", "<?php echo $this->lang['common']['date'][10], $this->lang['common']['date'][1]; ?>", "<?php echo $this->lang['common']['date'][10], $this->lang['common']['date'][2]; ?>"],
                    dayOfWeek: ["<?php echo $this->lang['common']['date'][0]; ?>", "<?php echo $this->lang['common']['date'][1]; ?>", "<?php echo $this->lang['common']['date'][2]; ?>", "<?php echo $this->lang['common']['date'][3]; ?>", "<?php echo $this->lang['common']['date'][4]; ?>", "<?php echo $this->lang['common']['date'][5]; ?>", "<?php echo $this->lang['common']['date'][6]; ?>"]
                }
            },
            //timepicker: false,
            format: "Y-m-d H:i",
            step: 30,
            mask: true
        };
        var opts_datepicker = {
            lang: "<?php echo $this->config['lang']; ?>",
            i18n: {
                <?php echo $this->config['lang']; ?>: {
                    months: ["<?php echo $this->lang['common']['date'][1], $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][2], $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][3], $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][4], $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][5], $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][6], $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][7], $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][8], $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][9], $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][10], $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][10], $this->lang['common']['date'][1], $this->lang['common']['label']['month']; ?>", "<?php echo $this->lang['common']['date'][10], $this->lang['common']['date'][2], $this->lang['common']['label']['month']; ?>"],
            monthsShort: ["<?php echo $this->lang['common']['date'][1]; ?>", "<?php echo $this->lang['common']['date'][2]; ?>", "<?php echo $this->lang['common']['date'][3]; ?>", "<?php echo $this->lang['common']['date'][4]; ?>", "<?php echo $this->lang['common']['date'][5]; ?>", "<?php echo $this->lang['common']['date'][6]; ?>", "<?php echo $this->lang['common']['date'][7]; ?>", "<?php echo $this->lang['common']['date'][8]; ?>", "<?php echo $this->lang['common']['date'][9]; ?>", "<?php echo $this->lang['common']['date'][10]; ?>", "<?php echo $this->lang['common']['date'][10], $this->lang['common']['date'][1]; ?>", "<?php echo $this->lang['common']['date'][10], $this->lang['common']['date'][2]; ?>"],
                    dayOfWeek: ["<?php echo $this->lang['common']['date'][0]; ?>", "<?php echo $this->lang['common']['date'][1]; ?>", "<?php echo $this->lang['common']['date'][2]; ?>", "<?php echo $this->lang['common']['date'][3]; ?>", "<?php echo $this->lang['common']['date'][4]; ?>", "<?php echo $this->lang['common']['date'][5]; ?>", "<?php echo $this->lang['common']['date'][6]; ?>"]
                }
            },
            timepicker: false,
            format: "Y-m-d",
            mask: true
        };
        </script>
    <?php }

    if (isset($cfg['tooltip'])) { ?>
        <script type="text/javascript">
        $(document).ready(function(){
            $("[data-toggle='tooltip']").tooltip({
                html: true,
                template: "<div class='tooltip bg-tooltip'><div class='tooltip-arrow'></div><div class='tooltip-inner'></div></div>"
            });
        });
        </script>
    <?php }

    if (isset($this->tplData['adminLogged']['rcode']) && $this->tplData['adminLogged']['rcode'] == 'y020102' && !isset($cfg['noToken'])) { ?>
        <div class="modal fade" id="msg_token">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <?php echo $this->lang['common']['btn']['ok']; ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
        function tokenReload() {
            $.getJSON("<?php echo BG_URL_CONSOLE; ?>request.php?mod=token&act=make", function(result){
                if (result.rcode == 'y020102') {
                    $("#box_pm_new").text(result.pm_count);
                } else {
                    $("#msg_token .modal-body").text(result.msg);
                    $("#msg_token").modal("show");
                }
            });
        }

        $(document).ready(function(){
            tokenReload();
            setInterval(function(){
                tokenReload();
            }, <?php echo BG_DEFAULT_TOKEN_RELOAD; ?>);
        });
        </script>
    <?php } ?>

    <script src="<?php echo BG_URL_STATIC; ?>lib/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo BG_URL_STATIC; ?>lib/baigoAccordion/baigoAccordion.min.js" type="text/javascript"></script>

    <!--
        <?php echo PRD_CMS_POWERED, ' ';
        if (BG_DEFAULT_UI == 'default') {
            echo PRD_CMS_NAME;
        } else {
            echo BG_DEFAULT_UI, ' CMS ';
        }
        echo PRD_CMS_VER; ?>
    -->

</body>
</html>