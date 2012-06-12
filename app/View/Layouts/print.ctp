<?php
	$pagetitle = "Fragenkatalog - " . $title_for_layout;
	$this->Html->script("jquery-1.7.1.js", array('inline'=>false));
?>
<html>
	<head>
		<title>
			<?php echo $pagetitle?>
		</title>
		<?php
			echo $this->Html->css('print');
			echo $this->fetch('meta');
			echo $this->fetch('css');
			echo $this->fetch('script');
		?>
	</head>
<?php
	$this->Js->buffer('scrollcontainer = $("body");');
	echo $this->Js->writeBuffer();
?>
	<body>
		<div id='header'>
			<h1><?php echo $pagetitle;?></h1>
		</div>


		<div id='content'>
			<?php echo $this->fetch('content'); ?>
		</div>

		<div id='foot'>
		</div>

	</body>
</html>
