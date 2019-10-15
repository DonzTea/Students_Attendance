@extends('layouts.admin-master')

@section('title')
Kelola User
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Kelola User</h1>
  </div>
  <div class="section-body">
    <users-component></users-component>
  </div>
</section>
@endsection