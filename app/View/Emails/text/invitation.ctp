Du hast eine Einladung für ... erhalten. Dein Anmeldelink lautet


<?php echo Router::url(array(
	'controller'=>'users',
	'action'=>'register',
	'token'=>$invitation['Invitation']['token']
), true);?>


Sollte der Link nicht funktionieren, so kannst du dich auch unter <?php echo Router::url(array(
	'controller'=>'users',
	'action'=>'register'
),true);?> mit folgenden Bestätigungscode anmelden:

<?php echo $invitation['Invitation']['token'];?>


Viel Spaß beim Pauken!
