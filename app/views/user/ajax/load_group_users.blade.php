 <div class="user_body">
	<div class="user_list">
		<div class="col add_user_col">
			<div class="add_user_block">
				<input class="form-control" type="text" name="user_email" id="user_email" placeholder="输入Email地址添加新成员到当前部门" />
				<ul class="nav" id="__role_ul">
					@foreach($roles as $role)
					<li value="{{$role->role_id}}">
						<a href="#"><i class="user_icon {{$role->right_tag}}"></i>{{$role->role_name}}</a>
					</li>
					@endforeach
				</ul>
				<input type="hidden" name="group_id" id="__select_group" />
				<input type="hidden" name="role_right" id="__select_role" />
				<a href="#" class="btn btn-blue btn-block" id="__add_user">确定添加</a>
			</div>
		</div>
		<div id="__users_div">
			@foreach($users as $key => $user)
			<div class="col" id="__user_{{$key}}">
				<div class="user_block @if($user->user_status == UserEnum::USER_STATUS_AWAITING_ACTIVATE || $user->user_status == UserEnum::USER_STATUS_DELETED)user_inactive@endif">
					<div class="user_handle">
					@if(UserService::getUserCache()->user_id != $key)
						@if($user->user_status == UserEnum::USER_STATUS_NORMAL)
						<i class="fa fa-pause" onclick="group.modifyUserStatus({{$key}},{{UserEnum::USER_STATUS_PAUSED}});" title="暂停"></i>
						@endif
						@if($user->user_status == UserEnum::USER_STATUS_PAUSED)
						<i class="fa fa-play" onclick="group.modifyUserStatus({{$key}},{{UserEnum::USER_STATUS_NORMAL}});" title="开启"></i>
						@endif
						@if($user->user_status != UserEnum::USER_STATUS_DELETED)
						<i class="fa fa-times" onclick="group.modifyUserStatus({{$key}},{{UserEnum::USER_STATUS_DELETED}});" title="删除"></i>
						@endif
					@endif	
					</div>
					<div class="user_head">
						<img src="/resource/img/admin/user_head.png" class="img-circle" alt="" value="{{$key}}" />
					</div>
					<div class="user_name">{{$user->user_name}}</div>
					<div class="user_status">（{{UserSpall::userStatusLabel($user->user_status)}}）</div>
					<span class="user_mark {{$user->right_tag}}"></span>
				</div>
			</div>
			@endforeach
		</div>
	</div>
	{{$pages->links()}}
</div>