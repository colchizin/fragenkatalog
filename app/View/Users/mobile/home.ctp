<?php
	$this->Html->script('comment', array('inline'=>false));
	$this->Html->script('news', array('inline'=>false));
	$this->Html->css('news',null, array('inline'=>false));
?>	
<p>
	Wilkommen in der mobilen Version des <em>Fragenkataloges</em>. Mit wenigen Einschränkungen kannst du hier auf die gleichen Funktionen wie in der Desktop-Version zugreifen. Den Einstieg findest du über die Menüpunkte <em><?php echo __('My Programme');?></em> und <em><?php echo __('My Exams');?></em>.
</p>
<p>
	In der <em>linken</em> oberen Enke findest du eine Zurück-Schaltfläche
	<a data-role='button' data-icon='arrow-l' data-iconpos='notext' data-inline='true'>Menü</a>,
	mit der du eine Ebene nach oben navigieren kannst (z.B.von einer Prüfung zum zugehörigen Fachgebiet).
</p>
<p>
	In der <em>rechten</em> oberen Ecke findest du eine <em>Menü-Schaltfläche</em>
	<a data-role='button' data-icon='grid' data-iconpos='notext' data-inline='true'>Menü</a>,
	mit der du von jeder Seite aus zusätzliche Navigationspunkte aufrufen kannst.
</p>

<h2><?php echo __('News');?></h2>

	<div class='news-entry info news' id='news_<?php echo $news['News']['id'];?>'>
		<span style='float:right'></span>
		<h3><?php echo h($news['News']['title']);?></h3>
		<p class='news-metadata'>
			<?php echo __('created by');?>
			<?php echo $this->Html->link($news['User']['username'], array(
				'controller' => 'users',
				'action' => 'view',
				$news['User']['id']
			));?>
			<?php echo __('on');?>
			<?php echo $news['News']['created'];?>
		</p>
		<div class='news-content'>
			<?php echo $news['News']['description'];?>
		</div>
		<div class='comments'>
			<?php foreach ($news['HasComment'] as $comment):?>
			<div class='comment'>
				<p>
					<?php echo $comment['Comment']['comment'];?>
					<span class='comment-author'><?php echo $comment['Comment']['User']['username'];?></span>
				</p>
			</div>
			<?php endforeach;?>
		</div>
		<div style='position:relative' class='comment-field' id='comment-field-<?php echo $news['News']['id'];?>'>
			<textarea placeholder='<?php echo __('comment');?>'></textarea>
			<button class='btn-comment-submit'
				onclick='submitNewsComment(
					<?php echo $news['News']['id'];?>,
					$(commentFieldNamePrefix + <?php echo $news['News']['id'];?>)
				);'
			>
				<?php echo __('comment');?>
			</button>
		</div>
		<?php echo $this->Html->link(
			__('All news entries'),
			array(
				'controller'=>'news',
				'action'=>'index'
			),
			array(
				'data-role' => 'button'
			)
		);?>
	</div>

<ul data-role='listview' data-inset='true' data-theme='b'>
	<li>
		<?php echo $this->Html->link(__('My Exams'),array(
			'controller'=>'examsessions',
			'action'=>'my_sessions'
		));?>
	</li>
	<?php if (!empty($user['User']['programme_id'])):?>
	<li>
		<?php echo $this->Html->link(__('My Programme'), array(
			'controller'=>'programmes',
			'action'=>'view',
			$user['User']['programme_id']
		));?>
	</li>
	<?php endif;?>
</ul>
