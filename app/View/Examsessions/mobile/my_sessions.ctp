<?php $this->Html->css('exam', null, array('inline'=>false));?>
<ul data-role="listview">
	<li data-role='list-divider'><?php echo __('Unfinished Exams');?></li>
	<?php foreach ($sessions_unfinished as $session):?>
		
		<li><a href="/fragenkatalog/examsessions/continue_session/<?php echo $session['Examsession']['id'];?>">
			<span class='ui-li-count'>
			<?php echo count($session['ExamsessionsQuestion']);?>
			/
			<?php echo $session['Exam']['question_count'];?>
			</span>
			<h3><?php echo $session['Exam']['Subject']['name'];?></h3>
			<p><?php echo $session['Exam']['shortname'];?></p>
			</a>
		</li>

	<?php endforeach;?>
<li data-role='list-divider'><?php echo __('Finished Exams');?></li>

	<?php foreach ($sessions_finished as $session):?>
		<?php
			$percent = round(($session['Examsession']['correct']/$session['Exam']['question_count'])*100,0);
		?>
		
		<li>
			<span
				class='ui-li-count <?php echo $this->Exam->classByPercentage($percent);?>'
			><?php echo $percent;?> %</span>
			<a href="/fragenkatalog/examsessions/result/<?php echo $session['Examsession']['id'];?>">
			<h3>
				<?php echo $session['Exam']['Subject']['name'];?>
			</h3>
			<p><?php echo $session['Exam']['fullname'];?></p>
			</a>
		</li>

	<?php endforeach;?>
</ul>
