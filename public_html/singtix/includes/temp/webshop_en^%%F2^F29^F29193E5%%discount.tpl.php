<?php /* Smarty version 2.6.19, created on 2010-01-23 23:54:02
         compiled from discount.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'discount', 'discount.tpl', 36, false),array('block', 'category', 'discount.tpl', 39, false),array('function', 'ShowFormToken', 'discount.tpl', 41, false),)), $this); ?>
<?php $this->assign('event_id', $_POST['event_id']); ?>
<?php $this->assign('category_id', $_POST['category_id']); ?>

<?php if ($this->_tpl_vars['event_id']): ?>
  <?php $this->_tag_stack[] = array('discount', array('all' => 'on','event_id' => $this->_tpl_vars['event_id'])); $_block_repeat=true;smarty_block_discount($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?><?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_discount($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
  <?php if ($this->_tpl_vars['shop_discounts']): ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array('name' => @con('discounts'))));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    <?php $this->_tag_stack[] = array('category', array('event' => 'on','category_id' => $this->_tpl_vars['category_id'])); $_block_repeat=true;smarty_block_category($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <form action='index.php' method='post'>
        <?php echo $this->_plugins['function']['ShowFormToken'][0][0]->showFormToken(array('name' => 'Discounts'), $this);?>

        <table class="table_midtone">
          <tr>
            <td valign='top'>
              <table   width='100%' border='0' cellspacing='0'>
                <tr>
                  <td class='title2' colspan='<?php echo $this->_tpl_vars['shop_discounts_count']+1; ?>
' valign='top'>
                    <?php echo $this->_tpl_vars['shop_category']['event_name']; ?>
 - <?php echo $this->_tpl_vars['shop_category']['category_name']; ?>

                  </td>
                </tr>
                <tr>
                  <td  valign='top'> <b><?php echo @con('place_nr'); ?>
</b></td>
                  <td colspan='<?php echo $this->_tpl_vars['shop_discounts_count']+1; ?>
'></td>
                </tr>
                <?php if ($this->_tpl_vars['last_item']->load_info()): ?><?php endif; ?>
                <?php $this->assign('places_id', $this->_tpl_vars['last_item']->places_id); ?>
                <?php $this->assign('places_nr', $this->_tpl_vars['last_item']->places_nr); ?>
                <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['places_id']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
                  <tr>
                    <td >
                      <?php if ($this->_tpl_vars['shop_category']['category_numbering'] == 'both'): ?>
                        <?php echo $this->_tpl_vars['places_nr'][$this->_sections['i']['index']]['0']; ?>
 - <?php echo $this->_tpl_vars['places_nr'][$this->_sections['i']['index']]['1']; ?>

                      <?php elseif ($this->_tpl_vars['shop_category']['category_numbering'] == 'rows'): ?>
                        <?php echo @con('row'); ?>
<?php echo $this->_tpl_vars['places_nr'][$this->_sections['i']['index']]['0']; ?>

                      <?php elseif ($this->_tpl_vars['shop_category']['category_numbering'] == 'none'): ?>
                        <?php echo $this->_tpl_vars['index']; ?>

                      <?php endif; ?>
                    </td>
                    <td style='font-size:11px;font-family:Verdana;'>
                      <label><input class='checkbox_dark' type='radio' name='discount[<?php echo $this->_tpl_vars['places_id'][$this->_sections['i']['index']]; ?>
]' value='0' checked><?php echo @con('normal'); ?>
</label>
                    </td>
                    <?php unset($this->_sections['d']);
$this->_sections['d']['name'] = 'd';
$this->_sections['d']['loop'] = is_array($_loop=$this->_tpl_vars['shop_discounts']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['d']['show'] = true;
$this->_sections['d']['max'] = $this->_sections['d']['loop'];
$this->_sections['d']['step'] = 1;
$this->_sections['d']['start'] = $this->_sections['d']['step'] > 0 ? 0 : $this->_sections['d']['loop']-1;
if ($this->_sections['d']['show']) {
    $this->_sections['d']['total'] = $this->_sections['d']['loop'];
    if ($this->_sections['d']['total'] == 0)
        $this->_sections['d']['show'] = false;
} else
    $this->_sections['d']['total'] = 0;
if ($this->_sections['d']['show']):

            for ($this->_sections['d']['index'] = $this->_sections['d']['start'], $this->_sections['d']['iteration'] = 1;
                 $this->_sections['d']['iteration'] <= $this->_sections['d']['total'];
                 $this->_sections['d']['index'] += $this->_sections['d']['step'], $this->_sections['d']['iteration']++):
$this->_sections['d']['rownum'] = $this->_sections['d']['iteration'];
$this->_sections['d']['index_prev'] = $this->_sections['d']['index'] - $this->_sections['d']['step'];
$this->_sections['d']['index_next'] = $this->_sections['d']['index'] + $this->_sections['d']['step'];
$this->_sections['d']['first']      = ($this->_sections['d']['iteration'] == 1);
$this->_sections['d']['last']       = ($this->_sections['d']['iteration'] == $this->_sections['d']['total']);
?>
                      <td style='font-size:11px;font-family:Verdana;'>
                        <label><input class='checkbox_dark' type='radio' name='discount[<?php echo $this->_tpl_vars['places_id'][$this->_sections['i']['index']]; ?>
]' value='<?php echo $this->_tpl_vars['shop_discounts'][$this->_sections['d']['index']]['discount_id']; ?>
'><?php echo $this->_tpl_vars['shop_discounts'][$this->_sections['d']['index']]['discount_name']; ?>
</label>
                      </td>
                    <?php endfor; endif; ?>
                  </tr>
                <?php endfor; endif; ?>
                <tr>
                  <td colspan='<?php echo $this->_tpl_vars['shop_discounts_count']+2; ?>
' align='center'>
                    <input type='hidden' name='event_id' value='<?php echo $this->_tpl_vars['shop_category']['event_id']; ?>
'>
                    <input type='hidden' name='category_id' value='<?php echo $this->_tpl_vars['shop_category']['category_id']; ?>
'>
                    <input type='hidden' name='item_id' value='<?php echo $this->_tpl_vars['last_item']->id; ?>
'>
                    <input type='hidden' name='action' value='adddiscount'><br>
                    <input type='submit' name='submit' value='<?php echo @con('continue'); ?>
'>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </form>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_category($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
  <?php else: ?>
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'cart_view.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  <?php endif; ?>
<?php endif; ?>