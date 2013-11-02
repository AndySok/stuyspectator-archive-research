<html>
<body>
Hello, today is <?php echo date('l, F jS, Y'); ?>.
<table border="1">
<tr>
<th>Location</th>
<th>Server</th>
<th>SSH Online?</th>
</tr>
<tr>
<td>Main</td>
<td>homer.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('homer.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>marge.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('marge.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>bart.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('bart.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>lisa.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('marge.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>duffman.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('duffman.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td>CSLAB1</td>
<td>cslab1-1.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-1.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-2.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-2.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-3.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-3.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-4.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-4.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-5.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-5.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-6.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-6.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-7.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-7.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-8.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-8.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-9.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-9.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-10.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-10.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-11.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-11.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-12.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-12.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-13.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-13.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-14.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-14.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-15.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-15.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-16.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-16.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-17.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-17.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-18.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-18.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-19.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-19.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-20.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-20.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-23.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-23.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-23.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-23.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-24.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-24.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-25.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-25.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-26.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-26.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-27.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-27.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-28.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-28.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-29.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-29.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-30.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-30.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-31.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-31.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-32.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-32.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-33.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-33.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab1-34.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab1-34.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td>CSLAB2</td>
<td>cslab2-1.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-1.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-2.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-2.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-3.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-3.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-4.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-4.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-5.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-5.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-6.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-6.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-7.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-7.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-8.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-8.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-9.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-9.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-10.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-10.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-11.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-11.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-12.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-12.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-13.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-13.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-14.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-14.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-15.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-15.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-16.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-16.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-17.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-17.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-18.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-18.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-19.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-19.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-20.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-20.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-23.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-23.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-23.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-23.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-24.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-24.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-25.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-25.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-26.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-26.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-27.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-27.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-28.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-28.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-29.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-29.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-30.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-30.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-31.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-31.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-32.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-32.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-33.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-33.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
<tr>
<td></td>
<td>cslab2-34.stuy.edu</td>
<td>
	<?php 
		if (fsockopen('cslab2-34.stuy.edu', 22, $errno, $errstr, 1)){  
			echo('<p style="color: green; text-align: center">Online</p>');  
		} else{  
			echo('<p style="color: red; text-align: center">Offline</p>');  
		}
	?>
</td>
</tr>
</table>
</body>
</html>