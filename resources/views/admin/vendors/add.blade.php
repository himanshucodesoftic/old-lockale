@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.AddVendor') }} <small>{{ trans('labels.AddVendor') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/vendors/display')}}"><i class="fa fa-users"></i> {{ trans('labels.ListingAllVendors') }}</a></li>
            <li class="active">{{ trans('labels.AddVendor') }}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->

        <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('labels.AddVendor') }} </h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="box box-info">
                                    <!--<div class="box-header with-border">
                                          <h3 class="box-title">Edit category</h3>
                                        </div>-->
                                    <!-- /.box-header -->
                                  <br>
                                  @if (session('update'))
                                  <div class="alert alert-success alert-dismissable custom-success-box" style="margin: 15px;">
                                      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                      <strong> {{ session('update') }} </strong>
                                  </div>
                                  @endif

                                  @if (count($errors) > 0)
                                    @if($errors->any())
                                      <div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        {{$errors->first()}}
                                      </div>
                                    @endif
                                  @endif

                                    <div class="box-body">
                                      {!! Form::open(array('url' =>'admin/vendors/add', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}
                                        
                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Image') }} </label>
                                          <div class="col-sm-10 col-md-4">

                                            <!-- Modal -->
                                            <div class="modal fade" id="Modalmanufactured" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                              <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" id="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    <h3 class="modal-title text-primary" id="myModalLabel">Choose Image </h3>
                                                  </div>

                                                  <div class="modal-body manufacturer-image-embed">
                                                    @if(isset($allimage))
                                                      <select class="image-picker show-html " name="image_id" id="select_img">
                                                        <option value=""></option>
                                                        @foreach($allimage as $key=>$image)
                                                        <option data-img-src="{{asset($image->path)}}" class="imagedetail" data-img-alt="{{$key}}" value="{{$image->id}}"> {{$image->id}} </option>
                                                        @endforeach
                                                      </select>
                                                    @endif
                                                  </div>
                                                  <div class="modal-footer">
                                                    <a href="{{url('admin/media/add')}}" target="_blank" class="btn btn-primary pull-left">{{ trans('labels.Add Image') }}</a>
                                                    <button type="button" class="btn btn-default refresh-image"><i class="fa fa-refresh"></i></button>
                                                    <button type="button" class="btn btn-primary" id="selected" data-dismiss="modal">Done</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>

                                            <div id="imageselected">
                                              {!! Form::button(trans('labels.Add Image'), array('id'=>'newImage','class'=>"btn btn-primary ", 'data-toggle'=>"modal", 'data-target'=>"#Modalmanufactured" )) !!}
                                              <br>
                                              <div id="selectedthumbnail" class="selectedthumbnail col-md-5"> </div>
                                              <div class="closimage">
                                                <button type="button" class="close pull-left image-close " id="image-close"
                                                  style="display: none; position: absolute;left: 105px; top: 54px; background-color: black; color: white; opacity: 2.2; " aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                            </div>
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.UploadVendorImageText') }}</span>
                                          </div>
                                        </div>
                                        <hr>

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Name') }} </label>
                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::text('vendor_name',  '', array('class'=>'form-control field-validate', 'id'=>'vendor_name')) !!}
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.VendorNameText') }}</span>
                                            <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                          </div>

                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::text('vendor_name_arabic',  '', array('class'=>'form-control field-validate', 'id'=>'vendor_name_arabic')) !!}
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.VendorNameArabicText') }}</span>
                                            <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                          </div>
                                        </div>

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Telephone') }}</label>
                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::text('vendor_phone',  '', array('class'=>'form-control field-validate', 'id'=>'vendor_phone')) !!}
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                            {{ trans('labels.TelephoneText') }}</span>
                                          </div>
                                        </div>

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Address') }} </label>
                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::text('vendor_address',  '', array('class'=>'form-control field-validate', 'id'=>'vendor_address')) !!}
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.VendorAddressText') }}</span>
                                            <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                          </div>
                                        </div>
                                        <hr>

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.EmailAddress') }} </label>
                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::text('email',  '', array('class'=>'form-control email-validate', 'id'=>'email')) !!}
                                              <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                              {{ trans('labels.EmailText') }}</span>
                                            <span class="help-block hidden"> {{ trans('labels.EmailError') }}</span>
                                          </div>
                                        </div>

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Password') }}</label>
                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::password('password', array('class'=>'form-control field-validate', 'id'=>'password')) !!}
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                            {{ trans('labels.PasswordText') }}</span>
                                            <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                          </div>
                                        </div>

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Confirm Password') }}</label>
                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::password('confirm_password', array('class'=>'form-control field-validate', 'id'=>'confirm_password')) !!}
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                            {{ trans('labels.ConfirmPasswordText') }}</span>
                                            <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                          </div>
                                        </div>                                        
                                          
                                        <!-- <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.DOB') }} </label>
                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::text('customers_dob',  '', array('class'=>'form-control datepicker' , 'readonly'=>'readonly', 'id'=>'customers_dob')) !!}
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                            {{ trans('labels.DOBText') }}</span>
                                          </div>
                                        </div> -->
                                        
                                        <!-- <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Fax') }}</label>
                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::text('customers_fax',  '', array('class'=>'form-control', 'id'=>'customers_fax')) !!}
                                            <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.FaxText') }}</span>
                                          </div>
                                        </div> -->
                                        <hr>

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Current Status') }}</label>
                                          <div class="col-sm-10 col-md-4">
                                            <label>
                                              <input type="radio" name="vendor_open" value="1" class="minimal" checked> {{ trans('labels.Open') }}
                                            </label><br>

                                            <label>
                                              <input type="radio" name="vendor_open" value="0" class="minimal"> {{ trans('labels.Close') }}
                                            </label>
                                          </div>
                                        </div>

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }} </label>
                                          <div class="col-sm-10 col-md-4">
                                            <select class="form-control" name="isActive">
                                              <option value="1">{{ trans('labels.Active') }}</option>
                                              <option value="0">{{ trans('labels.Inactive') }}</option>
                                            </select>
                                          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                          {{ trans('labels.StatusText') }}</span>
                                          </div>
                                        </div>
                                        <div class="box-footer text-center">
                                            <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                            <a href="{{ URL::to('admin/vendors/display')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
                                        </div>

                                      {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->

        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
@endsection
