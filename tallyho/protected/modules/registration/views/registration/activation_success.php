<h1> <?php echo Yum::t('Your account has been activated'); ?> </h1>

<p> <?php Yum::t('Click {here} to go to the login form', array(
			'{here}' => CHtml::link(Yum::t('here'), Yum::module()->loginUrl
				))); ?> </p>
