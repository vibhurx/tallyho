<?php
class SignupForm extends YumUser {
	public $email;
	public $password;
	public $terms; 
	public $verifyCode; // Captcha

	public function rules() 
	{
		$rules = parent::rules();
		$rules[] = array('terms', 'safe');
		if(Yum::module('registration')->enableCaptcha)
			$rules[] = array('verifyCode', 'captcha',
					'allowEmpty'=>CCaptcha::checkRequirements()); 
		return $rules;
	}

	public static function genRandomString($length = 10)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$string ='';    
		for ($p = 0; $p < $length; $p++)
		{
			$string .= $characters[mt_rand(0, strlen($characters)-1)];
		}
		return $string;
	}
}
?>