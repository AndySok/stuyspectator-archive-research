<?php /* Smarty version 2.6.19, created on 2010-01-23 23:54:04
         compiled from cart_content.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'counter', 'cart_content.tpl', 39, false),array('function', 'cycle', 'cart_content.tpl', 64, false),array('function', 'valuta', 'cart_content.tpl', 72, false),array('modifier', 'string_format', 'cart_content.tpl', 72, false),)), $this); ?>
 <?php if ($this->_tpl_vars['cart']->is_empty_f()): ?>
  <table class='table_dark' cellpadding='5' bgcolor='white' width='100%'>
    <tr><td class='TblLower' align='center' >  <br><br>
      <span class='title'><?php echo @con('cart_empty'); ?>
<br><br><br><br> </span>
    </td></tr>
  </table>
<?php else: ?>
  <?php echo smarty_function_counter(array('start' => '0','assign' => 'count'), $this);?>

  <table class='table_dark' cellpadding='5' width="100%" bgcolor='white'>
    <tr>
			<td class='TblHeader' valign='top'>
 				<b><?php echo @con('event'); ?>
</b>
			</td>
			<td class='TblHeader' valign='top'>
  			<b><?php echo @con('tickets'); ?>
</b>
			</td>
			<td class='TblHeader' valign='top'>
  			<b><?php echo @con('total'); ?>
</b>
			</td>
			<td class='TblHeader' valign='top'>
  			<b><?php echo @con('expires_in'); ?>
</b>
			</td>
    </tr>
    <?php $this->_tag_stack[] = array('items', array(), $this); $_block_repeat=true; $this->_reg_objects['cart'][0]->items($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat); while ($_block_repeat) { ob_start();?>
      <?php if ($this->_tpl_vars['check_out'] == 'on'): ?>
        <?php if (! $this->_tpl_vars['seat_item']->is_expired()): ?>
          <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "cart_subcontent.tpl", 'smarty_include_vars' => array('check_out' => 'on')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <?php endif; ?>
      <?php else: ?>
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "cart_subcontent.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <?php endif; ?>
    <?php $_obj_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_reg_objects['cart'][0]->items($this->_tag_stack[count($this->_tag_stack)-1][1], $_obj_block_content, $this, $_block_repeat);} array_pop($this->_tag_stack);?>

    <tr class="<?php echo smarty_function_cycle(array('name' => 'events','values' => 'TblHigher,TblLower'), $this);?>
">
      <td  colspan='2' class="title" align='right'>
        <?php echo @con('total_price'); ?>

      </td>
      <td class="title" align='right'>
        <?php ob_start(); ?>
          <?php echo $this->_reg_objects['cart'][0]->total_price(array(), $this);?>

        <?php $this->_smarty_vars['capture']['total_price'] = ob_get_contents(); ob_end_clean(); ?>
        <?php echo $this->_plugins['function']['valuta'][0][0]->valuta(array('value' => ((is_array($_tmp=$this->_smarty_vars['capture']['total_price'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f"))), $this);?>

      </td>
      <td>&nbsp;</td>
    </tr>
  </table>
<?php endif; ?>
