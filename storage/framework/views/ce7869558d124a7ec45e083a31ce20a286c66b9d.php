<?php $__env->startSection('content'); ?>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="<?php echo e(url('admin/info')); ?>">首页</a> &raquo; 分类管理
    </div>
    <!--面包屑导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>分类列表</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="<?php echo e(url('admin/category/create')); ?>"><i class="fa fa-plus"></i>添加分类</a>
                    <a href="<?php echo e(url('admin/category')); ?>"><i class="fa fa-recycle"></i>全部分类</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th>分类名称</th>
                        <th class="tc">分类标题</th>
                        <th class="tc">URL</th>
                        <th class="tc">点击次数</th>
                        <th class="tc">操作</th>
                    </tr>
                    <?php $__currentLoopData = $cate_tree; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="tc">
                                <input type="text" name="ord[]" value="<?php echo e($v->cate_order); ?>" onchange="editOrder(this, <?php echo e($v->cate_id); ?>)">
                            </td>
                            <td class="tc"><?php echo e($v->cate_id); ?></td>
                            <td class="tc">
                                <a href="#"><?php echo e($v->_cate_name); ?></a>
                            </td>
                            <td class="tc"><?php echo e($v->cate_title); ?></td>
                            <td class="tc"><?php echo e($v->cate_url); ?></td>
                            <td class="tc"><?php echo e($v->cate_view); ?></td>
                            <td class="tc">
                                <a style="float: none;" href="<?php echo e(url('admin/category/'.$v->cate_id.'/edit')); ?>">修改</a>
                                <a style="float: none;" href="javascript:;" onclick="delCate(<?php echo e($v->cate_id); ?>)">删除</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </table>
            </div>
        </div>
    </form>
<!--搜索结果页面 列表 结束-->

<script>
    //修改排序
    function editOrder(obj, cate_id){
        var URL = '<?php echo e(url('admin/cate/changeOrder')); ?>';
        var cate_order = $(obj).val();
        $.post(URL, {'_token':'<?php echo e(csrf_token()); ?>', 'cate_id':cate_id, 'cate_order':cate_order}, function(data){
            if(data.status == 1){
                layer.msg(data.msg, {icon:6});
                setTimeout(function () {
                    window.location.reload();
                }, 3000);
            }else{
                layer.msg(data.msg, {icon:5});
            }
        });
    }

    //删除
    function delCate(cate_id){
        layer.confirm("确定要删除该分类吗？", {
            btn: ["确定","取消"] //按钮
        },  function(){
                var URL = "<?php echo e(url('admin/category')); ?>/" + cate_id;
                $.post(URL, {'_method':'delete', '_token':'<?php echo e(csrf_token()); ?>'}, function(data){
                    if(data.status == 1){
                        layer.msg(data.msg, {icon:6});
                        setTimeout(function () {
                            window.location.reload();
                        }, 2500);
                    }else{
                        layer.msg(data.msg, {icon:5});
                    }
                })
            }, function(){

        });
    }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>