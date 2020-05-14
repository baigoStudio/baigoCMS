/*
v1.0.0 jQuery baigoDialog plugin 对话框插件
(c) 2013 baigo studio - http://www.baigo.net/
License: http://www.opensource.org/licenses/mit-license.php
*/
;{
    jQuery.baigoDialog = function(options) {
        'use strict';
        if (this.length < 1) {
            return this;
        }

        var opts_default = {
            selector: {
                modal: '.bg-confirm-modal',
                msg: '.bg-msg',
                cancel: '.bg-cancel',
                confirm: '.bg-confirm',
                ok: '.bg-ok',
                group_confirm: '.bg-group-confirm',
                group_alert: '.bg-group-alert'
            },
            btn_text: {
                cancel: 'Cancel',
                confirm: 'Confirm',
                ok: 'OK'
            },
            tpl: '<div class="modal bg-confirm-modal">' +
                '<div class="modal-dialog modal-dialog-centered">' +
                    '<div class="modal-content">' +
                        '<div class="modal-body">' +
                            '<p class="bg-msg"></p>' +
                        '</div>' +
                        '<div class="modal-footer">' +
                            '<button type="button" class="btn btn-outline-secondary btn-sm bg-cancel bg-group-confirm" data-act="cancel">Cancel</button>' +
                            '<button type="button" class="btn btn-primary btn-sm bg-confirm bg-group-confirm" data-act="confirm">Confirm</button>' +
                            '<button type="button" class="btn btn-primary btn-sm bg-ok bg-group-alert" data-dismiss="modal">OK</button>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>'
        };

        var opts = $.extend(true, opts_default, options);

        if ($(opts.selector.modal).length < 1) {
            $('body').append(opts.tpl);
        }

        $(opts.selector.modal + ' ' + opts.selector.cancel).text(opts.btn_text.cancel);
        $(opts.selector.modal + ' ' + opts.selector.confirm).text(opts.btn_text.confirm);
        $(opts.selector.modal + ' ' + opts.selector.ok).text(opts.btn_text.ok);

        var process = {
            modalShow: function(msg) {
                if (typeof msg != 'undefined' && msg.length > 0) {
                    $(opts.selector.modal + ' ' + opts.selector.msg).text(msg);
                }

                var _option = { backdrop: 'static', show: true };

                $(opts.selector.modal).modal(_option);
            }
        };

        var el = {
            confirm: function(msg, callback) {
                var _status = true;
                $(opts.selector.group_alert).hide();
                $(opts.selector.group_confirm).show();

                if (typeof msg != 'undefined' && msg.length > 0) {
                    process.modalShow(msg);

                    if (callback && callback instanceof Function) {
                        $(opts.selector.modal + ' ' + opts.selector.group_confirm).off('click');
                        $(opts.selector.modal + ' ' + opts.selector.group_confirm).click(function() {
                            if ($(this).data('act') == 'confirm') {
                                callback(true);
                            } else {
                                callback(false);
                            }

                            $(opts.selector.modal).modal('hide');
                        });
                    }
                }
            },
            alert: function (msg) {
                $(opts.selector.group_alert).show();
                $(opts.selector.group_confirm).hide();
                process.modalShow(msg);
                $(opts.selector.modal + ' ' + opts.selector.group_confirm).click(function() {
                    $(opts.selector.modal).modal('hide');
                });
            }
        };

        return el;
    }
};
