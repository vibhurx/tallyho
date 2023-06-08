<?php

class ApiController extends Controller
{

	public function actionUploadPicture($id)
	{
		header('Content-type:application/json');

		$model = Player::model()->findByPk($id);
		$current_picture = $model->picture;

		if($model == null){
			echo CJSON::encode(array("success"=> "false", "reason"=> 'Invalid input: No such player'));
		} else {
			if(isset($_POST)){
			
				$params = 'There is an error. You current parameters are :';
				$keys = 'The keys are : ';
				foreach($_POST as $key => $param) {
					$params = $params . ', ' . $param;
					$keys = $keys . ', ' . $key;
				}
				echo CJSON::encode(array("name"=> "params", "value"=> $params));
				echo CJSON::encode(array("name"=> "keys", "value"=> $keys));
				echo CJSON::encode(array("name"=> "picture_file", "value" => $_POST['picture_file']));
				return;
					
				if(isset($_POST['picture_file'])){
					//$model->attributes = $_POST['Player'];
					$model->picture_file = $_POST['picture_file'];
					$image = CUploadedFile::getInstance($model, 'picture_file');
					$model->picture = $image->name;
					
					/**** Generate guid and create new image name*******/
					$filename = substr($image->name, 0, strrpos($image->name, '.'));
					$extension = strtolower(substr($image->name, strrpos($image->name, '.') + 1));
					
					if($extension == 'jpeg' || $extension == 'jpg'  || $extension == 'gif' || $extension == 'png'){
						$guid = com_create_guid();
						$guid_image_name =  str_ireplace("$filename", "$guid", $image->name);
					
						if($model->save(false, array('picture'))){
							$structure = Yii::app()->basePath . '/../images/' . $model->id . '/';
							if (!file_exists($structure)){
								if (!mkdir($structure, 0777, true)) {
									$image->saveAs($structure . $guid_image_name);
								} else { // meaning there might be an older image in place. delete it.
									unlink(Yii::app()->basePath . '/../images/' . $current_picture);
								}
							} else
								$image->saveAs($structure . $guid_image_name);
							echo CJSON::encode(array("success"=> "true", "message"=> 'The profile picture has been updated.'));
						} else {
							echo CJSON::encode(array("success"=> "false", "reason"=> 'The profile picture could not be uploaded.'));
						}
					} else {
						echo CJSON::encode(array("success"=> "false", "reason"=> 'Invalid input: Only JPG, GIF and PNG files are accepted.'));
					}
				} else {
					echo CJSON::encode(array("success"=> "false", "reason"=> 'The POST method parameters are invalid. Expecting picture_file as the parameter.'));
					$params = 'There is an error. You current parameters are :';
					foreach($_POST as $param)
						$params = $params . ', ' . $param;
					echo CJSON::encode(array("success"=> "false", "reason"=> $params));
					
				}
			} else {
				echo CJSON::encode(array("success"=> "false", "reason"=> 'The API needs to be called with POST method.'));
			}
		}
	}
}