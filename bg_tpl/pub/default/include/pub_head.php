<?php include('html_head.php'); ?>

    <header class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                    <span class="sr-only">nav</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php if (BG_DEFAULT_UI == 'default') { ?>
                    <a class="navbar-brand" href="<?php echo PRD_CMS_URL; ?>" target="_blank"><?php echo BG_SITE_NAME; ?></a>
                <?php } else { ?>
                    <a class="navbar-brand" href="javascript:void(0);"><?php echo BG_SITE_NAME; ?></a>
                <?php } ?>
            </div>
            <nav class="collapse navbar-collapse bs-navbar-collapse">
                <form class="navbar-form navbar-left hidden-sm" id="search_form_global">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="关键词" id="search_key_global">
						<span class="input-group-btn">
							<button type="button" class="btn btn-default" id="search_btn_global">
								<span class="glyphicon glyphicon-search"></span>
							</button>
						</span>
					</div>
				</form>
				<ul class="nav navbar-nav navbar-right">
                    <?php if (isset($this->tplData['cateRows'])) {
                        foreach ($this->tplData['cateRows'] as $key=>$value) { ?>
                            <li>
                                <a href="<?php echo $value['urlRow']['cate_url']; ?>">
                                    <?php echo $value['cate_name']; ?>
                                </a>
                            </li>
                        <?php }
                    } ?>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">