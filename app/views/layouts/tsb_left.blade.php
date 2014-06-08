@section('tsb_left')
<div class="slider">
   <ul class="nav web-nav">
        @foreach($leftMenus as $menu)
        <li @if(isset($menu['active'])) class="active" @endif>
            <a href="{{ $menu['url'] }}">
                <div class="slider-icon-block"><span class="slider-icon"></span></div>
                <div class="slider-text">{{ $menu['label'] }}</div>
            </a>
        </li>
        @endforeach
    </ul>
</div>
@stop