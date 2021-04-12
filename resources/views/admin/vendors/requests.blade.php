@extends('admin.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('labels.Requests') }} <small>{{ trans('labels.ListingAllRequests') }}...</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{{ URL::to('admin/dashboard/this_month')}}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
            <li class="active">{{ trans('labels.Requests') }}</li>
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
                        <div class="container-fluid">
                            <div class="row">
                                <!-- <div class="box-tools pull-right">
                                    <a href="{{ url('admin/vendors/add')}}" type="button" class="btn btn-block btn-primary">{{ trans('labels.AddNew') }}</a>
                                </div> -->
                            </div>
                        </div>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-12">
                                @if (count($errors) > 0)
                                  @if($errors->any())
                                  <div class="alert alert-success alert-dismissible" role="alert">
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      {{$errors->first()}}
                                  </div>
                                  @endif
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                                              
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{trans('labels.ID')}}</th>
                                            <th>@sortablelink('title', trans('labels.Title')) </th>
                                            <th>{{trans('labels.Name')}} </th>
                                            <th>{{ trans('labels.Email') }}</th>
                                            <th>{{ trans('labels.Phone') }} </th>
                                            <th>{{ trans('labels.Address') }}</th>
                                            <th>{{ trans('labels.Status') }}</th>
                                            <th>{{ trans('labels.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($data['requests']))
                                            @foreach ($data['requests'] as $key => $requests)
                                            <tr>
                                                <td style="vertical-align: middle;"><center>{{ $key+1 }}</center></td>
                                                <td style="vertical-align: middle;">
                                                  {{ $requests->title }}
                                                </td>
                                                <td style="vertical-align: middle;">{{ $requests->first_name }} {{ $requests->last_name }}</td>
                                                <td style="text-transform: none; vertical-align: middle;">{{ $requests->email }}</td>
                                                <td style="vertical-align: middle;">{{ $requests->phone }}</td>
                                                <td style="vertical-align: middle;">
                                                    {{ $requests->address }}, {{ $requests->city }}, {{ $requests->countries_name }}
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    @if ($requests->status == 2)
                                                      <p style="color: red; margin: 0; font-weight: bold; font-size: 12px;">New</p>
                                                    @endif
                                                    @if ($requests->status == 1)
                                                      <p style="color: #4aea08; margin: 0; font-weight: bold; font-size: 12px;">Accepted</p>
                                                    @endif
                                                    @if ($requests->status == 0)
                                                      <p style="color: #3a06a0; margin: 0; font-weight: bold; font-size: 12px;">Declined</p>
                                                    @endif
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    @if ($requests->status == 2)
                                                    <ul class="nav table-nav">
                                                        <li class="dropdown">
                                                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                                                {{ trans('labels.Action') }} <span class="caret"></span>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                @if ($requests->status == 2 || $requests->status == 0)
                                                                <li role="presentation"><a role="menuitem" tabindex="-1" href="{{url('admin/vendors/accept') }}/{{$requests->id}}">{{ trans('labels.View Detail') }}</a></li>
                                                                @endif

                                                                @if ($requests->status == 2)
                                                                  <li role="presentation" class="divider"></li>    
                                                                  <li role="presentation"><a data-toggle="tooltip" data-placement="bottom" title="{{ trans('labels.Decline') }}" id="deleteCustomerFrom" users_id="{{ $requests->id }}">{{ trans('labels.Decline') }}</a></li>
                                                                @endif
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                        <tr>
                                          <td colspan="4">{{ trans('labels.NoRecordFound') }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                                
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

        <!-- deleteCustomerModal -->
        <div class="modal fade" id="deleteCustomerModal" tabindex="-1" role="dialog" aria-labelledby="deleteCustomerModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="deleteCustomerModalLabel">{{ trans('labels.Decline') }}</h4>
                    </div>
                    {!! Form::open(array('url' =>'admin/vendors/decline', 'name'=>'deleteRequest', 'id'=>'deleteRequest', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
                    {!! Form::hidden('action', 'delete', array('class'=>'form-control')) !!}
                    {!! Form::hidden('users_id', '', array('class'=>'form-control', 'id'=>'users_id')) !!}
                    <div class="modal-body">
                        <p>{{ trans('labels.DeclineVendorRequest') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('labels.Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ trans('labels.Decline') }}</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content notificationContent">

                </div>
            </div>
        </div>

        <!-- Main row -->

        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

@endsection
