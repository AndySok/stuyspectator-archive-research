<?php /* Smarty version 2.6.19, created on 2010-01-23 23:53:44
         compiled from cat_description.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'category', 'cat_description.tpl', 40, false),array('block', 'discount', 'cat_description.tpl', 70, false),array('function', 'cycle', 'cat_description.tpl', 41, false),array('function', 'valuta', 'cat_description.tpl', 44, false),array('function', 'ShowFormToken', 'cat_description.tpl', 122, false),array('modifier', 'string_format', 'cat_description.tpl', 44, false),array('modifier', 'date_format', 'cat_description.tpl', 120, false),)), $this); ?>
<?php if ($this->_tpl_vars['shop_event']['event_pm_id']): ?>
  <br>
  <table border=0 class='table_midtone'>
    <tr>
      <td colspan='3' class="title2">
        <?php echo @con('cat_description'); ?>

      </td>
    </tr>
    <?php $this->_tag_stack[] = array('category', array('event_id' => $this->_tpl_vars['shop_event']['event_id'],'stats' => 'on')); $_block_repeat=true;smarty_block_category($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
      <tr class="<?php echo smarty_function_cycle(array('name' => 'events','values' => "TblHigher,TblLower"), $this);?>
">
        <td><b><?php echo $this->_tpl_vars['shop_category']['category_name']; ?>
</b></td>
        <td align='right'>
          <?php echo $this->_plugins['function']['valuta'][0][0]->valuta(array('value' => ((is_array($_tmp=$this->_tpl_vars['shop_category']['category_price'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f"))), $this);?>

        </td>
        <td align='left' width='25%'>
          <?php if ($this->_tpl_vars['shop_category']['cs_free'] > 0): ?>
            <?php if ($this->_tpl_vars['shop_category']['cs_free']/$this->_tpl_vars['shop_category']['cs_total'] >= 0.2): ?>
              <font><?php echo @con('tickets_available'); ?>
 <?php echo $this->_tpl_vars['shop_category']['cs_free']; ?>
</font>
            <?php else: ?>
              <font color='Yellow'><?php echo @con('tickets_available'); ?>
 <?php echo $this->_tpl_vars['shop_category']['cs_free']; ?>
</font>
            <?php endif; ?>
          <?php else: ?>
            <span class='error'><?php echo @con('category_sold'); ?>
</span>
          <?php endif; ?>
        </td>
      </tr>
      <?php if ($this->_tpl_vars['shop_category']['cs_free'] > 0): ?>
        <?php $this->assign('js_array', ($this->_tpl_vars['js_array'])." unnum_cats[unnum_cats.length]='".($this->_tpl_vars['shop_category']['category_numbering'])."';"); ?>
        <?php ob_start(); ?>
          <option value='<?php echo $this->_tpl_vars['shop_category']['category_id']; ?>
' <?php if ($this->_tpl_vars['shop_category']['category_id'] == $_REQUEST['category_id']): ?>selected<?php endif; ?> />
             <?php echo $this->_tpl_vars['shop_category']['category_name']; ?>
 - <?php echo $this->_plugins['function']['valuta'][0][0]->valuta(array('value' => ((is_array($_tmp=$this->_tpl_vars['shop_category']['category_price'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f"))), $this);?>

          </option>
        <?php $this->_smarty_vars['capture']['default'] = ob_get_contents();  $this->assign('opt', ob_get_contents());ob_end_clean(); ?>
        <?php $this->assign('opt_array', ($this->_tpl_vars['opt_array'])." ".($this->_tpl_vars['opt'])); ?>
      <?php endif; ?>
    <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_category($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
    <tr>
      <td colspan='3'>
        <?php $this->_tag_stack[] = array('discount', array('event_id' => $this->_tpl_vars['shop_event']['event_id'],'cat_price' => $this->_tpl_vars['shop_category']['category_price'])); $_block_repeat=true;smarty_block_discount($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
          &nbsp;
          <span class='note'>
            <?php echo @con('Discount_for'); ?>
 <?php echo $this->_tpl_vars['shop_discount']['discount_name']; ?>

             : <?php echo $this->_tpl_vars['shop_discount']['discount_value']; ?>
<?php if ($this->_tpl_vars['shop_discount']['discount_type'] == 'percent'): ?>%<?php endif; ?>)
          </span>
        <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_discount($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
      </td>
    </tr>
     <tr>
      <td colspan='3' align='left' class='note'>
        <?php echo @con('prices_in'); ?>
 <?php echo $this->_tpl_vars['organizer_currency']; ?>

      </td>
    </tr>
  </table>
  <br>

  <script><!--
  var unnum_cats=new Array;
  <?php echo $this->_tpl_vars['js_array']; ?>


  <?php echo '

  function getElement(id){
       if(document.all) {return document.all(id);}
       if(document.getElementById) {return document.getElementById(id);}
  }

  function setQtyShown(){
        if(cat_select_e=getElement(\'cat_select\')){
           if(qty_e=getElement(\'qqq\')){
             if(unnum_cats[cat_select_e.selectedIndex]==\'none\'){
               qty_e.style.display=\'block\';
             }else{
               qty_e.style.display=\'none\';
             }
           }
         }
       }
   -->
  </script>
  '; ?>

  <?php if ($this->_tpl_vars['user']->mode() == '-1' && ! $this->_tpl_vars['user']->logged): ?>
    	<table class='table_dark' cellpadding='5' bgcolor='white' width='100%'>
      	<tr>
    			<td class='TblLower'>
          			<?php echo @con('Please_login'); ?>

          </td>
			</tr>
		</table> <br/>   <br/>
  <?php elseif ($this->_tpl_vars['shop_event']['event_date'] >= ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d"))): ?>
    <form name='catselect' method='post' action='index.php'>
      <?php echo $this->_plugins['function']['ShowFormToken'][0][0]->showFormToken(array(), $this);?>

      <table  class='table_midtone'>
        <tr>
          <td class='title2' colspan='3' >
            <?php echo @con('select_category'); ?>

          </td>
        </tr>
        <tr>

          <?php if ($this->_tpl_vars['shop_event']['pm_image']): ?>
            <td colspan='3'>
              <img src="files/<?php echo $this->_tpl_vars['shop_event']['pm_image']; ?>
"  border='0'  usemap="#ort_map">
              <map name="ort_map">
                <?php $this->_tag_stack[] = array('category', array('event_id' => $this->_tpl_vars['shop_event']['event_id'],'stats' => 'on')); $_block_repeat=true;smarty_block_category($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
                  <?php if ($this->_tpl_vars['shop_category']['cs_free'] > 0): ?>
                    <area href="index.php?category_id=<?php echo $this->_tpl_vars['shop_category']['category_id']; ?>
&event_id=<?php echo $_GET['event_id']; ?>
" <?php echo $this->_tpl_vars['shop_category']['category_data']; ?>
 />
                  <?php endif; ?>
                <?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_category($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
              </map>
            </td>
          <?php else: ?>
            <td width='50%' align='left'>
              <select name='category_id' onchange='setQtyShown()' id='cat_select' style="float:right;" class="select">
                 <?php echo $this->_tpl_vars['opt_array']; ?>

              </select>
            </td>
            <td  align='left'>
              <div id='qqq'  align='left' style='font-size:9px; float:left;'>x 
                <?php $this->assign('limit', 14); ?>
                <?php if ($this->_tpl_vars['shop_event']['event_order_limit'] > 0): ?>
                   <?php $this->assign('limit', $this->_tpl_vars['shop_event']['event_order_limit']); ?>
                <?php endif; ?>

                <select style="float:none;"  name='qty' >
                  <?php unset($this->_sections['myLoop']);
$this->_sections['myLoop']['name'] = 'myLoop';
$this->_sections['myLoop']['start'] = (int)0;
$this->_sections['myLoop']['loop'] = is_array($_loop=$this->_tpl_vars['limit']+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['myLoop']['show'] = true;
$this->_sections['myLoop']['max'] = $this->_sections['myLoop']['loop'];
$this->_sections['myLoop']['step'] = 1;
if ($this->_sections['myLoop']['start'] < 0)
    $this->_sections['myLoop']['start'] = max($this->_sections['myLoop']['step'] > 0 ? 0 : -1, $this->_sections['myLoop']['loop'] + $this->_sections['myLoop']['start']);
else
    $this->_sections['myLoop']['start'] = min($this->_sections['myLoop']['start'], $this->_sections['myLoop']['step'] > 0 ? $this->_sections['myLoop']['loop'] : $this->_sections['myLoop']['loop']-1);
if ($this->_sections['myLoop']['show']) {
    $this->_sections['myLoop']['total'] = min(ceil(($this->_sections['myLoop']['step'] > 0 ? $this->_sections['myLoop']['loop'] - $this->_sections['myLoop']['start'] : $this->_sections['myLoop']['start']+1)/abs($this->_sections['myLoop']['step'])), $this->_sections['myLoop']['max']);
    if ($this->_sections['myLoop']['total'] == 0)
        $this->_sections['myLoop']['show'] = false;
} else
    $this->_sections['myLoop']['total'] = 0;
if ($this->_sections['myLoop']['show']):

            for ($this->_sections['myLoop']['index'] = $this->_sections['myLoop']['start'], $this->_sections['myLoop']['iteration'] = 1;
                 $this->_sections['myLoop']['iteration'] <= $this->_sections['myLoop']['total'];
                 $this->_sections['myLoop']['index'] += $this->_sections['myLoop']['step'], $this->_sections['myLoop']['iteration']++):
$this->_sections['myLoop']['rownum'] = $this->_sections['myLoop']['iteration'];
$this->_sections['myLoop']['index_prev'] = $this->_sections['myLoop']['index'] - $this->_sections['myLoop']['step'];
$this->_sections['myLoop']['index_next'] = $this->_sections['myLoop']['index'] + $this->_sections['myLoop']['step'];
$this->_sections['myLoop']['first']      = ($this->_sections['myLoop']['iteration'] == 1);
$this->_sections['myLoop']['last']       = ($this->_sections['myLoop']['iteration'] == $this->_sections['myLoop']['total']);
?>
                    <option value='<?php echo $this->_sections['myLoop']['index']; ?>
' > <?php echo $this->_sections['myLoop']['index']; ?>
 </option>
                  <?php endfor; endif; ?>
                </select>
                <?php if ($this->_tpl_vars['shop_event']['event_order_limit'] > 0): ?>
                   (<?php echo @con('order_limit'); ?>
 <?php echo $this->_tpl_vars['shop_event']['event_order_limit']; ?>
)
                <?php endif; ?>
              </div>
            </td>
            <td  align='left'>
              <input type='submit' name='submit_cat' value='<?php echo @con('continue'); ?>
'>
              <input type='hidden' name='event_id' value='<?php echo $_REQUEST['event_id']; ?>
'>
            </td>
          <?php endif; ?>
        </tr>
      </table>
    </form><br>
    <script><!--
    setQtyShown();
    --></script>
  <?php else: ?>
    	<table class='table_dark' cellpadding='5' bgcolor='white' width='100%'>
      	<tr>
    			<td class='TblLower'>
          			<?php echo @con('old_event'); ?>

          </td>
			</tr>
		</table> <br/> <br/>

  <?php endif; ?>
<?php endif; ?>