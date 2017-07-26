@extends('consultant.consultant_dashboard_layout')
@section('top_section')
	<h1>Dashboard<small>Consultant</small></h1>
	<!--<ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Dashboard</li>
	</ol>-->
@endsection
@section('content')
@section('content')
<link rel="stylesheet" href="{{ asset('admin/plugins/timepicker/bootstrap-timepicker.css') }}">
<link rel="stylesheet" href="{{ asset('admin/plugins/datepicker/datepicker3.css') }}">

<div class="col-md-12 profile_page">
<h3 class="box-title">{{ $page_title }}</h3>
<div class="col-lg-3 col-xs-12">
	@if($page_type == 'edit')
		<form role="form" method="post" enctype="multipart/form-data" action="{{ url('consultant/availability/'.$edit_availability->id.'/edit') }}">
	@else
		<form role="form" method="post" enctype="multipart/form-data" action="{{ url('consultant/availability/form') }}">
	@endif
	<!-- text input -->		
		<div class="form-group">
			<label>Availability Date:</label>
			<div class="input-group date">
			  <div class="input-group-addon">
				<i class="fa fa-calendar"></i>
			  </div>
			@if($page_type == 'edit')
				<input type="text" id="datepicker" name="available_date" value="{{ date('m/d/Y',strtotime($edit_availability->getDate())) }}" class="form-control pull-right" id="datepicker">
			@else
				<input type="text" id="datepicker" name="available_date"  value="{{ old('available_date') }}"  class="form-control pull-right">
			@endif
			</div>
		</div>
		<div class="form-group">
			<label>Availability Type:</label>
			<div class="input-group date">
				<div class="input-group-addon">
					<i class="fa fa-calendar"></i>
				</div>
				@if($page_type == 'edit')
					<select class="form-control" name="type_id">
						<option>---Select Availability Type</option>
						@foreach(\App\ConsultantAvailablity::getTypeOptions() as $key => $type)
							<option value="{{ $key }}" @if($edit_availability->type_id == $key) selected @endif > {{ $type }}  </option>
							@endforeach
						</select>
				@else
					<select class="form-control" name="type_id">
						<option>---Select Availability Type</option>
						@foreach(\App\ConsultantAvailablity::getTypeOptions() as $key => $type)
							<option value="{{ $key }}" @if(old('type_id') == $key) selected @endif > {{ $type }}  </option>
						@endforeach
					</select>
				@endif
			</div>
		</div>
		<div class="bootstrap-timepicker">
			<div class="form-group">
				<label>Start Time (24hr format):</label>
				<div class="input-group">
				@if($page_type == 'edit')
					<input type="text" name="available_start_time" value="{{ $edit_availability->getDate(\App\ConsultantAvailablity::START_TIME) }}" class="form-control timepicker">
				@else
					<input type="text" name="available_start_time" class="form-control timepicker">	
				@endif	
					<div class="input-group-addon">
					  <i class="fa fa-clock-o"></i>
					</div>
				</div>
			</div>
		</div>
		<div class="bootstrap-timepicker">
			<div class="form-group">
				<label>End Time (24hr format):</label>
				<div class="input-group">
				@if($page_type == 'edit')
					<input type="text" name="available_end_time" value="{{ $edit_availability->getDate(\App\ConsultantAvailablity::END_TIME) }}" class="form-control timepicker">
				@else
					<input type="text" name="available_end_time" class="form-control timepicker">
				@endif
					<div class="input-group-addon">
					  <i class="fa fa-clock-o"></i>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label>Status</label>
			<div class="radio">
			  <label>
			    <input type="radio" @if (isset($edit_availability) && $edit_availability->status==1) checked @endif @if (!isset($edit_availability)) checked @endif name="status" value="1">
			    Yes
			  </label>
			</div>
			<div class="radio">
			  <label>
			    <input type="radio" @if (isset($edit_availability) && $edit_availability->status==0) checked @endif name="status" value="0" >
			    No
			  </label>
			</div>
		 </div>


		{{ csrf_field() }}
		<button type="submit" class="btn btn-primary">Save</button>
		<a href="{{ url('consultant/dashboard') }}" class="btn btn-default">Cancel</a>
	</form>
</div>

@endsection
@section('js')
		<script src="{{ asset('frontend/js/jquery-2.1.4.min.js') }}"></script>
		<script src="{{ asset('frontend/js/jquery.ui.js') }}"></script>
		<script src="{{ asset('admin/plugins/timepicker/bootstrap-timepicker.js') }}"></script>
		<script>
			$(function () {
				//Timepicker

				$(".timepicker").timepicker({
					showInputs: false,
					showMeridian : false
				});
			});
		</script>
		<script src="{{ asset('admin/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
		<script>
			$(document).ready(function () {
				$('#datepicker').datepicker({
					autoclose: true,
					dateFormat: "Y-m-d",
					startDate:new Date()
				});
			});
		</script>
@endsection
