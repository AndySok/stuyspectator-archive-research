<?php /* Smarty version 2.6.19, created on 2010-01-23 23:56:06
         compiled from personal_page.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'clean', 'personal_page.tpl', 50, false),)), $this); ?>

<table width="100%" cellpadding="3" class="main">
	<tr>
	  <td class="title">
      <h3><?php echo @con('personal'); ?>
</h3>      </td>
      <td class="title">
      <h3><?php echo @con('pers_orders'); ?>
</h3>      </td>
    </tr>
    <tr>
    	<td valign="top">
          <table class="table_dark">
            <tr>
              <td colspan="2"><p><?php echo @con('pers_mess'); ?>

              </p><br />
			  </td>
            </tr>
            <tr>
              <td><?php echo @con('user_firstname'); ?>
</td>
              <td><?php echo ((is_array($_tmp=$this->_reg_objects['user'][0]->user_firstname)) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp));?>
</td>
            </tr>
            <tr>
              <td><?php echo @con('user_lastname'); ?>
</td>
              <td><?php echo ((is_array($_tmp=$this->_reg_objects['user'][0]->user_lastname)) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp));?>
</td>
            </tr>
            <tr>
              <td><?php echo @con('user_address1'); ?>
</td>
              <td><?php echo ((is_array($_tmp=$this->_reg_objects['user'][0]->user_address)) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp));?>
</td>
            </tr>
            <tr>
              <td><?php echo @con('user_address2'); ?>
</td>
              <td><?php echo ((is_array($_tmp=$this->_reg_objects['user'][0]->user_address2)) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp));?>
</td>
            </tr>
            <tr>
              <td><?php echo @con('user_zip'); ?>
</td>
			        <td><?php echo ((is_array($_tmp=$this->_reg_objects['user'][0]->user_zip)) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp));?>
</td>
            </tr>
            <tr>
              <td><?php echo @con('user_city'); ?>
</td>
              <td><?php echo ((is_array($_tmp=$this->_reg_objects['user'][0]->user_city)) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp));?>
</td>
            </tr>
            <tr>
              <td><?php echo @con('user_state'); ?>
</td>
              <td><?php echo ((is_array($_tmp=$this->_reg_objects['user'][0]->user_state)) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp));?>
</td>
            </tr>
            <?php echo $this->_reg_objects['gui'][0]->viewcountry(array('name' => 'user_country','value' => $this->_tpl_vars['user']->user_country), $this);?>

            <tr>
              <td><?php echo @con('user_phone'); ?>
</td>
              <td><?php echo ((is_array($_tmp=$this->_reg_objects['user'][0]->user_phone)) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp));?>
</td>
            </tr>
            <tr>
              <td><?php echo @con('user_fax'); ?>
</td>
              <td><?php echo ((is_array($_tmp=$this->_reg_objects['user'][0]->user_fax)) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp));?>
</td>
            </tr>
            <tr>
              <td><?php echo @con('user_email'); ?>
</td>
              <td><?php echo ((is_array($_tmp=$this->_reg_objects['user'][0]->user_email)) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp));?>
</td>
            </tr>
        </table>
	  </td>
      <td valign="top">
		<table class="table_dark">
		  <tr>
		  	<td colspan="5"><p><?php echo @con('pers_mess2'); ?>
  <br></p>
			</td>
		  </tr>
          <tr>
            <td><p><strong><?php echo @con('order_id'); ?>
</strong></p></td>
            <td><p><strong><?php echo @con('order_date'); ?>
</strong></p></td>
            <td><p><strong><?php echo @con('tickets'); ?>
</strong></p></td>
            <td><p><strong><?php echo @con('total_price'); ?>
</strong></p></td>
            <td><p><b><?php echo @con('status'); ?>
</b></p></td>
          </tr>
   <?php $this->_tag_stack[] = array('order_list', array('user_id' => $this->_tpl_vars['user']->user_id,'order_by_date' => 'DESC','length' => 6), $this); $_block_repeat=true; $this->_reg_objects['order'][0]->order_list($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat); while ($_block_repeat) { ob_start();?>
		    <?php if ($this->_tpl_vars['shop_order']['order_status'] == 'cancel'): ?>
				<tr class='user_order_<?php echo $this->_tpl_vars['shop_order']['order_status']; ?>
'>
			<?php elseif ($this->_tpl_vars['shop_order']['order_status'] == 'reemit'): ?>
				<tr class='user_order_<?php echo $this->_tpl_vars['shop_order']['order_status']; ?>
'>
			<?php elseif ($this->_tpl_vars['shop_order']['order_status'] == 'res'): ?>
				<tr class='user_order_<?php echo $this->_tpl_vars['shop_order']['order_status']; ?>
'>
			<?php elseif ($this->_tpl_vars['shop_order']['order_shipment_status'] == 'send'): ?>
				<tr class='user_order_<?php echo $this->_tpl_vars['shop_order']['order_shipment_status']; ?>
'>
			<?php elseif ($this->_tpl_vars['shop_order']['order_payment_status'] == 'payed'): ?>
				<tr class='user_order_<?php echo $this->_tpl_vars['shop_order']['order_payment_status']; ?>
'>
			<?php elseif ($this->_tpl_vars['shop_order']['order_status'] == 'ord'): ?>
				<tr class='user_order_<?php echo $this->_tpl_vars['shop_order']['order_status']; ?>
'>
			<?php else: ?>
				<tr class='user_order_cancel'>
			<?php endif; ?>
		    <td class='admin_info'><?php echo $this->_tpl_vars['shop_order']['order_id']; ?>
</td>
			<td class='admin_info'><?php echo $this->_tpl_vars['shop_order']['order_date']; ?>
</td>
			<td class='admin_info'><?php echo $this->_tpl_vars['shop_order']['order_tickets_nr']; ?>
</td>
			<td class='admin_info'><?php echo $this->_tpl_vars['shop_order']['order_total_price']; ?>
</td>
			<td class='admin_info'>
			<?php if ($this->_tpl_vars['shop_order']['order_status'] == 'cancel'): ?><?php echo @con('pers_cancel'); ?>

			<?php elseif ($this->_tpl_vars['shop_order']['order_status'] == 'reemit'): ?><?php echo @con('pers_reeemit'); ?>

			<?php elseif ($this->_tpl_vars['shop_order']['order_status'] == 'res'): ?><?php echo @con('pers_res'); ?>

			<?php elseif ($this->_tpl_vars['shop_order']['order_shipment_status'] == 'send'): ?><?php echo @con('pers_send'); ?>

			<?php elseif ($this->_tpl_vars['shop_order']['order_payment_status'] == 'payed'): ?><?php echo @con('pers_payed'); ?>

			<?php elseif ($this->_tpl_vars['shop_order']['order_status'] == 'ord'): ?><?php echo @con('pers_ord'); ?>

			<?php else: ?><?php echo @con('pers_unknown'); ?>

			<?php endif; ?></td>
	  	  </tr>
 	  <?php $_obj_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo $this->_reg_objects['order'][0]->order_list($this->_tag_stack[count($this->_tag_stack)-1][1], $_obj_block_content, $this, $_block_repeat);} array_pop($this->_tag_stack);?>

        </table></td>
    </tr>
</table>