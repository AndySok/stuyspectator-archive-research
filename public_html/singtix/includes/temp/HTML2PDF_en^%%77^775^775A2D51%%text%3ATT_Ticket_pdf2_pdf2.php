<?php /* Smarty version 2.6.19, created on 2010-01-24 00:49:37
         compiled from text:TT_Ticket_pdf2_pdf2 */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count_characters', 'text:TT_Ticket_pdf2_pdf2', 21, false),array('modifier', 'date_format', 'text:TT_Ticket_pdf2_pdf2', 46, false),)), $this); ?>
<?php echo '
<style type="text/css">
<!--
table	{ vertical-align: middle; }
tr		{ vertical-align: middle; }
td		{ vertical-align: middle; }
}
-->
</style>
'; ?>

<page>
<br><br>
	<table align="center" cellspacing="0" style="width: 90%">
		<tr>
			<td  colspan="6" style="border-left-style: solid; border-left-width: 1px; border-top-style: solid; border-top-width: 1px" align="center" width="50%">
			<b><i><?php echo $this->_tpl_vars['organizer_name']; ?>
 Presents</i></b></td>
			<td  colspan="4" style="border-right-style: solid; border-right-width: 1px; border-top-style: solid; border-top-width: 1px" rowspan="2" width="50%"><barcode type="CODE39"; value="<?php echo $this->_tpl_vars['barcode_text']; ?>
"></barcode></td>
		</tr>
		<tr>
			<td  colspan="6" style="border-left-style: solid; border-left-width: 1px; vertical-align:top" align="center" width="50%">
				<?php if (((is_array($_tmp=$this->_tpl_vars['event_name'])) ? $this->_run_mod_handler('count_characters', true, $_tmp, true) : smarty_modifier_count_characters($_tmp, true)) < 20): ?>
					<h1 align="center"><?php echo $this->_tpl_vars['event_name']; ?>
</h1>
				<?php else: ?>
					<h4 align="center"><?php echo $this->_tpl_vars['event_name']; ?>
</h4>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<td style="border-left-style: solid; border-left-width: 1px" width="5%">&nbsp;</td>
			<td colspan="4" bgcolor="#E6E6E6" align="center" width="40%"><b>
			Location Details</b></td>
			<td style= "width: 5%">&nbsp;</td>
			<td width="5%">&nbsp;</td>
			<td bgcolor="#E6E6E6" colspan="2" align="center" width="40%"><b>Date 
			and Time</b></td>
			<td style="border-right-style: solid; border-right-width: 1px;" width="5%">&nbsp;</td>
		</tr>
		<tr>
			<td style="border-left-style: solid; border-left-width: 1px" width="5%">&nbsp;</td>
			<td style="bgcolor" colspan="2" align="center" width="20%" rowspan="5">
			<img border="0" src="<?php echo $this->_tpl_vars['_SHOP_files']; ?>
<?php echo $this->_tpl_vars['ort_image']; ?>
" width="90"></td>
			<td style="bgcolor" colspan="2" align="center" width="20%"><?php echo $this->_tpl_vars['ort_name']; ?>
