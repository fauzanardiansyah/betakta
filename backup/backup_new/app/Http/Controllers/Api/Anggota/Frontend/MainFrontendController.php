<?php

namespace App\Http\Controllers\Api\Anggota\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Frontend\SponsorShipsResource;
use App\Http\Resources\Frontend\TestimonialsResource;
use App\Http\Resources\Frontend\FaqResource;
use App\Http\Resources\Frontend\AllCouncilResource;
use Validator;
use DB;

class MainFrontendController extends Controller
{
    public function sponsorShips()
    {
        $sponsorship = \App\Sponsorship::orderBy('id', 'DESC')->get();
        if (!empty($sponsorship)) {
            // $data = [
            //     'data' => $sponsorship,
            //     'message' => 'Data sponsorship di temukan',
            //     'status' => 200
            // ];
            return SponsorShipsResource::collection($sponsorship);
            // return response()->json($data, 200);
        }

        return response()->json([
            'data' => null,
            'message' => 'Data sponsorship tidak di temukan',
            'status' => 404
        ], 200);
    }

    public function testimonials()
    {
        $testimonials = \App\Testimonials::orderBy('id', 'DESC')->limit(3)->get();
        if (!empty($testimonials)) {
            $data = [
                'data' => $testimonials,
                'message' => 'Data testimonials di temukan',
                'status' => 200
            ];
            //return TestimonialsResource::collection($testimonials);
            return response()->json($data, 200);
        }

        return response()->json([
         
                'data' => null,
                'message' => 'Data testimonials tidak di temukan',
                'status' => 404
           
        ], 200);
    }


    public function faqs()
    {
        $faq = \App\Faq::orderBy('id', 'DESC')->get();
        if (!empty($faq)) {
            $data = [
                'data' => $faq,
                'message' => 'Data FAQ di temukan',
                'status' => 200
            ];
            //return FaqResource::collection($faq);
            return response()->json($data, 200);
        }

        return response()->json([
                'data' => null,
                'message' => 'Data FAQ tidak di temukan',
                'status' => 404
        ], 200);
    }

    public function allProvinceOfCouncil()
    {
        $pengurus_inkindo = \App\DewanPengurus::with('provinsi')->paginate(3);

        if (!empty($pengurus_inkindo)) {
            $data = [
                'data' => $pengurus_inkindo,
                'message' => 'Data pengurus inkindo di temukan',
                'status' => 200
            ];
            // return AllCouncilResource::collection($pengurus_inkindo);
            return response()->json($data, 200);
        }

        return response()->json([
                'data' => null,
                'message' => 'Data pengurus inkindo tidak di temukan',
                'status' => 404
        ], 200);
    }

    public function checkMembersValidity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'npwp_email_bu' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        } else {
            $dataAnggota = DB::table('t_registrasi_users')
           ->join('t_kta', 't_kta.id_registrasi_users', '=', 't_registrasi_users.id')
           ->join('t_detail_kta', 't_detail_kta.id_kta', '=', 't_kta.id')
           ->join('t_pj_kta', 't_pj_kta.id_detail_kta', '=', 't_detail_kta.id')
           ->join('t_administrasi_kta', 't_administrasi_kta.id_detail_kta', '=', 't_detail_kta.id')
           ->select('t_kta.no_kta', 't_registrasi_users.nm_bu', 't_registrasi_users.bentuk_bu', 't_registrasi_users.npwp_bu', 't_pj_kta.nm_pjbu', 't_administrasi_kta.alamat', 't_kta.jenis_bu', 't_kta.kualifikasi', 't_kta.status_kta')
           ->where('t_registrasi_users.npwp_bu', $request->npwp_email_bu)
           ->orWhere('t_registrasi_users.email_bu', $request->npwp_email_bu)
           ->orderBy('t_detail_kta.created_at', 'desc')
           ->first();
       
            if (empty($dataAnggota)) {
                return response()->json([
                  'message' => 'Email / NPWP yang anda masukan tidak terdaftar sebagai anggota aktif inkindo',
                  'status' => 404
              ], 404);
            }

            $data = [

                'data' => [
                    "no_kta"       => $dataAnggota->no_kta,
                    "nm_bu"        => $dataAnggota->nm_bu,
                    "bentuk_bu"    => $dataAnggota->bentuk_bu,
                    "npwp_bu"      => $dataAnggota->npwp_bu,
                    "nm_pjbu"      => $dataAnggota->nm_pjbu,
                    "alamat"       => $dataAnggota->alamat,
                    "jenis_bu"     => $dataAnggota->jenis_bu,
                    "kualifikasi"  => $dataAnggota->kualifikasi,
                    "status_kta"   => ($dataAnggota->status_kta == 0) ? 'Aktif' : (($dataAnggota->status_kta == 1) ? 'Pasif' : 'Tidak Aktif')
                ],
                'message' => 'Cek data keabsahan di temukan',
                'status' => 200
                    
           ];
            return response()->json($data, 200);
        }
    }



    public function getAllNews()
    {
        $news = \App\Post::with('category')->get();
        $rowNews = count($news);
        if ($rowNews > 0) {
            foreach ($news as $news_item) {
                $data_news[] = [
                    'id'    => $news_item->id,
                    'title' => $news_item->title,
                    'slug'  => $news_item->slug,
                    'date'  => $news_item->date,
                    'cover' => asset('storage/news-cover/'.$news_item->cover),
                    'news'  => $news_item->news,
                    'category' => [
                        'nama_category' => $news_item->category->nama_category
                    ]
                    
                ];
            }
            $data = [
               'data' => $data_news,
               'message' => 'Data berita KTA Online',
               'status' => 200,
               
            ];

            return response()->json($data, 200);
        }

        return response()->json([
           'message' => 'Data berita KTA Online tidak di temukan',
           'status' => 404
       ], 404);
    }


    public function getDetailNews($id_news)
    {
        $news = \App\Post::with('category', 'comments')->where('id', $id_news)->first();
        if ($news) {
            $data = [
                'data' => [
                    'id'    => $news->id,
                    'title' => $news->title,
                    'slug'  => $news->slug,
                    'date'  => $news->date,
                    'cover' => asset('storage/news-cover/'.$news->cover),
                    'news'  => $news->news,
                    'category' => $news->category,
                    'comments' => $news->comments,
                'message' => 'Data berita KTA Online',
                'status' => 200,
                ]
             ];
 
            return response()->json($data, 200);
        }

        return response()->json([
            'message' => 'Data berita KTA Online tidak di temukan',
            'status' => 404
        ], 404);
    }
}
