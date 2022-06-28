<div class="row">
	<hr class="my-15">
	<div class="col-md-6 form-group">
		<label>Category/SubCategory Name</label>
		<input type="text" name="catg_name" id="catg_name" class="form-control catg_name" placeholder="Enter Category/SubCategory Name" value="{{isset($category1->catg_id) ? $category1->catg_name : old('catg_name')}}">
		@error('catg_name')
	        <span class="help-block text-danger font-size-12">
	            <strong>{{ $message }}</strong>
	        </span>
	    @enderror
	</div>
		@if(isset($type) && $type === 'subCategory')
			<div class="col-md-6 form-group">
				<label>Category</label>
				<select name="parent_id" class="form-control">
					<option value="">Select Category</option>
					@foreach($categories as $Cate)
						<option {{isset($category1) ? $category1->parent_id === $Cate->catg_id ? 'selected=selected':'':''}} value="{{$Cate->catg_id}}">{{$Cate->catg_name}}</option>
					@endforeach
				</select>
				@error('parent_id')
			        <span class="help-block text-danger font-size-12">
			            <strong>{{ $message }}</strong>
			        </span>
			    @enderror
			</div>
		@endif	
		@if(isset($category1) && $category1->parent_id !== null)
			<div class="col-md-6 form-group">
				<label>Category</label>
				<select name="parent_id" class="form-control">
					<option value="">Select Category</option>
					@foreach($categories as $Cate)
						<option {{$category1->parent_id === $Cate->catg_id ? 'selected=selected':''}} value="{{$Cate->catg_id}}">{{$Cate->catg_name}}</option>
					@endforeach
				</select>
				@error('parent_id')
			        <span class="help-block text-danger font-size-12">
			            <strong>{{ $message }}</strong>
			        </span>
			    @enderror
			</div>
		@endif	
	<div class="col-md-6 form-group">
		<label>Icon</label>
		<input type="text" name="icon" class="form-control" placeholder="Enter Category/SubCategory Name" value="{{isset($category1->icon) ? $category1->icon : old('icon')}}">
		@error('icon')
	        <span class="help-block text-danger font-size-12">
	            <strong>{{ $message }}</strong>
	        </span>
	    @enderror
	</div>
	<div class="col-md-6 form-group">
		<label>Slug</label>
		<input type="text" name="slug" id="slug" class="form-control slug" placeholder="Slug" value="{{isset($category1->slug) ? $category1->slug : old('slug')}}">
		@error('slug')
	        <span class="help-block text-danger font-size-12">
	            <strong>{{ $message }}</strong>
	        </span>
	    @enderror
	</div>
	@if(!isset($category1->image))
		<div class="col-md-6 form-group">
			<label>Image</label>
			<input type="file" name="image" id="slug" class="form-control " >
			@error('image')
		        <span class="help-block text-danger font-size-12">
		            <strong>{{ $message }}</strong>
		        </span>
		    @enderror
		</div>
	@else
		<div class="col-md-3 form-group">
			<label>Image</label>
			<input type="file" name="image" id="image" class="form-control " >
			@error('image')
		        <span class="help-block text-danger font-size-12">
		            <strong>{{ $message }}</strong>
		        </span>
		    @enderror
		</div>
		<div class="col-md-3 form-group">
			<img class="cateImage" src="{{asset('/storage/'.$category1->image->doc_path)}}">
		</div>
	@endif		
		
</div>
<style>
.cateImage{
	 height: 76px;
    margin-top: 18px;
    margin-left: 123px;
}
</style>

<script>
	$(document).on('keyup','#catg_name',function(){
		var catg_name = $(this).val()
		catg_name=catg_name.replace(" ","_").toLowerCase();
		$('#slug').val(catg_name)
	})
</script>