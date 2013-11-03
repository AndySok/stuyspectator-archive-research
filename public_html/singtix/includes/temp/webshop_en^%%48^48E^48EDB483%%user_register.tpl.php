<?php /* Smarty version 2.6.19, created on 2010-01-23 23:54:09
         compiled from user_register.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'ShowFormToken', 'user_register.tpl', 46, false),array('function', 'eval', 'user_register.tpl', 108, false),)), $this); ?>
 
<?php if ($this->_tpl_vars['ManualRegister']): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array('name' => @con('becomemember'),'header' => @con('memberinfo'))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <form action='index.php' method='post'  id="user-register">
<?php else: ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array('name' => @con('pers_info'),'header' => @con('user_notice'))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <form action='checkout.php' method='post' >
<?php endif; ?>
  <?php if ($this->_tpl_vars['user_errors']): ?>
     <br/>
     <div class='error'><?php echo $this->_tpl_vars['user_errors']['_error']; ?>
</div><br>

  <?php endif; ?>
    <?php echo $this->_plugins['function']['ShowFormToken'][0][0]->showFormToken(array('name' => 'UserRegister'), $this);?>

    <input type='hidden' name='action' value='register' />
    <input type='hidden' name='register_user' value='on' />

    <table cellpadding="2" bgcolor='white' width='100%' id='guest'>
      <?php if (! $this->_tpl_vars['ManualRegister']): ?>
        <tr>
          <td colspan='2' class='TblHeader'>
            <?php if ($this->_tpl_vars['user']->mode() <= '1'): ?>
              <?php echo @con('becomemember'); ?>

            <?php elseif ($this->_tpl_vars['user']->mode() == '2'): ?>
              <?php echo @con('becomememberorguest'); ?>

            <?php else: ?>
              <?php echo @con('becomeguest'); ?>

            <?php endif; ?>
          </td>
        </tr>
        <tr>
          <td colspan="2" class='TblHigher'><?php echo @con('guest_info'); ?>
</td>
        </tr>
      <?php endif; ?>
      <?php if ($this->_tpl_vars['user']->mode() <= '1' || $this->_tpl_vars['ManualRegister']): ?>
        <input type='hidden' name='ismember' id='type' value='true'/>
      <?php elseif ($this->_tpl_vars['user']->mode() == '2'): ?>
        <tr>
          <td colspan='2' class='TblLower'>
            <input type='checkbox' name='ismember' id='type' onclick='ShowPasswords(this.checked);' value='true' <?php if ($_POST['ismember']): ?> checked <?php endif; ?> /> <?php echo @con('becomemember'); ?>

          </td>
        </tr>
      <?php endif; ?>
      <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "user_form.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
      <tr id='passwords_tr1' >
        <td class='TblLower'><?php echo @con('password1'); ?>
 *</td>
        <td class='TblHigher'>
           <input autocomplete='off' type='password' name='password1' size='10' maxlength='10' id="password" />&nbsp;
           <?php echo @con('pwd_min'); ?>

           <div class='error'><?php echo $this->_tpl_vars['user_errors']['password']; ?>
</div>
        </td>
      </tr>
      <tr id='passwords_tr2'>
        <td class='TblLower'> <?php echo @con('confirmpassword'); ?>
 *</td>
        <td class='TblHigher'><input autocomplete='off' type='password' name='password2' size='10'  maxlength='10' /></td>
      </tr>
      <tr>
        <td class='TblLower' width='30%'><?php echo @con('user_nospam'); ?>
&nbsp;*</td>
        <td class='TblHigher' valign='top'>
          <table cellpadding="0" cellspacing="0" width='400'>
            <tr>
              <td >
                <input type='text' name='user_nospam' size='10' maxlength="10" value='' >
				<sup> &nbsp;<?php echo @con('nospam_info'); ?>
 </sup><span class='error'><?php echo $this->_tpl_vars['user_errors']['user_nospam']; ?>
</span>
              </td>
              <td align='center'>
                <img src="nospam.php?name=user_nospam" alt='' border=1>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan='2' class='TblHigher'>
          <input type='checkbox' class='checkbox' name='check_condition' value='check'> *
          <a  href='agb.php' target='cond'><?php echo smarty_function_eval(array('var' => @con('agrement')), $this);?>
</a>
          <div class='error'><?php echo $this->_tpl_vars['user_errors']['check_condition']; ?>
</div>
        </td>
      </tr>

      <tr>
        <td colspan='2' align='right'><input type='submit' name='submit_info' value='<?php echo @con('continue'); ?>
'></td>
      </tr>
    </table>

  </form>
<br> <br><br>
<?php echo '
<script  type="text/javascript">
  function getElement(id){
       if(document.all) {return document.all(id);}
       if(document.getElementById) {return document.getElementById(id);}
			}
  function ShowPasswords(a){

       if(tr1=getElement(\'passwords_tr1\')){
         if (a) {
           tr1.style.display=\'\';
         } else {
           tr1.style.display=\'none\';
         }
       }
       if(tr2=getElement(\'passwords_tr2\')){
         if (a) {
           tr2.style.display=\'\';
         } else {
           tr2.style.display=\'none\';
         }
       }
  }
  '; ?>


  <?php if ($this->_tpl_vars['user']->mode() <= '1' || $this->_tpl_vars['ManualRegister']): ?>
       ShowPasswords(true);
  <?php elseif ($this->_tpl_vars['user']->mode() == '2'): ?>
    ShowPasswords(getElement('type').checked);
  <?php else: ?>
    ShowPasswords(false);
  <?php endif; ?>

</script>

<?php if (! $this->_tpl_vars['ManualRegister']): ?>
  <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>