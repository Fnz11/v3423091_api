@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Welcome to the Dashboard')

@section('content')
    <div class="grid grid-cols-3 gap-4 h-full">
        <div class="bg-white rounded-2xl shadow-2xl shadow-slate-300 h-full row-span-2"></div>
        <div class="gradient-primary !bg-gradient-to-br rounded-2xl shadow-2xl shadow-slate-300 h-full row-span-1"></div>
        <div class="gradient-dark rounded-2xl shadow-2xl shadow-slate-300 h-full row-span-3"></div>
        <div class="bg-white rounded-2xl shadow-2xl shadow-slate-300 h-full col-span-1"></div>
        <div class="bg-white rounded-2xl shadow-2xl shadow-slate-300 h-full col-span-2"></div>
    </div>
@endsection
