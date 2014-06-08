<div class="main-slider">
	<ul class="nav main-nav">
		@foreach($leftLeafMenu as $key => $menus)
		<li>
			<a href="#">{{ $menuGroup[$key] }}</a>
			<ul class="nav">
				@foreach($menus as $menu)
				<li @if(isset($menu[MenuEnum::ACTIVE])) class="active" @endif>
					<a href="{{ $menu[MenuEnum::URL] }}">{{ $menu[MenuEnum::LABEL] }}</a>
				</li>
				@endforeach
			</ul>
		</li>
		@endforeach
	</ul>
</div>