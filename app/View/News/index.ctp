<?php
	$this->Html->css('news',null, array('inline'=>false));
	$this->Html->script('comment', array('inline'=>false));
	$this->Html->script('news', array('inline'=>false));
?>
<div class="news index">
	<h2><?php echo __('News');?></h2>
	<?php
	foreach ($news as $news): ?>
	<div class='news-entry' id='news_<?php echo $news['News']['id'];?>'>
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
	</div>
<?php endforeach; ?>

	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
