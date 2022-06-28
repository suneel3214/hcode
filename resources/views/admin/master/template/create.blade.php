
<form  action="{{route('template_store')}}" method="post" autocomplete="off" enctype="multipart/form-data">
	@csrf
	@include('admin.master.template.form')
	<div class="modal-footer" style="justify-content: flex-start;">
	    <button class="btn btn-primary ml-2" type="submit">Save</button>
	</div>
</form>