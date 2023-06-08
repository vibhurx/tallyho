<?php

/* This file handles a example registration process logic and some of the
 * most used functions for Registration and Activation. It is recommended to
 * extend from this class and implement your own, project-specific 
 * Registration process. If this example does exactly what you want in your
 * Project, then you can feel lucky already! */

Yii::import('application.modules.user.controllers.YumController');
Yii::import('application.modules.user.models.*');
Yii::import('application.modules.profile.models.*');
Yii::import('application.modules.registration.models.*');

class YumRegistrationController extends YumController {
	public $defaultAction = 'registration';

	// Only allow the registration if the user is not already logged in and
	// the function is activated in the Module Configuration
	public function beforeAction($action) {
		if(!Yum::hasModule('registration'))
			throw new CHttpException(401, 'Please activate the registration submodule in your config/main.php. See the installation instructions or registration/RegistrationModule.php for details');
		if(!Yum::hasModule('profile'))
			throw new CHttpException(401, 'The Registration submodule depends on the profile submodule. Please see the installation instructions or registration/RegistrationModule.php for details');

		if(!Yii::app()->user->isGuest) 
			$this->redirect(Yii::app()->user->returnUrl);

		$this->layout = Yum::module('registration')->layout;
		return parent::beforeAction($action);
	}

	public function accessRules() {
		return array(
				array('allow',
					'actions' => array('index', 'registration', 'recovery', 'activation', 'resendactivation'),
					'users' => array('*'),
					),
				array('allow',
					'actions' => array('captcha'),
					'users' => array('*'),
					),
				array('deny', // deny all other users
					'users' => array('*'),
					),
				);
	}

	public function actions() {
		return array(
				'captcha' => array(
					'class' => 'CCaptchaAction',
					'backColor' => 0xFFFFFF,
					),
				);
	}

	/*
	 * an Example implementation of an registration of an new User in the system.
	 *
	 * please see the documentation of yii-user-management for examples on how to
	 * extend from this class and implement your own registration logic in
	 * user/docs/registration.txt
	 */
	public function actionRegistration() {
		// When we override the registrationUrl, this one is not valid anymore!
		if(Yum::module('registration')->registrationUrl != array(
					'//registration/registration/registration'))
			throw new CHttpException(403);

		Yii::import('application.modules.profile.models.*');
		$form = new YumRegistrationForm(); //new SignupForm;
		$profile = new YumProfile;
		$user = new YumUser;
		
		$this->performAjaxValidation('YumRegistrationForm', $form);

		if (isset($_POST['YumRegistrationForm'])) {
			$form->attributes = $_POST['YumRegistrationForm'];
			$profile->attributes = $_POST['YumProfile'];
			
			/* Prefill data */
			$form->username = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_."), 0, 10);
			$form->password = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?"), 0, 8);
			$profile->firstname = $profile->email;
			$profile->lastname = 'Not set'; 
			
			$form->validate();
			$profile->validate();

			if(!$form->hasErrors() && !$profile->hasErrors()) {
// 				$user = new YumUser;
				if($user->register($form->username, $form->password, $profile)){
					$this->sendRegistrationEmail($user, $form->password);
					Yum::setFlash('Thank you for your registration. Please check your email.');
					$this->redirect(Yum::module()->loginUrl);
				}
			}
		}

		$this->render(Yum::module()->registrationView, array(	//registrationView = /registration/registration
					'form' => $form,
					'profile' => $profile,
					'user' => $user, //for error display purpose
		));  
	}
	
	// Send the Email to the given user object. 
	// $user->profile->email needs to be set.
	public function sendRegistrationEmail($user, $password) {
		if (!isset($user->profile->email)) 
			throw new CException(Yum::t('Email is not set when trying to send Registration Email'));

		$activation_url = $user->getActivationUrl();

		$body = strtr('<div style="width:100%">
  <div style="width:20%;float:left;overflow:auto">&nbsp;</div>
  <div style="border:1px solid; font-family: Arial; width:60%; float:left; overflow:auto">
    Hello,
    <p>
      Thanks for registering with Tallyho. <br><br>
    </p>
    <div style="width:100%;text-align:center;">
      <a href="{activation_url}" 
         style="border-radius:5px; height:30px; width:400px; background:steelblue; padding:16px; font-size: 16pt; color: white; text-decoration:none">
        Activate you Account
      </a>
    </div>
    <br></br>
    <div>
      After activation, you can use the following password to use the application - 
      <br><br>
      <div style="width:100%;text-align:center;">
        <span style="border-radius:5px; height:30px; min-width:400px; background:gray; padding:16px; font-size: 16pt;">
              {password}
        </span>
      </div>
    </div>
    <br>
    <div>
      <p>
      Once you have activated your account, you get to update your profile with one of the roles - an organizer, a player or a developer.
      </p>
    </div>
  </div>
</div>', array(
// 					'{username}' => $user->username,
					'{password}' => $password,
					'{activation_url}' => $activation_url));

// 		$mail = array(
// 				'from' => Yum::module('registration')->registrationEmail,
// 				'to' => $user->profile->email,
// 				'subject' => strtr(
// 					'Please activate your account for {username}', array(
// 						'{username}' => $user->username)),
// 				'body' => $body,
// 				);
		
		/* Does not work */
		//$sent = YumMailer::send($mail);
		
