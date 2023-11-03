@extends('adminlte::page')

@section('content')
<style>
    html,
    body {
        overflow-x: hidden;
    }
    .hidden {
      display: none;
    }
</style>
<script>
    function toggleTextarea() {
      var textarea = document.getElementById('questionTextarea');
      if (textarea.value === '') {
        textarea.classList.add('hidden');
      } else {
        textarea.classList.remove('hidden');
      }
    }

    document.addEventListener('DOMContentLoaded', function() {
      toggleTextarea();

      var textarea = document.getElementById('questionTextarea');
      textarea.addEventListener('input', toggleTextarea);
    });
  </script>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h3>
                            @if (session('user-quiz.section') =='membaca')
                            읽기 <!-- membaca -->
                            @else
                            듣기 <!-- mendengarkan -->
                            @endif
                        </h3>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-8">
                                <h3 style="padding: 0px 5px;">남은 시간 <!-- sisa waktu-->&nbsp;</h3>
                            </div>
                            <div class="md:col-3">
                                <h3 id="timer" class="text-white justify-center" style="padding:0px 10px; background-color:#1D3D73"></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-9">
                    <input type="hidden" name="quiz_id" id="quiz-id" value="{{$quiz->id}}">
                    @foreach ($data as $key => $question)
                    <div class="card">
                        <div class="card-header">
                            @if(session('user-quiz.section') == 'membaca')
                            <h4> 문제 번호<!-- Soal Nomor--> {{ $data->currentPage() }}</h4>
                                
                            @else
                            <h4> 문제 번호<!-- Soal Nomor--> {{ $data->currentPage() + 20 }}</h4>
                                
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <textarea id="questionTextarea" class="form-control" style="border: none;height:150px" readonly>{{$question['question']}}</textarea>
                                @if(!empty($question['pic_url']))
                                <div class="col-lg-6 p-0 mt-1">
                                    <img class="img-fluid rounded w-100" src="{{config('apiurl.url').'/api/storage/question/'.$question['pic_url']}}" alt="Gambar soal">
                                </div>

                                @endif
                                @if(!empty($question['audio_url']))
                                <div class="col-lg-6 p-0 mt-1">
                                    <audio class="w-100" controls controlsList="nodownload" src="{{config('apiurl.url').'/storage/audio/question/'.$question['audio_url']}}">
                                    </audio>
                                </div>
                                @endif
                            </div>
                            <div>
                                <div class="row">
                                    @foreach(collect($question['answer']) as $keyAnswer => $answer)
                                    @switch($answer['option'])
                                    @case('A')
                                    @php $order = 'order-1 order-lg-1'; @endphp
                                    @php $optionNumber = '1'; @endphp
                                    @break;
                                    @case('B')
                                    @php $order = 'order-2 order-lg-3'; @endphp
                                    @php $optionNumber = '2'; @endphp
                                    @break;
                                    @case('C')
                                    @php $order = 'order-3 order-lg-2'; @endphp
                                    @php $optionNumber = '3'; @endphp
                                    @break;
                                    @case('D')
                                    @php $order = 'order-4 order-lg-4'; @endphp
                                    @php $optionNumber = '4'; @endphp
                                    @break;
                                    @case('E')
                                    @php $order = 'order-5 order-lg-5'; @endphp
                                    @php $optionNumber = '5'; @endphp
                                    @break;
                                    @endswitch
                                    <div class="col-lg-6 col-md-12 {{$order}}">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group">
                                                <div class="custom-control custom-radio mb-2">
                                                    <input class="custom-control-input answer-option" type="radio" id="userAnswer{{$keyAnswer}}" name="userAnswer[{{$key}}]" data-no="{{$data->currentPage()}}" data-question-id="{{$question['id']}}" data-id="{{$answer['id']}}" value="{{$optionNumber}}" {{ session('user-quiz.answer-'.$section.'.'.$data->currentPage().'.0.option') == $answer['option'] ? 'checked':'' }}>
                                                    <label for="userAnswer{{$keyAnswer}}" class="custom-control-label">
                                                        <span class="radio-bullet">{{$optionNumber}}</span> <!-- Label nomor opsi dalam lingkaran -->
                                                        {{$answer['content']}}
                                                        @if(!empty($answer['pic_url']))
                                                        <div>
                                                            <img src="{{config('apiurl.url').'/storage/images/option/'.$answer['pic_url']}}" class="img-fluid w-25 rounded" alt="Opsi gambar">
                                                        </div>
                                                        @endif
                                                    </label>
                                                </div>
                                            </div>
                                            <style>
                                                .custom-control.custom-radio .custom-control-label {
                                                    display: flex;
                                                    align-items: center;
                                                }

                                                .custom-control.custom-radio .custom-control-input {
                                                    display: none; /* Sembunyikan radio button asli */
                                                }

                                                .radio-bullet {
                                                    display: flex;
                                                    align-items: center;
                                                    justify-content: center;
                                                    width: 24px; /* Ukuran lingkaran */
                                                    height: 24px;
                                                    border:1px solid black; 
                                                    border-radius: 50%; /* Membuatnya lingkaran */
                                                    color: #000000; /* Warna teks dalam lingkaran */
                                                    font-weight: bold;
                                                    margin-right: 10px; /* Jarak antara lingkaran dan konten radio button */
                                                }

                                            </style>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                        <div class="card-footer d-flex justify-content-center">
                            {{ $data->links('vendor.pagination.simple-bootstrap-4') }}
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col-12 col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h4>질문 번호 <!-- Nomor Soal --></h4>
                        </div>
                        <div class="card-body">
                            @if(session('user-quiz.section') == 'membaca')
                            <div class="d-flex flex-wrap justify-content-center align-items-center answer-map-container mb-3">
                                @for($i=1;$i<=$data->total();$i++)  
                                    <a href="{{$data->url($i)}}" class="btn m-1 btn-map {{ $data->currentPage() == $i ? 'btn-primary' : (session('user-quiz.answer-'.$section.'.'.$i.'.0.option') ? 'btn-success' : 'btn-default') }}">{{$i}}</a>
                                @endfor
                            </div>
                            @else
                            <div class="d-flex flex-wrap justify-content-center align-items-center answer-map-container mb-3">
                                @for($i=21; $i <= $data->total() + 20; $i++)
                                    <a href="{{$data->url($i - 20)}}" class="btn m-1 btn-map {{ $data->currentPage() == $i ? 'btn-primary' : (session('user-quiz.answer-'.$section.'.'.$i.'.0.option') ? 'btn-success' : 'btn-default') }}">{{$i}}</a>
                                @endfor
                            </div>
                            @endif                            
                        </div>
                        <div class="card-footer d-flex justify-content-center">
                            <div class="row ml-3">
                                <div class="row col-12">
                                    <div style="width: 18px;height:18px;background-color:#1E9549"></div>
                                    <p style="font-size: 15px;margin-top:-3px"> &nbsp; : 이미 대답했다<!-- Sudah dijawab --></p>
                                </div>
                                <br>
                                <div class="row col-12">
                                    <div style="width: 18px;height:18px" class="bg-primary"></div>
                                    <p style="font-size: 15px;margin-top:-3px"> &nbsp; :
                                        답장을 받고 있다<!-- Sedang dijawab --></p>
                                </div>
                                <br>
                                <div class="row col-12">
                                    <div style="width: 18px;height:18px" class="bg-white border border-2"></div>
                                    <p style="font-size: 15px;margin-top:-3px;"> &nbsp; : 대답하지 않았다<!--Belum dijawab--> </p>
                                </div>
                                @if(session('user-quiz.section') == 'membaca')
                                <button class="btn btn-outline-danger mr-1" id="btn-batal-tryout">Batal Mengerjakan</button>
                                <button class="btn btn-outline-primary mt-2" id="btn-pindah-tryout">Simpan Jawaban Membaca</button>
                                @else
                                <button class="btn btn-secondary" id="btn-selesai-tryout">Akhiri Tes</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@stop

@section('js')
<script src="{{asset('js/tryout.js')}}"></script>
@stop