@php
	$urls = [
		'dashboard' => [
			'route-name' => 'admin.dashboard',
			'icon' => 'fas fa-chart-line',
			'active-route-list' => ['admin.dashboard']
		],
		'master' => [
			'route-name' => 'admin.master.admin.list',
			'icon' => 'fas fa-user-circle',
			'active-route-list' => [],
			'children' => [
				'admin' => [
					'route-name' => 'admin.master.admin.list',
					'icon' => 'fas fa-users-cog',
					'active-route-list' => ['admin.master.admin.list', 'admin.master.admin.update', 'admin.master.admin.create', 'admin.master.admin.view']
				],
				'user' => [
					'route-name' => 'admin.master.user.list',
					'icon' => 'fas fa-user',
					'active-route-list' => ['admin.master.user.list', 'admin.master.user.update', 'admin.master.user.create', 'admin.master.user.view'],
				],
			],
		],

		'game' => [
			'route-name' => 'admin.game.game.list',
			'icon' => 'fas fa-calendar-alt',
			'active-route-list' => [],
			'children' => [
				'game' => [
					'route-name' => 'admin.game.game.list',
					'icon' => 'fas fa-calendar-alt',
					'active-route-list' => ['admin.game.game.list', 'admin.game.game.update', 'admin.game.game.create', 'admin.game.game.view']
				],
			],
		],
	]
@endphp

@foreach($urls as $key => $url)
	@php
		$isActive = in_array(Route::currentRouteName(), $url['active-route-list']) ? ' active' : '';
		$isChildren = isset($url['children']) ? true : false;
	@endphp
	@if(!$isChildren)
		<li class="nav-item{{$isActive}}">
			<a href="{{ route($url['route-name']) }}" class="nav-link">
				<span style="font-size: 14px;">
					<i class="{{$url['icon']}}"></i> @lang('common.'.$key)
				</span>
			</a>
		</li>
	@else
		@php
			$isActive = '';
			foreach($url['children'] as $childKey => $child) {
				if(in_array(Route::currentRouteName(), $child['active-route-list'])) {
					$isActive =  ' active';
					break;
				}
			}
		@endphp
		<li class="nav-item dropdown{{$isActive}}">
			<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
				<span style="font-size: 14px;">
					<i class="{{$url['icon']}}"></i> @lang('common.'.$key)
				</span>
			</a>
			<ul class="dropdown-menu">
			@foreach($url['children'] as $childKey => $child)
				@php
					$isActiveChild = (in_array(Route::currentRouteName(), $child['active-route-list'])) ? ' active' : '';
				@endphp
				<li>
					<a class="dropdown-item{{$isActiveChild}}" href="{{ route($child['route-name']) }}">
						<span style="font-size: 14px;">
        			<i class="{{$child['icon']}}"></i> @lang('common.'.$childKey)
          	</span>
					</a>
				</li>
			@endforeach
			</ul>
		</li>
	@endif
@endforeach
