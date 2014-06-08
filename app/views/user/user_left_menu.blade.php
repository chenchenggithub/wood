<div style="float:left;width:150px;padding:10px 10px;">
    @foreach(UserAdminMenuEnum::$user_left_menu as $k1=>$v1)
    <div style="width:100%;height:30px;line-height:30px;background-color: #ccc;text-align: center;">{{UserAdminMenuEnum::$left_menu_title[$k1]}}</div>
    <ul class="nav nav-pills nav-stacked">
        @foreach($v1 as $k2=>$v2)
        <li @if($k2 == $select_label) class="active" @endif><a href="{{$v2['url']}}">{{$v2['label']}}</a></li>
        @endforeach
    </ul>
    @endforeach
</div>