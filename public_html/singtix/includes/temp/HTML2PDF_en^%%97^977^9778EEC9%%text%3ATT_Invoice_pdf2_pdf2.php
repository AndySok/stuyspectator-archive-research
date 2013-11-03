<?php /* Smarty version 2.6.19, created on 2010-01-24 00:44:58
         compiled from text:TT_Invoice_pdf2_pdf2 */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'capitalize', 'text:TT_Invoice_pdf2_pdf2', 39, false),array('modifier', 'date_format', 'text:TT_Invoice_pdf2_pdf2', 72, false),array('modifier', 'string_format', 'text:TT_Invoice_pdf2_pdf2', 109, false),array('function', 'valuta', 'text:TT_Invoice_pdf2_pdf2', 109, false),)), $this); ?>
<?php echo '
<style type="text/css">
<!--
table	{ vertical-align: middle; }
tr	{ vertical-align: middle; }
td	{ vertical-align: middle; }
}
-->
</style>
'; ?>


<page backcolor="#FEFEFE" backtop="0" backbottom="30mm" footer="date;;heure;page" style="font-size: 8pt">
<br>
	
	<table align="center" border="0" style="border-collapse: collapse" id="table1" width="95%">
		<tr>
			<td><h1><?php echo @con('tmp_invoice'); ?>
</h1></td>
		</tr>
	</table>

<table align="center" cellspacing="0" style="border-width:0px; width: 95%; text-align: left">
		<tr>
			<td style="border-style:none; border-width:medium; width:50%; ">&nbsp;</td>
			<td style="border-style:none; border-width:medium; width:50%; text-align:center" rowspan="2">
			<?php if ($this->_tpl_vars['organizer_logo']): ?>
			<img src='<?php echo $this->_tpl_vars['_SHOP_files']; ?>
<?php echo $this->_tpl_vars['organizer_logo']; ?>
' width="75" height="75"/><br><br>
			<?php endif; ?>
			<?php echo $this->_tpl_vars['organizer_name']; ?>
<br>
			<?php echo $this->_tpl_vars['organizer_address']; ?>
<br>
			<?php echo $this->_tpl_vars['organizer_ort']; ?>
, <?php echo $this->_tpl_vars['organizer_state']; ?>
&nbsp; <?php echo $this->_tpl_vars['organizer_plz']; ?>
<br>
			<?php echo @con('user_phone'); ?>
:<?php echo $this->_tpl_vars['organizer_phone']; ?>
<br>
			<?php echo @con('user_fax'); ?>
:<?php echo $this->_tpl_vars['organizer_fax']; ?>
<br>
			<?php echo $this->_tpl_vars['organizer_email']; ?>
