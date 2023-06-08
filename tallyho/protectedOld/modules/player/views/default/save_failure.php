<h2> <?php echo Yum::t('Activation did not work'); ?> </h2>

<?php echo $error ;?> <br/><br/><br/>
<?php if($error == -1) echo Yum::t('The user is already activated'); ?>
<?php if($error == -2) echo Yum::t('Wrong activation Key'); ?>
<?php if($error == -3) echo Yum::t('Profile found, but no associated user. Possible database inconsistency. Please contact the System administrator with this error message, thank you'); ?>
<?php if($error == -4) echo Yum::t('Something wrong with the User Model'); ?>
<?php if($error == -5) echo Yum::t('Something wrong with the Player/Contact Model'); ?>
