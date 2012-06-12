<?php
	echo $this->Form->create('Question',array('method'=>'post'));
?>
	<ul data-role='listview'>
<?php	foreach ($questions as $question) :?>
		<li>
			<span class='ui-li-count'><?php echo $question[0]['count'];?></span>
			<?php echo $this->Html->link(
				$question['Question']['question'],
				array(
					'action'=>'merge',
					$question['Question']['id']
				)
			);?>
		</li>
<?php 	endforeach;?>
	</ul>
<?php
	
	echo $this->Form->end(__('Merge'));
?>

