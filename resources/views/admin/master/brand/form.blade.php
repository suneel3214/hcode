<div class="row">
	<div class="col-sm-12">
		<hr class="my-5">
		<div class="col-md-6 form-group">
			<label>Brand Name</label>
			<input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{isset($brands->brand_id) ? $brands->name : old('name')}}">
			@error('name')
		        <span class="help-block text-danger font-size-12">
		            <strong>{{ $message }}</strong>
		        </span>
		    @enderror
		</div>
	</div>
</div>

