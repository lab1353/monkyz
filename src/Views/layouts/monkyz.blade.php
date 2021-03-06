<!doctype html>
<html lang="{{Lang::getLocale()}}">
<head>
	@include('monkyz::partials.head')
	@yield('css')
</head>
<body>
	<div class="wrapper perfect-scrollbar-off">

		<!-- Navigation -->
		<div class="sidebar" data-background-color="brown" data-active-color="warning">
			@include('monkyz::partials.sidebar')
		</div>

		<div class="main-panel" id="scroll-body">
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					@include('monkyz::partials.header')
				</div>
	        </nav>
	        <div class="content">
	            <div class="container-fluid">
					@include('monkyz::partials.messages')

					@yield('content')
				</div>
			</div>
            <footer class="footer">
                <div class="container-fluid">
					@include('monkyz::partials.footer')
                </div>
            </footer>
	    </div>
	</div>

	@include('monkyz::partials.scripts')
	@yield('scripts')
</body>
</html>
