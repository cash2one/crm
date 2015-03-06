<?php

/**
 * This is the model class for table "{{users}}".
 *
 * The followings are the available columns in table '{{users}}':
 * @property string $id
 * @property string $eno
 * @property string $pass
 * @property string $name
 * @property string $username
 * @property string $birth
 * @property integer $sex
 * @property string $tel
 * @property string $qq
 * @property integer $dept
 * @property integer $group
 * @property integer $ismaster
 * @property integer $status
 */
class Users extends CActiveRecord
{
    
    
        public $pass_repeat;   //验证密码再次输入
        public $login_time;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{users}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pass, username, tel, dept', 'required'),
			array('sex, dept, group, ismaster, status', 'numerical', 'integerOnly'=>true),
			array('eno', 'length', 'max'=>10),
			array('pass', 'length', 'max'=>50),
			array('name, tel', 'length', 'max'=>20),
			array('username', 'length', 'max'=>30),
			array('qq', 'length', 'max'=>15),
			array('birth, pass_repeat, create_time, login_time', 'safe'),
                        array('pass','compare'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, eno, pass, name, username, birth, sex, tel, qq, dept, group, ismaster, status', 'safe', 'on'=>'search'),
		);
	}

          protected function beforeValidate() {
            if ($this->isNewRecord) {
                // set the create date,
              //  $this->create_time =$this->login_time =  new CDbExpression('NOW()');


            } 
            return parent::beforeValidate();
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
			'eno' => '工号',
			'pass' => '密码',
			'name' => '姓名',
			'username' => '用户名',
			'birth' => '生日',
			'sex' => '性别',
			'tel' => '电话',
			'qq' => 'QQ',
			'dept' => '部门',
			'group' => '组别',
			'ismaster' => '是否精英',
			'status' => '状态',
                        'pass_repeat'=>'重复密码',
                        'login_time'=>'最后登录时间',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                
		$criteria->compare('id',$this->id,true);
		$criteria->compare('eno',$this->eno,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('birth',$this->birth,true);
		$criteria->compare('tel',$this->tel,true);
		$criteria->compare('qq',$this->qq,true);
		$criteria->compare('dept',$this->dept);
		$criteria->compare('group',$this->group);
		$criteria->compare('ismaster',$this->ismaster);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        protected function afterValidate() {
            parent::afterValidate();
            $this->pass = $this->encrypt($this->pass);
         }
         
        public function encrypt($value) {
            return md5($value);
        }
}
