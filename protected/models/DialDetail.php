<?php

/**
 * This is the model class for table "{{dial_detail}}".
 *
 * The followings are the available columns in table '{{dial_detail}}':
 * @property string $id
 * @property string $eno
 * @property string $cust_id
 * @property string $extend_no
 * @property string $phone
 * @property integer $dial_time
 * @property double $dial_long
 * @property integer $dial_num
 * @property string $record_path
 * @property integer $isok
 * @property integer $uid
 */
class DialDetail extends CActiveRecord {

    public $user_name;
    public $cust_name;
    public $searchtype;
    public $keyword;
    public $stime; //搜索开始时间
    public $etime; //搜索结束时间
    public $timetype; //时间段 1:昨天，2:最近7天,3:最近30天
    public $dept;
    public $group;
    private $priv_users = array(
        'admin',
        '谭玥',
        '牛祥莉',
        '罗香',
        'jerry',
    );

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{dial_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('dial_time, dial_num, isok', 'numerical', 'integerOnly' => true),
            array('dial_long', 'numerical'),
            array('eno', 'length', 'max' => 10),
            array('record_path', 'length', 'max' => 200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, eno, dial_time, dial_long, dial_num, record_path, isok,stime,etime,timetype', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => '主键',
            'eno' => '工号',
            'cust_id' => '客户id',
            'extend_no' => '分机号',
            'phone' => '电话号码',
            'dial_time' => '拔打时间',
            'dial_long' => '拔打时长',
            'dial_num' => '拔打次数',
            'record_path' => '录音路径',
            'isok' => '是否成功',
            'uid' => '接口id',
            'user_name' => '联系人',
            'cust_name' => '客户名称',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.eno', $this->eno, true);
        $criteria->compare('dial_time', $this->dial_time);
        $criteria->compare('dial_long', $this->dial_long);
        $criteria->compare('dial_num', $this->dial_num);
        $criteria->compare('record_path', $this->record_path, true);
        $criteria->compare('isok', $this->isok);
        //只看到自己的客户,及下属客户 
        $loginuser = Users::model()->findByPk(Yii::app()->user->id);
        if (in_array($loginuser->name, $this->priv_users)) {
            $dept_arr = Userinfo::getAllChildDeptId($loginuser->dept_id);
            $dept_arr[] = $loginuser->dept_id;
            if (!empty($dept_arr) && count($dept_arr) > 0) {
                $wherestr = " t.eno in(select eno from {{users}} where dept_id in(" . implode(",", $dept_arr) . ") )";
                $criteria->addCondition($wherestr);
            }
        } else {
            $user_arr = Userinfo::getAllChildUsersId(Yii::app()->user->id);
            $user_arr[] = Yii::app()->user->id;
            if (!empty($user_arr) && count($user_arr) > 0) {
                $wherestr = Utils::genUserCondition($user_arr);
                if (!empty($wherestr)) {
                    $criteria->addCondition(" exists (select 1 from {{users}} where eno=t.eno and $wherestr)");
                }
            }
        }
        switch ($this->searchtype) {
            case '1':
                $criteria->compare("u.name", $this->keyword, true);
                break;
            case '2':
                $criteria->compare("c.cust_name", $this->keyword, true);
                break;
            case '3':
                $criteria->compare("t.phone", $this->keyword, true);
                break;
        }
        switch ($this->timetype) {
            //昨天
            case '1':
                $starttime = date("Y-m-d",strtotime('-1 day')) . " 00:00:00";  
                $istartTime = strtotime($starttime);
                $criteria->addCondition("t.dial_time>=$istartTime"); 
                $endtime = date("Y-m-d",strtotime('-1 day')) . " 23:59:59";
                $iendTime = strtotime($endtime);
                $criteria->addCondition("t.dial_time<=$iendTime"); 
                break;
            //最近7天
            case '2':
                $starttime = date("Y-m-d",strtotime('-7 day')) . " 00:00:00"; 
                $istartTime = strtotime($starttime);
                $criteria->addCondition("t.dial_time>=$istartTime"); 
                break;
            case '3':
                $starttime = date("Y-m-d",strtotime('-30 day')) . " 00:00:00";
                $istartTime = strtotime($starttime);
                $criteria->addCondition("t.dial_time>=$istartTime"); 
                break;
        }
        if($this->stime){
                $starttime = $this->stime . " 00:00:00";
                $istartTime = strtotime($starttime);
                $criteria->addCondition("t.dial_time>=$istartTime"); 
        }
        if($this->etime){
                $endtime = $this->etime . " 23:59:59";
                $iendTime = strtotime($endtime);
                $criteria->addCondition("t.dial_time<=$iendTime"); 
        }
        if($this->dept){
            $criteria->compare("u.dept_id", $this->dept);
        }
        if($this->group){
            $criteria->compare("u.group_id", $this->group);
        }
        $criteria->join = " left join {{customer_info}} c on t.cust_id=c.id" .
                " left join {{users}} u on t.eno=u.eno";
        $criteria->select = "t.id,t.uid,t.extend_no,u.name as user_name,c.cust_name,t.phone,t.dial_time,t.dial_long,t.record_path";
        $sort = new CSort();
        $sort->attributes = array(
            'defaultOrder' => 't.id desc',
            'id' => array('asc' => 't.id asc', 'desc' => 't.id desc'),
            'user_name' => array('asc' => 'u.name asc', 'desc' => 'u.name desc'),
            'cust_name' => array('asc' => 'c.cust_name asc', 'desc' => 'c.cust_name desc'),
            'phone',
            'dial_time',
            'dial_long',
            'record_path',
        );
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DialDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
