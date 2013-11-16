<!-- BEGIN SEARCHFORM.PHP -->
<form method="get" id="searchform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div>
<input class="search" type="text" name="s" id="s" tabindex="7" value="Search the archives..." onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
<input class="search-submit" name="submit" type="submit" id="search-submit" tabindex="8" value="Go" />
</div>
</form>
<!-- END SEARCHFORM.PHP -->