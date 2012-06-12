<?php
/**
 * View/Layout/mobile.ctp
 *
 * Layout für die Darstellung des Fragenkataloges auf mobilen Endgeräten
 * (Mobiltelefonen, Tablets, etc).
 *
 * @author	Johannes Schulze
 * @version	0.1
 */

echo $this->Html->script("jquery-1.7.1.js", array('inline'=>false));
// echo $this->Html->script("jquery-ui-1.8.18.custom.min.js", array('inline'=>false));
echo $this->Html->script("jquery.mobile-1.1.0.min.js", array('inline'=>false));

?>

<html>
<head>
	<?php echo $this->Html->charset();?>
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	<title>
		<?php echo $title_for_layout;?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('http://code.jquery.com/mobile/1.1.0/jquery.mobile-1.1.0.min.css');
//		echo $this->Html->css('jquery.mobile-1.1.0.min');
		echo $this->Html->css('mobile');

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
<div data-role="page">
	<div id='header' data-role="header">
		<a data-rel='back' data-icon='back' data-iconpos='notext'>Zurück</a>
		<h1><?php echo $title_for_layout;?></h1>
		<?php echo $this->Html->link(__('Home'),
			array(
				'controller'=>'pages',
				'action'=>'home'
			),
			array(
				'data-icon'=>'home',
				'data-iconpos'=>'notext'
			)
		);?>
	</div>

	<div id='content' data-role="content">
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>
		<?php
			// echo $this->element('sql_dump');
		?>
	</div>

	<div id="footer" data-role="footer" class='ui-bar'>
		<div data-role="controlgroup" data-type='horizontal'>
<?php
		
		echo $this->Html->link(__('logout'), array(
			'controller'=>'users',
			'action'=>'logout'
		));
		echo $this->Html->link(__('Privacy'),
			array(
				'controller'=>'pages',
				'action'=>'display',
				'datenschutz'
			),
			array(
				'data-rel'=>'dialog'
			)
		);
			
?>
			<a href='<?php echo $this->here;?>/mobile:false' rel='external'><?php echo __('Desktopversion');?></a>
	
		</div>
	</div>
</div>
</body>

</html>
