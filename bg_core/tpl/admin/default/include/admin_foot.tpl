            </div>

            <div class="col-md-2 col-md-pull-10">
                <div class="panel panel-info">
                    <div class="list-group">
                        {foreach $adminMod as $key_m=>$value_m}
                            <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod={$value_m.main.mod}" class="list-group-item{if isset($cfg.menu_active) && $cfg.menu_active == $key_m} active{/if}">
                                <span class="glyphicon glyphicon-{$value_m.main.icon}"></span>
                                {$value_m.main.title}
                                <span class="caret"></span>
                            </a>
                            {if isset($cfg.menu_active) && $cfg.menu_active == $key_m}
                                {foreach $value_m.sub as $key_s=>$value_s}
                                    <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod={$value_s.mod}&act_get={$value_s.act_get}" class="list-group-item {if $cfg.sub_active == $key_s}list-group-item-info{else}sub_normal{/if}">{$value_s.title}</a>
                                {/foreach}
                            {/if}
                        {/foreach}

                        <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=custom&act_get=list" class="list-group-item{if isset($cfg.menu_active) && $cfg.menu_active == "opt"} active{/if}">
                            <span class="glyphicon glyphicon-cog"></span>
                            {$lang.href.opt}
                            <span class="caret"></span>
                        </a>

                        {if isset($cfg.menu_active) && $cfg.menu_active == "opt"}
                            <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=custom&act_get=list" class="list-group-item {if $cfg.menu_active == "opt" && $cfg.sub_active == "custom"}list-group-item-info{else}sub_normal{/if}">
                                {$lang.page.custom}
                            </a>

                            <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=app&act_get=list" class="list-group-item {if $cfg.menu_active == "opt" && $cfg.sub_active == "app"}list-group-item-info{else}sub_normal{/if}">
                                {$lang.page.app}
                            </a>

                            <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=opt&act_get=chkver" class="list-group-item {if isset($cfg.sub_active) && $cfg.sub_active == "chkver"}list-group-item-info{else}sub_normal{/if}">{$lang.page.chkver}</a>

                            <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=opt&act_get=dbconfig" class="list-group-item {if $cfg.menu_active == "opt" && $cfg.sub_active == "dbconfig"}list-group-item-info{else}sub_normal{/if}">
                                {$lang.page.installDbConfig}
                            </a>
                            {foreach $opt as $key_opt=>$value_opt}
                                <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=opt&act_get={$key_opt}" class="list-group-item {if $cfg.menu_active == "opt" && $cfg.sub_active == $key_opt}list-group-item-info{else}sub_normal{/if}">
                                    {$value_opt.title}
                                </a>
                            {/foreach}
                        {/if}
                    </div>
                </div>

                {if $smarty.const.BG_MODULE_GEN > 0 && $smarty.const.BG_VISIT_TYPE == "static"}
                    <div class="form-group">
                        <button data-whatever="{$smarty.const.BG_URL_ADMIN}gen.php?mod=article&act_get=1by1&overall=true" class="btn btn-success btn-block" data-toggle="modal" data-target="#gen_modal">
                            <span class="glyphicon glyphicon-refresh"></span>
                            {$lang.btn.genOverall}
                        </button>
                    </div>
                {/if}
            </div>
        </div>
    </div>

    <footer class="bg-info page_foot">
        <div class="pull-left foot_logo">
            {if $smarty.const.BG_DEFAULT_UI == "default"}
                <a href="{$smarty.const.PRD_CMS_URL}" target="_blank">{$smarty.const.PRD_CMS_POWERED} {$smarty.const.PRD_CMS_NAME} {$smarty.const.PRD_CMS_VER}</a>
            {else}
                <a href="javascript:void(0);">{$smarty.const.BG_DEFAULT_UI} CMS</a>
            {/if}
        </div>
        <div class="pull-right foot_power">
            {$smarty.const.PRD_CMS_POWERED}
            {if $smarty.const.BG_DEFAULT_UI == "default"}
                <a href="{$smarty.const.PRD_CMS_URL}" target="_blank">{$smarty.const.PRD_CMS_NAME}</a>
            {else}
                {$smarty.const.BG_DEFAULT_UI} CMS
            {/if}
            {$smarty.const.PRD_CMS_VER}
        </div>
        <div class="clearfix"></div>
    </footer>

    <div class="modal fade" id="msg_token">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <p id="msg_token_content"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{$lang.btn.ok}</button>
                </div>
            </div>
        </div>
    </div>

    {if $smarty.const.BG_MODULE_GEN > 0 && $smarty.const.BG_VISIT_TYPE == "static"}
        <div class="modal fade" id="gen_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <span class="glyphicon glyphicon-refresh"></span>
                        {$lang.page.gening}
                    </div>
                    <div class="modal-body">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" name="iframe_gen"></iframe>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{$lang.btn.close}</button>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
    	$("#gen_modal").on("show.bs.modal", function(event){
    		var button       = $(event.relatedTarget);
    		var recipient    = button.data("whatever");
    		var modal        = $(this);
    		modal.find("iframe").attr("src", recipient);
    	})
        </script>
    {/if}