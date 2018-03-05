<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <?php echo $__env->make('layouts/alert', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <form  method="POST" class="form-horizontal" action="<?php echo e(url('questionair')); ?>">
                <div class="panel panel-default">
                    <div class="panel-heading">Create New Questionair</div>
                    <div class="panel-body">
                        <?php echo e(csrf_field()); ?>

                            <div class="form-group <?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                                <div class="col-md-2">
                                    <label for="name" class="control-label"> Name</label>
                                </div>

                                <div class="col-md-10">
                                   <input id="name" value="<?php echo e(old('name')); ?>" name="name" placeholder=" Name" class="form-control" required type="text">
                                    <?php if($errors->has('name')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('name')); ?></strong>
                                            </span>
                                    <?php endif; ?>
                                </div>
                                 
                             </div>

                             <div class="form-group  <?php echo e($errors->has('duration') ? ' has-error' : ''); ?>">
                                 <div class=" col-md-2">
                                    <label for="time" class="control-label">Duration</label>
                                 </div>
                                 <div class="col-md-10">
                                     <div class="input-group">
                                        <input type="number" value="<?php echo e(old('time')); ?>" id="time" name="time" required="required" class="form-control">
                                      
                                        <!-- insert this line -->
                                        <span class="input-group-addon" style="width:0px; padding-left:0px; padding-right:0px; border:none;"></span>
                                      
                                        <select id="" name="duration" class="form-control">
                                            <option <?php echo e(old('duration') == 'Minutes' ? 'selected' : ''); ?> value="Minutes">Minutes</option>
                                            <option <?php echo e(old('duration') == 'Hours' ? 'selected' : ''); ?> value="Hours">Hours</option>
                                        </select>
                                    </div>
                                      <?php if($errors->has('duration')): ?>
                                            <span class="help-block">
                                                <strong><?php echo e($errors->first('duration')); ?></strong>
                                            </span>
                                    <?php endif; ?>
                                 </div>
                             </div>

                             <div class="form-group <?php echo e($errors->has('canResume') ? ' has-error' : ''); ?>">
                                 <div class="col-md-2">
                                     <label >Can Resume?</label>
                                 </div>
                                 <div class="col-md-10">
                                     <div class="col-md-2">
                                          <div class="radio">
                                          <label><input type="radio" <?php echo e(old('canResume') == 'Yes' ? 'checked' : ''); ?> checked value="Yes" name="canResume">Yes</label>
                                        </div>
                                     </div>
                                    <div class="col-md-2">
                                          <div class="radio">
                                          <label><input <?php echo e(old('canResume') == 'No' ? 'checked' : ''); ?> type="radio" value="No" name="canResume">No</label>
                                        </div>
                                     </div>
                                    <?php if($errors->has('duration')): ?>
                                        <span class="help-block">
                                            <strong><?php echo e($errors->first('duration')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                 </div>
                            </div>
                    </div>
                    <div class="panel-footer">
                        <div class="form-group">
                            <div class="col-md-12 ">
                                <button type="button" id="btnQuestionair" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-primary" style="">
                    <div class="panel-heading">
                        <p>Add Questions</p>
                    </div>
                    <div class="panel-body" >
                        <div class="row col-md-12" id="content-area">

                        </div>
                        <br/>
                         <div class="form-group">
                            <div class="col-md-12 ">
                                <button type="button" id="addQuestion" class="btn btn-primary">
                                    Add Question
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary pull-right">Save Questions</button>
                            <button type="button" id="back" class="btn btn-default pull-left">Back</button>
                        </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<input type="hidden" id="counter" value="0">
<?php echo $__env->make('layouts/assets', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<script type="text/javascript">

    $(document).ready(function(){
         $('#btnQuestionair').click(function(){
            if($('#name').val()  == '' && $('#time').val() == '' ){
                $('#name').css('border-color','red');
                $('#time').css('border-color','red');
            }else{
                $('#name').css('border-color','#ccc');
                $('#time').css('border-color','#ccc');
                $('.panel-default').hide();
                $('.panel-primary').show();

            }
         });

        $('#back').click(function(){
             $('.panel-default').show();
                $('.panel-primary').hide();
        }) 


        $('#addQuestion').click(function(){
            var content  = getSelect();

            $('#content-area').append(content);
        });

        $(document).on('change','select',function(){
            var type = $(this).val();

            if(type == 'text'){
                var question  = getTextQuestion();

                $(this).parent().closest('.row').find('div[data-role=question]').remove();
                $(this).parent().closest('.row').append(question);

            } else if( type == 'multiple choice'){
                var choices = getMultipleChoiceQuestion();
                $(this).parent().closest('.row').find('div[data-role=question]').remove();
                $(this).parent().closest('.row').append(choices);
            }  

        });



        $(document).on('click','#addChoice',function(){
               var content = getChoice();
               
               $(this).parent().append(content);
               $(this).remove(); 
        });

        $(document).on('click','#removeChoice',function(){

            $(this).parent().parent().remove();

        });

        $(document).on('click','#remove',function(){
            $(this).closest('div[data-role=question]').parent().remove();
        });



        function getMultipleChoiceQuestion(){
            var counter  = $('#counter').val();
            var content = '<div class="col-md-12" data-role="question"><div class="col-md-12" ><div class="form-group"><div class="col-md-2"><label>Question</label></div><div class="col-md-8"> <input type="text" name="question[]" class="form-control">   </div><div class="col-md-2"><button type="button" class="btn btn-link" id="remove">Remove</button></div></div>  <div class="form-group"><div class="col-md-2"><label>Choice</label></div><div class="col-md-6"> <input type="text" name="choice['+counter+']" class="form-control">   </div><div class="col-md-4"><label><input type="checkbox" name="correct['+counter+']" value="1">Correct</label><button class="btn btn-link" href="#" id="removeChoice">Remove</button></div></div> <button type="button" id="addChoice" class="btn btn-link pull-left">Add Choice</button></div></div>';

                $('#counter').val(parseInt(counter) + 1);                    
            return content;
        }

        function getChoice(){
            var counter  = $('#counter').val();
            var content = '<div class="form-group"><div class="col-md-2"><label>Choice 1</label></div><div class="col-md-6"> <input type="text" name="choice['+counter+']" class="form-control"></div><div class="col-md-4"><label><input type="checkbox" name="correct['+counter+']" value="1">Correct</label><button class="btn btn-link" href="#" id="removeChoice">Remove</button></div></div> <button type="button" id="addChoice" class="btn btn-link pull-left">Add Choice</button>';
            $('#counter').val(parseInt(counter) + 1);
            return content;
        }

        function getTextQuestion(){
            var content = '<div class="col-md-12" data-role="question"> <div class="col-md-10" ><div class="form-group"><div class="col-md-2"><label>Question</label></div><div class="col-md-10"> <input type="text" name="question[]" class="form-control">   </div></div>  <div class="form-group"><div class="col-md-2"><label>Answer</label></div><div class="col-md-10"> <input type="text" name="answer[]" class="form-control"></div></div></div><div class="col-md-2"><button type="button" class="btn btn-link" id="remove">Remove</button></div><div>';

            return content;
        }


        function getSelect(){
            var content = '<div class="row"><div class="form-group"><div class="col-md-2"><label for="type" class="control-label"> Question Type</label></div><div class="col-md-10"><select id="type" name="type[]" class="form-control" ><option >Choose Type</option> <option value="text">Text</option><option value="multiple choice">Multiple Choice</option></select></div></div></div>';
            return content;
        }




    }); 

</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>