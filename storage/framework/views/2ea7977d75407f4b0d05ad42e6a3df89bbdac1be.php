<?php $__env->startSection('content'); ?>
  <?php if(session('status')): ?>
    <div class="alert alert-success">
        <?php echo e(session('status')); ?>

    </div>
<?php endif; ?>
<?php if(session('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>
<!-- Small boxes (Stat box) -->
      <div class="row">       
        
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
                <h3></h3>

              <p>Users</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="<?php echo e(url('admin/users')); ?>" class="small-box-footer">View Users<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
            <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><sup style="font-size: 20px"></sup></h3>

              <p>Users Role</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo e(url('admin/roles')); ?>" class="small-box-footer">View roles <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3></h3>

              <p>Global Oriented Test</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="<?php echo e(url('admin/questions')); ?>" class="small-box-footer">View Questions <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3></h3>

              <p>Create Test Question</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="<?php echo e(url('admin/question/create')); ?>" class="small-box-footer">Create question <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-6 ">
          <table class="table table-striped panel">
            <thead>
            <tr>
              <th>This Week:</th>
              <th>Professional Kit</th>
              <th>Global Tool Box</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $weekOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td><?php echo e($key); ?></td>
              <td><?php echo e(isset($order['professional_kit']) ? $order['professional_kit'] : 0); ?></td>
              <td><?php echo e(isset($order['global_tool_query'] ) ? $order['global_tool_query'] : 0); ?></td>
            </tr>
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          </table>
        </div>
        <div class="col-md-6">
          <table class="table table-striped panel">
            <thead>
            <tr>
              <th>This Month:</th>
              <th>Professional Kit</th>
              <th>Global Tool Box</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $monthOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $monthOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td><?php echo e($key); ?></td>
                <td><?php echo e(isset( $monthOrder['professional_kit']) ? $monthOrder['professional_kit'] : ""); ?></td>
                <td><?php echo e(isset( $monthOrder['global_tool_query']) ? $monthOrder['global_tool_query'] : ""); ?></td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
          </table>
        </div>
      </div>
      <!-- /.row (main row) -->
      <!--<p><br><br>TESTING<br></p>
      <div class="row">
        <div class="col-md-6 ">
          <table class="table table-striped panel">
            <thead>
            <tr>
              <th colspan="3">Last CLients</th>
            </tr>
            <tr>
              <th>Id</th>
              <th>Nome</th>
              <th>Cognome</th>
              <th>Data/ora iscrizione</th>
            </tr>
            </thead>
            <tbody>
            
            
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
           
            </tbody>
          </table>
        </div>
        <div class="col-md-6 ">
          <table class="table table-striped panel">
            <thead>
            <tr>
              <th>Id</th>
              <th>Nome</th>
              <th>Cognome</th>
              <th>Data/ora iscrizione</th>
            </tr>
            </thead>
            <tbody>
            
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
           
            </tbody>
          </table>
        </div>
      </div>-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>