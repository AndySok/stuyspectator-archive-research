<?php /* Smarty version 2.6.19, created on 2010-01-23 23:54:04
         compiled from cart_view.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'ShowFormToken', 'cart_view.tpl', 44, false),)), $this); ?>
<?php if ($this->_tpl_vars['cart_error']): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array('name' => @con('shopping_cart'))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <div align='center' class='error'><?php echo $this->_tpl_vars['cart_error']; ?>
</div>
<?php else: ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array('name' => @con('shopping_cart'),'header' => @con('cart_cont_mess'))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "cart_content.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>
<br>
<table class="table_midtone" width='100%'>
  <tr>
    <td width="50%" align="left">
      <form method='post' action="index.php">
        <?php echo $this->_plugins['function']['ShowFormToken'][0][0]->showFormToken(array('name' => 'moretickets'), $this);?>

        <?php if ($this->_tpl_vars['event_id']): ?>
           <input type='hidden' name='event_id' value='<?php echo $this->_tpl_vars['event_id']; ?>
' />
        <?php endif; ?>
        <input name="go_home" value="<?php echo @con('order_more_tickets'); ?>
" type="submit">
      </form>
    </td>
    <td align="right">
      <?php if ($this->_tpl_vars['cart']->can_checkout_f()): ?>
        <form action="checkout.php" method='post' >
          <?php echo $this->_plugins['function']['ShowFormToken'][0][0]->showFormToken(array('name' => 'checkout'), $this);?>

          <input name="go_pay" value="<?php echo @con('checkout'); ?>
" type="submit">
        </form>
      <?php endif; ?>
    </td>
  </tr>
</table>