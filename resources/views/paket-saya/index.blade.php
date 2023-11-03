@extends('adminlte::page')

<!-- @section('title', 'RUKO') -->

@section('content')

<style>
    html,body{
        overflow-x: hidden; 
    }
</style>
@if (Session::has('pesan'))
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </symbol>
    </svg>
    <div class="alert alert-success d-flex align-items-center justify-content-center mb-4 " role="alert" style="width: 300px; margin: 0 auto;">
        <svg class="bi flex-shrink-0 me-2 mr-3" width="24" height="24" role="img" aria-label="Success:">
            <use xlink:href="#check-circle-fill" />
        </svg>
        {{ Session::get('pesan') }}
    </div>
    <script>
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 5000);
    </script>
@endif
{{-- Alert Register --}}
@if(session('success'))
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
        <path
            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
    </symbol>
</svg>
    <div class="alert alert-success d-flex align-items-center justify-content-center mb-4 " role="alert" style="width: 300px; margin: 0 auto;">
        <svg class="bi flex-shrink-0 me-2 mr-3" width="24" height="24" role="img" aria-label="Success:">
            <use xlink:href="#check-circle-fill" />
        </svg>
        {{ session('success') }}
    </div>
    <script>
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 5000);
    </script>
@endif


<div class="text-center mb-5">
    <div class="container">
        <div>
            <a href="{{route('home')}}">
                <img style="border-radius: 10px;" class="img-fluid w-75" src="{{ asset('img/banner.png') }}" alt="">
            </a>
        </div>
    </div>
</div>

<div style="padding-bottom: 100px; margin: 0px" class="row">
    <div class="col-12">
        <div class="d-flex justify-content-center">
            <div class="w-100 max-w-1000">
                <div class="text-center mb-3">
                    <h3 class="font-weight-bold" style="color: #263B5E">Paket Saya</h3>
                    <a style="" target="_blank" href="https://forms.gle/KcqGk3TEhnHXJa6b7" class="btn alert-default-primary btn-sm"><i class="fas fa-fw fa-file-alt"></i><strong>Klik untuk mengisi testimoni</strong></a>
                </div>
                
                {{-- <div style="margin-left: 90px" class="col-lg-3 col-md-12">
                    <div style="" class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-fw fa-search"></i></span>
                        </div>
                        <select name="filter_paket[]" id="filter-paket" class="form-control select2">
                            <option value="semua-topik">Semua Topik</option>
                            @foreach($topiks as $topik)
                            <option value="{{ $topik->id }}">{{ $topik->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}
                
                <div class="row d-flex justify-content-center" id="component-list-paket">
                    @include('paket-saya.component-list-paket')
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('footer')
    @include('adminlte::partials.footer.footer')
@endsection

@section('js')
<script src="{{ asset('js/paket-saya.js') }}"></script>
@stop
