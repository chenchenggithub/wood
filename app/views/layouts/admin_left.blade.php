<div class="slider">
	<ul class="nav web-nav">
		@foreach($menus as $list)
		<li @if(isset($list['active'])) class="active" @endif>
			<a href="{{ $list['url'] }}">
				<div class="slider-icon-block"><span class="slider-icon"></span></div>
				<div class="slider-text">{{ $list['label'] }}</div>
			</a>
		</li>
		@endforeach
	</ul>
</div>
