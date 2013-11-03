<?php /* Smarty version 2.6.19, created on 2010-01-23 23:57:34
         compiled from programm.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'event', 'programm.tpl', 35, false),array('function', 'counter', 'programm.tpl', 36, false),array('modifier', 'date_format', 'programm.tpl', 61, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array('name' => @con('program'))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<table class="table_trans">
  <?php $this->_tag_stack[] = array('event', array('order' => "event_date,event_time",'main' => 'on','ort' => 'on','event_status' => 'pub')); $_block_repeat=true;smarty_block_event($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
    <?php echo smarty_function_counter(array('print' => false,'assign' => 'count'), $this);?>

    <?php if ((1 & $this->_tpl_vars['count'])): ?>
      <tr style='padding-bottom:30px;'>
    <?php endif; ?>
    <td  valign="top" align='center' width='50%'>
      <table class="small_table_dark" width="100%">
        <?php if ($this->_tpl_vars['shop_event']['event_image']): ?>
          <tr><td align='left'>
            <a href='index.php?event_id=<?php echo $this->_tpl_vars['shop_event']['event_id']; ?>
'>
              <img src="files/<?php echo $this->_tpl_vars['shop_event']['event_image']; ?>
" align='middle' style="margin:15px;">
            </a>
          </td></tr>
        <?php endif; ?>
        <tr>
          <td valign='top' align='left'>
            <div class='title' align='left' >
              <a  href='index.php?event_id=<?php echo $this->_tpl_vars['shop_event']['event_id']; ?>
'><?php echo $this->_tpl_vars['shop_event']['event_name']; ?>
</a>
              <?php if ($this->_tpl_vars['shop_event']['event_mp3']): ?>
                <a href='files/<?php echo $this->_tpl_vars['shop_event']['event_mp3']; ?>
'>
                  [<img src='images/audio-small.png' border='0' valign='bottom'>]</a>
              <?php endif; ?>
            </div>
            <div  align='left'><?php echo $this->_tpl_vars['shop_event']['event_short_text']; ?>
</div><br>
            <div class='date' align='left'>
              <?php if ($this->_tpl_vars['shop_event']['event_rep'] == "main,sub"): ?>
                <?php echo ((is_array($_tmp=$this->_tpl_vars['shop_event']['event_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, @con('shortdate_format')) : smarty_modifier_date_format($_tmp, @con('shortdate_format'))); ?>

                <?php echo ((is_array($_tmp=$this->_tpl_vars['shop_event']['event_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, @con('time_format')) : smarty_modifier_date_format($_tmp, @con('time_format'))); ?>

                <?php echo $this->_tpl_vars['shop_event']['pm_name']; ?>

              <?php elseif ($this->_tpl_vars['shop_event']['event_rep'] == 'main'): ?>
                <?php echo @con('div_dates'); ?>

              <?php endif; ?>
            </div>
          </td>
        </tr>
      </table>
      <br>
    </td>
    <?php if (!(1 & $this->_tpl_vars['count'])): ?>
      </tr>
    <?php endif; ?>
  <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_event($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
</table>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>