		/* New code copied from Contact which works well on BigRock */
		$subject = 'Please activate your new Tallyho account.';
		$to = $user->profile->email;
		$from = Yum::module('registration')->registrationEmail;
		$headers = "From: Tallyho Admin <" . $from . ">\r\n".
				// "Reply-To: " . Yii::app()->params['adminEmail']. "\r\n".
				"MIME-Version: 1.0\r\n".
				"Content-Type: text/html; charset=UTF-8";
		try {
			$mail_sent = mail($to, $subject, $body, $headers);

		} catch(Exception $ex) {
			throw new CException(Yum::t('The verification email could not be sent.'));
			return false;
		}
		return true;
	}

	/**
	 * Activation of an user account. The Email and the Activation key send
	 * by email needs to correct in order to continue. The Status will
	 * be initially set to 1 (active - first Visit) so the administrator
	 * can see, which accounts have been activated, but not yet logged in 
	 * (more than once)
	 */
	public function actionActivation($email, $key) {
		// If already logged in, we dont activate anymore
		if (!Yii::app()->user->isGuest) {
			Yum::setFlash('You are already logged in, please log out to activate your account');
			$this->redirect(Yii::app()->user->returnUrl);
		}

		// If everything is set properly, let the model handle the Validation
		// and do the Activation
		$status = YumUser::activate($email, $key);


		if($status instanceof YumUser) {
			if(Yum::module('registration')->loginAfterSuccessfulActivation) {
				$login = new YumUserIdentity($status->username, false); 
				$login->authenticate(true);
				Yii::app()->user->login($login);	
			} 

			$this->render(Yum::module('registration')->activationSuccessView);
		}
		else
			$this->render(Yum::module('registration')->activationFailureView, array(
						'error' => $status));
	}

	/**
	 * Password recovery routine. The User will receive an email with an
	 * activation link. If clicked, he will be prompted to enter his new
	 * password.
	 */
	public function actionRecovery($email = null, $key = null) {
		$form = new YumPasswordRecoveryForm;

		if ($email != null && $key != null) {
			if($profile = YumProfile::model()->find('email = :email', array(
							'email' =>  $email))) {
				$user = $profile->user;
				if($user->status <= 0)
					throw new CHttpException(403, 'User is not active');
				else if($user->activationKey == $key) {
					$passwordform = new YumUserChangePassword;
					if (isset($_POST['YumUserChangePassword'])) {
						$passwordform->attributes = $_POST['YumUserChangePassword'];
						if ($passwordform->validate()) {
							$user->password = YumEncrypt::encrypt($passwordform->password, $user->salt);
							$user->activationKey = YumEncrypt::encrypt(microtime() . $passwordform->password, $user->salt);
							$user->save();
							Yum::setFlash('Your new password has been saved.');
							if(Yum::module('registration')->loginAfterSuccessfulRecovery) {
								$login = new YumUserIdentity($user->username, false); 
								$login->authenticate(true);
								Yii::app()->user->login($login);
								$this->redirect(Yii::app()->homeUrl);
							}
							else {
								$this->redirect(Yum::module()->loginUrl);
							}
						}
					}
					$this->render(
							Yum::module('registration')->changePasswordView, array(
								'form' => $passwordform));
					Yii::app()->end();
				} else {
					$form->addError('login_or_email', Yum::t('Invalid recovery key'));
					Yum::log(Yum::t(
								'Someone tried to recover a password, but entered a wrong recovery key. Email is {email}, associated user is {username} (id: {uid})', array(
									'{email}' => $email,
									'{uid}' => $user->id,
									'{username}' => $user->username)));
				}
			}
		} else {
			if (isset($_POST['YumPasswordRecoveryForm'])) {
				$form->attributes = $_POST['YumPasswordRecoveryForm'];

				if ($form->validate()) {
					if($form->user instanceof YumUser) {
						if($form->user->status <= 0)	
							throw new CHttpException(403, 'User is not active');
						$form->user->generateActivationKey();
						$recovery_url = $this->createAbsoluteUrl(
								Yum::module('registration')->recoveryUrl[0], array(
									'key' => $form->user->activationKey,
									'email' => $form->user->profile->email));

						Yum::log(Yum::t(
									'{username} successfully requested a new password in the password recovery form. A email with the password recovery url {recovery_url} has been sent to {email}', array(
										'{email}' => $form->user->profile->email,
										'{recovery_url}' => $recovery_url,
										'{username}' => $form->user->username)));

						$mail = array(
								'from' => Yii::app()->params['adminEmail'],
								'to' => $form->user->profile->email,
								'subject' => 'You requested a new password',
								'body' => strtr(
									'You have requested a new password. Please use this URL to continue: {recovery_url}', array(
										'{recovery_url}' => $recovery_url)),
								);
						$sent = YumMailer::send($mail);
						Yum::setFlash(
								'Instructions have been sent to you. Please check your email.');
					} else
						Yum::log(Yum::t(
									'A password has been requested, but no associated user was found in the database. Requested user/email is: {username}', array(
										'{username}' => $form->login_or_email)));
					$this->redirect(Yum::module()->loginUrl);
				}
			}
		}
		$this->render(Yum::module('registration')->recoverPasswordView, array(
					'form' => $form));

	}
}
