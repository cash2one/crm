<?php
	$this->breadcrumbs = array(
		'报表分析' ,
		'售后-新分资源分析',
	);
?>

<div class="row">
    <div class="col-xs-12">     
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'user-form',
            'method' => 'post',
            'action' => $this->createUrl('after/newResource'),
            'htmlOptions' => array(
                'class' => 'form-inline',
                'role' => 'form'
            ),
        ));
        ?> <div class="form-group">
		&nbsp;&nbsp;部门: 
                
                 <?php   
                 echo CHTML::dropDownList("search[dept]", $search['dept'], $this->getDeptArr()); ?>
            </div>
        <input type="hidden" name="isexcel" value="0" id="isexcel"/>
            <div class="form-group">
				&nbsp;&nbsp;时间段: 
                                <input type="text" class="form-control" name="search[stime]" value="<?php echo $search['stime'];?>" placeholder="" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})">
		to  
                <input type="text" class="form-control" name="search[etime]" value="<?php echo $search['etime'];?>" placeholder="" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})">
            </div>
            <div class="form-group"> 
                <button type="button" class="btn btn-info form-control" onclick="sub();">
                    <i class="icon-search"></i>
                    查询
                </button>
            </div>
            <div class="form-group" style="padding-left: 10px; padding-top: 10px;"> 
                <a href="<?php echo $this->createUrl('newresource'); ?>">
                    <i class="icon-undo"></i>
                    取消筛选
                </a>
            </div> 
            <div class="form-group" style="float:right;"> 
                <button type="button" class="btn btn-info form-control" onclick="exportToExcel()">
                    <i class="icon-search"></i>
                    导出excel
                </button>
            </div>
        <?php $this->endWidget(); ?>
        <div class="space-10"></div>
    </div>
    <div class="col-xs-12">
        <table class="table table-bordered table-hover table-striped table-projects">
            <thead>
                <tr> 
                    <th>序号</th>
                    <th>部门</th>
                    <th>合计</th>
                    <th>未处理的分类</th>
                    <th>未处理的分类%</th>
                    <th>3/4/5类</th>
                    <th>3/4/5类%</th>
                    <th>0类</th>
                    <th>0类%</th>
                    <th>1类</th>
                    <th>1类%</th>
                    <th>2类</th>
                    <th>2类%</th>
                    <th>3类</th>
                    <th>3类%</th>
                    <th>4类</th>
                    <th>4类%</th>
                    <th>5类</th>
                    <th>5类%</th>
                    <th>6类</th>
                    <th>6类%</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($list)):
                    foreach ($list as $k => $v):
                        ?>
                        <tr>
                            <td><?php echo $k+1; ?></td>
                            <td><?php echo $v['dept_name']; ?></td>
                            <td><?php echo $v['total']; ?></td>
                            <td><?php echo $v['a']; ?></td>
                            <td><?php echo $v['total']==0?'0%':number_format(100*$v['a']/$v['total'],2).'%'; ?></td>
                            <td><?php echo $v['b']; ?></td>
                            <td><?php echo $v['total']==0?'0%':number_format(100*$v['b']/$v['total'],2).'%'; ?></td>
                            <td><?php echo $v['a0']; ?></td>
                            <td><?php echo $v['total']==0?'0%':number_format(100*$v['a0']/$v['total'],2).'%'; ?></td>
                            <td><?php echo $v['a1']; ?></td>
                            <td><?php echo $v['total']==0?'0%':number_format(100*$v['a1']/$v['total'],2).'%'; ?></td>
                            <td><?php echo $v['a2']; ?></td>
                            <td><?php echo $v['total']==0?'0%':number_format(100*$v['a2']/$v['total'],2).'%'; ?></td>
                            <td><?php echo $v['a3']; ?></td>
                            <td><?php echo $v['total']==0?'0%':number_format(100*$v['a3']/$v['total'],2).'%'; ?></td>
                            <td><?php echo $v['a4']; ?></td>
                            <td><?php echo $v['total']==0?'0%':number_format(100*$v['a4']/$v['total'],2).'%'; ?></td>
                            <td><?php echo $v['a5']; ?></td>
                            <td><?php echo $v['total']==0?'0%':number_format(100*$v['a5']/$v['total'],2).'%'; ?></td>
                            <td><?php echo $v['a6']; ?></td>
                            <td><?php echo $v['total']==0?'0%':number_format(100*$v['a6']/$v['total'],2).'%'; ?></td>
                        </tr>
                        <?php
                    endforeach;
                endif;
                ?>
            </tbody>
        </table>
        <!-- .pagination -->
        <div class="row table-page">
            <div class="col-sm-6"> 
                共<span class="orange"><?php echo $total; ?></span>条记录
            </div>
            <div class="col-sm-6 no-padding-right"> 
            <?php
            $this->widget('GLinkPager', array('pages' => $pages,));
            ?>
            </div>
        </div>
    </div>

</div> <!-- .row -->
<div class="space-20"></div>
 
