<?php /* Smarty version 2.6.19, created on 2010-01-23 23:46:31
         compiled from cart_resume.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'cart_resume.tpl', 62, false),array('modifier', 'string_format', 'cart_resume.tpl', 81, false),array('function', 'ShowFormToken', 'cart_resume.tpl', 100, false),)), $this); ?>
<!--CART_RESUME.tpl-->

<table width="195px" border="0" cellspacing="0" cellpadding="0" class="cart_table">
  <tr>
  	<td class="cart_title">
  	  <?php echo @con('shopcart'); ?>
&nbsp;
  	  <?php if ($this->_tpl_vars['cart']->is_empty_f()): ?>
  	  	<img src="images/caddie.gif">
  	  <?php else: ?>
    		<img src="images/caddie_full.png" border='0'>
  	  <?php endif; ?>
  	</td>
  </tr>
  <tr>
  	<?php if ($this->_tpl_vars['cart']->is_empty_f()): ?>
	    <td valign="top" class='cart_content' align="center"><?php echo @con('no_tick_res'); ?>
</td>
	  <?php else: ?>
    	<?php $this->assign('cart_overview', $this->_tpl_vars['cart']->overview_f()); ?>
    	<td valign="top" class='cart_content' align='left' >
    	  <table>
      		<tr>
      		  <td class="cart_content">
        		  <?php if ($this->_tpl_vars['cart_overview']['valid']): ?>
        		  	<img src='images/ticket-valid.png'> <?php echo @con('valid_tickets'); ?>
 <?php echo $this->_tpl_vars['cart_overview']['valid']; ?>
<br><br>
        		  <?php endif; ?>
        		  <?php if ($this->_tpl_vars['cart_overview']['expired']): ?>
        		  	<img src='images/ticket-expired.png'> <?php echo @con('expired_tickets'); ?>
 <?php echo $this->_tpl_vars['cart_overview']['expired']; ?>
<br><br>
        		  <?php endif; ?>
        		  <?php if ($this->_tpl_vars['cart_overview']['valid']): ?>
                <?php $this->assign('timetl', time()+$this->_tpl_vars['cart_overview']['secttl']); ?>
          			<img src='images/clock.gif'> <?php echo @con('tick_exp_in'); ?>
 <span id="countdown1"><?php echo ((is_array($_tmp=$this->_tpl_vars['timetl'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M:%S') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M:%S')); ?>
 GMT+00:00</span>
        		  <?php endif; ?>
      		  </td>
      		</tr>
    	  </table>
  	  </td>
    </tr>
    <tr>
    	<td class='cart_content'>
    	  <table>
        	<?php $this->_tag_stack[] = array('items', array(), $this); $_block_repeat=true; $this->_reg_objects['cart'][0]->items($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat); while ($_block_repeat) { ob_start();?>
        	  <?php if (! $this->_tpl_vars['seat_item']->is_expired()): ?>
          		<tr>
          		  <td class='cart_content' style='border-bottom:#cccccc 1px solid;padding-bottom:4px;padding-top:4px; font-size:10px;'>
            		  <?php echo $this->_tpl_vars['event_item']->event_name; ?>
<br>
            		  <?php echo $this->_tpl_vars['category_item']->cat_name; ?>
<br>
            		  <?php echo $this->_tpl_vars['seat_item']->count(); ?>
 <?php echo @con('x_tick'); ?>
          		  </td>
          		  <td  width="45%" valign='top' class='cart_content' style='border-bottom:#cccccc 1px solid;padding-bottom:4px;padding-top:4 font-size:10px;'>
            			<b><?php echo ((is_array($_tmp=$this->_tpl_vars['seat_item']->total_price($this->_tpl_vars['category_item']->cat_price))) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
</b> <?php echo $this->_tpl_vars['organizer_currency']; ?>

            			<br>
            			<img src='images/clock.gif' valign='middle' align='middle'> <?php echo $this->_tpl_vars['seat_item']->ttl(); ?>
 min.
          		  </td>
          		</tr>
            <?php endif; ?>
       		<?php $_obj_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_reg_objects['cart'][0]->items($this->_tag_stack[count($this->_tag_stack)-1][1], $_obj_block_content, $this, $_block_repeat);} array_pop($this->_tag_stack);?>

      		<?php if ($this->_tpl_vars['cart_overview']['valid']): ?>
        		<tr>
        		  <td align='center' class='cart_content' colspan='2'>
          			<br>
          			<a href='index.php?action=view_cart'><?php echo @con('view_order'); ?>
</a>
          			<br>
          			<br><?php echo @con('tot_tick_price'); ?>
 <?php echo ((is_array($_tmp=$this->_reg_objects['cart'][0]->total_price(array(), $this))) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f"));?>
 <?php echo $this->_tpl_vars['organizer_currency']; ?>

        		  </td>
        		</tr>
        		<tr>
        		  <td align='center' class='cart_content' colspan='2'>
          			<form action="checkout.php" method='post'>
          			   <?php echo $this->_plugins['function']['ShowFormToken'][0][0]->showFormToken(array('name' => 'ReservHandling'), $this);?>

            			<input type="submit" name="go_pay" value="<?php echo @con('checkout'); ?>
">
          			</form>
        	    </td>
        		</tr>
      		<?php endif; ?>
    	  </table>
  	  <?php endif; ?>
  	</td>
  </tr>
</table>
<?php echo $this->_tpl_vars['login_msg']; ?>