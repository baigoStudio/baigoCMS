    <?php use ginkgo\Plugin;

    Plugin::listen('action_console_foot_before'); //后台界面底部触发

    if (isset($cfg['baigoClear'])) { ?>
        <!--表单 ajax 提交 js-->
        <script src="{:DIR_STATIC}lib/baigoClear/2.0.0/baigoClear.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['baigoSubmit'])) { ?>
        <!--表单验证 js-->
        <script src="{:DIR_STATIC}lib/baigoSubmit/2.1.3/baigoSubmit.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['baigoValidate'])) { ?>
        <!--表单验证 js-->
        <script src="{:DIR_STATIC}lib/baigoValidate/3.0.3/baigoValidate.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['prism'])) { ?>
        <script src="{:DIR_STATIC}lib/prism/prism.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['baigoDialog']) || isset($cfg['upload'])) { ?>
        <!--表单 ajax 提交 js-->
        <script src="{:DIR_STATIC}lib/baigoDialog/1.1.0/baigoDialog.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['baigoQuery'])) { ?>
        <!--全选 js-->
        <script src="{:DIR_STATIC}lib/baigoQuery/1.0.0/baigoQuery.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['baigoCheckall'])) { ?>
        <!--全选 js-->
        <script src="{:DIR_STATIC}lib/baigoCheckall/2.0.0/baigoCheckall.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['baigoTag'])) { ?>
        <script src="{:DIR_STATIC}lib/baigoTag/1.0.0/baigoTag.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['dad'])) { ?>
        <!--拖放 js-->
        <script src="{:DIR_STATIC}lib/dad/jquery.dad.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['upload'])) { ?>
        <script src="{:DIR_STATIC}lib/webuploader/0.1.5/webuploader.html5only.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['datetimepicker'])) { ?>
        <!--日历插件-->
        <script src="{:DIR_STATIC}lib/datetimepicker/2.3.0/jquery.datetimepicker.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['tinymce'])) { ?>
        <script src="{:DIR_STATIC}lib/tinymce/5.0.0/tinymce.min.js" type="text/javascript"></script>
    <?php }

    if (isset($cfg['typeahead']) || isset($cfg['baigoTag'])) { ?>
        <script src="{:DIR_STATIC}lib/typeahead/0.11.1/typeahead.bundle.min.js" type="text/javascript"></script>
    <?php }

    if (isset($adminLogged['rcode']) && $adminLogged['rcode'] == 'y020102' && !isset($cfg['no_token'])) { ?>
        <div class="modal fade" id="msg_token">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
                            <?php echo $lang->get('OK', 'console.common'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <script type="text/javascript">
    <?php if (isset($adminLogged['rcode']) && $adminLogged['rcode'] == 'y020102' && !isset($cfg['no_token'])) { ?>
        function tokenReload() {
            $.getJSON('<?php echo $route_console; ?>token/make/', function(result){
                if (result.rcode == 'y020102') {
                    $('#box_pm_new').text(result.pm_count);
                } else {
                    $('#msg_token .modal-body').text(result.msg);
                    $('#msg_token').modal('show');
                }
            });
        }
    <?php }

    if (isset($cfg['datetimepicker'])) { ?>
        var opts_datetimepicker = {
            lang: '<?php echo $lang->getCurrent(); ?>',
            i18n: {
                <?php echo $lang->getCurrent(); ?>: {
                    months: [
                        '<?php echo $lang->get('Jan', 'console.common'); ?>',
                        '<?php echo $lang->get('Feb', 'console.common'); ?>',
                        '<?php echo $lang->get('Mar', 'console.common'); ?>',
                        '<?php echo $lang->get('Apr', 'console.common'); ?>',
                        '<?php echo $lang->get('May', 'console.common'); ?>',
                        '<?php echo $lang->get('Jun', 'console.common'); ?>',
                        '<?php echo $lang->get('Jul', 'console.common'); ?>',
                        '<?php echo $lang->get('Aug', 'console.common'); ?>',
                        '<?php echo $lang->get('Sep', 'console.common'); ?>',
                        '<?php echo $lang->get('Oct', 'console.common'); ?>',
                        '<?php echo $lang->get('Nov', 'console.common'); ?>',
                        '<?php echo $lang->get('Dec', 'console.common'); ?>'
                    ],
                    monthsShort: [
                        '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'
                    ],
                    dayOfWeek: [
                        '<?php echo $lang->get('Sun', 'console.common'); ?>',
                        '<?php echo $lang->get('Mon', 'console.common'); ?>',
                        '<?php echo $lang->get('Tue', 'console.common'); ?>',
                        '<?php echo $lang->get('Wed', 'console.common'); ?>',
                        '<?php echo $lang->get('Thu', 'console.common'); ?>',
                        '<?php echo $lang->get('Fri', 'console.common'); ?>',
                        '<?php echo $lang->get('Sat', 'console.common'); ?>'
                    ]
                }
            },
            //timepicker: false,
            format: '<?php echo $config['var_extra']['base']['site_date'] . ' ' . $config['var_extra']['base']['site_time_short']; ?>',
            step: 30,
            scrollMonth: false,
            scrollInput: false,
            mask: true
        };
    <?php }

    if (isset($cfg['captchaReload'])) { ?>
        function captchaReload() {
            var imgSrc = '<?php echo $route_misc; ?>captcha/index/' + new Date().getTime() + '/' + Math.random() + '/';
            $('.bg-captcha-img').attr('src', imgSrc);
        }
    <?php } ?>

    $(document).ready(function(){
        <?php if (isset($adminLogged['rcode']) && $adminLogged['rcode'] == 'y020102' && !isset($cfg['no_token'])) { ?>
            tokenReload();
            setInterval(function(){
                tokenReload();
            }, <?php echo $config['console']['token_reload']; ?>);
        <?php }

        if (isset($cfg['tinymce'])) { ?>
            var insertConfig = {
                title: '<?php echo $lang->get('Insert iframe', 'console.common'); ?>',
                body: {
                    type: 'panel',
                    items: [
                        {
                            type: 'textarea',
                            name: 'iframesrc',
                            label: '<?php echo $lang->get('Fill in iframe link', 'console.common'); ?>'
                        },
                        {
                            type: 'selectbox',
                            name: 'ratio',
                            label: '<?php echo $lang->get('Choose a ratio', 'console.common'); ?>',
                            items: [
                                { value: '16by9', text: '<?php echo $lang->get('16 : 9', 'console.common'); ?>' },
                                { value: '21by9', text: '<?php echo $lang->get('21 : 9', 'console.common'); ?>' },
                                { value: '4by3', text: '<?php echo $lang->get('4 : 3', 'console.common'); ?>' },
                                { value: '1by1', text: '<?php echo $lang->get('1 : 1', 'console.common'); ?>' }
                            ]
                        },
                    ]
                },
                buttons: [
                    {
                        type: 'cancel',
                        name: 'cancel',
                        text: 'Cancel',
                        disabled: false
                    },
                    {
                        type: 'custom',
                        name: 'save',
                        text: 'Save',
                        primary: true,
                        disabled: false
                    }
                ],
                initialData: {
                    ratio: '16by9'
                },
                onAction: (dialogApi, details) => {
                    var data = dialogApi.getData();

                    if (data.iframesrc.length > 0) {
                        var result = '[iframe=' + data.ratio + ']' + data.iframesrc + '[/iframe]';
                        //console.log(result);
                        tinymce.activeEditor.execCommand('mceInsertContent', false, '<p>' + result + '</p>');
                    }

                    dialogApi.close();
                }
            };

            tinyMCE.init({
                selector: 'textarea.tinymce',
                min_height: <?php if (isset($adminLogged['admin_prefer']['editor']['default_height']) && $adminLogged['admin_prefer']['editor']['default_height'] > 0) { echo $adminLogged['admin_prefer']['editor']['default_height']; } else { echo '500'; } ?>,
                autoresize_min_height: <?php if (isset($adminLogged['admin_prefer']['editor']['default_height']) && $adminLogged['admin_prefer']['editor']['default_height'] > 0) { echo $adminLogged['admin_prefer']['editor']['default_height']; } else { echo '500'; } ?>,
                language: '<?php echo $lang->getCurrent(); ?>',
                plugins: ['table image lists advlist link media charmap code paste visualblocks visualchars hr autosave<?php if (isset($adminLogged['admin_prefer']['editor']['autosize']) && $adminLogged['admin_prefer']['editor']['autosize'] === 'on') { ?> autoresize<?php } ?> fullscreen quickbars'],
                resize: <?php if (isset($adminLogged['admin_prefer']['editor']['resize']) && $adminLogged['admin_prefer']['editor']['resize'] === 'on') { ?>true<?php } else { ?>false<?php } ?>,
                menu: {
                    insert: { title: 'Insert', items: 'image media insertiframe link inserttable | charmap hr' }
                },
                menubar: 'edit insert view format table',
                toolbar: 'undo redo restoredraft | bold italic styleselect | alignleft aligncenter alignright alignjustify | forecolor backcolor | bullist numlist outdent indent | link unlink | removeformat code fullscreen | wizardExample',
                quickbars_selection_toolbar: 'bold italic underline | h2 h3 | link unlink image',
                quickbars_insert_toolbar: 'image quicktable charmap',
                contextmenu: false,
                content_style: 'img { max-width: 100%; }',
                autosave_restore_when_empty: <?php if (isset($adminLogged['admin_prefer']['editor']['restore']) && $adminLogged['admin_prefer']['editor']['restore'] === 'on') { ?>true<?php } else { ?>false<?php } ?>,
                powerpaste_word_import: 'clean',
                powerpaste_html_import: 'clean',
                convert_urls: false,
                remove_script_host: false,
                setup: (editor) => {
                    editor.ui.registry.addMenuItem('insertiframe', {
                        icon: 'embed-page',
                        text: '<?php echo $lang->get('Insert iframe', 'console.common'); ?>',
                        onAction: () => {
                            editor.windowManager.open(insertConfig);
                        }
                    });
                }
            });
        <?php }

        if (isset($cfg['popover'])) { ?>
            $('[data-toggle="popover"]').popover({
                html: true,
                template: '<div class="popover bg-popover"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
            });
        <?php }

        if (isset($cfg['tooltip'])) { ?>
            $('[data-toggle="tooltip"]').tooltip({
                html: true,
                template: '<div class="tooltip bg-tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
            });
        <?php }

        if (isset($cfg['captchaReload'])) { ?>
            $('.bg-captcha-btn, .bg-captcha-img').click(function(){
                captchaReload();
            });
        <?php }

        if (isset($cfg['imageAsync'])) { ?>
            $('[data-toggle="async"]').each(function(){
                var _src = $(this).data('src');
                $(this).attr('src', _src);

                $(this).one('error', function(){
                    $(this).attr('src', '{:DIR_STATIC}image/notfound.svg');
                });
            });
        <?php } ?>

        $('.bg-collapse.collapse').on('shown.bs.collapse', function(){
            var _key = $(this).data('key');
            $('#bg-caret-' + _key).attr('class', 'fas fa-chevron-down');
        });

        $('.bg-collapse.collapse').on('hidden.bs.collapse', function(){
            var _key = $(this).data('key');
            $('#bg-caret-' + _key).attr('class', 'fas fa-chevron-right');
        });

        <?php if (!isset($cfg['no_loading'])) { ?>
            $('#loading_mask').fadeOut();
        <?php } ?>
    });
    </script>

    <script src="{:DIR_STATIC}lib/bootstrap/4.5.2/js/bootstrap.bundle.min.js" type="text/javascript"></script>

    <!-- Powered by <?php echo PRD_CMS_NAME, ' ', PRD_CMS_VER; ?> -->

    <?php Plugin::listen('action_console_foot_after'); //后台界面底部触发 ?>
</body>
</html>
