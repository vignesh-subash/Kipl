<!-- Collect the nav links, forms, and other content for toggling -->
<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
	<ul class="nav navbar-nav">
		<li><a href="{{ url(config('crmadmin.adminRoute')) }}">Dashboard</a></li>
		<?php
		$menuItems = Kipl\Crmadmin\Models\Menu::where("parent", 0)->orderBy('hierarchy', 'asc')->get();
		?>
		@foreach ($menuItems as $menu)
			@if($menu->type == "module")
				<?php
				$temp_module_obj = Module::get($menu->name);
				?>
				@ca_access($temp_module_obj->id)
					@if(isset($module->id) && $module->name == $menu->name)
						<?php echo CAHelper::print_menu_topnav($menu ,true); ?>
					@else
						<?php echo CAHelper::print_menu_topnav($menu); ?>
					@endif
				@endca_access
			@else
				<?php echo CAHelper::print_menu_topnav($menu); ?>
			@endif
		@endforeach
	</ul>
	@if(CAConfigs::getByKey('sidebar_search'))
	<form class="navbar-form navbar-left" role="search">
		<div class="form-group">
			<input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
		</div>
	</form>
	@endif
</div><!-- /.navbar-collapse -->
