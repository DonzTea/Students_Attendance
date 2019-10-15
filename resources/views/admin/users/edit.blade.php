@extends('layouts.admin-master')

@section('title')
Edit Profil ({{ $user->name }})
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Edit Profil</h1>
  </div>
  <div class="section-body">
    <profile-component user='{!! $user->toJson() !!}'></profile-component>
  </div>
</section>
@endsection