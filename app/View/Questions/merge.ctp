<?php
	echo $this->Form->create('Question',array('method'=>'post'));
?>
	<fieldset data-role='controlgroup'>
<?php	foreach ($questions as $question) :?>
		<div>
			<input
				type='Checkbox'
				name="data[Question][id][]"
				id="question_<?php echo $question['Question']['id'];?>"
				value="<?php echo $question['Question']['id'];?>"
			>
			<label
				for="question_<?php echo $question['Question']['id'];?>"
			>
				<?php echo $question['Question']['question'];?> (<?php
					echo $this->Html->link($question['Question']['id'],array(
						'action'=>'view',
						$question['Question']['id']
					));
				?>)
				<ul class='answers'>
				<?php	foreach ($question['Answer'] as $answer): ?>
					<?php var_dump($answer);?>
					<li>
						<?php echo $answer['answer'];?>
						<div class='comments'>
						<?php foreach ($answer['Comment'] as $comment):?>
							<div class='comment'>
								<?php echo $comment['comment'];?>
							</div>
						<?php endforeach;?>
						</div>
					</li>
				<?php	endforeach;?>
				</ul>
				<div class='comments'>
				<?php foreach($question['Comment'] as $comment):?>
					<div class='comment'><?php echo $comment['comment'];?></div>
				<?php endforeach;?>
				</div>
			</label>

		</div>
<?php 	endforeach;?>
<?php	if (isset($this->data['confirm'])):
			echo $this->Form->input('confirm', array(
				'name'=>'data[confirm]',
				'type'=>'checkbox',
				'label'=>__('Confirm Merging')
			));
		endif;
?>
	</fieldset>
<?php
	
	echo $this->Form->end(__('Merge'));
?>

