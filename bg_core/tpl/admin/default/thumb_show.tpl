{* admin_groupForm.tpl 管理组编辑界面 *}
{$cfg = [
    title          => "{$adminMod.attach.main.title} - {$adminMod.attach.sub.thumb.title}",
    menu_active    => "attach",
    sub_active     => "thumb",
    baigoClear     => "true"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl" cfg=$cfg}

    <li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=attach&act_get=list">{$adminMod.attach.main.title}</a></li>
    <li>{$adminMod.attach.sub.thumb.title}</li>

    {include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

    <div class="form-group">
        <ul class="nav nav-pills nav_baigo">
            <li>
                <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=thumb&act_get=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    {$lang.href.back}
                </a>
            </li>
            <li>
                <a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=attach#thumb" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    {$lang.href.help}
                </a>
            </li>
        </ul>
    </div>

    <form name="thumb_gen" id="thumb_gen">
        <input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
        <input type="hidden" name="thumb_id" value="{$tplData.thumbRow.thumb_id}">
        <input type="hidden" name="act_post" id="act_gen" value="gen">

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label">{$lang.label.rangeId}</label>
                            <div class="input-group">
                                <input type="text" name="attach_range[begin_id]" id="attach_range_begin_id" value="0" class="form-control">
                                <span class="input-group-addon input_range">{$lang.label.to}</span>
                                <input type="text" name="attach_range[end_id]" id="attach_range_end_id" value="0" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-warning" id="go_gen">
                                <span class="glyphicon glyphicon-refresh"></span>
                                {$lang.btn.thumbGen}
                            </button>
                        </div>
                        <div class="form-group">
                            <div class="baigoClear progress">
                                <div class="progress-bar progress-bar-info progress-bar-striped active"></div>
                            </div>
                        </div>
                
                        <div class="form-group">
                            <div class="baigoClearMsg">
                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="well">
                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.id}</label>
                        <p class="form-control-static">{$tplData.thumbRow.thumb_id}</p>
                    </div>
            
                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.thumbWidth}</label>
                        <p class="form-control-static">{$tplData.thumbRow.thumb_width}</p>
                    </div>
            
                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.thumbHeight}</label>
                        <p class="form-control-static">{$tplData.thumbRow.thumb_height}</p>
                    </div>
            
                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.thumbCall}</label>
                        <p class="form-control-static">thumb_{$tplData.thumbRow.thumb_width}_{$tplData.thumbRow.thumb_height}_{$tplData.thumbRow.thumb_type}</p>
                    </div>
            
                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.thumbType}</label>
                        <p class="form-control-static">{$type.thumb[$tplData.thumbRow.thumb_type]}</p>
                    </div>
                </div>
            </div>
        </div>
    </form>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_foot.tpl" cfg=$cfg}

    <script type="text/javascript">
    var opts_gen = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=attach",
        confirm_selector: "#act_gen",
        confirm_val: "gen",
        confirm_msg: "{$lang.confirm.gen}",
        msg_loading: "{$alert.x070409}",
        msg_complete: "{$alert.y070409}"
    };
    
    $(document).ready(function(){
        var obj_gen = $("#thumb_gen").baigoClear(opts_gen);
        $("#go_gen").click(function(){
            obj_gen.clearSubmit();
        });
    });
    </script>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}
