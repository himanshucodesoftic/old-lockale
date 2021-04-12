<div style="width: 100%; display:block;">
<h2>{{ trans('labels.RequestStatus') }}</h2>
<p>
	<br>    
	{{ trans('labels.Title') }}: {{ $requestData['vendor_title'] }}<br>  
  {{ trans('labels.Message') }}: {{ $requestData['message'] }}<br>  

  @if(!empty($requestData['password']))
  {{ trans('labels.Password') }}: {{ $requestData['password'] }}<br>
  @endif  

	<strong>{{ trans('labels.Sincerely') }},</strong><br>
	
</p>
</div>