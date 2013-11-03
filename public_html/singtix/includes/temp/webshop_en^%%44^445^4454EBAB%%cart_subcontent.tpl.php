<?php /* Smarty version 2.6.19, created on 2010-01-23 23:54:04
         compiled from cart_subcontent.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'cycle', 'cart_subcontent.tpl', 32, false),array('function', 'valuta', 'cart_subcontent.tpl', 63, false),array('modifier', 'date_format', 'cart_subcontent.tpl', 34, false),array('modifier', 'string_format', 'cart_subcontent.tpl', 63, false),)), $this); ?>
<tr class="<?php echo smarty_function_cycle(array('name' => 'events','values' => 'tr_0,tr_1'), $this);?>
">
  <td  valign='top'> <b><?php echo $this->_tpl_vars['event_item']->event_name; ?>
</b> <br>
    <?php echo ((is_array($_tmp=$this->_tpl_vars['event_item']->event_date)) ? $this->_run_mod_handler('date_format', true, $_tmp, @con('shortdate_format')) : smarty_modifier_date_format($_tmp, @con('shortdate_format'))); ?>
 -
    <?php echo ((is_array($_tmp=$this->_tpl_vars['event_item']->event_time)) ? $this->_run_mod_handler('date_format', true, $_tmp, @con('time_format')) : smarty_modifier_date_format($_tmp, @con('time_format'))); ?>
 <br>
    <?php echo $this->_tpl_vars['event_item']->event_ort_name; ?>
 - <?php echo $this->_tpl_vars['event_item']->event_ort_city; ?>

  </td>
  <td  valign='top'>
    <?php echo $this->_tpl_vars['seat_item']->count(); ?>
 x <?php echo $this->_tpl_vars['category_item']->cat_name; ?>
     <?php if ($this->_tpl_vars['seat_item']->discounts): ?>              <table border='0' width='100%'>
        <?php unset($this->_sections['seats']);
$this->_sections['seats']['name'] = 'seats';
$this->_sections['seats']['loop'] = is_array($_loop=$this->_tpl_vars['seats_id']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['seats']['show'] = true;
$this->_sections['seats']['max'] = $this->_sections['seats']['loop'];
$this->_sections['seats']['step'] = 1;
$this->_sections['seats']['start'] = $this->_sections['seats']['step'] > 0 ? 0 : $this->_sections['seats']['loop']-1;
if ($this->_sections['seats']['show']) {
    $this->_sections['seats']['total'] = $this->_sections['seats']['loop'];
    if ($this->_sections['seats']['total'] == 0)
        $this->_sections['seats']['show'] = false;
} else
    $this->_sections['seats']['total'] = 0;
if ($this->_sections['seats']['show']):

            for ($this->_sections['seats']['index'] = $this->_sections['seats']['start'], $this->_sections['seats']['iteration'] = 1;
                 $this->_sections['seats']['iteration'] <= $this->_sections['seats']['total'];
                 $this->_sections['seats']['index'] += $this->_sections['seats']['step'], $this->_sections['seats']['iteration']++):
$this->_sections['seats']['rownum'] = $this->_sections['seats']['iteration'];
$this->_sections['seats']['index_prev'] = $this->_sections['seats']['index'] - $this->_sections['seats']['step'];
$this->_sections['seats']['index_next'] = $this->_sections['seats']['index'] + $this->_sections['seats']['step'];
$this->_sections['seats']['first']      = ($this->_sections['seats']['iteration'] == 1);
$this->_sections['seats']['last']       = ($this->_sections['seats']['iteration'] == $this->_sections['seats']['total']);
?>
          <tr>
            <td class='view_cart_td'><li>
              <?php if (! $this->_tpl_vars['category_item']->cat_numbering || $this->_tpl_vars['category_item']->cat_numbering == 'both'): ?>
                  <?php echo $this->_tpl_vars['seats_nr'][$this->_sections['seats']['index']][0]; ?>
 - <?php echo $this->_tpl_vars['seats_nr'][$this->_sections['seats']['index']][1]; ?>

              <?php elseif ($this->_tpl_vars['category_item']->cat_numbering == 'seat'): ?>
                  <?php echo $this->_tpl_vars['seats_nr'][$this->_sections['seats']['index']][1]; ?>

              <?php elseif ($this->_tpl_vars['category_item']->cat_numbering == 'rows'): ?>
                  <?php echo @con('row'); ?>
 <?php echo $this->_tpl_vars['seats_nr'][$this->_sections['seats']['index']][0]; ?>

              <?php endif; ?></li>
            </td>
            <td class='view_cart_td'>
              <?php $this->assign('disc', $this->_tpl_vars['seat_item']->discounts[$this->_sections['seats']['index']]); ?>
              <?php if ($this->_tpl_vars['disc']): ?>
                  <?php echo $this->_tpl_vars['disc']->discount_name; ?>

              <?php else: ?>
                  <?php echo @con('normal'); ?>

              <?php endif; ?>
            </td>
            <td align='right'>
              <?php if ($this->_tpl_vars['disc']): ?>
                <?php echo $this->_plugins['function']['valuta'][0][0]->valuta(array('value' => ((is_array($_tmp=$this->_tpl_vars['disc']->apply_to($this->_tpl_vars['category_item']->cat_price))) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f"))), $this);?>

              <?php else: ?>
                <?php echo $this->_plugins['function']['valuta'][0][0]->valuta(array('value' => ((is_array($_tmp=$this->_tpl_vars['category_item']->cat_price)) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f"))), $this);?>

              <?php endif; ?>
            </td>
          </tr>
        <?php endfor; endif; ?>
      </table>
    <?php else: ?>                                    <table border='0' width='100%'>
        <tr>
          <td class='view_cart_td'><li>
            <?php if (! $this->_tpl_vars['category_item']->cat_numbering || $this->_tpl_vars['category_item']->cat_numbering == 'both'): ?>
              <?php unset($this->_sections['seats']);
$this->_sections['seats']['name'] = 'seats';
$this->_sections['seats']['loop'] = is_array($_loop=$this->_tpl_vars['seats_id']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['seats']['show'] = true;
$this->_sections['seats']['max'] = $this->_sections['seats']['loop'];
$this->_sections['seats']['step'] = 1;
$this->_sections['seats']['start'] = $this->_sections['seats']['step'] > 0 ? 0 : $this->_sections['seats']['loop']-1;
if ($this->_sections['seats']['show']) {
    $this->_sections['seats']['total'] = $this->_sections['seats']['loop'];
    if ($this->_sections['seats']['total'] == 0)
        $this->_sections['seats']['show'] = false;
} else
    $this->_sections['seats']['total'] = 0;
if ($this->_sections['seats']['show']):

            for ($this->_sections['seats']['index'] = $this->_sections['seats']['start'], $this->_sections['seats']['iteration'] = 1;
                 $this->_sections['seats']['iteration'] <= $this->_sections['seats']['total'];
                 $this->_sections['seats']['index'] += $this->_sections['seats']['step'], $this->_sections['seats']['iteration']++):
$this->_sections['seats']['rownum'] = $this->_sections['seats']['iteration'];
$this->_sections['seats']['index_prev'] = $this->_sections['seats']['index'] - $this->_sections['seats']['step'];
$this->_sections['seats']['index_next'] = $this->_sections['seats']['index'] + $this->_sections['seats']['step'];
$this->_sections['seats']['first']      = ($this->_sections['seats']['iteration'] == 1);
$this->_sections['seats']['last']       = ($this->_sections['seats']['iteration'] == $this->_sections['seats']['total']);
?>
                 <?php echo $this->_tpl_vars['seats_nr'][$this->_sections['seats']['index']][0]; ?>
 - <?php echo $this->_tpl_vars['seats_nr'][$this->_sections['seats']['index']][1]; ?>

              <?php endfor; endif; ?>
            <?php elseif ($this->_tpl_vars['category_item']->cat_numbering == 'seat'): ?>
              <?php unset($this->_sections['seats']);
$this->_sections['seats']['name'] = 'seats';
$this->_sections['seats']['loop'] = is_array($_loop=$this->_tpl_vars['seats_id']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['seats']['show'] = true;
$this->_sections['seats']['max'] = $this->_sections['seats']['loop'];
$this->_sections['seats']['step'] = 1;
$this->_sections['seats']['start'] = $this->_sections['seats']['step'] > 0 ? 0 : $this->_sections['seats']['loop']-1;
if ($this->_sections['seats']['show']) {
    $this->_sections['seats']['total'] = $this->_sections['seats']['loop'];
    if ($this->_sections['seats']['total'] == 0)
        $this->_sections['seats']['show'] = false;
} else
    $this->_sections['seats']['total'] = 0;
if ($this->_sections['seats']['show']):

            for ($this->_sections['seats']['index'] = $this->_sections['seats']['start'], $this->_sections['seats']['iteration'] = 1;
                 $this->_sections['seats']['iteration'] <= $this->_sections['seats']['total'];
                 $this->_sections['seats']['index'] += $this->_sections['seats']['step'], $this->_sections['seats']['iteration']++):
$this->_sections['seats']['rownum'] = $this->_sections['seats']['iteration'];
$this->_sections['seats']['index_prev'] = $this->_sections['seats']['index'] - $this->_sections['seats']['step'];
$this->_sections['seats']['index_next'] = $this->_sections['seats']['index'] + $this->_sections['seats']['step'];
$this->_sections['seats']['first']      = ($this->_sections['seats']['iteration'] == 1);
$this->_sections['seats']['last']       = ($this->_sections['seats']['iteration'] == $this->_sections['seats']['total']);
?>
                <?php echo $this->_tpl_vars['seats_nr'][$this->_sections['seats']['index']][1]; ?>

              <?php endfor; endif; ?>
            <?php elseif ($this->_tpl_vars['category_item']->cat_numbering == 'rows'): ?>
              <?php $_from = $this->_tpl_vars['seat_item_rows_count']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row'] => $this->_tpl_vars['count']):
?>
                <?php echo $this->_tpl_vars['count']; ?>
 x <?php echo @con('row'); ?>
 <?php echo $this->_tpl_vars['row']; ?>

              <?php endforeach; endif; unset($_from); ?>
            <?php endif; ?>
            </li>
          </td>
          <td class='view_cart_td'>
            <?php echo @con('normal'); ?>

          </td>
          <td align='right'>
            <?php echo $this->_plugins['function']['valuta'][0][0]->valuta(array('value' => ((is_array($_tmp=$this->_tpl_vars['category_item']->cat_price)) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f"))), $this);?>

          </td>
        </tr>
      </table>
    <?php endif; ?>
  </td>
  <td  valign='top' align='right' >
    <?php echo $this->_plugins['function']['valuta'][0][0]->valuta(array('value' => ((is_array($_tmp=$this->_tpl_vars['seat_item']->total_price($this->_tpl_vars['category_item']->cat_price))) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f"))), $this);?>

  </td>
  <?php if ($this->_tpl_vars['three_cols'] != 'on'): ?>
    <td  valign='top'>
      <?php if ($this->_tpl_vars['seat_item']->is_expired()): ?>
        <span style="color:#ff0000;"><?php echo @con('expired'); ?>
</span>
      <?php else: ?>
        <img src='images/clock.gif' valign="middle" align="middle"> <?php echo $this->_tpl_vars['seat_item']->ttl(); ?>
 <?php echo @con('minutes'); ?>
.
      <?php endif; ?>
      <?php if ($this->_tpl_vars['check_out'] != 'on'): ?>
        <br><a  href='index.php?action=remove&event_id=<?php echo $this->_tpl_vars['event_item']->event_id; ?>
&cat_id=<?php echo $this->_tpl_vars['category_item']->cat_id; ?>
&item=<?php echo $this->_tpl_vars['seat_item_id']; ?>
'>
          <?php echo @con('remove'); ?>

        </a>
      <?php endif; ?>
    </td>
  <?php endif; ?>
</tr>