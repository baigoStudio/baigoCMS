{*cate_show.php 栏目编辑界面*}
{$cfg = [
    title          => "{$adminMod.cate.main.title} - {$lang.page.show}",
    menu_active    => "cate",
    sub_active     => "list",
    baigoClear     => "true",
    tokenReload    => "true"
]}

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_head.tpl" cfg=$cfg}

    <li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=cate&act_get=list">{$adminMod.cate.main.title}</a></li>
    <li>{$lang.page.show}</li>

    {include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_left.tpl" cfg=$cfg}

    <div class="form-group">
        <ul class="nav nav-pills nav_baigo">
            <li>
                <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=cate&act_get=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    {$lang.href.back}
                </a>
            </li>
            <li>
                <a href="{$smarty.const.BG_URL_HELP}ctl.php?mod=admin&act_get=cate#form" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    {$lang.href.help}
                </a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    {if $smarty.const.BG_MODULE_GEN == 1 && $smarty.const.BG_MODULE_FTP == 1 && $smarty.const.BG_VISIT_TYPE == "static"}
                        <form name="cate_gen" id="cate_gen">
                            <input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
                            <input type="hidden" name="act_post" id="act_post" value="cate">
                            <input type="hidden" name="cate_id" id="cate_id" value="{$tplData.cateRow.cate_id}">

                            <div class="form-group">
                                <button type="button" class="btn btn-warning" id="go_gen">
                                    <span class="glyphicon glyphicon-refresh"></span>
                                    {$lang.btn.cateGen}
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
                        </form>
                    {/if}

                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.cateName}</label>
                        <p class="form-control-static input-lg">{$tplData.cateRow.cate_name}</p>
                    </div>

                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.cateAlias}</label>
                        <p class="form-control-static input-lg">{$tplData.cateRow.cate_alias}</p>
                    </div>

                    <div class="form-group" id="item_cate_perpage">
                        <label class="control-label static_label">{$lang.label.catePerpage}</label>
                        <p class="form-control-static input-lg">{$tplData.cateRow.cate_perpage}</p>
                    </div>

                    {if $tplData.cateRow.cate_parent_id < 1}
                        <div class="form-group">
                            <label class="control-label static_label">{$lang.label.cateDomain}</label>
                            <p class="form-control-static input-lg">{$tplData.cateRow.cate_domain}</p>
                        </div>
                    {/if}


                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.cateContent}</label>
                        <p class="form-control-static">{$tplData.cateRow.cate_content}</p>
                    </div>

                    <div class="form-group">
                        <label class="control-label static_label">{$lang.label.cateLink}</label>
                        <p class="form-control-static input-lg">{$tplData.cateRow.cate_link}</p>
                    </div>

                    <div class="form-group">
                        <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=cate&act_get=form&cate_id={$tplData.cateRow.cate_id}">
                            <span class="glyphicon glyphicon-edit"></span>
                            {$lang.href.edit}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="well">
                <div class="form-group">
                    <label class="control-label static_label">{$lang.label.id}</label>
                    <p class="form-control-static input-lg">{$tplData.cateRow.cate_id}</p>
                </div>

                <div class="form-group">
                    <label class="control-label static_label">{$lang.label.cateType}</label>
                    <p class="form-control-static input-lg">{$type.cate[$tplData.cateRow.cate_type]}</p>
                </div>

                <div class="form-group">
                    <label class="control-label static_label">{$lang.label.cateStatus}</label>
                    <p class="form-control-static input-lg">{$status.cate[$tplData.cateRow.cate_status]}</p>
                </div>

                <div class="form-group">
                    <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=cate&act_get=form&cate_id={$tplData.cateRow.cate_id}">
                        <span class="glyphicon glyphicon-edit"></span>
                        {$lang.href.edit}
                    </a>
                </div>
            </div>
        </div>
    </div>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/admin_foot.tpl" cfg=$cfg}

    <script type="text/javascript">
    var opts_gen = {
        ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=gen",
        confirm_selector: "#act_post",
        confirm_val: "cate",
        confirm_msg: "{$lang.confirm.gen}",
        msg_loading: "{$alert.x110402}",
        msg_complete: "{$alert.y110402}"
    };

    $(document).ready(function(){
        var obj_gen = $("#cate_gen").baigoClear(opts_gen);
        $("#go_gen").click(function(){
            obj_gen.clearSubmit();
        });
    });
    </script>

{include "{$smarty.const.BG_PATH_TPLSYS}admin/default/include/html_foot.tpl" cfg=$cfg}

