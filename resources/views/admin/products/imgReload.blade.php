@foreach($product->pro_images as $Img)
	<div class="col-md-3 mb-5">
	    <div>
	    	<a class="deleteImage" url="{{route('delete_image',[$Img->doc_id,$productId])}}"><i class="nav-icon i-Close-Window font-weight-bold"></i></a></div>
	    <img style="height: 100px;" src="{{url('/storage').'/'.$Img->doc_path}}">
	</div>
@endforeach	