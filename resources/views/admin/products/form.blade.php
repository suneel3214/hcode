<div class="row">
	<hr class="my-15">
	<div class="col-md-6 form-group error-div">
		<label>Product Name</label><span class="text-danger">*</span><br>
		<input type="text" name="name" class="form-control required" placeholder="Enter Name" value="{{isset($product) ? old('name') ? old('name'):  $product->name:'' }} ">
		@error('name')
	        <span class="help-block text-danger font-size-12">
	            <strong>{{ $message }}</strong>
	        </span>
	    @enderror
	</div>
	{{-- <div class="col-md-6 form-group error-div bid-div">
		<label>Bid Option</label><span class="text-danger">*</span><br>
		<select name="bid_option" id="bid_option" class="form-control bid_option required"   >
			<option {{isset($product) ? $product->bid_option ? 'selected=selected' :'' :''}} class="form-group" value="Yes" >Yes</option>	
			<option {{isset($product) ?  !$product->bid_option ? 'selected=selected' :'' :'selected=selected'}} class="form-group" value="No" >No</option>	
		</select>	
		@error('bid_option')
	        <p class="help-block text-danger font-size-12">
	            <strong>{{ $message }}</strong>
	        </p>
	    @enderror
	</div> --}}
	{{-- <div class="col-md-6 form-group ">
		<label>Product Short Name</label>
		<input type="text" name="shrt_name" class="form-control" placeholder="Enter Name" value="{{old('shrt_name')}}">
		@error('shrt_name')
	        <span class="help-block text-danger font-size-12">
	            <strong>{{ $message }}</strong>
	        </span>
	    @enderror
	</div> --}}
	<div class="col-md-6 form-group error-div cart-div">
		<label>Add To Cart Option</label><span class="text-danger">*</span><br>
		<select id="add_to_cart" name="add_to_cart_option"  class="form-control required"   >
			<option {{ isset($product) ? $product->add_to_cart_option ? 'selected=selected' :'':'' }} value="Yes" >Yes</option>	
			<option {{isset($product) ? !$product->add_to_cart_option ?  'selected=selected' :'':'' }} value="No" >No</option>	
		</select>	
		@error('add_to_cart_option')
	        <p class="help-block text-danger font-size-12">
	            <strong>{{ $message }}</strong>
	        </p>
	    @enderror
	</div>
	<div class="col-md-6 form-group free-div" style="{{isset($product) ? $product->bid_option ? 'display: none':'display: inline':'display: none'}}">
		<label>Free</label>
		<select id="free" name="free_option"  class="form-control"   >
			<option {{isset($product) ? $product->free_option ? 'selected=selected' :'':'' }} value="Yes" >Yes</option>	
			<option {{isset($product) ? !$product->free_option ? 'selected=selected' :'':'selected=selected	' }} value="No" >No</option>	
		</select>	
		
	</div>
	
	<div class="col-md-6 form-group error-div">
		<label>Select Category</label><span class="text-danger">*</span><br>
		<select id="category" class="form-control required " placeholder="Select Category" name="catg_id">
			<option value="">Select...</option>
			@foreach($categories as $category)
			<option class="root" {{isset($catIds) ? $catIds === $category->catg_id ? 'selected=selected' :'' :''}} value="{{$category->catg_id }}" >{{$category->catg_name}}</option>
			@endforeach

		</select>	
		@error('catg_id')
	        <span class="help-block text-danger font-size-12">
	            <strong>{{ $message }}</strong>
	        </span>
	    @enderror
	</div>
	<div class="col-md-6 form-group error-div">
		<label>Select SubCategory</label><br>
		<select class="form-control required subcatg_id" placeholder="Select Sub-Category" name="subcatg_id" >
			<option class="root" value="" >Select...</option>
		</select>	
		@error('subcatg_id')
	        <span class="help-block text-danger font-size-12">
	            <strong>{{ $message }}</strong>
	        </span>
	    @enderror
	</div>
	<div class="col-md-6 form-group error-div">
		<label>Quantity</label><span class="text-danger">*</span><br>
		<input type="number" name="qty" class="form-control required" placeholder="Enter Quantity" value="{{isset($product) ? old('qty') ? old('qty') :  $product->qty : '' }}">
		@error('qty')
	        <span class="help-block text-danger font-size-12">
	            <strong>{{ $message }}</strong>
	        </span>
	    @enderror
	</div>
</div>