<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo __($title_for_layout); ?>
	</title>
	<?php
		echo $this->Html->css('dialog');
		echo $this->Html->script("jquery-1.7.1.js");

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<?php echo $this->fetch('content'); ?>
</body>
</html>
