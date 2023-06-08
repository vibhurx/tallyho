	<?php 
		if($profile && !$profile->isNewRecord && $profile->getProfileFields()) {
			$this->widget('zii.widgets.CDetailView', array(
			'data'=>$profile,
			'attributes'=>array(
				array('name' => 'Username', 'value' => $profile->user->username),
				array('name' => 'Name', 'value' => $profile->firstname. ' ' . $profile->lastname),
				'email',
				'phone',
				'street',
				'city',
				'about'	),
			));
		}
	?>
