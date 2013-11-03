<?php /* Smarty version 2.6.19, created on 2010-01-23 23:56:52
         compiled from user_activate.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'ShowFormToken', 'user_activate.tpl', 43, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array('name' => @con('act_name'))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if (! $this->_tpl_vars['user']->activate()): ?>
   <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "user_registred.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
   <br>
   <table border="0" cellpadding="5" cellspacing="5" width="600" class="login_table"  >
      <tr>
        <td colspan=2  class="TblLower">
           <h2><?php echo @con('act_enter_title'); ?>
</h2>
        </td>
      </tr>
      <form action='<?php echo @con('PHP_SELF'); ?>
' method='post'>
        <?php echo $this->_plugins['function']['ShowFormToken'][0][0]->showFormToken(array('name' => 'TryActivateUser'), $this);?>

        <input type='hidden' name='action' value='activate'>
        <tr><td  colspan='2'><?php echo @con('act_enter_code'); ?>
<br><br></td></tr>
        <?php if ($this->_tpl_vars['errors']): ?>
          <tr><td colspan='2' class='error'><?php echo $this->_tpl_vars['errors']; ?>
<br><br></td></tr>
        <?php endif; ?>
        <tr>
          <td><?php echo @con('act_code'); ?>
</td>
          <td><input type='text' name='uar' value='<?php echo $_REQUEST['uar']; ?>
' size='40'> &nbsp; <input type='submit' name='submit' value="<?php echo @con('act_send'); ?>
"></td>
        </tr>
        <tr><td colspan='2'><a href='index.php?action=resend_activation'><?php echo @con('act_notarr'); ?>
</a></td></tr>
      </table>
   </form>
<?php else: ?>
    <?php echo @con('success_activate'); ?>

<?php endif; ?>