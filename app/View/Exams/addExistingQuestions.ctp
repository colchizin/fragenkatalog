<?php
	$this->Form->create('Exam');
?>
<table>
<?php
	foreach ($questions as $question):
?>
	<tr>
		<td>
			<input
				type='checkbox'
				name='data[Question][Question][]'
				value="<?php echo $question['Question']['id'];?>"
				id="Question<?php echo $question['Question']['id'];?>"
			>
		</td>
		<td>
			<label
				for="Question<?php echo $question['Quesiton']['id'];?>"
				style="display:block; margin:0px;"
			>
				<?php echo $question['Question']['question'];?>
			</label>
		</td>
	</tr>

<?php
	endforeach;
?>
</table>
<?
	echo $this->Html->link(__('Cancel'),array('action'=>'view'));
	echo $this->Form->submit(__('Save'));
?>

<?php	echo $this->Form->end();?>
