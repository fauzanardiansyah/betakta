<?php

namespace App\Http\Controllers\Administrator\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Ramsey\Uuid\Uuid;
use App\Post;
use App\Category;
use Validator;
use File;
use DB;

class PortalBeritaController extends Controller
{
    public function index()
    {
        return view('administrator/content-pages/cms/portal.portal-berita-page');
    }

    public function getNews()
    {
        $news = DB::table('post')
        ->join('category', 'post.id_category', '=', 'category.id')
        ->select('post.*', 'category.nama_category', 'category.id as id_category');

    
        return Datatables::of($news)
 
    
        ->editColumn('cover', function ($cover) {
            return "<img src=".asset('storage/news-cover/'.$cover->cover)." style='width:100px' class='img-fluid'>";
        })

        ->addColumn('action', function ($news) {
            return '
           <a href="'.route('administrator.cms.form-edit', ['id' => $news->id]).'" class="mb-2 mr-2 btn btn-warning" style="color:#fff">Edit</a>
           <a href="#" class="mb-2 mr-2 btn btn-danger" id="delete-news" data-id-news="'.route('administrator.cms.delete-news', ['id' => $news->id]).'"  style="color:#fff">Delete</a>
            ';
        })
        ->rawColumns(['action','cover'])
        ->make(true);
    }

    public function formAddNews()
    {
        $category = Category::orderBy('id')->get();
        
        return view('administrator/content-pages/cms/portal.form-tambah-berita', compact('category'));
    }

    public function addNewsProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'   => 'required|string|max:191',
            'cover'   => 'required|file|mimes:jpg,jpeg,png,svg|max:10000',
            'id_category'   => 'required|string|max:191',
            'news' => 'required|string|max:10000'
        ]);

        
        if (! $validator->fails()) {
            $image = $request->file('cover');
            $name = uuid::uuid4().'.'.$image->getClientOriginalExtension();
            $destinationPath = storage_path('app/public/news-cover');
            $image->move($destinationPath, $name);
           
            $newsInput =  [
                'id_category' => $request->id_category,
                'title'       => $request->title,
                'slug'        => str_slug($request->title),
                'date'        => date('Y-m-d H:i:s'),
                'cover'       => $name,
                'news'        => $request->news
            ];
           
            if (Post::create($newsInput)) {
                return redirect()
                ->route('administrator.cms.portal-main')
                ->with('successAddNews', 'Berhasil menambah data berita');
            }

            return redirect()
                ->back()
                ->with('failedAddNews', 'Gagal menambah data berita');
        } else {
            return redirect()
            ->back()
            ->withErrors($validator);
        }
    }


    public function formEditNews($id)
    {
        $category = Category::orderBy('id')->get();
        $news = Post::findOrfail($id);
        return view('administrator/content-pages/cms/portal.form-edit-berita', compact('category', 'news'));
    }

    public function formUpdateNewsProcess(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'         => 'required|string|max:191',
            'cover'         => 'file|mimes:jpg,jpeg,png,svg|max:10000',
            'id_category'   => 'required|string|max:191',
            'news'          => 'required|string|max:10000'
        ]);

        if (! $validator->fails()) {
            $news = Post::findOrFail($id);

            if($request->hasFile('cover')) {
                $image = $request->file('cover');
                $name = uuid::uuid4().'.'.$image->getClientOriginalExtension();
                $destinationPath = storage_path('app/public/news-cover');
                $image->move($destinationPath, $name);
           
            $newsInput =  [
                'id_category' => $request->id_category,
                'title'       => $request->title,
                'slug'        => str_slug($request->title),
                'date'        => date('Y-m-d H:i:s'),
                'cover'       => $name,
                'news'        => $request->news
            ];
            } else {

                $newsInput =  [
                    'id_category' => $request->id_category,
                    'title'       => $request->title,
                    'slug'        => str_slug($request->title),
                    'date'        => date('Y-m-d H:i:s'),
                    'cover'       => $news->cover,
                    'news'        => $request->news
                ];

            }

            if($news->fill($newsInput)->save()) {
                return redirect()
                ->route('administrator.cms.portal-main')
                ->with('successUpdateNews', 'Berhasil merubah data berita');
            } 

            return redirect()
            ->route('administrator.cms.portal-main')
            ->with('failedUpdateNews', 'Gagal merubah data berita');

        } else {
            return redirect()
            ->back()
            ->withErrors($validator);
        }
    }

    public function destroy($id)
    {
        $news = Post::findOrFail($id);
        if (!is_null($news)) {
            if ($news->delete()) {
                $path = public_path('storage/news-cover/'.$news->cover) ;
                File::delete($path);
                return redirect()->back();
                
            }
        } else {
            return redirect()->back()->with('failedDeleteNews', 'Gagal menghapus data testimonial');
                
        }
    }
}
