@extends('adminlte::master')

@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home') )

@if (config('adminlte.use_route_url', false))
@php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
@php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('adminlte_css')
@stack('css')
@yield('css')
@stop

{{-- @section('classes_body'){{ ($auth_type ?? 'login') . '-page' }}@stop --}}

@section('body')

<style>
    html,body{
        height: 100vh;
    }
    .tul{
            display: flex;
            align-items: center;
        }
    @media only screen and (max-width:500px){
        html, body {
            overflow-x: hidden;
        }
        .form{
            margin-top: -5%;
        }
        .kotak{
            margin-top: -120%;
            width: 400px;
            box-shadow: 2px 2px 20px 2px white;
            height: -200px;
            height: 60vh;
            
        }
        .tul{
            display: flex;
            align-items: center;
            margin-left: 9%;
            margin-top: -30%;
        }
        
        
    }
</style>
<div class="row no-gutters" style="">
    <div style="background: url('../img/backgound.png') no-repeat ;padding:0px 0px;background-size:cover;background-position:center;margin:0px;height:110vh" class="col-12 col-md-4">
        <div class="text-center" style="margin-top:60%">
            <img class="img-fluid w-75 tul" src="{{asset('landingpage/img/icon/logo.png')}}" alt="">
        </div>
    </div>
    <div class="col-12 col-md-8  form" style="margin-top: 8%;">
        <div class="mx-auto" style="max-width: 400px;">
            <div class="{{ $auth_type ?? 'login' }}-box">

                {{-- Logo --}}

                {{-- Card Box --}}
                <div class="card kotak">
                <div class="isi"> 
                
                        {{-- Card Header --}}
                    @hasSection('auth_header')
                    <div class="card-header">
                        <h3 class="card-title text-center">
                            @yield('auth_header')
                        </h3>
                    </div>
                    @endif
            

                    {{-- Card Body --}}
                    <div class="card-body tes {{ $auth_type ?? 'login' }}-card-body">
                        @yield('auth_body')
                    </div>
                    
                    {{-- Card Footer --}}
                    @hasSection('auth_footer')
                    <div class="card-footer">
                        @yield('auth_footer')
                    </div>
                    @endif
                             
                    

                </div>
            </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('adminlte_js')
@stack('js')
@yield('js')
@stop