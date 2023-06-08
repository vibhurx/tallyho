<?php
/*
 * 
 */
class ApiController extends Controller
{

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * This action leads to a popup view.
	 */
	public function actionAjaxScheduleUpdate($id)
	{
		$model=new Category;
		$model->tour_id = $tid;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Category'])) {
			$model->attributes=$_POST['Category'];
			//	Stop if duplicate
			$duplicate = Category::model()->find(array(
				'condition' => 'tour_id=:tour_id AND category=:category',
				'params' => array(':tour_id' => $tid, ':category' => $model->category),
			));
			
			if($duplicate == null){
				$tour = $model->tour;	// via relationship
				if($model->start_date >= $tour->start_date || $model->start_date == 0){
					$model->save();
				}
			}
			$this->redirect(Yii::app()->request->urlReferrer);	//@todo: include an error message
		} else {
			$this->renderPartial('create',array(
				'model'=>$model,
			));
		}
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if($this->loadModel($id)->delete()){
		
			//@todo: The corresponding children and grandchildren should be deleted
			// participants based on tour_id and category code
			// matches based on tour_id and category code
			// Important - this is a data-model logic. Should it not go into the model?
			// update: deletion of participants with the category is done
		
		}
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : $this->redirect(Yii::app()->request->urlReferrer)); //array('admin'));
	}


	/**
	 * Displays the draw tree from the matches (or saved data - need to figure out).
	 * @param integer $id the ID of the model to be displayed
	 * Accessed by public, players & organizers
	 */
	public function actionView($id) //THIS IS NOT WORKING 22 JAN 2015
	{
		$category = $this->loadModel($id);
		
		$this->render('view',array(
				'category' => $category
		));
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Category('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Category']))
			$model->attributes=$_GET['Category'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Category the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Category::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Category $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='category-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}