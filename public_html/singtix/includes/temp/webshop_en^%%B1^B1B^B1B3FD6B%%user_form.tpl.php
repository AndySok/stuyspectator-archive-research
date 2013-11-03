<?php /* Smarty version 2.6.19, created on 2010-01-23 23:54:09
         compiled from user_form.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'clean', 'user_form.tpl', 35, false),)), $this); ?>
 <?php echo $this->_reg_objects['gui'][0]->setdata(array('errors' => $this->_tpl_vars['user_errors']), $this);?>

<tr>
  <td class='TblLower' width="120px"> <?php echo @con('user_firstname'); ?>
&nbsp;* </td>
  <td class='TblHigher'><input type='text' name='user_firstname' size='30' maxlength='50' value='<?php echo ((is_array($_tmp=$this->_tpl_vars['user_data']['user_firstname'])) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp)); ?>
'><span class='error'><?php echo $this->_tpl_vars['user_errors']['user_firstname']; ?>
</span></td>
</tr>
<tr>
  <td class='TblLower'> <?php echo @con('user_lastname'); ?>
&nbsp;* </td>
  <td class='TblHigher'><input type='text' name='user_lastname' size='30'  maxlength='50' value='<?php echo ((is_array($_tmp=$this->_tpl_vars['user_data']['user_lastname'])) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp)); ?>
'><span class='error'><?php echo $this->_tpl_vars['user_errors']['user_lastname']; ?>
</span></td>
</tr>
<tr>
  <td class='TblLower'> <?php echo @con('user_address'); ?>
&nbsp;* </td>
  <td class='TblHigher'><input type='text' name='user_address' size='30'  maxlength='75' value='<?php echo ((is_array($_tmp=$this->_tpl_vars['user_data']['user_address'])) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp)); ?>
'><span class='error'><?php echo $this->_tpl_vars['user_errors']['user_address']; ?>
</span></td>
</tr>
<tr>
  <td class='TblLower'> <?php echo @con('user_address2'); ?>
  </td>
  <td class='TblHigher'><input type='text' name='user_address1' size='30'  maxlength='75' value='<?php echo ((is_array($_tmp=$this->_tpl_vars['user_data']['user_address1'])) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp)); ?>
'><span class='error'><?php echo $this->_tpl_vars['user_errors']['user_address1']; ?>
</span></td>
</tr>
<tr>
  <td class='TblLower'> <?php echo @con('user_zip'); ?>
&nbsp;* </td>
  <td class='TblHigher'><input type='text' name='user_zip' size='8'  maxlength='20' value='<?php echo ((is_array($_tmp=$this->_tpl_vars['user_data']['user_zip'])) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp)); ?>
'><span class='error'><?php echo $this->_tpl_vars['user_errors']['user_zip']; ?>
</span></td>
</tr>
<tr>
  <td class='TblLower'> <?php echo @con('user_city'); ?>
&nbsp;* </td>
  <td class='TblHigher'><input type='text' name='user_city' size='30'  maxlength='50' value='<?php echo ((is_array($_tmp=$this->_tpl_vars['user_data']['user_city'])) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp)); ?>
'><span class='error'><?php echo $this->_tpl_vars['user_errors']['user_city']; ?>
</span></td>
</tr>
<tr>
  <td class='TblLower'> <?php echo @con('user_state'); ?>
&nbsp;</td>
  <td class='TblHigher'><input type='text' name='user_state' size='30' maxlength="50" value='<?php echo ((is_array($_tmp=$this->_tpl_vars['user_data']['user_state'])) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp)); ?>
'><span class='error'><?php echo $this->_tpl_vars['user_errors']['user_state']; ?>
</span></td>
</tr>
<?php echo $this->_reg_objects['gui'][0]->selectcountry(array('name' => 'user_country','value' => $this->_tpl_vars['user_data']['user_country']), $this);?>

<tr>
  <td class='TblLower'  > <?php echo @con('user_phone'); ?>
 </td>
  <td class='TblHigher'><input type='text' name='user_phone' size='30'  maxlength='50' value='<?php echo ((is_array($_tmp=$this->_tpl_vars['user_data']['user_phone'])) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp)); ?>
'><span class='error'><?php echo $this->_tpl_vars['user_errors']['user_phone']; ?>
</span></td>
</tr>
<tr>
  <td class='TblLower'  > <?php echo @con('user_fax'); ?>
 </td>
  <td class='TblHigher'><input type='text' name='user_fax' size='30'  maxlength='50' value='<?php echo ((is_array($_tmp=$this->_tpl_vars['user_data']['user_fax'])) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp)); ?>
'><span class='error'><?php echo $this->_tpl_vars['user_errors']['user_fax']; ?>
</span></td>
</tr>
<tr>
	<td class='TblLower' > <?php echo @con('user_email'); ?>
&nbsp;* </td>
  	<td class='TblHigher'>
	  	<input <?php if ($this->_tpl_vars['user_data']['user_id']): ?>readonly="readonly"<?php endif; ?> type='text' name='user_email' size='30'  maxlength='50' value='<?php echo ((is_array($_tmp=$this->_tpl_vars['user_data']['user_email'])) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp)); ?>
' id="email" />
	  	<span class='error'><?php echo $this->_tpl_vars['user_errors']['user_email']; ?>
</span>
 	</td>
 	
</tr>
<?php if (! $this->_tpl_vars['user_data']['user_id']): ?>
 	<tr>
		<td class='TblLower' > <?php echo @con('confirmemail'); ?>
&nbsp;* </td>
		<td class='TblHigher'>
  		<input autocomplete='off' type='text' name='user_email2' size='30'  maxlength='50' value='<?php echo ((is_array($_tmp=$this->_tpl_vars['user_data']['user_email2'])) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp)); ?>
'/>
  	</td>
	</tr>
<?php endif; ?>