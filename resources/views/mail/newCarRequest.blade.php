<div style="width: 100%; display:block;">
<h2>{{ trans('website.NewProductRequest') }}</h2>
<p>
	<br>
	<strong>{{ trans('labels.Title') }}: {{ $requestData['car_title'] }}</strong><br>  
  {{ trans('website.Price') }}: KD{{ $requestData['price'] }}<br>
  {{ trans('labels.Email') }}: {{ $requestData['request_email'] }}<br>
  {{ trans('labels.Phone') }}: {{ $requestData['phone'] }}<br><br>
	<strong>{{ trans('labels.Sincerely') }}</strong><br>
	{{ $requestData['app_name'] }}
</p>
</div>