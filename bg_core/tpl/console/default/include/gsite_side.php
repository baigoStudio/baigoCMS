            <div class="col-md-3">
                <div class="well">
                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['id']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['gsiteRow']['gsite_id']; ?></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['status']; ?></label>
                        <div class="form-control-static">
                            <?php gsite_status_process($this->tplData['gsiteRow']['gsite_status'], $this->lang['mod']['status']); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['gsiteName']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['gsiteRow']['gsite_name']; ?></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['note']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['gsiteRow']['gsite_note']; ?></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['belongCate']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['cateRow']['cate_name']; ?></div>
                    </div>
                </div>
            </div>