{include "include/html_head.tpl"}

    <header class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                    <span class="sr-only">nav</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                {if $smarty.const.BG_DEFAULT_UI == "default"}
                    <a class="navbar-brand" href="{$smarty.const.PRD_CMS_URL}" target="_blank">{$smarty.const.BG_SITE_NAME}</a>
                {else}
                    <a class="navbar-brand" href="javascript:void(0);">{$smarty.const.BG_SITE_NAME}</a>
                {/if}
            </div>
            <nav class="collapse navbar-collapse bs-navbar-collapse">
                <form class="navbar-form navbar-left hidden-sm" id="search_form_global">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="{$lang.label.key}" id="search_key_global">
						<span class="input-group-btn">
							<button type="button" class="btn btn-default" id="search_btn_global">
								<span class="glyphicon glyphicon-search"></span>
							</button>
						</span>
					</div>
				</form>
				<ul class="nav navbar-nav navbar-right">
                    {foreach $tplData.cateRows as $key=>$value}
                        <li>
                            <a href="{$value.urlRow.cate_url}">
                                {$value.cate_name}
                            </a>
                        </li>
                    {/foreach}
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">