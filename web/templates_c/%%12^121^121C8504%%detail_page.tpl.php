<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'eval', 'list/detail_page.tpl', 13, false),)), $this); ?>
<div style="margin: 0px; font-size: 8pt; text-align: left;">

<?php if ($this->_tpl_vars['DetailPage']->GetFullRecordCount() < $this->_tpl_vars['DetailPage']->GetRecordLimit()): ?>
    <?php $this->assign('first_record_count', $this->_tpl_vars['DetailPage']->GetFullRecordCount()); ?>
<?php else: ?>
    <?php $this->assign('first_record_count', $this->_tpl_vars['DetailPage']->GetRecordLimit()); ?>
<?php endif; ?>

<?php $this->assign('total_record_count', $this->_tpl_vars['DetailPage']->GetFullRecordCount()); ?>

<?php $this->assign('shown_first_m_of_n_records', $this->_tpl_vars['Captions']->GetMessageString('ShownFirstMofNRecords')); ?>

<?php echo smarty_function_eval(array('var' => $this->_tpl_vars['shown_first_m_of_n_records']), $this);?>

<?php $this->assign('full_view_link', $this->_tpl_vars['DetailPage']->GetFullViewLink()); ?>
    (<?php echo smarty_function_eval(array('var' => $this->_tpl_vars['Captions']->GetMessageString('FullView')), $this);?>
)
</div>

<?php echo $this->_tpl_vars['Grid']; ?>