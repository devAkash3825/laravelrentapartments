@extends('admin.layouts.app')
@section('content')
<h1> Admin Dashboard Page </h1>

<a href="{{route('admin.logout')}}">logout</a>
@endsection