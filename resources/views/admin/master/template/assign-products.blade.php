@extends('layouts.main')
@section('content')
<div class="card text-left">
    <div class="card-body">
    <div class="row">
        <div class="col-md-12">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-6">
                            <span class="pl-3">Template Name: <strong>{{ $getAssignProducts->name}}</strong> </span>
                        </div>    
                        <div class="col-md-6">
                            <a href="{{route('template.index')}}" class="float-right btn btn-primary pull-right bt-sm mr-3">Back</a>
                        </div>    
                        <div class="col-md-12">
                           @if($message = Session::get('success'))
                            <div class="alert alert-success pull-right btn-sm">
                                {{$message}}
                            </div>
                            @endif
                        </div>    
                    </div>    
                </div>
                <div class="card-body">
                    <form  action="{{route('store_assign_product')}}" method="post">
                    @csrf
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="product_id"> Select Products</label>
                                <?php $selectedPro = []; ?>
                                @foreach($getAssignProducts->get_assign_products as $assignProducts)
                                 @php
                                 $selectedPro [] = $assignProducts->product_id;
                                @endphp
                                   
                                @endforeach
                                <select class="form-control js-example-basic-single" name="product_id[]" multiple="multiple" >
                                	<option value="">Select Products</option>
                                	{{-- @foreach($allProducts as $allProduct)
                                		<option value="{{isset($getAssignProducts->id) ? $allProduct->pro_id : ''}} " {{in_array($allProduct->pro_id, $selectedPro) ? 'selected':''}}>{{$allProduct->name}}</option>
                                	@endforeach --}}
                                    @foreach($allProducts as $allProduct)
                                        <option value="{{ $allProduct->pro_id }} ">{{$allProduct->name}}</option>
                                    @endforeach
                                </select>
                                {{-- <input type="text" name="name" id="name" class="form-control" > --}}
                                @error('product_id')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                             <div class="col-md-12 col-sm-12 col-lg-12 form-group">
                                <input type="hidden" name="template_id" value="{{$templateId}}"  >
                            </div>                            
                        </div>
	                    <button  class="btn btn-success btn-sm" type="submit" id="btnSubmit">Submit</button>
	               </form>            
                 </div>
                <div class="card-body">
                    <table class="table table-hover table-bordered" id="complex_header">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                {{-- <th>Template Name</th> --}}
                                <th>Assign Products</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1; $allPro = []; @endphp
                            @foreach($allProducts as $allProduct)
                            @php
                            $allPro [] = $allProduct->pro_id;
                            @endphp
                            @endforeach
                            @foreach($allProducts as $key => $allProduct)
                                @if(in_array($allProduct->pro_id, $selectedPro))
                                <tr>
                                    <td>{{ $i++}}</td>
                                    {{-- <td>{{ $getAssignProducts->name}}</td> --}}
                                    <td>
                                     {{$allProduct->name}}<br>
                                    </td>
                                    <td>                                       
                                        <a href="{{ route('delete_assign_product',$allProduct->pro_id) }}" class="text-danger" onclick="return confirm('Are you sure you want to delete?');">
                                        <i class="nav-icon i-Close-Window font-weight-bold"></i>   
                                        </a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                     </table>
                    </div>
                </div>
            
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>

<script >

</script>
@endsection
