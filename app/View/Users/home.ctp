<h2>Hallo <?php echo $user['User']['username'];?></h2>

<h3>Klausur-Sitzungen</h3>
<table>
	<tr>
		<th>Klausur</th>
		<th>Status</th>
<?php
	foreach ($user['Examsession'] as $session):?>
	<tr>
		<td><?php echo $this->Html->link($session['Exam']['fullname'], array(
			'controller'=>'examsessions',
			'action' => 'view',
			$session['id']
		));?></td>
		<td><?php echo ($session['finished'] != null ) ? 'Abgeschlossen' : 'offen';?></td>
	</tr>
	<?php endforeach;?>
