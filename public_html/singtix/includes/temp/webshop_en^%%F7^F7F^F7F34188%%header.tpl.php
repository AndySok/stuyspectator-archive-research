<?php /* Smarty version 2.6.19, created on 2010-01-23 23:46:31
         compiled from header.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['_SHOP_theme'])."/header.tpl", 'smarty_include_vars' => array('name' => $this->_tpl_vars['name'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
<script>
function BasicPopup(a)
{
	var url = a.href;
  if (win = window.open(url, a.target || "_blank", \'width=640,height=200,left=300,top=300,toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=0\'))
	 { win.focus();
	   win.focus();
     return false; }
}
</script>
'; ?>