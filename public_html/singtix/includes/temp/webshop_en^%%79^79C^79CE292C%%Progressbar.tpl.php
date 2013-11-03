<?php /* Smarty version 2.6.19, created on 2010-01-23 23:46:31
         compiled from Progressbar.tpl */ ?>
<?php echo '
<style type="text/css">
.pagination{
  background-color: #99d9ea;
  TEXT-ALIGN: center;    
}
.done{
  background-color: #42729a;
  color: #FFFFFF;
  TEXT-ALIGN: center;  
  border-left: 2px solid #5EA3DB;
}
.current{
  background-repeat: no-repeat;
  background-color: #BdC9D5;
   font-weight: bold;
   color: #000000;
}
.next{
  TEXT-ALIGN: center;
  border-right: 2px solid #9FE1F2;
}

</style> '; ?>

  <br>

  <table border="0" class="pagination" width="100%"  cellpadding="0" cellspacing="0" >
    <tr>
      <?php if ($this->_tpl_vars['name'] == @con('shop') && $this->_tpl_vars['shop_event']['event_pm_id']): ?>
        <td class='current'> <?php echo @con('prg_order'); ?>
 </td>
        <td width='25'><img src='<?php echo $this->_tpl_vars['_SHOP_images']; ?>
trans_12_11_r.png' height='20'></td>
        <td class='next'><?php echo @con('prg_review'); ?>
</td>
        <?php if (! $this->_tpl_vars['user']->logged): ?>
          <td class='next'>
            <?php echo @con('prg_signin'); ?>

          </td>
        <?php endif; ?>
        <td class='next'><?php echo @con('prg_payment'); ?>
</td>
        <td class="next"><?php echo @con('prg_complete'); ?>
</td>          
      <?php elseif ($this->_tpl_vars['name'] == @con('select_seat')): ?>
        <td class='done'><?php echo @con('prg_order'); ?>
 </td>
        <td width='11'><img src='<?php echo $this->_tpl_vars['_SHOP_images']; ?>
trans_12_11_b.png' width='11' height='20'></td>
        <td class='current'><?php echo @con('prg_seat'); ?>
 </td>
        <td width='25'><img src='<?php echo $this->_tpl_vars['_SHOP_images']; ?>
trans_12_11_r.png' height='20'></td>
        <td class='next'><?php echo @con('prg_review'); ?>
</td>
        <?php if (! $this->_tpl_vars['user']->logged): ?>
          <td class='next'>
            <?php echo @con('prg_signin'); ?>

          </td>
        <?php endif; ?>
        <td class='next'><?php echo @con('prg_payment'); ?>
</td>
        <td class="next"><?php echo @con('prg_complete'); ?>
</td>          
      <?php elseif ($this->_tpl_vars['name'] == @con('discounts')): ?>
        <td class='done'><?php echo @con('prg_order'); ?>
 </td>
        <td width='11'><img src='<?php echo $this->_tpl_vars['_SHOP_images']; ?>
trans_12_11_b.png' width='11' height='20'></td>
        <td class='current'><?php echo @con('prg_discounts'); ?>
</td>
        <td width='25'><img src='<?php echo $this->_tpl_vars['_SHOP_images']; ?>
trans_12_11_r.png' height='20'></td>
        <td class='next'><?php echo @con('prg_review'); ?>
</td>
        <?php if (! $this->_tpl_vars['user']->logged): ?>
          <td class='next'>
            <?php echo @con('prg_signin'); ?>

          </td>
        <?php endif; ?>
        <td class='next'><?php echo @con('prg_payment'); ?>
</td>
        <td class="next"><?php echo @con('prg_complete'); ?>
</td>       
      <?php elseif ($this->_tpl_vars['name'] == @con('shopping_cart')): ?>
        <td class='done'><?php echo @con('prg_order'); ?>
 </td>
        <td width='11'><img src='<?php echo $this->_tpl_vars['_SHOP_images']; ?>
trans_12_11_b.png' width='11' height='20'></td>
        <td class='current'><?php echo @con('prg_review'); ?>
 </td>
        <td width='25'><img src='<?php echo $this->_tpl_vars['_SHOP_images']; ?>
trans_12_11_r.png' height='20'></td>
        <?php if (! $this->_tpl_vars['user']->logged): ?>
          <td class='next'>
            <?php echo @con('prg_signin'); ?>

          </td>
        <?php endif; ?>
        <td class='next'><?php echo @con('prg_payment'); ?>
</td>
        <td class="next"><?php echo @con('prg_complete'); ?>
</td>       
      <?php elseif ($this->_tpl_vars['name'] == @con('pers_info')): ?>
        <td class='done'><?php echo @con('prg_order'); ?>
 </td>
        <td class='done'><?php echo @con('prg_review'); ?>
 </td>
        <td width='11'><img src='<?php echo $this->_tpl_vars['_SHOP_images']; ?>
trans_12_11_b.png' width='11' height='20'></td>
        <td class='current'><?php echo @con('prg_signin'); ?>
 </td>
        <td width='25'><img src='<?php echo $this->_tpl_vars['_SHOP_images']; ?>
trans_12_11_r.png' height='20'></td>
        <td class='next'><?php echo @con('prg_payment'); ?>
</td>
        <td class="next"><?php echo @con('prg_complete'); ?>
</td>       
      <?php elseif ($this->_tpl_vars['name'] == @con('shopping_cart_check_out')): ?>
        <td class='done'><?php echo @con('prg_order'); ?>
 </td>
        <td class='done'><?php echo @con('prg_review'); ?>
 </td>
        <td class='done'><?php echo @con('prg_signin'); ?>
</td>
        <td width='11'><img src='<?php echo $this->_tpl_vars['_SHOP_images']; ?>
trans_12_11_b.png' width='11' height='20'></td>
        <td class='current'><?php echo @con('prg_payment'); ?>
 </td>
        <td width='25'><img src='<?php echo $this->_tpl_vars['_SHOP_images']; ?>
trans_12_11_r.png' height='20'></td>
        <td class="next"><?php echo @con('prg_complete'); ?>
</td>
      <?php elseif ($this->_tpl_vars['name'] == @con('order_reg')): ?>
        <td class='done'><?php echo @con('prg_order'); ?>
 </td>
        <td class='done'><?php echo @con('prg_review'); ?>
 </td>
        <td class='done'><?php echo @con('prg_signin'); ?>
</td>
        <td class='done'><?php echo @con('prg_payment'); ?>
 </td>
        <td width='11'><img src='<?php echo $this->_tpl_vars['_SHOP_images']; ?>
trans_12_11_b.png' width='11' height='20'></td>
        <td class="current"><?php echo @con('prg_complete'); ?>
</td>
        <td width='25' ><img src='<?php echo $this->_tpl_vars['_SHOP_images']; ?>
trans_12_11_r.png' height='20'></td>
      <?php elseif ($this->_tpl_vars['name'] == @con('pay_accept') || $this->_tpl_vars['name'] == @con('pay_refused')): ?>
        <td class='done'><?php echo @con('prg_order'); ?>
 </td>
        <td class='done'><?php echo @con('prg_review'); ?>
 </td>
        <td class='done'><?php echo @con('prg_signin'); ?>
</td>
        <td class='done'><?php echo @con('prg_payment'); ?>
 </td>
        <td width='11'><img src='<?php echo $this->_tpl_vars['_SHOP_images']; ?>
trans_12_11_b.png' height='20'></td>
        <td class="current"><?php echo @con('prg_complete'); ?>
</td>
      <?php endif; ?>
    </tr>
  </table>