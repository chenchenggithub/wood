 <div class="u_slider">
	<ul class="nav u_nav" id="__group_ul">
		@foreach($groups as $key => $group)
		<li class=" @if( $key == 0) root_item @endif" value="{{ $group->group_id }}" name="{{$group->group_name}}">
			<a href="#">
				@if( $key == 0)
				<i class="fa fa-home"></i>&nbsp;
				@endif
				{{$group->group_name}}(<span id="__user_num_{{$group->group_id}}">{{$group->user_num}}</span>)
			</a>
			<i class="fa fa-pencil"></i>
		</li>
		@endforeach
	</ul>
	<ul class="nav u_nav">
		<li class="add_depart_btn" id="__add_btn">
			<a href="#"><i class="fa fa-plus"></i>&nbsp;添加新部门</a>
		</li>
		<div class="depart_control" style="display:none;">
			<input class="form-control" type="text" name="group_name" id="group_name" placeholder="输入新部门名称" />
			<a href="#" id="__submit_btn" class="btn btn-blue">保存</a>
			<a href="#" id="__reset_btn" class="btn">取消</a>
		</div>
	</ul>
</div>