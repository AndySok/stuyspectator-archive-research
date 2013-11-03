<?php /* Smarty version 2.6.19, created on 2010-01-23 23:46:31
         compiled from /home/stuyspec/public_html/singtix/includes/template/theme/default//footer.tpl */ ?>
 </td>
    <td width='210px' align='right' valign="top"><br>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "user_login_block.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> <br>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "cart_resume.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><br>
	</td>
  </tr>
</table>
</div>
	<div class="footer">
		<hr width="100%" />
<?php 

GLOBAL $_SHOP;
$link = $_SHOP->link;
printf("System status: %s \n", mysqli_stat($link));

mysqli_close($link);
if (function_exists('sys_getloadavg')) {
    	$loadArray = sys_getloadavg();
    	$load= "Load: ".$loadArray[0]." / ".$loadArray[1]." / ".$loadArray[2];
    } else {
    	$load=@file_get_contents('/proc/loadavg');
    }
    if($load) {
      echo "Date: ".date('d.m.Y H:i:s')." ".$load;
    }
$start=$_SESSION["ustart"];
$end = utime(); $run = $end - $start;
echo " Page expelled in " . substr($run, 0, 5) . " secs.";
echo "<hr>";
 ?>

		<table width="100%">
		<tr>
		<!-- To comply with our GPL please keep the following link in the footer of your site -->
  		<td width='27'>
	  		<img src="images/atom.png" height='20' width='23' />
		  </td>
		  <td  class="copy" valign="top">
        Copyright 2009<br />
		    Powered By <a href="http://www.fusionticket.org"> Fusion Ticket</a> - Free Open Source Online Box Office
		  </td>
		</tr>
		</table>
	</div>
</div>
</body>
</html>