@extends('layouts.admin-master')

@section('title')
Pilih Bulan
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
        content: '\f073 \A';
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
        <h1>Riwayat Kehadiran Tahun Pelajaran {{$year->name}} - {{$year->name + 1}}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">
                <a href="{{ route('admin.historyPresences.schoolYears') }}">
                    Riwayat Kehadiran
                </a>
            </div>
            <div class="breadcrumb-item">
                <a href="{{ route('admin.historyPresences.index', $year->id) }}">
                    {{$year->name}} - {{$year->name + 1}}
                </a>
            </div>
            <div class="breadcrumb-item">{{$class->name}}</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h4>Pilih Bulan</h4>
            </div>
            <div class="card-body">
                <div class="row middle mt-3">
                    @foreach ($months as $key => $month)
                    <div class="col-12 col-md-4 col-lg-4">
                        <label>
                            <input type="radio" name="month_id" />
                            @php
                            $temp = ($key < 9) ? '0' . ($key + 1) : ($key + 1); @endphp <a
                                href="{{route('admin.historyPresences.month', [$year->id, $class->id, $temp])}}"
                                class="fas fa-home box">
                                <span>
                                    <br>{{$month}}
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