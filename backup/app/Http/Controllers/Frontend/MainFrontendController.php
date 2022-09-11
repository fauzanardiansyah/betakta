<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;


class MainFrontendController extends Controller
{
    public function index()
    {
        $testimonials = \App\Testimonials::orderBy('id', 'DESC')->first();
        $news         = \App\Post::with('category')->get();
        $sponsorship  = \App\Sponsorship::orderBy('id', 'DESC')->get(); 
       
        return view('frontend/base.index', compact('testimonials', 'news', 'sponsorship'));
	//return view('construct');
    }

    public function alur()
    {
        return view('frontend/content-pages/alur.alur-page');
    }

    public function faq()
    {
        $faq = \App\Faq::orderBy('id', 'DESC')->get();
        return view('frontend/content-pages/faq.faq-page', compact('faq'));
    }

    public function informasi()
    {
        $anggotaSemuaProvinsi = DB::table('t_registrasi_users')
                                ->join('t_kta', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
                                ->join('t_dp', 't_kta.id_dp', '=', 't_dp.id')
                                ->join('provinsi', 'provinsi.id', '=', 't_dp.id_provinsi')
                                ->join('t_detail_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
                                ->join('t_pj_kta', 't_pj_kta.id_detail_kta', '=', 't_detail_kta.id')
                                ->join('t_administrasi_kta','t_administrasi_kta.id_detail_kta', '=', 't_detail_kta.id')
                                ->where('t_detail_kta.is_inserted', '=', 4)
                                ->select(
                                    't_registrasi_users.nm_bu',
                                    'provinsi.name as nama_provinsi',
                                    't_kta.no_kta', 
                                    't_registrasi_users.bentuk_bu',
                                    't_pj_kta.nm_pjbu',
                                    't_administrasi_kta.alamat',
                                    't_administrasi_kta.no_telp',
                                    't_registrasi_users.email_bu',
                                    't_administrasi_kta.website',
                                    't_registrasi_users.foto_profile'
                                    )
                                ->limit(3)
                                ->get();
        $pengurusInkindo = DB::table('t_dp')
                                    ->join('provinsi', 't_dp.id_provinsi', '=', 'provinsi.id')
                                    ->select('t_dp.*', 'provinsi.name as nama_provinsi')
                                    ->limit(3)
                                    ->get();
        
        return view('frontend/content-pages/informasi.informasi-page', compact('anggotaSemuaProvinsi', 'pengurusInkindo'));
    }

    public function detailListMember()
    {
        $anggotaSemuaProvinsi = DB::table('t_registrasi_users')
        ->join('t_kta', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
        ->join('t_dp', 't_kta.id_dp', '=', 't_dp.id')
        ->join('provinsi', 'provinsi.id', '=', 't_dp.id_provinsi')
        ->join('t_detail_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
        ->join('t_pj_kta', 't_pj_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->join('t_administrasi_kta','t_administrasi_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->where('t_detail_kta.is_inserted', '=', 4)
        ->select(
            't_registrasi_users.nm_bu',
            'provinsi.name as nama_provinsi',
            't_kta.no_kta', 
            't_registrasi_users.bentuk_bu',
            't_pj_kta.nm_pjbu',
            't_administrasi_kta.alamat',
            't_administrasi_kta.no_telp',
            't_registrasi_users.email_bu',
            't_administrasi_kta.website',
            't_registrasi_users.foto_profile'
            )
       
        ->paginate();

        $provinsi = \App\Provinsi::all();

        return view('frontend/content-pages/informasi.detail-list-member', compact('anggotaSemuaProvinsi', 'provinsi'));
    }


    public function allMembersByProvince(Request $request)
    {
        $anggotaSemuaProvinsi = DB::table('t_registrasi_users')
        ->join('t_kta', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
        ->join('t_dp', 't_kta.id_dp', '=', 't_dp.id')
        ->join('provinsi', 'provinsi.id', '=', 't_dp.id_provinsi')
        ->join('t_detail_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
        ->join('t_pj_kta', 't_pj_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->join('t_administrasi_kta','t_administrasi_kta.id_detail_kta', '=', 't_detail_kta.id')
        ->where('t_detail_kta.is_inserted', '=', 4)
        ->select(
            't_registrasi_users.nm_bu',
            'provinsi.name as nama_provinsi',
            't_kta.no_kta', 
            't_registrasi_users.bentuk_bu',
            't_pj_kta.nm_pjbu',
            't_administrasi_kta.alamat',
            't_administrasi_kta.no_telp',
            't_registrasi_users.email_bu',
            't_administrasi_kta.website',
            't_registrasi_users.foto_profile'
            )
            ->where('provinsi.id', $request->provinsi_id)
       
        ->paginate();

      

        $provinsi = \App\Provinsi::all();

        return view('frontend/content-pages/informasi.detail-list-member', compact('anggotaSemuaProvinsi', 'provinsi'));
    }


    public function detailPengurus()
    {
        $pengurusInkindo = DB::table('t_dp')
        ->join('provinsi', 't_dp.id_provinsi', '=', 'provinsi.id')
        ->select('t_dp.*', 'provinsi.name as nama_provinsi')
        ->paginate(6);
        return view('frontend/content-pages/informasi.detail-list-pengurus', compact('pengurusInkindo'));
    }

    public function blogDetail($slug)
    {
        $recent_news = \App\Post::orderBy('date', 'DESC')->limit(3)->get(); 
        $category = \App\Category::orderBy('id', 'DESC')->get();
        $news = DB::table('post')
                ->join('category', 'post.id_category', '=', 'category.id')
                ->where('post.slug', $slug)
                ->select('post.*', 'category.nama_category')
                ->first();
        if(!empty($news)) {
            $comment = \App\Comment::where('id_post', $news->id)->get();
            
        } else {
            abort(404);
        }
        
        
        return view('frontend/content-pages/blog.blog-detail', compact('news', 'comment','category','recent_news'));
    }


    public function commentAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string',
            'email'     => 'required|email|max:30',
            'website'   => 'string',
            'reply'     => 'required|string',
        ]);


        if(! $validator->fails()) {
            $data_input = [
                'id_post'   => $request->id_post,
                'name'      => $request->name,
                'email'     => $request->email,
                'website'   => $request->website,
                'reply'     => $request->reply,
            ];

            if(\App\Comment::create($data_input)) {
                return redirect()->back()
                       ->with('successAddComment', 'Berhasil Menambah Komentar');
            }

            return redirect()->back()
            ->with('failedAddComment', 'Gagal Menambah Akun Super Admin');

        } else {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }


    }
    
}
