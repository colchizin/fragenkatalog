<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = "Fragenkatalog";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo __($title_for_layout); ?>
	</title>
	<?php
		echo $this->Html->script("jquery-1.7.1.js");
		echo $this->Html->script("jquery-ui-1.8.18.custom.min");
		echo $this->Html->script("default");
		echo $this->Html->meta('icon');

		echo $this->Html->css('default');
		echo $this->Html->css('jquery.wysiwyg');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<?php
$this->Js->buffer('scrollcontainer = $("#content");');
echo $this->Js->writeBuffer();

?>
<body>
	<div id="container">
		<div id="header">
			<h1>
				<span class='description'><?php echo $cakeDescription; ?>:</span>
				<?php echo __($title_for_layout); ?>
			</h1>
			<div id='userdiv'>
<?php
			if (AuthComponent::user()):?>
				<span id='username'>
					<?php echo $this->Html->link(AuthComponent::user('username'),array(
						'controller'=>'users',
						'action'=>'view_myprofile'
					));?>
				</span>
				<span id='user_login'>
					<?php echo $this->Html->link(
						__('logout'),
						array(
							'controller'=>'users',
							'action'=>'logout'
						)
					);?>
				</span>
<?php		else:?>
				<span id='username'><?php echo __("Guest");?><span>
				<span id='user_login'>
					<?php echo $this->Html->link(
						__('Login'),
						array(
							'controller'=>'users',
							'action'=>'login'
						)
					);?>
				</span>
<?php		endif;
?>
			</div> <!-- End Userdiv !-->
		</div>
		<div id="navigation">
			<a
				id='hide_navigation'
				class='ui-button'
				onclick='
					$("#content").addClass("full_width", "fast");
					$("#navigation").hide("slide","fast");
				'
				title='<?php echo __('Hide sidebar');?>'
			>&lt;</a>
			<ul class='menu'>
				<li><?php echo $this->Html->link(__('Home'), array(
					'controller'=>'pages',
					'action'=>'display',
					'home'
				));?></li>
				<li><?php echo $this->Html->link(__('Universities'), array(
					'controller'=>'universities',
					'action'=>'index'
				));?></li>

				<li class='separator'></li>
<?php			if (AuthComponent::user('programme_id')):?>
					<li><?php echo $this->Html->link(__('My Programme'), array(
						'controller'=>'programmes',
						'action'=>'view',
						AuthComponent::user('programme_id')
					));?></li>	
<?php			endif;?>

				<li><?php echo $this->Html->link(__('My User Profile'), array(
					'controller'=>'users',
					'action'=>'view_myprofile'
				));?></li>
				<li><?php echo $this->Html->link(__('Invite someone'), array(
					'controller'=>'invitations',
					'action'=>'add'
				));?></li>
				<li class='separator'></li>
				<li><?php echo $this->Html->link(__('Report an error'), array(
					'controller'=>'tickets',
					'action'=>'add'
				));?></li>
				<li><?php echo $this->Html->link(__('Errors and Requests'), array(
					'controller'=>'tickets',
					'action'=>'index'
				));?></li>
			</ul>
		</div>
		<div id="content">
			<a
				id='show_navigation'
				class='ui-button'
				onclick='
					$("#navigation").show();
					$("#content").removeClass("full_width","fast");
				'
				title='<?php echo __('Show sidebar');?>'
			>&gt;</a>
			<a
				id='go_fullscreen'
				class='ui-button'
				onclick='switchFullscreen(true)'
			>Vollbild</a>
			<a
				id='leave_fullscreen'
				class='ui-button'
				onclick='switchFullscreen(false)'
			>Vollbild beenden</a>
			<div>		
				<?php echo $this->Session->flash('flash');?>
				<?php echo $this->Session->flash('error',array('class'=>'failure'));?>
				<?php echo $this->Session->flash('auth', array('class'=>'failure'));?>
			</div>

			<?php echo $this->fetch('content'); ?>
			<?php if (AuthComponent::user('group_id') == Configure::read('User.admin_group')) :?>
				<a
					class='ui-button'
					href='javascript:$(".cake-sql-log").toggle("show")'>Sql-Log</a>
				<?php echo $this->element('sql_dump'); ?>
			<?php endif;?>
		</div>
		<div id="footer">
			<?php echo $this->Html->link(
				__('Donate'),
				array(
					'controller'=>'pages',
					'action'=>'display',
					'donate'
				)
			);?>
			<?php echo $this->Html->link(
				__('Privacy'),
				array('controller'=>'pages','action'=>'display','datenschutz')
			);?>
			<a href='<?php echo $this->here;?>/mobile:true'><?php echo __('Mobile Version');?></a>
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
</body>
</html>
