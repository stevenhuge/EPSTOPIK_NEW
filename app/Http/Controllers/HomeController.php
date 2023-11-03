<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\Quiz;
use App\Models\Paket;
use App\Models\Topik;
use App\Models\Banner;
use App\Models\Transaksi;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
public function index(Request $request)
{
    // Mendapatkan filter dari request, jika tidak ada, maka akan bernilai null
    $filter = $request->filter ?: null;

    // Mendapatkan ID collager dari user yang sedang login
    $collagerId = Auth::user()->collager->id;

    // Mendapatkan data topik
    $topiks = Topik::self();

    // Mendapatkan data banner yang ditampilkan di halaman
    $banner = Banner::where('isViewWeb', 1)->get();

    // Mendapatkan data paket premium yang dimiliki oleh user yang sedang login
    $premium = DetailTransaksi::with('transaksi', 'detailPaket.paket')
        ->whereHas('transaksi', function ($query) use ($collagerId) {
            $query->where('collager_id', $collagerId)
                ->where('status', 'STATUS_TRANS_2')
                ->where('start_date', '<=', Carbon::now())
                ->where('expired_date', '>=', Carbon::now());
        })->get()->sortBy(function ($query) {
            return $query->detailPaket->paket->name;
        });

    // Mendapatkan data paket "uji coba" (trial)
    $data = Paket::with('topik')->where('name', 'uji coba')->get();

    // Jika user belum memiliki paket premium, alihkan langsung ke halaman "data uji coba"
    if ($premium->isEmpty()) {
        return redirect()->route('data.uji.coba');
    }

    // Jika user sudah memiliki paket premium, tampilkan halaman dengan data-data yang diperlukan
    return view('paket-saya.index', compact('data', 'topiks', 'premium', 'banner'));
}

// Fungsi untuk menampilkan halaman "data uji coba"
public function showDataUjiCoba()
{
    $data = Paket::with('topik')->where('name', 'uji coba')->get();
    return view('beranda.uji-coba', compact('data'));
}


    public function show($namaPaket)
    {
        try {
            $namaPaket = Str::lower(str_replace('-',' ',$namaPaket));
            $data = Paket::self($namaPaket);
            


            if (empty($data)) {
                abort(404);
            }
        }
        catch (\Throwable $th) {
            abort(404);
        }
        
        return view('paket-saya.detail', compact('data'));
         
        

    }

    public function filter(Request $request)
    {
        $topik = $request->topik !== 'semua-topik' ? $request->topik:null;
        $collagerId = Auth::user()->collager->id;
        $data = DetailTransaksi::with('transaksi','detailPaket.paket')
        ->whereHas('transaksi', function($query) use($collagerId){
            $query->where('collager_id',$collagerId)
            ->where('status','STATUS_TRANS_2')
            ->where('start_date','<=',Carbon::now())
            ->where('expired_date','>=',Carbon::now());
        })->when($topik, function($query) use($topik){
            $query->whereHas('detailPaket.paket', function($query) use($topik){
                $query->where('quiz_category_id',$topik);
            });
        })->get();
        return response()->json(['view'=>view('paket-saya.component-list-paket',compact('data'))->render()]);
    }

    public function opening($id){
         
        $data=Quiz::findOrFail($id);
        $data=Quiz::where('id',$id)->get();
        
        return view('paket-saya.opening', compact('data'));
    }

    public function premium($namaPaket)
    {
        try {
            $namaPaket = Str::lower(str_replace('-',' ',$namaPaket));
            $data = Paket::premium($namaPaket);
            


            if (empty($data)) {
                abort(404);
            }
        }
        catch (\Throwable $th) {
            abort(404);
        }
        
        return view('paket-saya.detail', compact('data'));
         
        

    }
}
