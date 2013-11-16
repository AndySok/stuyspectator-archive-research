<?php
if ( function_exists('register_sidebar') ) 
{

	register_sidebar(array(
		'name'=>'Sidebar',
		'before_widget' => '<div class="menu">', // Removes <li>
		'after_widget' => '</div></div>', // Removes </li>
		'before_title' => '<h2>', // Replaces <h2>
		'after_title' => '</h2><div>', // Replaces </h2>
	));
}
?>