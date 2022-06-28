<?php $count = 1; ?>
@foreach($categories as $category )
<tr>
	<td>{{$count++}}</td>
	<td>{{$category->catg_name}}
		<a href="#" url="{{route('category.edit',$category->catg_id)}}" class="editCategory nav-icon i-Pen-2 font-weight-bold"></a>
	</td>
	<td>
		@foreach($category->subcategories as $subcategory )
			{{$subcategory->catg_name}},
		@endforeach 
		<a href="#" url="{{route('subCategoryedit',$category->catg_id)}}" class="editCategory nav-icon i-Pen-2 font-weight-bold">
			
		</a>
	</td>
	<td>
		<a class="text-warning text-white p-2 ml-2 " href="{{route('category.edit',$category->catg_id)}}">
			<i class="nav-icon i-Pen-2 font-weight-bold"></i>
		</a>
		<a class="text-danger text-white p-2 ml-2 " href="{{route('category.destroy',$category->catg_id)}}"><i class="nav-icon i-Close-Window font-weight-bold"></i></a>
		
	</td>
</tr>
@endforeach
							
