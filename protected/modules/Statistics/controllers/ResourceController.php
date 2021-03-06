<?php
class ResourceController extends GController { 
    private $pageSize = 10; 
    /**
     * 资源录入统计
     */
    public function actionInput(){
        $page = max(Yii::app()->request->getParam('page'), 1);
        $search = Yii::app()->request->getParam("search");
        if (empty($search)) {
            $curdate = date("Y-m-d");
            $search['stime'] = $curdate." 00:00:00";
            $search['etime'] = $curdate." 23:59:59";
            $search['eno'] = '';
        }
        $offset = ($page - 1) * $this->pageSize;
        $priv=Userinfo::getPrivCondiForReport();
        $wherestr = "";
        if (!empty($search['stime'])) { 
             $istime = strtotime($search['stime']);
             $wherestr=$wherestr." and c.create_time>=$istime";
        }
        if (!empty($search['etime'])) { 
             $ietime = strtotime($search['etime']);
             $wherestr=$wherestr." and c.create_time<=$ietime";
        }
        if (!empty($search['eno'])) { 
            $wherestr=$wherestr." and u.name like '".$search['eno']."%'";
        }
        $sql = <<<EOF
SELECT 
    u.name, COUNT(*) AS total
FROM
    c_customer_info c left join c_users u on c.creator=u.id 
WHERE
    1=1 $priv $wherestr
GROUP BY u.name     
EOF;
        $criteria = new CDbCriteria();
        $result1 = Yii::app()->db->createCommand($sql)->query();
        $pages = new CPagination($result1->rowCount);

        //获取查询的条数
        $pages->pageSize = $this->pageSize;
        $pages->applyLimit($criteria);
        $result = Yii::app()->db->createCommand($sql . " LIMIT :offset,:limit");
        $result->bindValue(':offset', $pages->currentPage * $pages->pageSize);
        $result->bindValue(':limit', $pages->pageSize);
        $res = $result->queryAll();


        $data = array(
            'pages' => $pages,
            'total' => $result1->rowCount,
            'list' => $res,
            'search' => $search,
        );
        $this->render("input", $data);
    }
    /**
     * 资源录入统计
     */
    public function actionDetail(){
        $page = max(Yii::app()->request->getParam('page'), 1);
        $search = Yii::app()->request->getParam("search");
        if (empty($search)) {
            $curdate = date("Y-m-d");
            $search['stime'] = $curdate." 00:00:00";
            $search['etime'] = $curdate." 23:59:59";
            $search['creator'] = '';
            $search['qq'] = '';
            $search['phone'] = '';
        }
        $offset = ($page - 1) * $this->pageSize;
        $priv=Userinfo::getPrivCondiForReport();
        $wherestr = "";
        if (!empty($search['stime'])) { 
             $istime = strtotime($search['stime']);
             $wherestr=$wherestr." and c.create_time>=$istime";
        }
        if (!empty($search['etime'])) { 
             $ietime = strtotime($search['etime']);
             $wherestr=$wherestr." and c.create_time<=$ietime";
        }
        if (!empty($search['creator'])) { 
            $wherestr=$wherestr." and u.name like '".$search['creator']."%'";
        }
        if (!empty($search['qq'])) { 
            $wherestr=$wherestr." and c.qq like '".$search['qq']."%'";
        }
        if (!empty($search['phone'])) { 
            $wherestr=$wherestr." and c.phone like '".$search['phone']."%'";
        }
        $sql = <<<EOF
SELECT 
    c.cust_name,
    c.shop_name,
    c.shop_url,
    c.shop_addr,
    c.phone,
    c.qq,
    d.name AS category,
    c.mail,
    u.name as username,
    from_unixtime(c.create_time) as create_time
FROM
    c_customer_info c
        LEFT JOIN c_dic d ON c.category = d.code AND d.ctype = 'cust_category'
        LEFT JOIN c_users u ON c.creator = u.id
WHERE
    1=1 
        $priv 
        $wherestr
EOF;
        $criteria = new CDbCriteria(); 
        $result1 = Yii::app()->db->createCommand("select count(*) as cnt from ( $sql ) tmp ")->queryRow(true);
        $pages = new CPagination($result1['cnt']);

        //获取查询的条数
        $pages->pageSize = $this->pageSize;
        $pages->applyLimit($criteria);
        $result = Yii::app()->db->createCommand($sql . " LIMIT :offset,:limit");
        $result->bindValue(':offset', $pages->currentPage * $pages->pageSize);
        $result->bindValue(':limit', $pages->pageSize);
        $res = $result->queryAll();


        $data = array(
            'pages' => $pages,
            'total' => $result1['cnt'],
            'list' => $res,
            'search' => $search,
        );
        $this->render("detail", $data);
    }
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

