<?php /* Smarty version 2.6.19, created on 2010-01-23 23:55:28
         compiled from user_address.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'clean', 'user_address.tpl', 52, false),)), $this); ?>
 <?php echo '
<script  type="text/javascript">
function UserPopup(a)
{
	var url = a.href;
	if (window.open(url, a.target || "_blank", \'toolbar=0,location=0,directories=0,status=0,menubar=0\'.concat(
  	\',width=\', "640",	\',height=\',  "400",	\',scrollbars=\',  "1", \',resizable=\', "1")))
		{ return false; }
}
</script>
'; ?>


<table border=0 cellpadding="3" bgcolor='white' width='90%'>
  <tr>
    <?php if ($this->_tpl_vars['title'] == 'on'): ?>
      <td class='TblHeader'>
        <?php echo @con('your_addr'); ?>
</td>
    <?php endif; ?>
  </tr>
  <tr><td class='TblHigher' nowrap>
     <?php echo ((is_array($_tmp=$this->_reg_objects['user'][0]->user_firstname)) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp));?>
 <?php echo ((is_array($_tmp=$this->_reg_objects['user'][0]->user_lastname)) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp));?>

  </tr>
  <tr><td class='TblHigher' nowrap>
     <?php echo ((is_array($_tmp=$this->_reg_objects['user'][0]->user_address)) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp));?>

  </tr>
  <?php if (((is_array($_tmp=$this->_tpl_vars['user']->user_address1)) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp))): ?>
    <tr><td class='TblHigher' nowrap>
       <?php echo ((is_array($_tmp=$this->_reg_objects['user'][0]->user_address1)) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp));?>

    </tr>
  <?php endif; ?>
  <tr><td class='TblHigher' nowrap>
     <?php echo ((is_array($_tmp=$this->_reg_objects['user'][0]->user_zip)) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp));?>
 <?php echo ((is_array($_tmp=$this->_reg_objects['user'][0]->user_city)) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp));?>

  </tr>
  <tr><td class='TblHigher' nowrap>
    <?php echo $this->_reg_objects['gui'][0]->viewcountry(array('value' => ((is_array($_tmp=$this->_tpl_vars['user']->user_country)) ? $this->_run_mod_handler('clean', true, $_tmp) : smarty_modifier_clean($_tmp)),'nolabel' => true), $this);?>

  </tr>
  <tr><td class='TblHigher' nowrap>
     <?php echo $this->_reg_objects['user'][0]->user_email;?>
</td></tr>
  <tr><td class='TblHigher' nowrap>
     <div align='right'><a target='editaddress' href='?action=useredit' onclick="UserPopup(this);" ><?php echo @con('edit'); ?>
</a></div>

  </td></tr>

</table>
