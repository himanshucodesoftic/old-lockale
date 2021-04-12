@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.View Detail') }} <small>{{ trans('labels.View Detail') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li><a href="{{ URL::to('admin/vendors/display')}}"><i class="fa fa-users"></i> {{ trans('labels.ListingAllVendors') }}</a></li>
            <li class="active">{{ trans('labels.View Detail') }}</li>
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
                        <h3 class="box-title">{{ trans('labels.View Detail') }} </h3>
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

                                  @if (count($errors) > 0)
                                    @if($errors->any())
                                      <div class="alert alert-danger alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        {{$errors->first()}}
                                      </div>
                                    @endif
                                  @endif

                                    @if(session()->has('message'))
                                        <div class="alert alert-success" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            {{ session()->get('message') }}
                                        </div>
                                    @endif

                                    <div class="box-body">                                        

                                      {!! Form::open(array('url' =>'admin/vendors/update', 'method'=>'post', 'class' => 'form-horizontal form-validate', 'enctype'=>'multipart/form-data')) !!}

                                        {!! Form::hidden('vendor_id', $data['vendors']->vendor_id, array('class'=>'form-control', 'id'=>'id')) !!}

                                        <div>
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

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label"></label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::hidden('oldImage', $data['vendors']->image , array('id'=>'oldImage', 'class'=>'field-validate ')) !!}
                                                    <img src="{{asset($data['vendors']->image_path)}}" alt="" width="100px">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Name') }} </label>
                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::text('vendor_name',  $data['vendors']->vendor_name, array('class'=>'form-control field-validate', 'id'=>'vendor_name', 'readonly' => 'true')) !!}
                                          </div>

                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::text('vendor_name_arabic',  $data['vendors']->vendor_name_arabic, array('class'=>'form-control field-validate', 'id'=>'vendor_name_arabic', 'readonly' => 'true')) !!}
                                          </div>
                                        </div>

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Telephone') }}</label>
                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::text('vendor_phone',  $data['vendors']->phone, array('class'=>'form-control', 'id'=>'vendor_phone', 'readonly' => 'true')) !!}
                                          </div>
                                        </div>

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Address') }} </label>
                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::text('vendor_address',  $data['vendors']->address, array('class'=>'form-control field-validate', 'id'=>'vendor_address', 'readonly' => 'true')) !!}
                                          </div>
                                        </div>
                                        <hr>

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.EmailAddress') }} </label>
                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::text('email',  $data['vendors']->email, array('class'=>'form-control email-validate', 'id'=>'email', 'readonly' => 'true')) !!}
                                          </div>
                                        </div>

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Owner') }} </label>
                                          <div class="col-sm-10 col-md-4">
                                            {!! Form::text('user_name',  $data['vendors']->first_name.' '.$data['vendors']->last_name, array('class'=>'form-control', 'id'=>'user_name', 'readonly' => 'true')) !!}
                                          </div>
                                        </div>

                                        <div class="form-group" style="display: none">
                                            <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.changePassword') }}</label>
                                            <div class="col-sm-10 col-md-4">
                                                {!! Form::checkbox('changePassword', 'yes', null, ['class' => '', 'id'=>'change-passowrd']) !!}
                                            </div>
                                        </div>
                                        <div class="password" style="display: none">
                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Password') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::password('password', array('class'=>'form-control', 'id'=>'password')) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.PasswordText') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Confirm Password') }}</label>
                                                <div class="col-sm-10 col-md-4">
                                                    {!! Form::password('confirm_password', array('class'=>'form-control', 'id'=>'confirm_password')) !!}
                                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                                    {{ trans('labels.ConfirmPasswordText') }}</span>
                                                    <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                                </div>
                                            </div>
                                        </div>                                        
                                        <hr>

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Current Status') }}</label>
                                          <div class="col-sm-10 col-md-4">
                                            <label>
                                              <input @if($data['vendors']->isopened == 1) checked @endif type="radio" name="vendor_open" value="1" class="minimal"> {{ trans('labels.Open') }}
                                            </label><br>

                                            <label>
                                              <input @if($data['vendors']->isopened == 0) checked @endif type="radio" name="vendor_open" value="0" class="minimal"> {{ trans('labels.Close') }}
                                            </label>                                            
                                          </div>
                                        </div>

                                        <div class="form-group">
                                          <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }} </label>
                                          <div class="col-sm-10 col-md-4">
                                            <select class="form-control" name="isActive">                                              
                                              <option @if($data['vendors']->status == 1) selected @endif value="1">{{ trans('labels.Active') }}</option>
                                              <option @if($data['vendors']->status == 0) selected @endif value="0">{{ trans('labels.Inactive') }}</option>
                                            </select>
                                          <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                          {{ trans('labels.StatusText') }}</span>
                                          </div>
                                        </div>
                                        <div class="box-footer text-center">
                                            <button type="submit" class="btn btn-primary">{{ trans('labels.Update') }}</button>
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
