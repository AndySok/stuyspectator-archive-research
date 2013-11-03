<?php /* Smarty version 2.6.19, created on 2010-01-23 23:55:28
         compiled from checkout_preview.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'ShowFormToken', 'checkout_preview.tpl', 62, false),array('function', 'cycle', 'checkout_preview.tpl', 72, false),array('function', 'eval', 'checkout_preview.tpl', 78, false),array('block', 'handling', 'checkout_preview.tpl', 70, false),array('modifier', 'string_format', 'checkout_preview.tpl', 85, false),)), $this); ?>
<?php if ($this->_tpl_vars['user']->mode() == 0 && ! $this->_tpl_vars['user']->active): ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "user_activate.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php else: ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array('name' => @con('shopping_cart_check_out'),'header' => @con('Handling_cont_mess'))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php if ($this->_tpl_vars['user']->mode() <= 2 && $this->_tpl_vars['user']->new_member): ?>
    	<table class='table_dark' cellpadding='5' bgcolor='white' width='100%'>
        	<tr>
				<td class='TblLower'>
          			<span class='title'><?php echo @con('act_name'); ?>
<br><br> </span>
          			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "user_registred.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        		</td>
			</tr>
		</table>
 	<?php endif; ?>

	<?php if ($this->_tpl_vars['order_error']): ?>
    	<div class='error'><?php echo $this->_tpl_vars['order_error']; ?>
</div><br />
	<?php endif; ?>

  	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "cart_content.tpl", 'smarty_include_vars' => array('check_out' => 'on')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  	<?php $this->assign('total', $this->_tpl_vars['cart']->total_price_f()); ?>
	<br />
  	<table cellpadding="0" cellspacing='0' border='0' width='100%'>
    	<tr>
    		<td width="50%" valign="top" align="left">
      			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "user_address.tpl", 'smarty_include_vars' => array('title' => 'on')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    		</td>
    		<td valign='top' align="right">
    			<?php if (! $this->_tpl_vars['update']->is_demo()): ?>
       			<form method='post' name='handling' onsubmit='this.submit.disabled=true;return true;'>
          			<?php echo $this->_plugins['function']['ShowFormToken'][0][0]->showFormToken(array('name' => 'OrderHandling'), $this);?>

          			<input type='hidden' name='action' value='confirm' />
    			<?php endif; ?>
 	  			<table border=0 width='90%' cellpadding="5" bgcolor='white'>
        			<tr>
        		  		<td colspan='3' class='TblHeader' align='left'><?php echo @con('handlings'); ?>
</td>
       				</tr>
        			<?php $this->assign('min_date', $this->_tpl_vars['cart']->min_date_f()); ?>
        			<?php $this->_tag_stack[] = array('handling', array('www' => 'on','event_date' => $this->_tpl_vars['min_date'])); $_block_repeat=true;smarty_block_handling($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
          			
				  	<tr class="<?php echo smarty_function_cycle(array('name' => 'payments','values' => 'TblHigher,TblLower'), $this);?>
">
          		  		<td class='payment_form'>
            		  		<input checked="checked" type='radio' id='<?php echo $this->_tpl_vars['shop_handling']['handling_id']; ?>
_check' class='checkbox_dark' name='handling_id' value='<?php echo $this->_tpl_vars['shop_handling']['handling_id']; ?>
'>
          		  		</td>
          		  		<td class='payment_form'>
          		  			<label for='<?php echo $this->_tpl_vars['shop_handling']['handling_id']; ?>
_check'>
            		  			<?php echo @con('payment'); ?>
: <?php echo smarty_function_eval(array('var' => $this->_tpl_vars['shop_handling']['handling_text_payment']), $this);?>
<br>
            		  			<?php echo @con('shipment'); ?>
: <?php echo smarty_function_eval(array('var' => $this->_tpl_vars['shop_handling']['handling_text_shipment']), $this);?>

          		  			</label>
          		  		</td>
          		  		<td class='payment_form' align='right'>
             				<?php $this->assign('fee', ($this->_tpl_vars['total']*$this->_tpl_vars['shop_handling']['handling_fee_percent']/100.00+$this->_tpl_vars['shop_handling']['handling_fee_fix'])); ?>
             				<?php if ($this->_tpl_vars['fee']): ?>
                   				+ <?php echo $this->_reg_objects['gui'][0]->valuta(array('value' => ((is_array($_tmp=$this->_tpl_vars['fee'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f"))), $this);?>

                  			<?php endif; ?>&nbsp;
          		  		</td>
          			</tr>
            		<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_handling($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
        			<?php if ($this->_tpl_vars['update_view']['currentres']): ?>
       				<tr class="<?php echo smarty_function_cycle(array('values' => 'TblHigher,TblLower'), $this);?>
">
          				<td colspan="3">
           			  		           			  		<?php echo @con('limit'); ?>

          				</td>
          			</tr>
        			<?php endif; ?>
      			</table>
  				<br />
    	    	<input type='submit' name='submit' value='<?php echo @con('order_it'); ?>
'/>
    			<?php if (! $this->_tpl_vars['update']->is_demo()): ?>
    			</form>
    			<?php else: ?>
       			<div class='error'><br/> For safety issues we have disabled the order button. </div>
    			<?php endif; ?>
    			    			<?php if ($this->_tpl_vars['update_view']['can_reserve']): ?>
        			<?php if (! $this->_tpl_vars['update']->is_demo()): ?>
       				<form action='' method='post' name='handling' onsubmit='this.submit.disabled=true;return true;'>
          				<input type='hidden' name='action' value='reserve'>
          			<?php echo $this->_plugins['function']['ShowFormToken'][0][0]->showFormToken(array('name' => 'ReservHandling'), $this);?>

          			<?php endif; ?>
    		  		<?php echo @con('orclick'); ?>

      					<input type='submit' name='submit_reserve' value='<?php echo @con('reserve'); ?>
'>
    				
					<?php if (! $this->_tpl_vars['update']->is_demo()): ?>
					</form>
    				<?php endif; ?>
 				<?php endif; ?>
    		</td>
    	</tr>
	</table>
<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>