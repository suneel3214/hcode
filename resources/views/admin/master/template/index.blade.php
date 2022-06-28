@extends('layouts.main')
@section('content')
<div class="card text-left">
    <div class="card-body">
    <div class="row">
        <div class="col-md-12">
                <div class="">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title pl-3">Template List</h5>
                        </div>    
                        <div class="col-md-6">
                            <button data-toggle="modal" data-target="#"  type="button" class="btn btn-primary btn-sm float-right mr-3 pull-right addTemplate">Add Template</button>
                        </div>    
                    <div>    
                </div>
                <div class="card-body">
                    <table class="table" id="template_table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Template Name</th>
                                <th>Sequence No</th>
                                <th>Slug</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; @endphp
                            @foreach($templates as $data)
                            <tr>
                                <td>{{ $i++}}</td>
                                <td>{{ $data->name}}</td>
                                <td>{{ $data->sequence_no}}</td>
                                <td>{{ $data->slug}}</td>
                                <td>
                                    
                                    <a class="text-success mr-2 editTemplate" id="{{$data->id}}" data-name="{{$data->name}}" data-id="{{$data->id}}"  data-sequence_no="{{$data->sequence_no}}" data-slug="{{$data->slug}}" ><i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                    </a>
                                    <a class="text-danger" href="{{route('template_delete',$data->id)}}" onclick="return confirm('Are you sure you want to delete?');">
                                    <i class="nav-icon i-Close-Window font-weight-bold"></i>   
                                    </a>
                                    @if($data->id===7)
                                        <a class=" btn-sm text-warning text-white" href="{{ route('assign_category',$data->id) }}">
                               				<i class="nav-icon font-weight-bold i-Add" title="Assign product"></i>
                                        </a>
                                    @else
                                        <a class=" btn-sm text-warning text-white" href="{{ route('assign_product',$data->id) }}">
                                            <i class="nav-icon font-weight-bold i-Add" title="Assign product"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                   
                </div>
        </div>
    </div>
    <div class="modal" id="subjectModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Template</h4>
                    <button type="button" class="close modalClose" >&times;</button>
                </div>
                <div class="modal-body">
                    <form  action="{{route('template.store')}}" method="post">
                    @csrf
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-lg-6 form-group">
                                <label for="name"> Template Name</label>
                                <input type="text" name="name" id="name" class="form-control" >
                                @error('name')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                             
                            <div class="col-md-6 col-sm-6 col-lg-6 form-group">
                                <label for="sequence_no">Sequence No </label>
                                <input type="text" name="sequence_no" id="sequence_no" class="form-control" >
                                @error('sequence_no')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6 form-group">
                                <label for="slug">Slug </label>
                                <input type="text" name="slug" id="slug" class="form-control" >
                                @error('slug')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>    
                            <div class="col-md-12 col-sm-12 col-lg-12 form-group">
                                <input type="hidden" name="flag" value="{{old('flag') ?? 'add'}}"  >
                                <input type="hidden" name="id" value="" value="{{old('id')}}">
                            </div>                            
                        </div>
	                <!-- Modal footer -->
	                <div class="modal-footer">
	                    <button  class="btn btn-primary btn-sm" type="submit" id="btnSubmit">Submit</button>
	                </div>
	                </form>
                    <button type="button" class="btn btn-danger pull-right btn-sm modalClose" >Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Template</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body formhere">
               
            </div>    
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>

<script >
$(document).ready(function(){
	$('.js-example-basic-single').select2();

    $('.addTemplate').on('click',function(e){
        e.preventDefault();
        $('.modal-title').html('Add Subject');
        $('input[name="flag"]').val('add');
        $('input[name="id"]').val('');
        $('input[name="slug"]').val('');
        $('#name').val('');
        $('#sequence_no').val('');
        $
        $('#subjectModal').modal('show');
    });
    $('.modalClose').on('click',function(e){
        e.preventDefault();
        $('#subjectModal').modal('hide');
    });
    $('.editTemplate').on('click',function(e){
        e.preventDefault();
        $('.modal-title').html('Edit Subject');
        $('input[name="flag"]').val('edit');
        $('input[name="id"]').val($(this).attr('id'));
        $('#name').val($(this).data('name'));
        $('#sequence_no').val($(this).data('sequence_no'));
        $('#slug').val($(this).data('slug'));
        
        $('#subjectModal').modal('show');
    });
    
    @if($message = Session::get('success'))
        alert("{{$message}}")
    @endif
    @if($errors->any())
         $('#subjectModal').modal('show');     
    @endif
})
</script>
@endsection
