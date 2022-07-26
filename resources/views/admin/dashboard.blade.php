@extends('admin.layouts.app')

@section('content')
<div class="container  text-white">
    Welcome, {{ auth()->guard('admin')->user()->name }} <br>
    In the Admin Dashboard.....
</div>
  

@endsection