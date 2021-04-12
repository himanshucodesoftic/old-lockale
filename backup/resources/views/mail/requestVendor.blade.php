<div style="width: 100%; display:block;">
<h2>{{ trans('labels.New Request') }}</h2>
<p>
	<br>
	{{ trans('labels.Title') }}: {{ $requestData['vendor_title'] }}<br>
  {{ trans('labels.Customer Name') }}: {{ $requestData['customer_name'] }}<br>
  {{ trans('labels.Email') }}: {{ $requestData['request_email'] }}<br>
  {{ trans('labels.Phone') }}: {{ $requestData['phone'] }}<br>
	{{ trans('labels.Address') }}: {{ $requestData['address'] }}<br><br>	
	<strong>{{ trans('labels.Sincerely') }},</strong><br>
	{{ $requestData['app_name'] }}
</p>
</div>