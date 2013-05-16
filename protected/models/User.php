<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $user
 * @property string $pass
 * @property string $sPass
 * @property string $email
 * @property string $jk
 * @property string $nama
 * @property string $tglLahir
 * @property integer $isActive
 */
class User extends CActiveRecord
{

	public $verifyCode;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user, pass, sPass, email, jk, nama, tglLahir, isActive', 'required'),
			array('isActive', 'numerical', 'integerOnly'=>true),
			array('user, pass, sPass, email, nama', 'length', 'max'=>50),
			array('jk', 'length', 'max'=>6),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user, pass, sPass, email, jk, nama, tglLahir, isActive', 'safe', 'on'=>'search'),
		// verifyCode needs to be entered correctly
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user' => 'User',
			'pass' => 'Pass',
			'sPass' => 'S Pass',
			'email' => 'Email',
			'jk' => 'Jk',
			'nama' => 'Nama',
			'tglLahir' => 'Tgl Lahir',
			'isActive' => 'Is Active',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user',$this->user,true);
		$criteria->compare('pass',$this->pass,true);
		$criteria->compare('sPass',$this->sPass,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('jk',$this->jk,true);
		$criteria->compare('nama',$this->nama,true);
		$criteria->compare('tglLahir',$this->tglLahir,true);
		$criteria->compare('isActive',$this->isActive);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function validatePassword($password)
	{
		return $this->hashPassword($password,$this->sPass)===$this->pass;
	}
	
	public function hashPassword($password,$salt)
	{
		return md5($salt.$password);
	}

	public function generateSalt()
	{
		return uniqid('',true);
	}
	
	public function rans()
        {
    	         $cc = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	         $rr = '';
    	         for ($i = 0; $i < 10; $i++)
                      $rr .= $cc[rand(0, strlen($cc))];
    	        return $rr;
         }
}