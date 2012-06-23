<p>
	Wilkommen in der mobilen Version des <em>Fragenkataloges</em>. Mit wenigen Einschränkungen kannst du hier auf die gleichen Funktionen wie in der Desktop-Version zugreifen. Den Einstieg findest du über die Menüpunkte <em><?php echo __('My Programme');?></em> und <em><?php echo __('My Exams');?></em>.
</p>
<p>
	In der <em>linken</em> oberen Enke findest du eine Zurück-Schaltfläche
	<a data-role='button' data-icon='arrow-l' data-iconpos='notext' data-inline='true'>Menü</a>,
	mit der du eine Ebene nach oben navigieren kannst (z.B.von einer Prüfung zum zugehörigen Fachgebiet).
</p>
<p>
	In der <em>rechten</em> oberen Ecke findest du eine <em>Menü-Schaltfläche</em>
	<a data-role='button' data-icon='grid' data-iconpos='notext' data-inline='true'>Menü</a>,
	mit der du von jeder Seite aus zusätzliche Navigationspunkte aufrufen kannst.
</p>

<ul data-role='listview' data-inset='true' data-theme='b'>
	<li>
		<?php echo $this->Html->link(__('My Exams'),array(
			'controller'=>'examsessions',
			'action'=>'my_sessions'
		));?>
	</li>
	<?php if (!empty($user['User']['programme_id'])):?>
	<li>
		<?php echo $this->Html->link(__('My Programme'), array(
			'controller'=>'programmes',
			'action'=>'view',
			$user['User']['programme_id']
		));?>
	</li>
	<?php endif;?>
</ul>
