@include('frontend.partials.header')
<script src="https://code.jquery.com/jquery-3.6.0.js" ></script>
<script src="{{asset('js/jquery.validate.min.js')}}"></script>
<div class="main">
	
  @yield('content')

</div>
<script src="{{asset('js/helper.js')}}"></script>

@include('frontend.partials.footer')