<?php /* Smarty version 2.6.19, created on 2010-01-23 23:46:31
         compiled from last_event_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'last_event_list.tpl', 34, false),array('block', 'event', 'last_event_list.tpl', 36, false),)), $this); ?>
 <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array('name' => @con('up_events'),'header' => @con('eventlist_info'))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!-- Upcoming Events (last_event_list.tpl) -->
<?php $this->assign('start_date', ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d"))); ?>
<p>
  <?php $this->_tag_stack[] = array('event', array('order' => "event_date,event_time",'ort' => 'on','sub' => 'on','event_status' => 'pub','start_date' => $this->_tpl_vars['start_date'],'limit' => '0,3')); $_block_repeat=true;smarty_block_event($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "event_description.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> <br>
  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_event($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</p>