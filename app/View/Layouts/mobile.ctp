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
		//echo $this->Html->css('jquery.mobile-1.1.0.min.css');
		// echo $this->Html->css('jquery.mobile-1.1.0.min');
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
		<a
			data-icon='arrow-d'
			data-iconpos='notext'
			data-rel='dialog'
			href='#dialog-settings'
		><?php __('Settings');?></a>
	</div>

	<div id='content' data-role="content">
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>
		<?php
			// echo $this->element('sql_dump');
		?>
	</div>
</div>

<div data-role='page' id='dialog-settings'>
	<div data-role='header'>
		<h1><?php echo __('Settings');?></h1>
	</div>
	<div data-role='content'>
		<ul data-role='listview'>
			<li>
			<?php echo $this->Html->link(__('logout'), array(
				'controller'=>'users',
				'action'=>'logout'
			));?>
			</li>
			<li>
				<a href='<?php echo $this->here;?>/layout:default' rel='external'><?php echo __('Desktopversion');?></a>
			</li>
			<li><a href='#dialog-comment' >Kommentar</a></li>
			<li>
			<?php echo $this->Html->link(__('Privacy'),
				array(
					'controller'=>'pages',
					'action'=>'display',
					'datenschutz'
				),
				array(
					'data-rel'=>'dialog'
				)
			);?>
			</li>
		</ul>
	</div>
</div>

<div data-role='page' id='dialog-comment'>
	<div data-role='header'>
		<h1>Kommentieren</h1>
	</div>
	<div data-role='content'>
		<input type='text'></input>
	</div>
</div>
</body>

</html>
