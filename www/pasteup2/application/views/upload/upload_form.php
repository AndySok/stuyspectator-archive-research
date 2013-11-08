<?php $this->load->view('desk/header'); ?>
<?php $error;?>
<a href="upload/my_uploads">My uploads</a>
<form action='upload/do_upload' method='post' enctype='multipart/form-data'>

<input type="file" name="userfile" size="20" />

<br /><br />
Caption: <input type='text' name='caption' />
<br />
Comment <input type= 'text' name='comment' />
<br />
<input type="submit" value="upload" />

</form>

<?php $this->load->view('desk/footer'); ?>