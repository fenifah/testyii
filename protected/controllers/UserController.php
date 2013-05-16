<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	 
	 public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),

			array('allow', // allow all users to perform 'index' and 'view' actions
			'actions'=>array('view','create','captcha'),
			'users'=>array('*'),
			
			/* 	array('deny',  // deny all users
			'users'=>array('*'),
			), */
			
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	/*public function actionCreate()
	{
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	*/
		public function actionCreate()
	{
		$model=new User;

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			
			$dua=User::model()->rans();
			$model->sPass=$model->generateSalt();
			$model->pass=$model->hashPassword($dua,$model->sPass);
			$model->isActive=0;
			
			if($model->save())
			{
				$mailer = Yii::createComponent('application.extensions.mailer.EMailer');
     			$mailer->IsSMTP();
     			$mailer->IsHTML(true);
     			$mailer->SMTPAuth = true;
     			$mailer->SMTPSecure = "ssl";
     			$mailer->Host = "smtp.gmail.com";
     			$mailer->Port = 465;
     			$mailer->Username = "mylovelycode@gmail.com";
     			$mailer->Password = 'mylovelydamncode';
     			$mailer->From = "Admin";
     			$mailer->FromName = "Admin";
     			$mailer->AddAddress($model->email);
     			$isi='Hai '.$model->nama.'<br/> Anda telah melakukan register dengan :<br/>
     			Username  :'.$model->user.'<br/>
     			Password  :'.$dua;
     			$mailer->Subject = "Confirmation.";
     			$mailer->Body = $isi;
     			$mailer->Send();
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
/* 	public function actionKirimemail()
	{
    	$mailer = Yii::createComponent('application.extensions.mailer.EMailer');
     	$mailer->IsSMTP();
     	$mailer->IsHTML(true);
     	$mailer->SMTPAuth = true;
     	$mailer->SMTPSecure = "ssl";
     	$mailer->Host = "smtp.gmail.com";
     	$mailer->Port = 465;
     	$mailer->Username = "fenifah@gmail.com";
     	$mailer->Password = 'bittersweet46';
     	$mailer->From = "Fenifah";
     	$mailer->FromName = "Percobaan Kirim Email";
     	$mailer->AddAddress("fenifah@gmail.com");
     	$mailer->Subject = "Percobaan.";
     	$mailer->Body = "Ini hanya percobaan mengirim email.";
     	if($mailer->Send()) 
     	{
          	echo "Message sent successfully!";
     	}
     	else 
     	{
          echo "Fail to send your message!";
     	}
	} */
	
	public function actionSendmail()
	{
	$mailer = Yii::createComponent('application.extensions.mailer.EMailer');
	$mailer->IsSMTP();
     $mailer->IsHTML(true);
     $mailer->SMTPAuth = true;
     $mailer->SMTPSecure = "ssl";
     $mailer->Host = "smtp.gmail.com";
     $mailer->Port = 465;
     $mailer->Username = "fenifah@gmail.com";
     $mailer->Password = "bittersweet46";
     $mailer->From = "fenifah@gmail.com";
     $mailer->FromName = "Test123";
     $mailer->AddAddress("fenifah@gmail.com");
     $mailer->Subject = "Someone sent you an email.";
     $mailer->Body = "Hi, This is just a test email using PHP Mailer and Yii Framework.";
     if($mailer->Send()) {
          echo "Message sent successfully!";
     }
     else {
          echo "Fail to send your message!";
     }
	 }
	
}
