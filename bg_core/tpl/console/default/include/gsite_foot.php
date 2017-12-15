        <div class="modal fade" id="selector_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <?php echo $this->lang['mod']['label']['selectorOften']; ?>
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><?php echo $this->lang['mod']['label']['selector']; ?></th>
                                <th><?php echo $this->lang['mod']['label']['selectorExample']; ?></th>
                                <th><?php echo $this->lang['mod']['label']['select']; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $_count = 1;
                            foreach ($this->lang['selector'] as $_key=>$_value) {
                                foreach ($_value as $_key_sub=>$_value_sub) { ?>
                                    <tr>
                                        <td class="text-danger"><?php echo $_value_sub[0]; ?></td>
                                        <td><?php echo $_value_sub[1]; ?></td>
                                        <td><?php echo $_value_sub[2]; ?></td>
                                    </tr>
                                <?php }

                                if ($_count < count($this->lang['selector'])) { ?>
                                    <tr class="active">
                                        <td colspan="3">&nbsp;</td>
                                    </tr>
                                <?php }

                                $_count++;
                            } ?>
                        </tbody>
                    </table>
                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <?php echo $this->lang['common']['btn']['close']; ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="keep_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <?php echo $this->lang['mod']['label']['keepTag']; ?>
                    </div>
                    <div class="modal-body">
                        <ul class="list-inline">
                            <?php foreach ($this->tplData['keepTag'] as $_key=>$_value) { ?>
                                <li class="lead">
                                    <span class="label label-info"><?php echo $_value; ?></span>
                                </li>
                            <?php } ?>
                        </ul>
                        <div><?php echo $this->lang['mod']['label']['keepTagNote']; ?></div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <?php echo $this->lang['common']['btn']['close']; ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="attr_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <?php echo $this->lang['mod']['label']['attrGather']; ?>
                    </div>
                    <div class="modal-body">
                        <div><?php echo $this->lang['mod']['label']['attrOftenNote']; ?></div>

                        <dl class="bg-dl">
                            <?php foreach ($this->tplData['attrQList'] as $_key=>$_value) { ?>
                                <dt>
                                    <?php if (isset($this->lang['mod']['attrQList'][$_key]['label'])) {
                                        echo $this->lang['mod']['attrQList'][$_key]['label'];
                                    } else {
                                        echo $_value['label'];
                                    } ?>
                                </dt>
                                <dd>
                                    <?php if (isset($this->lang['mod']['attrQList'][$_key]['note'])) {
                                        echo $this->lang['mod']['attrQList'][$_key]['note'];
                                    } ?>
                                </dd>
                            <?php } ?>
                        </dl>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <?php echo $this->lang['common']['btn']['close']; ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="attr_except_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <div><?php echo $this->lang['mod']['label']['attrExceptNoteSys']; ?></div>
                    </div>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><?php echo $this->lang['mod']['label']['attrExceptTag']; ?></th>
                                <th><?php echo $this->lang['mod']['label']['attrExceptAttr']; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($this->tplData['keepAttr'] as $key=>$value) { ?>
                                <tr>
                                    <td><?php echo $key; ?></td>
                                    <td class="text-danger">
                                        <ul class="list-inline">
                                            <?php foreach ($value as $key_attr=>$value_attr) { ?>
                                                <li>
                                                    <code><?php echo $value_attr; ?></code>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <?php echo $this->lang['common']['btn']['close']; ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="filter_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <?php echo $this->lang['mod']['label']['filter']; ?>
                    </div>
                    <div class="modal-body">
                        <div><?php echo $this->lang['mod']['label']['filterNote']; ?></div>

                        <dl class="bg-dl">
                            <?php foreach ($this->tplData['filter'] as $_key=>$_value) { ?>
                                <dt>
                                    <?php if (isset($this->lang['mod']['filter'][$_key]['label'])) {
                                        echo $this->lang['mod']['filter'][$_key]['label'];
                                    } else {
                                        echo $_value['label'];
                                    } ?>
                                </dt>
                                <dd>
                                    <?php if (isset($this->lang['mod']['filter'][$_key]['note'])) {
                                        echo $this->lang['mod']['filter'][$_key]['note'];
                                    } ?>
                                </dd>
                            <?php } ?>
                        </dl>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            <?php echo $this->lang['common']['btn']['close']; ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
