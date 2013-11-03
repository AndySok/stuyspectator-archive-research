<?php /* Smarty version 2.6.19, created on 2010-01-23 23:46:31
         compiled from user_login_block.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'ShowFormToken', 'user_login_block.tpl', 66, false),)), $this); ?>
<?php if ($_POST['action'] == 'login'): ?>
	<?php echo $this->_reg_objects['user'][0]->login(array('username' => $_POST['username'],'password' => $_POST['password'],'uri' => $_POST['uri']), $this);?>

<?php elseif ($_GET['action'] == 'logout'): ?>
	<?php echo $this->_reg_objects['user'][0]->logout(array(), $this);?>

<?php endif; ?>

<?php if ($this->_tpl_vars['user']->logged): ?>
<table  width="195px" border="0" cellpadding="0" cellspacing="0" class="cart_table">
	<tr>
		<td class="login_title" ><?php echo @con('member'); ?>
</td>
	</tr>
  	<tr>
		<td class="login_content"><?php echo @con('welcome'); ?>
 <b><?php echo $this->_reg_objects['user'][0]->user_firstname;?>
 <?php echo $this->_reg_objects['user'][0]->user_lastname;?>
</b>!
			<br>
			<li><a  href='index.php?personal_page=on'><?php echo @con('pers_page'); ?>
</a></li>
			<li><a  href='index.php?action=logout'><?php echo @con('logout'); ?>
</a></li>
		</td>
	</tr>
</table>
<?php else: ?>
  <table width="195px"  border="0" cellspacing="0" cellpadding="0"  class="cart_table">
  	<tr>
  		<td class="login_title"><?php echo @con('member'); ?>
</td>
  	</tr>
  <?php if ($this->_tpl_vars['login_error']): ?>
	<tr>
    	<td class='TblHigher'>
        	<div class='error'> <?php echo $this->_tpl_vars['login_error']['msg']; ?>
</div>
    	</td>
	</tr>
  <?php endif; ?>
    <form method='post' action='index.php' style='margin-top:0px;' id="user-login">
    <input type="hidden" name="action" value="login">
    <input type="hidden" name="type" value="block">
    <?php echo $this->_plugins['function']['ShowFormToken'][0][0]->showFormToken(array('name' => 'login'), $this);?>


    <?php if ($_GET['action'] != 'logout' && $_GET['action'] != 'login'): ?>
      <input type="hidden" name="uri" value="<?php echo $_SERVER['REQUEST_URI']; ?>
">
    <?php endif; ?>
  	<tr>
  		<td class="login_content"><?php echo @con('email'); ?>
</td>
  	</tr>
  	<tr>
  		<td class="login_content" style='padding-left:25px;'>
        	<input type='input' name='username' size='20' style='font-size:10px;' >
      	</td>
  	</tr>
  	<tr>
  		<td  class="login_content"><?php echo @con('password'); ?>
</td>
  	</tr>
  	<tr>
		<td class="login_content" style='padding-left:25px;'>
        	<input type='password' name='password' size='20' style='font-size:10px;' /><br />
			<input type='submit' value='<?php echo @con('login_button'); ?>
' style='font-size:10px;'/>
      	</td>
  	</tr>
  	<tr>
  		<td class="login_content">
  			<li><a  href='index.php?action=register'><?php echo @con('register'); ?>
</a></li>
  		</td>
  	</tr>
  	<tr>
  		<td class="login_content">
  			<li><a target='forgotpass' onclick='BasicPopup(this);' href='forgot_password.php'><?php echo @con('forgot_pwd'); ?>
</a></li>
  		</td>
  	</tr>
  </form>
  </table>
<?php endif; ?>