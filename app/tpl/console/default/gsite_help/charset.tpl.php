                <div class="modal-header">
                    <div class="modal-title"><?php echo $lang->get('Charset'); ?></div>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <?php foreach ($charsetRows as $key=>$value) { ?>
                            <thead>
                                <tr>
                                    <th class="text-nowrap"><?php echo $lang->get($value['title'], 'console.charset'); ?></th>
                                    <th class="text-nowrap">
                                        <?php echo $lang->get('Name'); ?>
                                        /
                                        <?php echo $lang->get('Note'); ?>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($value['lists'] as $key_sub=>$value_sub) { ?>
                                    <tr>
                                        <td class="text-nowrap"><?php echo $key_sub; ?></td>
                                        <td>
                                            <div><?php echo $lang->get($value_sub['title'], 'console.charset'); ?></div>
                                            <div class="text-muted"><?php echo $lang->get($value_sub['note'], 'console.charset'); ?></div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">
                        <?php echo $lang->get('Close'); ?>
                    </button>
                </div>
