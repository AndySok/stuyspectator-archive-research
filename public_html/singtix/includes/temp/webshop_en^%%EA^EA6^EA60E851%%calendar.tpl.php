<?php /* Smarty version 2.6.19, created on 2010-01-24 00:43:01
         compiled from calendar.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'calendar.tpl', 34, false),array('block', 'event', 'calendar.tpl', 36, false),array('function', 'cycle', 'calendar.tpl', 42, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array('name' => @con('calendar'))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $this->assign('length', '15'); ?>
<?php $this->assign('start_date', ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d"))); ?>
<table class='table_dark'>
  <?php $this->_tag_stack[] = array('event', array('start_date' => $this->_tpl_vars['start_date'],'sub' => 'on','ort' => 'on','place_map' => 'on','order' => "event_date,event_time",'first' => $_GET['offset'],'length' => $this->_tpl_vars['length'])); $_block_repeat=true;smarty_block_event($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <?php $this->assign('month', ((is_array($_tmp=$this->_tpl_vars['shop_event']['event_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%B") : smarty_modifier_date_format($_tmp, "%B"))); ?>
    <?php if ($this->_tpl_vars['month'] != $this->_tpl_vars['month1']): ?>
     <tr><td colspan='4' class='title' style='text-decoration:underline;'><br><?php echo ((is_array($_tmp=$this->_tpl_vars['shop_event']['event_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%B %Y") : smarty_modifier_date_format($_tmp, "%B %Y")); ?>
</td></tr>
     <?php $this->assign('month1', $this->_tpl_vars['month']); ?>
    <?php endif; ?>
    <tr class='tr_<?php echo smarty_function_cycle(array('values' => "0,1"), $this);?>
'>
      <td><a  href='index.php?event_id=<?php echo $this->_tpl_vars['shop_event']['event_id']; ?>
'>
            <?php if ($this->_tpl_vars['shop_event']['event_pm_id']): ?><img src='images/ticket.gif' border="0">
            <?php else: ?><img src='images/info.gif' border="0"><?php endif; ?>
          </a>
      </td>
      <td ><a  href='index.php?event_id=<?php echo $this->_tpl_vars['shop_event']['event_id']; ?>
'><?php echo $this->_tpl_vars['shop_event']['event_name']; ?>
</a></td>
      <td><?php echo ((is_array($_tmp=$this->_tpl_vars['shop_event']['event_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, @con('date_format')) : smarty_modifier_date_format($_tmp, @con('date_format'))); ?>
 - <?php echo ((is_array($_tmp=$this->_tpl_vars['shop_event']['event_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, @con('time_format')) : smarty_modifier_date_format($_tmp, @con('time_format'))); ?>
</td>
      <td ><?php echo $this->_tpl_vars['shop_event']['ort_name']; ?>
 <?php echo $this->_tpl_vars['shop_event']['ort_city']; ?>
 <?php echo $this->_tpl_vars['shop_event']['pm_name']; ?>
</td>
      <td width="20"><?php if ($this->_tpl_vars['shop_event']['event_mp3']): ?><a href='files/<?php echo $this->_tpl_vars['shop_event']['event_mp3']; ?>
'><img src='images/audio-small.png' border='0'></a><?php endif; ?></td>
    </tr>
  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_event($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</table>
<?php echo $this->_reg_objects['gui'][0]->navigation(array('offset' => $_GET['offset'],'count' => $this->_tpl_vars['shop_event']['tot_count'],'length' => $this->_tpl_vars['length']), $this);?>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>