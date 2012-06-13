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
		<dt>Falsch:</dt>
		<dd><?php echo $wrong;?></dd>

		<dt>Gesamt:</dt>
		<dd><?php echo $total;?></dd>
	</dl>
