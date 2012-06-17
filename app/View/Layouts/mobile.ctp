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

$loggedIn = AuthComponent::user('id');

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
		// echo $this->Html->css('jquery.mobile-1.1.0-rc.1.min');
		echo $this->Html->css('mobile');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<?php

$this->Js->buffer('scrollcontainer = $("body");');
$this->Js->buffer('$.mobile.ajaxEnabled = false;');
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
			data-icon='grid'
			data-iconpos='notext'
			data-rel='dialog'
			href='#dialog-navigation'
		><?php __('Navigation');?></a>
	</div>

	<div id='content' data-role="content">
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>
		<?php
			// echo $this->element('sql_dump');
		?>
	</div>
</div>

<div data-role='page' id='dialog-navigation'>
	<div data-role='header'>
		<h1><?php echo __('Navigation');?></h1>
	</div>
	<div data-role='content'>
		<ul data-role='listview' >
			<?php if ($loggedIn):?>
				<li data-role='list-divider'>Mein Fragenkatalog</li>
				<?php if (AuthComponent::user('programme_id')):?>
				<li data-icon='star'>
					<?php echo $this->Html->link(__('My Programme'), array(
						'controller'=>'programmes',
						'action'=>'view',
						AuthComponent::user('programme_id')
					));?>	
				</li>
				<?php endif;?>

				<li data-icon='star'>
				<?php echo $this->Html->link(__('My Exams'), array(
					'controller'=>'examsessions',
					'action'=>'my_sessions'
				));?>
				</li>
			<?php endif;?>

			<li data-role='list-divider'>Sonstiges</li>
			<li>
				<a href='<?php echo $this->here;?>/layout:default' rel='external'><?php echo __('Desktopversion');?></a>
			</li>
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
			
			<?php if ($loggedIn):?>
				<li data-role='list-divider'></li>
				<li data-icon='delete'>
				<?php echo $this->Html->link(__('logout'), array(
					'controller'=>'users',
					'action'=>'logout'
				));?>
				</li>
			<?php endif;?>
		</ul>
	</div>
</div>
</body>

</html>
