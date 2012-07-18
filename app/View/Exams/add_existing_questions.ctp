<?php
	echo $this->Form->create('Exam');
?>

<table>
<?php
	foreach ($questions as $id=>$question):
?>
	<tr>
		<td>
			<input
				type='checkbox'
				name='data[Question][Question][]'
				value="<?php echo $id;?>"
				id="Question<?php echo $id;?>"
			/>
		</td>
		<td>
			<label
				for="Question<?php echo $id;?>"
				style="display:block; margin:0px;"
			>
				<?php echo $question;?>
			</label>
		</td>
	</tr>

<?php
	endforeach;
?>
</table>

<?
	echo $this->Html->link(__('Cancel'),array('action'=>'view'));
	echo $this->Form->end(__('Save'));
?>

<?php 
