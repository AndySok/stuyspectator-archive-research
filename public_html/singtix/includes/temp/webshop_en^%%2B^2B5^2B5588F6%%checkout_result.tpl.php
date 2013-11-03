<?php /* Smarty version 2.6.19, created on 2010-01-23 23:55:39
         compiled from checkout_result.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'eval', 'checkout_result.tpl', 59, false),)), $this); ?>
<?php if ($this->_tpl_vars['pm_return']['approved']): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array('name' => @con('pay_accept'))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php else: ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array('name' => @con('pay_refused'))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
<table class="table_midtone">
  <tr>
    <td>
        <?php if (! $this->_tpl_vars['pm_return']['approved']): ?>
          <?php echo @con('pay_reg'); ?>
!
        <?php endif; ?> 
        <br>
		    <?php echo @con('order_id'); ?>
 <b><?php echo $this->_tpl_vars['shop_order']['order_id']; ?>
</b><br>
		    <?php if ($this->_tpl_vars['pm_return']['transaction_id']): ?>
          <?php echo @con('trx_id'); ?>
   <b><?php echo $this->_tpl_vars['pm_return']['transaction_id']; ?>
</b><br>
        <?php endif; ?>
        <br> <br>
        <?php if (! $this->_tpl_vars['pm_return']['approved']): ?>
          <div class='error'>
  	    <?php else: ?>
          <br>

             <a href='?action=print&<?php echo $this->_tpl_vars['order']->EncodeSecureCode($this->_tpl_vars['order']->obj); ?>
' target='_blank'><?php echo @con('printinvoice'); ?>
</a>
          <br>
          <div>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['pm_return']['response']): ?>
	        <?php echo smarty_function_eval(array('var' => $this->_tpl_vars['pm_return']['response']), $this);?>

        <?php endif; ?>
			  </div>

    </td>
  </tr>
</table>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>