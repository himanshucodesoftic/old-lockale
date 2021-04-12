@extends('web.layout')
@section('content')

<section class="pro-content empty-content bg_gray" style="padding-bottom: 100px;">
  <div class="container">

    <div class="row justify-content-center" style="text-align: center;">
      <div class="col-md-5">
        <div id="confirm">
          <div class="icon icon--order-success svg add_bottom_15">
            <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72">
              <g fill="none" stroke="#8EC343" stroke-width="2">
                <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;">
                </circle>
                <path d="M17.417,37.778l9.93,9.909l25.444-25.393"
                  style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
              </g>
            </svg>
          </div>
          <h2>@lang('website.Thank You')</h2>
          <p>@lang('website.You have successfully place your order')</p>
          <a href="{{url('/view-order/'.session('orders_id'))}}" class="btn-link"><b>@lang('website.View Order Detail')</b></a>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- <div class="col-12">
        <div class="pro-empty-page">
          <h2 style="font-size: 150px;"><i class="far fa-check-circle"></i></h2>
          <h1>@lang('website.Thank You')</h1>
          <p>
            @lang('website.You have successfully place your order')
            <a href="{{url('/view-order/'.session('orders_id'))}}" class="btn-link"><b>@lang('website.View Order
                Detail')</b></a>
          </p>
        </div>
      </div> -->


      @if(!empty(count($bankdetail)) and count($bankdetail)>0)
      <div class="col-12 col-lg-12 ">

        <div class="heading">
          <h2>
            @lang('website.Bank Detail')
          </h2>
          <hr style="
            margin-bottom: 0;
        ">
        </div>

        <div class="row">
          <div class="col-12 col-md-4">


            <table class="table order-id">
              <tbody>
                <tr class="d-flex">
                  <td class="col-6 col-md-6" style="border-top: 0; border-bottom: 1px solid #dee2e6;">
                    @lang('website.orderID')</td>
                  <td class="col-6 col-md-6" style="border-top: 0; border-bottom: 1px solid #dee2e6;">
                    <span class="badge badge-primary"><a href="{{url('/view-order/'.session('orders_id'))}}"
                        class="btn-link">{{session('orders_id')}}</a></span>
                  </td>
                </tr>
                <tr class="d-flex">
                  <td class="col-6 col-md-6" style="border-top: 0; border-bottom: 1px solid #dee2e6;">
                    @lang('website.Bank')</td>
                  <td class="underline col-6 col-md-6" align="left"
                    style="border-top: 0; border-bottom: 1px solid #dee2e6;">
                    {{@$result['bankdetail']['bank_name'] ?: '---' }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-12 col-md-4">
            <table class="table order-id">
              <tbody>
                <tr class="d-flex">
                  <td class="col-6 col-md-6" style="border-top: 0; border-bottom: 1px solid #dee2e6;">
                    @lang('website.account_name')</td>
                  <td class="col-6 col-md-6" style="border-top: 0; border-bottom: 1px solid #dee2e6;">
                    {{@$result['bankdetail']['account_name'] ?: '---' }}
                  </td>
                </tr>
                <tr class="d-flex">
                  <td class="col-6 col-md-6" style="border-top: 0; border-bottom: 1px solid #dee2e6;">
                    @lang('website.account_number')</td>
                  <td class="underline col-6 col-md-6" align="left"
                    style="border-top: 0; border-bottom: 1px solid #dee2e6;">
                    {{@$result['bankdetail']['account_number'] ?: '---' }}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-12 col-md-4">

            <table class="table order-id">
              <tbody>
                <tr class="d-flex">
                  <td class="col-6 col-md-6" style="border-top: 0; border-bottom: 1px solid #dee2e6;">
                    @lang('website.short_code')</td>
                  <td class="col-6 col-md-6" style="border-top: 0; border-bottom: 1px solid #dee2e6;">
                    {{@$result['bankdetail']['short_code'] ?: '---' }}
                  </td>
                </tr>
                <tr class="d-flex">
                  <td class="col-6 col-md-6" style="border-top: 0; border-bottom: 1px solid #dee2e6;">
                    @lang('website.iban')</td>
                  <td class="col-6 col-md-6" style="border-top: 0; border-bottom: 1px solid #dee2e6;">
                    {{@$result['bankdetail']['iban'] ?: '---' }}
                  </td>
                </tr>
                <tr class="d-flex">
                  <td class="col-6 col-md-6" style="border-top: 0; border-bottom: 1px solid #dee2e6;">
                    @lang('website.swift')</td>
                  <td class="underline col-6 col-md-6" align="left"
                    style="border-top: 0; border-bottom: 1px solid #dee2e6;">
                    {{@$result['bankdetail']['swift'] ?: '---' }}</td>
                </tr>
              </tbody>
            </table>

          </div>

        </div>




        <!-- ............the end..... -->
      </div>
      @endif
    </div>

  </div>


</section>

@endsection