<?php
	$wrong = 0;
	$total = 0;
	foreach ($examsession['ExamsessionsQuestion'] as $esquestion):
		$total++;
?>
	<div class='question'>
		<p><?php echo $total;?>.) <?php echo $esquestion['Question']['question'];?></p>
		<ul class='answers' data-role='listview' data-inset='true'>
			<?php foreach ($esquestion['Question']['Answer'] as $answer):?>
			<li class="answer
			<?php
				if ($esquestion['answer_id'] == $answer['id'] && !$answer['correct']) {
					$wrong ++;
					echo "wrong ";
				}
				echo ($answer['correct']) ? "correct" : "";
			?>"><label><?php echo $answer['answer'];?></label></li>
			<?php endforeach;?>
		</ul>
	</div>
<?php
	endforeach;
?>
	<dl>
		<dt><?php echo __('Correct');?>:</dt>
		<dd><?php echo $examsession['Examsession']['correct'];?></dd>

		<dt><?php echo __('Valid');?>:</dt>
		<dd><?php echo $examsession['Examsession']['valid'];?></dd>

		<dt><?php echo __('Result');?>:</dt>
		<dd>
		<?php
			echo round(
				($examsession['Examsession']['correct']/$examsession['Examsession']['valid'])*100,
				0
			);
		?> %
		</dd>
	</dl>
