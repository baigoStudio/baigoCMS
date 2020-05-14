        <div class="modal fade" id="keep_tag_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title"><?php echo $lang->get('Retained tags'); ?></div>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-inline">
                            <?php foreach ($keepTag as $_key=>$_value) { ?>
                                <li class="list-inline-item lead">
                                    <span class="badge badge-info"><?php echo $_value; ?></span>
                                </li>
                            <?php } ?>
                        </ul>
                        <div><?php echo $lang->get('These tags are automatically retained'); ?></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
                            <?php echo $lang->get('Close'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="keep_attr_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title"><?php echo $lang->get('System retains specific attributes of these tags by default'); ?></div>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th><?php echo $lang->get('Tag'); ?></th>
                                <th><?php echo $lang->get('Attributes'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($keepAttr as $key=>$value) { ?>
                                <tr>
                                    <td><?php echo $key; ?></td>
                                    <td class="text-danger">
                                        <ul class="list-inline">
                                            <?php foreach ($value as $key_attr=>$value_attr) { ?>
                                                <li class="list-inline-item">
                                                    <code><?php echo $value_attr; ?></code>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
                            <?php echo $lang->get('Close'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade help_modal" id="help_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                </div>
            </div>
        </div>

        <div class="modal fade help_modal" id="help_modal_lg">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                </div>
            </div>
        </div>

        <script type="text/javascript">
        $(document).ready(function(){
            $('.help_modal').on('shown.bs.modal',function(event){
        		var _obj_button   = $(event.relatedTarget);
        		var _act          = _obj_button.data('act');
                $('.help_modal .modal-content').load('<?php echo $route_console; ?>gsite_help/' + _act + '/view/modal/');
        	}).on('hidden.bs.modal', function(){
            	$('.help_modal .modal-content').empty();
        	});
    	});
        </script>
