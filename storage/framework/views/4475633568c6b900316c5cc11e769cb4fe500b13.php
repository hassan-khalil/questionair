<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php echo $__env->make('layouts/alert', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="panel panel-default">
                <div class="panel-heading">Questionairs <a class="pull-right" href="<?php echo e(url('questionair/create')); ?>"> Add questionair</a></div>
                <div class="panel-body">
                       <table class="table table-bordered"  >
                           <thead>
                               <tr>
                                   <th>Id</th>
                                   <th>Name</th>
                                   <th> Questions</th>
                                   <th>Duration</th>
                                   <th>Resumable</th>
                                   <th>Published</th>
                                   <th>Action</th>
                               </tr>
                           </thead>
                           <tbody>
                               <?php $__currentLoopData = $questionairObj; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <tr>
                                      <td><?php echo e($list->id); ?></td>
                                      <td><?php echo e($list->name); ?></td>
                                      <td><?php echo e($list->type()->count()); ?></td>
                                      <td><?php echo e($list->DurationTime); ?></td>
                                      <td><?php echo e($list->canResume); ?></td>
                                      <td><?php echo e($list->published); ?></td>
                                      <td> <a href="#">Edit</a> &nbsp;  
                                        <?php if($list->isPublished()): ?>
                                        <a data-id="<?php echo e($list->id); ?>" data-role="delete" href="#" >Delete</a>
                                        <?php else: ?>
                                          Delete
                                        <?php endif; ?>
                                      </td>
                                  </tr>  

                               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                           </tbody>
                       </table> 
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $__env->make('layouts/assets', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script>
     $(document).on('click' , 'a[data-role=delete]', function(){

          $tr = $(this).closest('tr');
            //================================================
            var id = $(this).data('id');
            
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, delete it!',
                buttonsStyling: false
            }).then(function() {

              var url   = "questionair/"+id;
              var token = $('meta[name=csrf-token]').attr("content");
              $.ajax({
                        url      : url,
                        method   : 'delete',
                        data     : {_token:token},
                        success  : function(response){
                                   if(response.code  > 0 ){
                                     swal({
                                          title: 'Success!',
                                          text: response.message,
                                          type: 'success',
                                          confirmButtonClass: "btn btn-success",
                                          buttonsStyling: false
                                      })
                                     // table.row($tr).remove().draw();
                                     $tr.remove();
                                   }
                        },
                        error    : function(errorResponse){    
                                   swal({
                                          title: 'Server Error!',
                                          text: errorResponse.message,
                                          type: 'error',
                                          confirmButtonClass: "btn btn-danger",
                                          buttonsStyling: false
                                      });
                        },
              }); 
                
            });
     });

</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>