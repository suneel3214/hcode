<div class="row">
	<div class="col-sm-12">
		<div class="col-md-12 form-group">
			<label>Section Name</label>
			<input type="text" name="name" class="form-control templte_name" placeholder="Enter Name" value="{{isset($template->name) ? $template->name : old('name')}}">
			@error('name')
		        <span class="help-block text-danger font-size-12">
		            <strong>{{ $message }}</strong>
		        </span>
		    @enderror
			
		</div>
		<div class="col-md-12 form-group">
			<label>Order</label>
			<input type="number" name="sequence_no" class="form-control" placeholder="Enter Order" value="{{isset($template->sequence_no) ? $template->sequence_no : old('sequence_no')}}">
			@error('sequence_no')
		        <span class="help-block text-danger font-size-12">
		            <strong>{{ $message }}</strong>
		        </span>
		    @enderror
			
		</div>
		<div class="col-md-12 form-group">
			<label>Slug</label>
			<input type="text" name="slug" class="form-control templte_slug" placeholder="Enter Slug" value="{{isset($template->slug) ? $template->slug : old('slug')}}">
			@error('slug')
		        <span class="help-block text-danger font-size-12">
		            <strong>{{ $message }}</strong>
		        </span>
		    @enderror
			
		</div>
		<input type="hidden" value="{{isset($template->id) ? $template->id :''}}" name="update_id">
	</div>
</div>

