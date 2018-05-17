<?php include('html_head.php'); ?>

    <header class="navbar navbar-expand-md navbar-light bg-light justify-content-between mb-3">
        <div class="container">
            <?php if (BG_DEFAULT_UI == 'default') { ?>
                <a class="navbar-brand" href="<?php echo PRD_CMS_URL; ?>" target="_blank"><?php echo BG_SITE_NAME; ?></a>
            <?php } else { ?>
                <a class="navbar-brand" href="javascript:void(0);"><?php echo BG_SITE_NAME; ?></a>
            <?php } ?>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <nav class="collapse navbar-collapse" id="navbarNav">
                <form class="d-none d-md-block mr-auto" id="search_form_global">
					<div class="input-group mt-3 mb-3">
						<input type="text" class="form-control" placeholder="关键词" id="search_key_global">
						<span class="input-group-append">
							<button type="button" class="btn btn-secondary" id="search_btn_global">
								<span class="oi oi-magnifying-glass"></span>
							</button>
						</span>
					</div>
				</form>
				<ul class="navbar-nav">
                    <?php if (isset($this->tplData['cateRows'])) {
                        foreach ($this->tplData['cateRows'] as $key=>$value) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo $value['urlRow']['cate_url']; ?>">
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