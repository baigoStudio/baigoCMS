  <div class="modal-header">
    <div class="modal-title"><?php echo $lang->get('Common selector'); ?></div>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>
  <table class="table table-hover">
    <thead>
      <tr>
        <th><?php echo $lang->get('Selector'); ?></th>
        <th>
          <?php echo $lang->get('Example'); ?>
          /
          <?php echo $lang->get('Result'); ?>
        </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($selectorRows as $_key=>$_value) { ?>
        <tr>
          <?php if (isset($_value['selector']) && isset($_value['example']) && isset($_value['result'])) { ?>
            <td class="text-danger"><i><?php echo $_value['selector']; ?></i></td>
            <td>
              <div><?php echo $_value['example']; ?></div>
              <div class="text-muted"><?php echo $lang->get($_value['result']); ?></div>
            </td>
          <?php } else { ?>
            <td colspan="2">&nbsp;</td>
          <?php } ?>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  <div class="modal-footer">
    <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">
      <?php echo $lang->get('Close', 'console.common'); ?>
    </button>
  </div>
