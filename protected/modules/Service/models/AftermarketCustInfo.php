<?php

/**
 * This is the model class for table "{{aftermarket_cust_info}}".
 *
 * The followings are the available columns in table '{{aftermarket_cust_info}}':
 * @property string $id
 * @property integer $cust_id
 * @property integer $cust_type
 * @property string $webchat
 * @property string $ww
 * @property string $eno
 * @property string $assign_eno
 * @property integer $assign_time
 * @property integer $next_time
 * @property integer $memo
 * @property integer $creator
 * @property integer $create_time
 */
class AftermarketCustInfo extends CActiveRecord
{
        public $dept;           //部门
        public $group;          //组别
        public $cust_name;
        public $category_name; 
        public $cust_type_name;
        public $category;
        public $qq;
        public $service_limit;  
        public $createtime_start;
        public $createtime_end;
        public $total_money; 
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{aftermarket_cust_info}}';
	} 
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cust_id, cust_type, webchat, ww, eno, assign_eno, assign_time, next_time, memo, creator, create_time', 'required'),
			array('cust_id, cust_type, assign_time, next_time, memo, creator, create_time', 'numerical', 'integerOnly'=>true),
			array('webchat, ww', 'length', 'max'=>20),
			array('eno, assign_eno', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, cust_id, cust_type, webchat, ww, eno, assign_eno, assign_time, next_time, memo, creator, create_time，dept,group,category', 'safe', 'on'=>'search'),
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
//                    'cust_id'=>array(self::HAS_ONE, 'CustomerInfo', 'id'), 
//                    'cust_type'=>array(self::HAS_ONE, 'CustType', 'id'), 
//                    'service_limit'=>array(self::HAS_ONE, 'ContractInfo', 'cust_id'), 
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
                        'dept'=>'部门',
                        'group'=>'组别',
			'cust_id' => '客户',
			'cust_name' => '客户',
			'cust_type' => '客户分类',
			'webchat' => '微信',
			'ww' => '旺旺',
                        'category' => '类目',
                        'service_limit'=>'服务期限',
			'eno' => '工号',
			'assign_eno' => '分配工号',
			'assign_time' => '分配时间',
			'next_time' => '下次联系时间',
			'memo' => '备注',
			'creator' => '创建人',
			'create_time' => '创建时间',
                        'total_money'=>'金额'
		);
	}

	/** 
	 * 新分客户
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function searchNewList()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;  
		$criteria->compare('c.cust_name',$this->cust_name,true);
		$criteria->compare('ct.type_no',$this->cust_type);
		$criteria->compare('webchat',$this->webchat,true);
		$criteria->compare('ww',$this->ww,true);
		$criteria->compare('c.qq',$this->qq,true); 
		$criteria->compare('u.dept',$this->dept); 
		$criteria->compare('u.group',$this->group);
                $criteria->select="c.id,c.cust_name,t.cust_type,ct.type_name as cust_type_name,c.category,d.name as category_name,c.qq,t.webchat,t.ww,ci.service_limit ";
                $criteria->join=" left join {{customer_info}} c on t.cust_id = c.id ".
                                " left join {{users}} u on t.eno=u.eno ".
                                " left join {{cust_type}} ct on ct.type_no=t.cust_type and ct.lib_type=3 ".
                                " left join {{dic}} d on c.category=d.code and d.ctype='cust_category' ".
                                " left join {{contract_info}} ci on t.cust_id=ci.cust_id ";
                $sort = new CSort();
                $sort->attributes=array(
                    'defaultOrder'=>'id desc',
                    'cust_id'=>array('asc'=>'c.cust_name asc','desc'=>'c.cust_name desc'),
                    'cust_type'=>array('asc'=>'ct.type_name asc','desc'=>'ct.type_name desc'),
                    'qq',
                    'webchat',
                    'ww',
                    'category'=>array('asc'=>'d.name asc','desc'=>'d.name desc'),
                    'service_limit'=>array('asc'=>'ci.service_limit asc','desc'=>'ci.service_limit desc'),
                    
                );
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>$sort,
		));
	}
        /** 
	 * 遗留数据
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function searchOldList()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;  
		$criteria->compare('c.cust_name',$this->cust_name,true);
		$criteria->compare('ct.type_no',$this->cust_type);
		$criteria->compare('webchat',$this->webchat,true);
		$criteria->compare('ww',$this->ww,true);
		$criteria->compare('c.qq',$this->qq,true); 
		$criteria->compare('u.dept',$this->dept); 
		$criteria->compare('u.group',$this->group);
                $criteria->select="c.id,c.cust_name,t.cust_type,ct.type_name as cust_type_name,c.category,d.name as category_name,c.qq,t.webchat,t.ww,ci.service_limit ";
                $criteria->join=" left join {{customer_info}} c on t.cust_id = c.id ".
                                " left join {{users}} u on t.eno=u.eno ".
                                " left join {{cust_type}} ct on ct.type_no=t.cust_type and ct.lib_type=3 ".
                                " left join {{dic}} d on c.category=d.code and d.ctype='cust_category' ".
                                " left join {{contract_info}} ci on t.cust_id=ci.cust_id ";
                $sort = new CSort();
                $sort->attributes=array(
                    'defaultOrder'=>'id desc',
                    'cust_id'=>array('asc'=>'c.cust_name asc','desc'=>'c.cust_name desc'),
                    'cust_type'=>array('asc'=>'ct.type_name asc','desc'=>'ct.type_name desc'),
                    'qq',
                    'webchat',
                    'ww',
                    'category'=>array('asc'=>'d.name asc','desc'=>'d.name desc'),
                    'service_limit'=>array('asc'=>'ci.service_limit asc','desc'=>'ci.service_limit desc'),
                    
                );
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>$sort,
		));
	}
        /** 
	 * 今日联系
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function searchTodayList()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;  
		$criteria->compare('c.cust_name',$this->cust_name,true);
		$criteria->compare('ct.type_no',$this->cust_type);
		$criteria->compare('webchat',$this->webchat,true);
		$criteria->compare('ww',$this->ww,true);
		$criteria->compare('c.qq',$this->qq,true); 
		$criteria->compare('u.dept',$this->dept); 
		$criteria->compare('u.group',$this->group);
                $criteria->select="c.id,c.cust_name,t.cust_type,ct.type_name as cust_type_name,c.category,d.name as category_name,c.qq,t.webchat,t.ww,ci.service_limit ";
                $criteria->join=" left join {{customer_info}} c on t.cust_id = c.id ".
                                " left join {{users}} u on t.eno=u.eno ".
                                " left join {{cust_type}} ct on ct.type_no=t.cust_type and ct.lib_type=3 ".
                                " left join {{dic}} d on c.category=d.code and d.ctype='cust_category' ".
                                " left join {{contract_info}} ci on t.cust_id=ci.cust_id ";
                $sort = new CSort();
                $sort->attributes=array(
                    'defaultOrder'=>'id desc',
                    'cust_id'=>array('asc'=>'c.cust_name asc','desc'=>'c.cust_name desc'),
                    'cust_type'=>array('asc'=>'ct.type_name asc','desc'=>'ct.type_name desc'),
                    'qq',
                    'webchat',
                    'ww',
                    'category'=>array('asc'=>'d.name asc','desc'=>'d.name desc'),
                    'service_limit'=>array('asc'=>'ci.service_limit asc','desc'=>'ci.service_limit desc'),
                    
                );
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>$sort,
		));
	}
        public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;  
		$criteria->compare('c.cust_name',$this->cust_name,true);
		$criteria->compare('ct.type_no',$this->cust_type);
		$criteria->compare('webchat',$this->webchat,true);
		$criteria->compare('ww',$this->ww,true);
		$criteria->compare('c.qq',$this->qq,true); 
		$criteria->compare('u.dept',$this->dept); 
		$criteria->compare('u.group',$this->group);
                $criteria->select="c.id,c.cust_name,t.cust_type,ct.type_name as cust_type_name,c.category,d.name as category_name,c.qq,t.webchat,t.ww,ci.service_limit ";
                $criteria->join=" left join {{customer_info}} c on t.cust_id = c.id ".
                                " left join {{users}} u on t.eno=u.eno ".
                                " left join {{cust_type}} ct on ct.type_no=t.cust_type and ct.lib_type=3 ".
                                " left join {{dic}} d on c.category=d.code and d.ctype='cust_category' ".
                                " left join {{contract_info}} ci on t.cust_id=ci.cust_id ";
                $sort = new CSort();
                $sort->attributes=array(
                    'defaultOrder'=>'id desc',
                    'cust_id'=>array('asc'=>'c.cust_name asc','desc'=>'c.cust_name desc'),
                    'cust_type'=>array('asc'=>'ct.type_name asc','desc'=>'ct.type_name desc'),
                    'qq',
                    'webchat',
                    'ww',
                    'category'=>array('asc'=>'d.name asc','desc'=>'d.name desc'),
                    'service_limit'=>array('asc'=>'ci.service_limit asc','desc'=>'ci.service_limit desc'),
                    
                );
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>$sort,
		));
	}
        
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AftermarketCustInfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}