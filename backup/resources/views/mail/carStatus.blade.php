<div style="width: 100%; display:block;">
<h2>{{ trans('labels.RequestStatus') }}</h2>
<p>
	<br>
  <strong>{{ trans('labels.Title') }}: {{ $requestData['car_title'] }}</strong><br>	
  {{ trans('website.Price') }}: KD{{ $requestData['price'] }}<br><br>

  {{ trans('labels.Message') }}: {{ $requestData['message'] }}<br>  

	<strong>{{ trans('labels.Sincerely') }}</strong><br>
	
</p>
</div>