</td><br>
		</tr>
		<tr>
			<td style="border-style:none; border-width:medium; " width="50%">


			<h4><?php echo ((is_array($_tmp=$this->_tpl_vars['user_firstname'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['user_lastname'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
<br>
				<?php echo ((is_array($_tmp=$this->_tpl_vars['user_address'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
<br>
					<?php if (((is_array($_tmp=$this->_tpl_vars['user_address1'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true))): ?>
						<?php echo ((is_array($_tmp=$this->_tpl_vars['user_address1'])) ? $this->_run_mod_handler('capitalize', true, $_tmp, true) : smarty_modifier_capitalize($_tmp, true)); ?>
<br>
					<?php endif; ?> <?php echo ((is_array($_tmp=$this->_tpl_vars['user_city'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
, <?php echo ((is_array($_tmp=$this->_tpl_vars['user_state'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
 <?php echo $this->_tpl_vars['user_zip']; ?>
 <br>
				<?php echo $this->_tpl_vars['user_email']; ?>
<br>
				<?php echo $this->_tpl_vars['user_phone']; ?>
<br></h4></td>
		</tr>
		<tr>
			<td width="100%">&nbsp;</td>
			<td width="100%">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2" width="100%"><?php echo $this->_tpl_vars['user_firstname']; ?>
,<br><br><?php echo @con('tmp_inv_message'); ?>

			</td>
		</tr>
</table>

	<br><br><br>
	<table align="center" cellspacing="3" style="width: 95%; text-align: left; border-collapse:collapse" border="1" bordercolor="#000000">
		<tr>
			<th style="border-style:solid; border-width:1px; width: 20%; background: #E7E7E7; text-align: center" height="20">
			<?php echo @con('tmp_order_date'); ?>
</th>
			<th style="border-style:solid; border-width:1px; width: 20%; background: #E7E7E7; text-align: center">
			<?php echo @con('tmp_order_number'); ?>
</th>
			<th style="border-style:solid; border-width:1px; width: 20%; background: #E7E7E7; text-align: center">
			<?php echo @con('tmp_order_method'); ?>
</th>
			<th style="border-style:solid; border-width:1px; width: 20%; background: #E7E7E7; text-align: center">
			<?php echo @con('tmp_shipping_method'); ?>
</th>
			<th style="border-style:solid; border-width:1px; width: 20%; background: #E7E7E7; text-align: center">
			<?php echo @con('tmp_payment_method'); ?>
</th>
		</tr>
		<tr>
			<td width="20%" style="border-style:solid; border-width:1px; text-align: center"><?php echo ((is_array($_tmp=$this->_tpl_vars['order_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, " 
			%B %e, %Y") : smarty_modifier_date_format($_tmp, " 
			%B %e, %Y")); ?>
</td>
			<td width="20%" style="border-style:solid; border-width:1px; text-align: center"><?php echo $this->_tpl_vars['order_id']; ?>
</td>
			<td width="20%" style="border-style:solid; border-width:1px; text-align: center"><?php if ($this->_tpl_vars['order_place'] == 'www'): ?>On-Line<?php else: ?>Box Office<?php endif; ?></td>
			<td width="20%" style="border-style:solid; border-width:1px; text-align: center"><?php echo ((is_array($_tmp=$this->_tpl_vars['handling_shipment'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</td>
			<td width="20%" style="border-style:solid; border-width:1px; text-align: center"><?php echo ((is_array($_tmp=$this->_tpl_vars['handling_payment'])) ? $this->_run_mod_handler('capitalize', true, $_tmp) : smarty_modifier_capitalize($_tmp)); ?>
</td>
		</tr>
</table>
	<br><br><br>
<?php $_from = $this->_tpl_vars['bill']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['foo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['foo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['cid'] => $this->_tpl_vars['con']):
        $this->_foreach['foo']['iteration']++;
?>
	<?php if (($this->_foreach['foo']['iteration'] <= 1)): ?>

		<table align="center" cellspacing="0" cellpadding="0" style="width: 95%;" border="1" bordercolor="#000000" >
			<tr>
				<th style="width: 30%; background: #E7E7E7; text-align: center;" height="20">
				<?php echo @con('tmp_description'); ?>
</th>
				<th style="width: 10%; background: #E7E7E7; text-align: center;">
				<?php echo @con('temp_quantity'); ?>
</th>
				<th style="width: 17%; background: #E7E7E7; text-align: center;">
				<?php echo @con('tmp_category'); ?>
</th>
				<th style="width: 17%; background: #E7E7E7; text-align: center;">
				<?php echo @con('tmp_discounts'); ?>
</th>
				<th style="width: 13%; background: #E7E7E7; text-align: right;">
				<?php echo @con('tmp_price'); ?>
</th>
				<th style="width: 13%; background: #E7E7E7; text-align: right;">
				<?php echo @con('tmp_total'); ?>
</th>
			</tr>
		</table><br>

	<?php endif; ?>

	<table align="center" cellspacing="0"  style="width: 95%;  font-size:; border-left-width:0px; border-right-width:0; border-top-width:0px; border-bottom-width:0px" border="0" cellpadding="0">
		<tr>
			<td style="border-style:none; border-width:medium; width: 30%; background: #F7F7F7; text-align: center; "><?php echo $this->_tpl_vars['con']['event_name']; ?>
</td>
			<td style="border-style:none; border-width:medium; width: 10%; background: #F7F7F7; text-align: center"><?php echo $this->_tpl_vars['con']['qty']; ?>
</td>
			<td style="border-style:none; border-width:medium; width: 17%; background: #F7F7F7; text-align: center"><?php echo $this->_tpl_vars['con']['category_name']; ?>
</td>
			<td style="border-style:none; border-width:medium; width: 17%; background: #F7F7F7; text-align: center"><?php echo $this->_tpl_vars['con']['discount_name']; ?>
</td>
			<td style="border-style:none; border-width:medium; width: 13%; background: #F7F7F7; text-align: right"><?php echo $this->_plugins['function']['valuta'][0][0]->valuta(array('value' => ((is_array($_tmp=$this->_tpl_vars['con']['seat_price'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f"))), $this);?>
</td>
			<td style="border-style:none; border-width:medium; width: 13%; background: #F7F7F7; text-align: right">
				<?php echo $this->_plugins['function']['valuta'][0][0]->valuta(array('value' => ((is_array($_tmp=$this->_tpl_vars['con']['total'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f"))), $this);?>
</td>
		</tr>
	</table>
<?php endforeach; endif; unset($_from); ?><br>

	  	<table align="center" style="width: 95%; " border="0">
			<tr>
				<th style="background-position: 0% 0%; width: 87%; text-align: right; background-image:none; background-repeat:repeat; background-attachment:scroll">
				<?php echo @con('tmp_subtotal'); ?>
 
				</th>
				<th style="width: 13%; background: #F7F7F7; text-align: right;"><?php echo $this->_plugins['function']['valuta'][0][0]->valuta(array('value' => ((is_array($_tmp=$this->_tpl_vars['order_subtotal'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f"))), $this);?>
</th>
			</tr>
</table>


<table align="center" style="width: 95%; " border="0">
	<tr>
		<th style="background-position: 0% 0%; width: 87%; text-align: right; background-image:none; background-repeat:repeat; background-attachment:scroll">
		<?php echo @con('tmp_fee'); ?>
 
		</th>
		<td style="width: 13%; background: #F7F7F7; text-align: right;">
<?php echo $this->_plugins['function']['valuta'][0][0]->valuta(array('value' => ((is_array($_tmp=$this->_tpl_vars['order_fee'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f"))), $this);?>
</td>
	</tr>
</table>


	<table align="center" style="width: 95%; " border="0">
		<tr>
			<th style="background-position: 0% 0%; width: 87%; text-align: right; background-image:none; background-repeat:repeat; background-attachment:scroll">
			<b><?php echo @con('tmp_order_total'); ?>
</b> </th>
			<th style="width: 13%; background: #F7F7F7; text-align: right;"><b><?php echo $this->_plugins['function']['valuta'][0][0]->valuta(array('value' => ((is_array($_tmp=$this->_tpl_vars['order_total_price'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f"))), $this);?>
</b></th>
		</tr>
		
</table>
<nobreak>
<br><br><br>
	<table align="center" width="95%" cellspacing="1">
		<tr>	
			<td align="center"><h1><?php echo @con('tmp_thank_you'); ?>
</h1></td>
		</tr>
	</table>
</nobreak>
</page>