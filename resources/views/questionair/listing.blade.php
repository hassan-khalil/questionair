@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @include('layouts/alert')
            <div class="panel panel-default">
                <div class="panel-heading">Questionairs <a class="pull-right" href="{{url('questionair/create')}}"> Add questionair</a></div>
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
                               @foreach($questionairObj as $list)
                                  <tr>
                                      <td>{{$list->id}}</td>
                                      <td>{{$list->name}}</td>
                                      <td>{{$list->type()->count()}}</td>
                                      <td>{{$list->DurationTime}}</td>
                                      <td>{{$list->canResume}}</td>
                                      <td>{{$list->published}}</td>
                                      <td> <a href="#">Edit</a> &nbsp;  
                                        @if($list->isPublished())
                                        <a data-id="{{$list->id}}" data-role="delete" href="#" >Delete</a>
                                        @else
                                          Delete
                                        @endif
                                      </td>
                                  </tr>  

                               @endforeach
                           </tbody>
                       </table> 
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts/assets')

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

@endsection
