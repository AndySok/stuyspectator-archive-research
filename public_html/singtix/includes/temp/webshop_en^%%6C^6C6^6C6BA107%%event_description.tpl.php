<?php /* Smarty version 2.6.19, created on 2010-01-23 23:53:41
         compiled from event_description.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'event_description.tpl', 56, false),array('block', 'event', 'event_description.tpl', 70, false),)), $this); ?>
<?php if ($this->_tpl_vars['shop_event']['event_rep'] == 'main'): ?>
  <table class="table_dark" cellpadding="5">
    <tr>
    	<?php if ($this->_tpl_vars['shop_event']['event_image']): ?>
        <td width="30%" valign="top" colspan="2">
    	  	<a href='index.php?event_id=<?php echo $this->_tpl_vars['shop_event']['event_id']; ?>
'>
            <img src="files/<?php echo $this->_tpl_vars['shop_event']['event_image']; ?>
" align='left' style="margin:3px;" alt="<?php echo $this->_tpl_vars['shop_event']['event_name']; ?>
 in <?php echo $this->_tpl_vars['shop_event']['ort_city']; ?>
" title="<?php echo $this->_tpl_vars['shop_event']['event_name']; ?>
 in <?php echo $this->_tpl_vars['shop_event']['ort_city']; ?>
" border="0" height="100">
          </a>
    	  </td>
    	<?php endif; ?>
      <td colspan='4' valign='top'>
        <a  class="title_link" href='index.php?event_id=<?php echo $this->_tpl_vars['shop_event']['event_id']; ?>
'>
          <?php if ($this->_tpl_vars['shop_event']['event_pm_id']): ?>
            <img border='0' src='images/ticket.gif'>
          <?php else: ?>
            <img border='0' src='images/info.gif' />
          <?php endif; ?>
          &nbsp;<?php echo $this->_tpl_vars['shop_event']['event_name']; ?>

        </a>
        <?php if ($this->_tpl_vars['shop_event']['event_mp3']): ?>
          <a  href='files/<?php echo $this->_tpl_vars['shop_event']['event_mp3']; ?>
'>
            <img src='images/audio-small.png' border='0' valign='bottom'>
          </a>
        <?php endif; ?><br>
        <span class="date"><?php echo ((is_array($_tmp=$this->_tpl_vars['shop_event']['event_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, @con('shortdate_format')) : smarty_modifier_date_format($_tmp, @con('shortdate_format'))); ?>

          <?php echo ((is_array($_tmp=$this->_tpl_vars['shop_event']['event_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, @con('time_format')) : smarty_modifier_date_format($_tmp, @con('time_format'))); ?>

          <?php echo $this->_tpl_vars['shop_event']['pm_name']; ?>

          <?php if ($this->_tpl_vars['info_plus']): ?>
            <?php echo @con('doors_open'); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['shop_event']['event_open'])) ? $this->_run_mod_handler('date_format', true, $_tmp, @con('time_format')) : smarty_modifier_date_format($_tmp, @con('time_format'))); ?>

          <?php endif; ?>
        </span><br>
        <?php echo $this->_tpl_vars['shop_event']['event_text']; ?>

      </td>
    </tr>
    <tr>
      <td colspan='6'>
        <?php if ($this->_tpl_vars['info_plus'] == 'on'): ?>
          <?php echo @con('dates_localities'); ?>
:
          <?php $this->_tag_stack[] = array('event', array('event_main_id' => $_GET['event_id'],'ort' => 'on','stats' => 'on','sub' => 'on','event_status' => 'pub','place_map' => 'on')); $_block_repeat=true;smarty_block_event($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
            <li>
              <a href="index.php?event_id=<?php echo $this->_tpl_vars['shop_event']['event_id']; ?>
">
                <?php echo ((is_array($_tmp=$this->_tpl_vars['shop_event']['event_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, @con('date_format')) : smarty_modifier_date_format($_tmp, @con('date_format'))); ?>

              </a>
	            <?php echo ((is_array($_tmp=$this->_tpl_vars['shop_event']['event_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, @con('time_format')) : smarty_modifier_date_format($_tmp, @con('time_format'))); ?>
 <?php echo $this->_tpl_vars['shop_event']['pm_name']; ?>

            </li>
          <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_event($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
        <?php else: ?>
          <?php echo @con('various_dates'); ?>

        <?php endif; ?>
      </td>
    </tr>
  </table>
<?php else: ?>
  <table class="table_dark">
    <tr>
      <?php if ($this->_tpl_vars['shop_event']['event_image']): ?>
        <td>
          <a href='index.php?event_id=<?php echo $this->_tpl_vars['shop_event']['event_id']; ?>
'>
            <img src="files/<?php echo $this->_tpl_vars['shop_event']['event_image']; ?>
" align='left' style="margin:15px;" border="0">
          </a>
        </td>
      <?php endif; ?>
      <td>
        <a  class="title_link" href='index.php?event_id=<?php echo $this->_tpl_vars['shop_event']['event_id']; ?>
'>
          <?php if ($this->_tpl_vars['shop_event']['event_pm_id']): ?>
            <img border='0' src='images/ticket.gif' align="middle">
          <?php else: ?>
            <img border='0' src='images/info.gif' align="middle">
          <?php endif; ?>
          &nbsp;<?php echo $this->_tpl_vars['shop_event']['event_name']; ?>

        </a>
        <?php if ($this->_tpl_vars['shop_event']['event_mp3']): ?>
          <a  href='files/<?php echo $this->_tpl_vars['shop_event']['event_mp3']; ?>
'>
            [<img src='images/audio-small.png' border='0' valign='bottom'>]
          </a>
        <?php endif; ?><br>
        <?php if ($this->_tpl_vars['info_plus'] == 'on'): ?>
          <span class="date">
            <?php echo @con('date'); ?>
:
            <?php echo ((is_array($_tmp=$this->_tpl_vars['shop_event']['event_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, @con('date_format')) : smarty_modifier_date_format($_tmp, @con('date_format'))); ?>
 -
            <?php echo ((is_array($_tmp=$this->_tpl_vars['shop_event']['event_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, @con('time_format')) : smarty_modifier_date_format($_tmp, @con('time_format'))); ?>
 <br>
            <?php echo @con('venue'); ?>
:
            <?php echo $this->_tpl_vars['shop_event']['ort_name']; ?>
 - <?php echo $this->_tpl_vars['shop_event']['ort_city']; ?>
 - <?php echo $this->_tpl_vars['shop_event']['pm_name']; ?>
 <br>
            <?php echo @con('doors_open'); ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['shop_event']['event_open'])) ? $this->_run_mod_handler('date_format', true, $_tmp, @con('time_format')) : smarty_modifier_date_format($_tmp, @con('time_format'))); ?>

          </span>
        <?php else: ?>
          <span class="date"><?php echo ((is_array($_tmp=$this->_tpl_vars['shop_event']['event_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, @con('shortdate_format')) : smarty_modifier_date_format($_tmp, @con('shortdate_format'))); ?>

            <?php echo ((is_array($_tmp=$this->_tpl_vars['shop_event']['event_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, @con('time_format')) : smarty_modifier_date_format($_tmp, @con('time_format'))); ?>
 <?php echo $this->_tpl_vars['shop_event']['ort_name']; ?>

          </span>
        <?php endif; ?>
        <br><br>
        <?php echo $this->_tpl_vars['shop_event']['event_text']; ?>

      </td>
    </tr>
  </table>
<?php endif; ?>