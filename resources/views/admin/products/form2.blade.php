<div class="row">

	<div class="col-md-6 form-group error-div">
		<label>Select Tag</label><span class="text-danger">*</span><br>
		<select class="form-control required select2-tag" name="tag[]" multiple="multiple">
			<option value="">{{__('Root')}}</option>
			@foreach($tag as $Tag)
				<option class="root" value="{{$Tag->id }}" >{{$Tag->tag_name}}
				</option>
			@endforeach	
		</select>	
		@error('tag')
	        <span class="help-block text-danger font-size-12">
	            <strong>{{ $message }}</strong>
	        </span>
	    @enderror
	</div>
	
	{{-- <div class="col-md-6 form-group">
		<label>Brand</label>
		
		<select class="form-control" name="brand">
			<option value="">Select brand</option>
			@foreach($brands as $brand)
				<option class="root" value="{{isset($brand->brand_id) }}" >{{$brand->name}}</option>
			@endforeach
		</select>	
		
		@error('brand')
	        <span class="help-block text-danger font-size-12">
	            <strong>{{ $message }}</strong>
	        </span>
	    @enderror
	</div> --}}
	
	{{-- <div class="col-md-6 form-group">
		<label>Color</label>
		<input type="color" name="color" multiple="" class="form-control" value="{{ old('color')}}">
		@error('color')
        <p class="help-block text-danger font-size-12">
            <strong>{{ $message }}</strong>
        </p>
	    @enderror
	</div> --}}
	{{-- <div class="col-md-6 form-group">
	<label>Size</label>
		<input type="text" name="size" class="form-control" placeholder="Enter size like X,L,XXL" value="{{old('size')}}" >
		@error('size')
	        <p class="help-block text-danger font-size-12">
	            <strong>{{ $message }}</strong>
	        </p>
	    @enderror
	</div> --}}
	<div class="col-md-6 form-group error-div">
		<label>Product Type</label><span class="text-danger">*</span><br>
		<select name="type"  class="form-control required" >
			<option  value="">Select Type</option>	
			<option  {{isset($product) ? $product->type === 'New' ? 'selected=selected':'':''}}  value="New"  >New</option>	
			<option  {{isset($product) ? $product->type === 'Refurbished' ? 'selected=selected':'':''}} value="Refurbished " >Refurbished </option>	
			<option  {{isset($product) ? $product->type === 'Old' ? 'selected=selected':'':''}} value="Old" >Old</option>	
		</select>	
	
		@error('type')
	        <p class="help-block text-danger font-size-12">
	            <strong>{{ $message }}</strong>
	        </p>
	    @enderror
	</div>
	{{-- <div class="col-md-6 form-group bid_price" style="{{isset($product) ? $product->bid_option ? 'display: inline':'display: none':''}};">
		<label>Bid Start Date</label>
		<input  name="bid_start_date" class="form-control bid_price" id="bid_start_date" placeholder="Enter Bid Start Date" value="{{isset($product) ? $product->bid_start_date ? $product->bid_start_date:'':'' }}">
		@error('bid_start_date')
	        <span class="help-block text-danger font-size-12">
	            <strong>{{ $message }}</strong>
	        </span>
	    @enderror
	</div> --}}
	{{-- <div class="col-md-6 form-group bid_price" style="{{isset($product) ? $product->bid_option ? 'display: inline':'display: none':''}};">
		<label>Bid End Date</label>
		<input name="bid_end_date" id="bid_end_date" class="form-control bid_price" placeholder="Enter Bid End Date" value="{{isset($product) ? $product->bid_end_date ? $product->bid_end_date:'':'' }}">
		@error('bid_end_date')
	        <span class="help-block text-danger font-size-12">
	            <strong>{{ $message }}</strong>
	        </span>
	    @enderror
	</div> --}}
   {{--  <div class="col-md-6 form-group bid_price" style="{{isset($product) ? $product->bid_option ? 'display: inline':'display: none':''}};">
        <label>Bid Price</label>
        <input name="bid_price" id="bid_end_date" class="form-control bid_price" placeholder="Enter Bid Price" value="{{isset($product) ? $product->bid_price ? $product->bid_price:'':'' }}">
        @error('bid_price')
            <span class="help-block text-danger font-size-12">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div> --}}
	<div class="col-md-6 form-group error-div">
		<label>Shipping Option</label><span class="text-danger">*</span><br>
		<select name="shipping_option" id="shipping_option"  class="form-control required"   >
			<option value="">Select option</option>	
			<option {{isset($product) ? $product->shipping_option === 'Available' ? 'selected=selected':'':''}} value="Available" >Available</option>	
			<option {{isset($product) ? $product->shipping_option === 'Not Available' ? 'selected=selected':'':''}} value="Not Available" >Not Available</option>	
		</select>	
		@error('shipping_option')
	        <p class="help-block text-danger font-size-12">
	            <strong>{{ $message }}</strong>
	        </p>
	    @enderror
	</div>
    <div class="col-md-6 form-group shipping_price " style="{{isset($product) ? $product->shipping_option === 'Available' ? 'display: inline':'display: none':'display: none'}};">
        <label>Shipping Price</label>
        <input name="shipping_price" class="form-control required" placeholder="Shipping Price" value="{{isset($product) ? $product->shipping_price ? $product->shipping_price:'':'' }}">
        @error('shipping_price')
            <span class="help-block text-danger font-size-12">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-md-6 form-group error-div">
        <label>Region </label><span class="text">*</span><br>
        <select name="state"  class="form-control province form-control-rounded required js-example-basic-single"   >
            <option value="">Select Region</option>
            @foreach(getAllProvince() as $key => $Citt)
                <option {{isset($product) ? (int)$product->province_id === $Citt->id ? 'selected=selected':'':''}} value="{{$Citt->id}}">{{$Citt->name}}</option>
            @endforeach
        </select>   
        @error('country')
            <p class="help-block text-danger font-size-12">
                <strong>{{ 'This field is required' }}</strong>
            </p>
        @enderror
    </div>
    <div class="col-md-6 form-group error-div">
        <label>District </label><span class="text">*</span><br>
        <select name="city"  class="form-control regions form-control-rounded required js-example-basic-single"   >
            <option value="">Select District</option>
            
        </select>   
        <input type='hidden' value='{{isset($product) ? $product->city:''}}' id="citySelect">

        @error('state')
            <p class="help-block text-danger font-size-12">
                <strong>{{ 'This field is required' }}</strong>
            </p>
        @enderror
    </div>

	<div class="col-md-6 form-group error-div">
		<label>Product Price</label><span class="text-danger">*</span><br>
		<input {{isset($product) ? $product->free_option ? 'disabled=disabled' :'' :''}} type="number" name="price" id="price" class="form-control required" placeholder="Enter Price" value="{{ isset($product) ? $product->price : old('price')}}">
		@error('price')
	        <span class="help-block text-danger font-size-12">
	            <strong>{{ $message }}</strong>
	        </span>
	    @enderror
	</div>
	<div class="col-md-6 form-group error-div">
		<label>Discount In %</label><br>
		<input {{isset($product) ? $product->free_option ? 'disabled=disabled' :'' :''}} id="discount" type="number" name="discount" class="form-control required" placeholder="Enter Product Discount" value="{{ isset($product) ? $product->discount : ''}} ">
		@error('discount')
	        <span class="help-block text-danger font-size-12">
	            <strong>{{ $message }}</strong>
	        </span>
	    @enderror
	</div>	
	<div class="col-md-12 form-group error-div">
		<label>Product Short Description</label><span class="text-danger">*</span><br>
		<textarea style="height: 197px;" type="text" name="short_des" id="short_des" class="form-control required" placeholder="Enter Long Description" >{{ isset($product) ? $product->short_des : old('short_des')}}</textarea>
        <label id="short_des-error" class="text-danger" ></label>
		@error('short_des')
	        <span class="help-block text-danger font-size-12">
	            <strong>{{ $message }}</strong>
	        </span>
	    @enderror
	</div>

	<div class="col-md-12 form-group error-div">
		<label>Product Long Description</label><span class="text-danger">*</span><br>
		<textarea style="height: 197px;" type="text" name="long_des" id="long_des" class="form-control long_des required" placeholder="Enter Long Description" >{{ isset($product) ? $product->long_des : old('long_des')}}</textarea>
        <label id="long_des-error" class="text-danger"></label>
		@error('long_des')
	        <span class="help-block text-danger font-size-12">
	            <strong>{{ $message }}</strong>
	        </span>
	    @enderror
	</div>
	<input type="hidden" name="long_des_hidden" id="long_des_hide" value="">
</div>
@if(isset($product))
    <div class="row deleteimg mb-2 imgSort">
        @php $count = 0; @endphp
        @foreach($product->pro_images as $Img)
            
            <div class="col-md-2 mb-2 imgSingle " data-newid="{{$count++}}" data-oldid="{{$Img->order}}" data-imgID="{{$Img->doc_id}}">
                <div>
                    <a class="deleteImage" url="{{route('delete_image',[$Img->doc_id,$product->pro_id])}}"><i class="nav-icon i-Close-Window font-weight-bold"></i></a>
                </div>
                <span class="imgShow">
                    <img style="height: 100px;" src="{{url('/storage').'/'.$Img->doc_path}}">
                </span> 
            </div>
        @endforeach      
    </div>
@endif    

<style>
.select2-container{
	width: 100% !important;
}
</style>