</td>
			<td width="5%">&nbsp;</td>
			<td width="5%">&nbsp;</td>
			<td width="20%"><b>&nbsp;Event Date:</b></td>
			<td width="20%"><?php echo ((is_array($_tmp=$this->_tpl_vars['event_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, " %a - %h %e, %Y") : smarty_modifier_date_format($_tmp, " %a - %h %e, %Y")); ?>
</td>
			<td style="border-right-style: solid; border-right-width: 1px" width="5%">&nbsp;</td>
		</tr>
		<tr>
			<td style="border-left-style: solid; border-left-width: 1px" width="5%"></td>
			<td style="bgcolor" colspan="2" align="center" width="20%"><?php echo $this->_tpl_vars['ort_address']; ?>
</td>
			<td width="5%">&nbsp;</td>
			<td width="5%">&nbsp;</td>
			<td width="20%"><b>&nbsp;Start Time:</b></td>
			<td width="20%"><?php echo ((is_array($_tmp=$this->_tpl_vars['event_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, " %I:%M %p") : smarty_modifier_date_format($_tmp, " %I:%M %p")); ?>
</td>
			<td style="border-right-style: solid; border-right-width: 1px" width="5%">&nbsp;</td>
		</tr>
		<tr>
			<td style="border-left-style: solid; border-left-width: 1px" width="5%">&nbsp;</td>
			<td style="bgcolor" colspan="2" align="center" width="20%"><?php echo $this->_tpl_vars['ort_city']; ?>
, 
			<?php echo $this->_tpl_vars['ort_state']; ?>
&nbsp; <?php echo $this->_tpl_vars['ort_zip']; ?>
</td>
			<td width="5%">&nbsp;</td>
			<td width="5%">&nbsp;</td>
			<td width="20%"><b>&nbsp;Doors Open:</b></td>
			<td width="20%"><?php echo ((is_array($_tmp=$this->_tpl_vars['event_open'])) ? $this->_run_mod_handler('date_format', true, $_tmp, " %I:%M %p") : smarty_modifier_date_format($_tmp, " %I:%M %p")); ?>
</td>
			<td style="border-right-style: solid; border-right-width: 1px" width="5%">&nbsp;</td>
		</tr>
		<tr>
			<td style="border-left-style: solid; border-left-width: 1px" width="5%"></td>
			<td style="bgcolor" colspan="2" align="center" width="20%"><?php echo $this->_tpl_vars['ort_phone']; ?>
</td>
			<td width="5%">&nbsp;</td>
			<td width="5%">&nbsp;</td>
			<td style="align=" colspan="2" width="40%">&nbsp;</td>
			<td style="border-right-style: solid; border-right-width: 1px" width="5%">&nbsp;</td>
		</tr>
		<tr>
			<td style="border-left-style: solid; border-left-width: 1px" width="5%">&nbsp;</td>
			<td style="bgcolor" align="center" colspan="2" width="20%">&nbsp;</td>
			<td width="5%">&nbsp;</td>
			<td width="5%">&nbsp;</td>
			<td colspan="2" style="align" width="40%">&nbsp;</td>
			<td style="border-right-style: solid; border-right-width: 1px" width="5%">&nbsp;</td>
		</tr>
		<tr>
			<td style="border-left-style: solid; border-left-width: 1px" width="5%">&nbsp;</td>
			<td align="center" colspan="4" style="bgcolor" width="40%" bgcolor="#E6E6E6">
				<?php if ($this->_tpl_vars['pmp_name']): ?>
					<b><?php echo $this->_tpl_vars['pmp_name']; ?>
</b>
				<?php else: ?> 
					<b>Seating Section</b>
				<?php endif; ?>
			</td>
			<td width="5%">&nbsp;</td>
			<td width="5%">&nbsp;</td>
			<td bgcolor="#E6E6E6" align="center" colspan="2" style="align" width="40%"><b>
			Ticket Details</b></td>
			<td style="border-right-style: solid; border-right-width: 1px" width="5%">&nbsp;</td>
		</tr>
		<tr>
			<td style="border-left-style: solid; border-left-width: 1px" width="5%">&nbsp;</td>
			<td width="5%"><b>Zone:</b></td>
			<td width="15%" align="left"><i><?php echo $this->_tpl_vars['pmz_short_name']; ?>
</i></td>
			<td width="10%">&nbsp;</td>
			<td width="10%" align="right">&nbsp;</td>
			<td width="5%">&nbsp;</td>
			<td width="5%">&nbsp;</td>
			<td "width=20%" width="20%"><b>&nbsp;Type:</b></td>
			<td width="20%"><i><?php echo $this->_tpl_vars['category_name']; ?>
</i></td>
			<td style="border-right-style: solid; border-right-width: 1px" width="5%">&nbsp;</td>
		</tr>
		<tr>
			<td style="border-left-style: solid; border-left-width: 1px" width="5%"></td>
			<td align="right" width="5%">&nbsp;</td>
			<td width="15%">&nbsp;</td>
			<td width="10%" align="right"><b>Row #:&nbsp;</b></td>
			<td width="10%"><i><?php echo $this->_tpl_vars['seat_row_nr']; ?>
</i></td>
			<td width="5%">&nbsp;</td>
			<td width="5%">&nbsp;</td>
			<td width="20%"><b>&nbsp;Price:</b></td>
			<td width="20%"><i>$ <?php echo $this->_tpl_vars['category_price']; ?>
 <small><?php echo $this->_tpl_vars['organizer_currency']; ?>
</small></i></td>
			<td style="border-right-style: solid; border-right-width: 1px" width="5%">&nbsp;</td>
		</tr>
		<tr>
			<td style="border-left-style: solid; border-left-width: 1px" width="5%">&nbsp;</td>
			<td align="right" width="5%">&nbsp;</td>
			<td width="15%">&nbsp;</td>
			<td width="10%" align="right"><b>Seat #:&nbsp;</b></td>
			<td width="10%"><i><?php echo $this->_tpl_vars['seat_nr']; ?>
</i></td>
			<td width="5%">&nbsp;</td>
			<td width="5%">&nbsp;</td>
			<td width="20%">&nbsp;</td>
			<td width="20%">&nbsp;</td>
			<td style="border-right-style: solid; border-right-width: 1px" width="5%">&nbsp;</td>
		</tr>
		<tr>
			<td style="border-left-style: solid; border-left-width: 1px" width="5%">&nbsp;</td>
			<td width="5%">&nbsp;</td>
			<td width="15%">&nbsp;</td>
			<td width="10%" align="right">&nbsp;</td>
			<td width="10%" align="right"><i>&nbsp;</i></td>
			<td width="5%">&nbsp;</td>
			<td width="5%">&nbsp;</td>
			<td width="20%"><?php if ($this->_tpl_vars['discount_name']): ?><b>&nbsp;Discount:</b><?php endif; ?></td>
			<td width="20%"><i><?php echo $this->_tpl_vars['discount_name']; ?>
</i></td>
			<td style="border-right-style: solid; border-right-width: 1px" width="5%">&nbsp;</td>
		</tr>
		<tr>
			<td style="border-left-style: solid; border-left-width: 1px; border-bottom-style: solid; border-bottom-width: 1px" width="5%">&nbsp;</td>
			<td style="border-bottom-style: solid; border-bottom-width: 1px" width="5%">&nbsp;</td>
			<td style="border-bottom-style: solid; border-bottom-width: 1px" width="15%">&nbsp;</td>
			<td style="border-bottom-style: solid; border-bottom-width: 1px" width="10%">&nbsp;</td>
			<td style="border-bottom-style: solid; border-bottom-width: 1px" width="10%" align="right">&nbsp;</td>
			<td style="border-bottom-style:solid; border-bottom-width:2px" style="border-bottom-style: solid; border-bottom-width: 1px" width="5%">&nbsp;</td>
			<td style="border-bottom-style:solid; border-bottom-width:2px" style="border-bottom-style: solid; border-bottom-width: 1px" width="5%">&nbsp;</td>
			<td style="border-bottom-style: solid; border-bottom-width: 1px" width="20%">&nbsp;</td>
			<td style="border-bottom-style: solid; border-bottom-width: 1px" width="20%">&nbsp;</td>
			<td style="border-right-style: solid; border-right-width: 1px; border-bottom-style: solid; border-bottom-width: 1px" width="5%">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="10" align="right" height="30
			" width="100%"><small>&copy;&nbsp;Fusion Ticket</small></td>
		</tr>
		<tr>
			<td colspan="10" style="vertical-align: top" align="justify" width="100%">
				<b>NOTE TO PURCHASER: TREAT THESE TICKETS AS YOU WOULD ANY OTHER 
				VALUABLE OR CASH.</b>  Unauthorized duplication, alteration, or 
				sale of this ticket may prevent admittance to the event. Present 
				this page at the time of admission to be scanned. The unique bar 
				code on this ticket allows only one entry per ticket</td>
		</tr>
		<tr>
			<td colspan="10" style=" border-top-style: dashed; border-top-width: 3px" width="100%"></td>
		</tr>
	</table>
</page>