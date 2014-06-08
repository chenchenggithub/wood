<table class="table table-striped">
	<thead>
		<tr>
			<td>公司名称</td>
			<td>申请时间</td>
			<td>网站链接</td>
			<td>所在行业</td>
			<td>联系人</td>
			<td>手机</td>
			<td>状态</td>
			<td>操作</td>
		</tr>
	</thead>
	<tbody>
		@foreach($lists as $list)
		<tr id="__user_{{ $list->register_id }}">
			<td>{{ $list->company_name }}</td>
			<td>{{ date('Y-m-d H:i:s',$list->register_time) }}</td>
			<td>{{ $list->company_url }}</td>
			<td>{{ $company_industry[$list->company_industry] }}</td>
			<td>{{ $list->user_name }}</td>
			<td>{{ $list->user_mobile }}</td>
			<td>{{ UserSpall::registerStatusLabel($list->register_status) }}</td>
			<td>
				@if($list->register_status == UserEnum::REGISTER_STATUS_NORMAL)
				<a href="" onclick="passRegister({{ $list->register_id }});return false;">审核通过</a>
				<a href="" onclick="failRegister({{ $list->register_id }});return false;">审核失败</a>
				@elseif($list->register_status == UserEnum::REGISTER_STATUS_FAIL)
				<a href="" onclick="passRegister({{ $list->register_id }});return false;">审核通过</a>
				@endif
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
{{ $pages->links() }}
