@extends('layouts.admin-master')

@section('title')
Pilih Kelas
@endsection

@section('styles')
{{-- Custom Radio Button --}}
<style>
    .middle {
        width: 100%;
        text-align: center;
    }

    .middle h1 {
        font-family: sans-serif;
        color: #fff;
    }

    .middle input[type="radio"] {
        display: none;
    }

    .middle input[type="radio"]:hover+.box {
        background-color: #6777EF;
    }

    .middle input[type="radio"]:hover+.box span {
        color: white;
        transform: translateY(70px);
    }

    .middle input[type="radio"]:hover+.box span:before {
        transform: translateY(0px);
        opacity: 1;
    }

    .middle .box {
        width: 200px;
        height: 200px;
        background-color: #fff;
        transition: all 250ms ease;
        will-change: transition;
        display: inline-block;
        text-align: center;
        cursor: pointer;
        position: relative;
        font-family: sans-serif;
        font-weight: 900;
    }

    .middle .box:active {
        transform: translateY(10px);
    }

    .middle .box span {
        position: absolute;
        transform: translate(0, 60px);
        left: 0;
        right: 0;
        transition: all 300ms ease;
        font-size: 1.5em;
        user-select: none;
        color: #6777EF;
    }

    .middle .box span:before {
        font-size: 1.2em;
        font-family: 'Font Awesome 5 Free';
        display: block;
        transform: translateY(-80px);
        opacity: 0;
        transition: all 300ms ease-in-out;
        font-weight: normal;
        color: white;
        white-space: pre;
        content: '\f015 \A';
        font-weight: 900;
    }

    .fa-home:before {
        content: '';
        font-weight: 900;
    }
</style>
@endsection

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Data Kehadiran</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Data Kehadiran</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Pilih Kelas</h4>
            </div>
            <div class="card-body">
                <div class="row middle mt-3">
                    @foreach ($classes as $class)
                    <div class="col-12 col-md-4 col-lg-4">
                        <label>
                            <input type="radio" name="class_id" />
                            <a href="{{route('admin.presences.show', [
                                'id' => $class->id,
                                'month' => date('m'),
                            ])}}" class="fas fa-home box">
                                <span>
                                    <br>{{$class->name}}
                                </span>
                            </a>
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endsection