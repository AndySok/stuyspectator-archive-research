<?php $this->load->view('desk/header'); ?>
<h3>Your file was successfully uploaded!</h3>

<ul>
<?php foreach($upload_data as $item => $value):?>
<li><?=$item;?>: <?=$value;?></li>
<?php endforeach; ?>
</ul>

<p><?=anchor('upload', 'Upload Another File!'); ?></p>

<?php $this->load->view('desk/footer'); ?>