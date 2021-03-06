
 <!DOCTYPE html>
  <html>
    <head>
		<meta charset="utf-8">
		<meta title="{% echo $_appTit; %}">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    @yield('meta.inline')
    @yield('style.files')
    @section('vip.files')
			<script type="text/javascript" src="js/jquery/jquery.js"></script>
			<link type="text/css" rel="stylesheet" href="js/materialize/materializeicon.css"/>
			<link type="text/css" rel="stylesheet" href="js/materialize/materialize.min.css"/>
			<script type="text/javascript" src="js/materialize/materialize.min.js"></script>
			<link type="text/css" rel="stylesheet" href="../mk/js/mk.css"/>
			<link type="text/css" rel="stylesheet" href="../mk/js/mkprint.css" media="print" />
			<script type="text/javascript" src="../mk/js/mk.js"></script>
			<link type="text/css" rel="stylesheet" href="css/css.css" />
		@show
    @yield('style.files')
		<style>
			@yield ('style.inline')
		</style>

	</head>

	<body >
	<div id="loader-wrapper">
      <div id="loader"></div>
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
    </div>
    @if(\Mk\Tools\App::isBuscar()==false)
		<header class="noprinter" style="position: fixed !important;z-index: 1000;background-color: #fff;width: 100%;top:0;">
		@include('navigation')
		</header>
	  @endif
		<div style="margin-top: 184px; clear: all;"> </div>
		<main>
			{!!$template!!}
		</main>

		<footer>
		</footer>
		@yield('div.modales}')
    @yield('js.files}')
		<script>
		$(window).on('load', function() {
		    setTimeout(function() {
		      $('body').addClass('loaded');
		    }, 200);
		  });
			$(document).ready(function(){
        @yield('js.onready')
				$('.dropdown-trigger').dropdown({hover: true});
			});
      @yield('js.inline')
		</script>
	</body>
</html>
