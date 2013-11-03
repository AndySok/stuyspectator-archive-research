<?php /* Smarty version 2.6.19, created on 2010-01-23 23:46:31
         compiled from /home/stuyspec/public_html/singtix/includes/template/theme/default//header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', '/home/stuyspec/public_html/singtix/includes/template/theme/default//header.tpl', 78, false),)), $this); ?>
<?php 
  function utime (){
    $time = explode( " ", microtime());
    $usec = (double)$time[0];
    $sec = (double)$time[1];
    return $sec + $usec;
  }
  $ustart = utime();

  global $smarty;
  $_SESSION["ustart"] = $ustart;
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<title>FusionTicket</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel='stylesheet' href='style.php' type='text/css' />
		
		<!-- Must be included in all templates -->
		
		<link rel="icon" href="favicon.ico" type="image/x-icon" />
		
		<script type="text/javascript" src="scripts/jquery/jquery-1.3.2.min.js"></script>
		<script type="text/javascript" src="scripts/jquery/jquery-ui-1.7.2.custom.min.js"></script>
		<script type="text/javascript" src="scripts/jquery/jquery.form.js"></script>
		<script type="text/javascript" src="scripts/jquery/jquery.validate.min.js"></script>
		<script type="text/javascript" src="scripts/jquery/jquery.maskedinput-1.2.2.js"></script>
		
		<script type="text/javascript">
			var lang = new Object();
			lang.required = '<?php echo @con('mandatory'); ?>
';        lang.phone_long = '<?php echo @con('phone_long'); ?>
'; lang.phone_short = '<?php echo @con('phone_short'); ?>
';
			lang.fax_long = '<?php echo @con('fax_long'); ?>
';         lang.fax_short = '<?php echo @con('fax_short'); ?>
';
			lang.email_valid = '<?php echo @con('email_valid'); ?>
';   lang.email_match = '<?php echo @con('email_match'); ?>
';
			lang.pass_short = '<?php echo @con('pass_too_short'); ?>
'; lang.pass_match = '<?php echo @con('pass_match'); ?>
';
			lang.not_number = '<?php echo @con('not_number'); ?>
';     lang.condition ='<?php echo @con('check_condition'); ?>
';
		</script>
		<script type="text/javascript" src="scripts/shop.jquery.forms.js"></script>
		
		<script type="text/javascript" src="scripts/countdownpro.js" defer="defer"></script>
		
		<meta scheme="countdown1" name="d_hidezero" content="1" />
		<meta scheme="countdown1" name="h_hidezero" content="1" />
		<meta scheme="countdown1" name="m_hidezero" content="1" />
		<meta scheme="countdown1" name="s_hidezero" content="1" />
		<meta scheme="countdown1" name="event_msg" content="0! " />
		<meta scheme="countdown1" name="servertime" content="<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d %H:%M:%S') : smarty_modifier_date_format($_tmp, '%Y-%m-%d %H:%M:%S')); ?>
 GMT+00:00" />
		
		<!-- End Required Headers -->
	</head>

	<body class='main_side'>   <center>
		<div class="mainbody" align='left'>
			<img class="spacer" src='images/dot.gif' height="1px" />
			<br />
			<img src="images/fusion.png" align="bottom" />
			<br />

		<div id="navbar">
    		<ul>
     			<li>
 					<a href='index.php'><?php echo @con('home'); ?>
</a>
				</li>
				<li>
					<a href='calendar.php'><?php echo @con('calendar'); ?>
</a>
				</li>
				<li>
					<a href='programm.php'><?php echo @con('program'); ?>
</a>
				</li>
			</ul>     <br>
  		<div align="right" style="vertical-align: top; width:100%; " >
  			<a href="?setlang=en">[en]</a>
  		</div>
		</div>
		
		<div class="maincontent">
			<table width='100%' border='0' cellpadding='0' cellspacing='0'>
  				<tr>
					<td valign='top' align='left'>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "Progressbar.tpl", 'smarty_include_vars' => array('name' => $this->_tpl_vars['name'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
						<br />
  						<?php if ($this->_tpl_vars['name']): ?>
    						<h1><?php echo $this->_tpl_vars['name']; ?>
</h1>
  						<?php endif; ?>
  						<?php if ($this->_tpl_vars['header']): ?>
    						<div><?php echo $this->_tpl_vars['header']; ?>
</div>
  						<?php endif; ?>