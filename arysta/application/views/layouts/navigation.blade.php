<div class="row">
	<div class="col s3">
		<a href="{{\Mk\Tools\App::routeLink('')}}" class="" >
			<img src="{{\Mk\Tools\App::routeImage('logo.png')}}"	height="100px">
		</a>
	</div>
	<div class="col s6">

	</div>

	<div class="col s3">
		@componente(social)
		@if(isset($_loged))
			<br>({{$_loged['id'].':'.$_loged['user']['nombre']}})
		@endif
		<br>{{"$_controller: $_action"}}<br>

	</div>
</div>

@if(strtoupper($_controller)=='HOME')
	@componente(submenus)
	<ul id="submodulos" class="dropdown-content dropmenu" >
		<?php

		$path = APP_PATH . "/application/modulos";
		$mmm='';
		$iterator = new DirectoryIterator($path);
		foreach ($iterator as $item) {
			if (!$item->isDot() && $item->isDir()) {
				$file=$item->getFilename();
				$mmm=$mmm.'<li><a href = "index.php?url='.$file.'" >'.$file.'</a></li>';
			}
		}
		?>
		{!!$mmm!!}
	</ul>
	<nav>
		<div class="nav-wrapper indigo darken-4">

			<ul class="right hide-on-med-and-down">
				<li><a href="{{\Mk\Tools\App::routeLink('')}}" > home</a></li>
				@componente(menus)
				<li><a class="dropdown-trigger" href="#!" data-target="submodulos" >Modulos<i class="material-icons right">arrow_drop_down</i></a></li>
				<li><a href = "index.php?url=resp/logout" >logout</a></li>
				<li><a href = "index.php?url=resp/login" > login</a></li>

			</ul>
		</div>
	</nav>

@else
	<ul id="submodulos" class="dropdown-content">
		<?php
		$path = APP_PATH . "/application/modulos";
		$mmm='';
		$iterator = new DirectoryIterator($path);
		foreach ($iterator as $item) {
			if (!$item->isDot() && $item->isDir()) {
				$file=$item->getFilename();
				$mmm=$mmm.'<li><a href = "index.php?url='.$file.'" >'.$file.'</a></li>';
			}
		}
		?>
		{!!$mmm!!}
	</ul>
	<nav>
		<div class="nav-wrapper">

			<ul class="right hide-on-med-and-down">
				<li><a href="{{\Mk\Tools\App::routeLink('')}}" > home</a></li>
				<li><a class="dropdown-trigger" href="#!" data-target="submodulos" >Modulos<i class="material-icons right">arrow_drop_down</i></a></li>
				<li><a href = "index.php?url=resp/logout" >logout</a></li>
				<li><a href = "index.php?url=resp/login" > login</a></li>
			</ul>
		</div>
	</nav>

@endif
