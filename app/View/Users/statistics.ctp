<?php
	$this->Html->script('lib/jquery.jqplot.min', array('inline'=>'false'));
	$this->Html->css('jquery.jqplot.min', null, array('inline'=>'false'));
?>

<script language="javascript">
	var users_registrations = <?php echo json_encode($users_registrations);?>;
	$(document).ready(function() {
		$.jqplot('graph-users-registrations', users_registrations);	
	});
</script>
<h2>Benutzer</h2>
<div id='graph-users-registrations'>
	<table>
		<thead>
			<tr>
				<th>Datum</th>
				<th>Anzahl</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($users_registrations as $registration):?>
			<tr>
				<td><?php echo $registration[0];?></td>
				<td><?php echo $registration[1];?></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
</div>
