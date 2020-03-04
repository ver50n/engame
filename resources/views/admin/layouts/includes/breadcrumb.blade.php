@php
	$breadcrumbName = ($routePrefix) ?
		$routePrefix.'.'.Route::getCurrentRoute()->getActionMethod() :
		Route::getCurrentRoute()->getActionMethod();
	$parameter = [$breadcrumbName];
	$parameter = isset($params) ? array_merge($parameter, $params) : $parameter;
@endphp
	{{ call_user_func_array('Breadcrumbs::render', $parameter) }}
