@extends('adminlte::page')

<!-- @section('title', 'RumahEpsTopik') -->

{{-- @section('content_header')
<h1 class="m-0 text-dark"><a href="{{route('paket-saya.index')}}" class="text-dark">{{$data->topik->name}}</a></h1>
@stop --}}

@section('content')

{{-- <div class="container-fluid" style="background-color: #f8f9fa;margin-top:-30px;margin-bottom:40px">
    <marquee class="contoh" behavior="scroll" direction="left" scrollamount="10">
        <strong>
            </strong>
    </marquee>
    <style>
        .contoh:hover{
            background-color:#dff0f3;
            box-shadow: 4px 0px 4px rgba(0, 0, 0, 0.189);
            transition: 0.5s;
        }.contoh:not(:hover){
            transition: 0.5s;
        }
    </style>
</div> --}}
<div style="background: url('../img/bg.png') no-repeat ;padding:0px 0px; min-height:90vh; background-size:cover;background-position:center;margin:0px">
    <div style="padding:0px 0px" class=" justify-content-center mb-5  ">

        @if (Session::has('pesan'))
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
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
        <div class="text-center ">
            <h3 class="font-weight-bold " style="color:black ">Selamat Datang di</h3>
            <h3 class="font-weight-bold" style="color:black "> {{$data->topik->name}}</h3>
            <style>
                .teks-animasi {
                max-width: 80%;
                display: inline-block;
                animation: naikTurun 2s linear infinite;
                text-align: center;
                font-size: 18px;
                color: #263B5E;                
                font-weight: bold;
                margin-top: 60px;
                }

                @keyframes naikTurun {
                0%, 100% {
                    transform: translateY(0);
                }
                50% {
                    transform: translateY(-20px);
                }
            }

            </style>
        </div>
        <div class="text-center">
            <p class="teks-animasi">Soal-Soal Tryout Eps-Topik Ini Bersumber Dari Kumpulan Soal-Soal Eps-Topik Hrdk Eps Center In Indonesia Http://Www.Hrdkepsid.Com/Eps/Bbs/Board.Php?Bo_Table=Publicwork&Wr_Id=1</p>
            
        </div>
    </div>
    <div class="row justify-content-center pb-4" style="width: 100%; margin:auto">
        <div class="col-10">

            <div class="">
                <div class="row justify-content-center overflow-hidden">
                    @if($data->quiz->isEmpty())
                    <div class="container-fluid d-flex justify-content-center w-100">
                        <h5 class="font-weight-bold">Paket ini belum memiliki kuis</h5>
                    </div>
                    @else
                    @foreach($data->quiz as $quiz)
                    <div style="width: 200px " class="mr-3 mt-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-start">
                                    <div class="ml-0">
                                        <h4 class="mb-0 font-weight-bold">{{$quiz->title}}</h4>
                                        <p class="card-text">Membaca 읽기 dan Mendengar 듣기</p>
                                        <span class="text-muted">Jumlah : {{$quiz->tot_visible}} Soal</span>
                                        <br>
                                        <span class="text-muted">Waktu : {{$quiz->timer_quiz}} Menit</span>
                                    </div>
                                    <div class="ml-0 mt-2">
                                        {{-- @if(\App\Models\TryoutUser::where('quiz_id',$quiz->id)->where('collager_id',Auth::user()->collager->id)->get()->isNotEmpty())
                                        <span class="badge badge-info">SUDAH DIKERJAKAN</span>
                                        @else --}}
                                        {{-- <a href="{{ route('tryout.index').'?session='.session()->getId().$quiz->id }}" data-kuis-id="{{$quiz->id}}" class="btn alert-default-primary btn-sm btn-mulai-tryout"><i class="fas fa-fw fa-file-alt"></i><strong>Kerjakan</strong></a> --}}
                                        <a href="{{route('paket-saya.opening',$quiz->id)}}" class="btn alert-default-primary btn-sm stretched-link"><i class="fas fa-fw fa-file-alt"></i><strong>Kerjakan</strong></a>
                                        {{-- @endif --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
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
<script src="{{asset('js/prepare-tryout.js')}}"></script>
@stop