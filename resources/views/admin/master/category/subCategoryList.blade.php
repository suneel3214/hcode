@foreach($subcategorie as $subcategory)
	<option value="{{$subcategory->catg_id}}" {{(old('parent_id') ?? $oldCatgId) == $subcategory->catg_id ? 'selected' : ''}} >
		{{-- {{!empty($categoryInfo) ? ($categoryInfo->parent_id == $subcategory->catg_id ? 'selected' : '') : ''}} --}}
			@php 
            	// if(count($subcategory->subcategory) ==0){
	            	$i =1;

	            	while ($i <= $dataSpace) {
	            		 echo "&nbsp;"." " ; 
	            		 $i++;
	            	}
	            	echo "-";
            	// }
            @endphp
		{{$subcategory->catg_name}}</option>
		{{-- @if($subcategory->level != 1)
			@if($subcategory->subcategories)
				@include('admin.master.category.subCategoryList',['subcategorie' => $subcategory->subcategories,'dataSpace' =>$dataSpace + 1 ])
			@endif		
		@endif --}}

@endforeach