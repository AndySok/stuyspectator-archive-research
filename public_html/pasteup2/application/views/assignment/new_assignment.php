<?php $this->load->view('desk/header'); ?>
<form action='../new_assignment_submit' method='post'>
<?php print "<input type='hidden' name='article_id' value='".$article_id."'>"; ?>

<br />
Title: <input type='text' name='title' maxlength='255' size='50' id='title'   /> 
<br />
Details: <input type='textarea' name='details' maxlength='255' size='100' id='details'  /> <br />
<input type='submit' name='new_assignment_submit' value='New assignment'  />
</form>

<?php $this->load->view('desk/footer'); ?>