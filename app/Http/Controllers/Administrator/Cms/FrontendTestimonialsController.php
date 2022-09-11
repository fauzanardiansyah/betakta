<?php

namespace App\Http\Controllers\Administrator\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Ramsey\Uuid\Uuid;
use App\Testimonials;
use Validator;
use DB;
use File;

class FrontendTestimonialsController extends Controller
{
    public function testimonials()
    {
        return view('administrator/content-pages/cms/frontend.testimonials-page');
    }

    public function getTestimonials()
    {
        $testimonials = DB::table('testimonials')->select('*');
        return Datatables::of($testimonials)
        ->editColumn('profile_picture', function ($profile_picture) {
            return "<img src=".asset('storage/foto-testimonial/'.$profile_picture->profile_picture)." style='width:100px' class='img-fluid'>";
        })

        ->addColumn('action', function ($testimonials) {
            return '
           <a href="'.route('administrator.cms.frontend-edit-testimonials', ['id' => $testimonials->id]).'" class="mb-2 mr-2 btn btn-warning" style="color:#fff">Edit</a>
           <a href="#" class="mb-2 mr-2 btn btn-danger" data-id-testi="'.route('administrator.cms.frontend-delete-testimonials', ['id' => $testimonials->id]).'" id="delete-testimonials"  style="color:#fff">Delete</a>
            ';
        })
        ->rawColumns(['action','profile_picture'])
        ->make(true);
    }

    public function addTestimonials()
    {
        return view('administrator/content-pages/cms/frontend.form-add-testimonials');
    }

    public function addTestimonialsProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'           => 'required|string|max:40',
            'foto_profile'   => 'required|file|mimes:jpg,jpeg,png|max:10000',
            'jabatan'        => 'required|string|max:40',
            'testimonials'   => 'required|string|max:2000',
        ]);

        if (! $validator->fails()) {
            $image = $request->file('foto_profile');
            $name = uuid::uuid4().'.'.$image->getClientOriginalExtension();
            $destinationPath = storage_path('app/public/foto-testimonial');
            $image->move($destinationPath, $name);
           
            $file =  Testimonials::create([
                'name' => $request->nama,
                'profile_picture' => $name ,
                'position' => $request->jabatan,
                'message' => $request->testimonials ,
            ]);
            return redirect()
                ->route('administrator.cms.frontend-testimonials')
                ->with('successAddTesti', 'Berhasil menambah data testimonial');
        } else {
            return redirect()
            ->back()
            ->withErrors($validator);
        }
    }

    public function editTestimonials($id)
    {
        $testimonials = Testimonials::findOrFail($id);
        return view('administrator/content-pages/cms/frontend.form-edit-testimonials',compact('testimonials'));
    }

    public function updateTestimonialsProcess(Request $request, $id)
    {
        $testimonials = Testimonials::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'nama'           => 'required|string|max:40',
            'foto_profile'   => 'file|mimes:jpg,jpeg,png|max:10000',
            'jabatan'        => 'required|string|max:40',
            'testimonials'   => 'required|string|max:2000',
        ]);

        if (! $validator->fails()) {

            if($request->hasFile('foto_profile')) {
            $image = $request->file('foto_profile');
            $name = uuid::uuid4().'.'.$image->getClientOriginalExtension();
            $destinationPath = storage_path('app/public/foto-testimonial');
            $image->move($destinationPath, $name);
           
            $testimonialsInput =  [
                'name' => $request->nama,
                'profile_picture' => $name ,
                'position' => $request->jabatan,
                'message' => $request->testimonials ,
            ];
           
            } else {
                $testimonialsInput =  [
                    'name' => $request->nama,
                    'position' => $request->jabatan,
                    'message' => $request->testimonials ,
                ];
               
            }

            
            if($testimonials->fill($testimonialsInput)->save()) {
                return redirect()
                ->route('administrator.cms.frontend-testimonials')
                ->with('successUpdateTesti', 'Berhasil merubah data testimonial');
            }

            return redirect()
                ->route('administrator.cms.frontend-testimonials')
                ->with('failedUpdateTesti', 'Gagal merubah data testimonial');
            
            
        } else {
            return redirect()
            ->back()
            ->withErrors($validator);
        }
    }

    public function destroy($id)
    {
        $testimonials = Testimonials::findOrFail($id);
        if (!is_null($testimonials)) {
            if ($testimonials->delete()) {
                $path = public_path('storage/foto-testimonial/'.$testimonials->profile_picture) ;
                File::delete($path);
                return redirect()->back();
                
            }
        } else {
            return redirect()->back()->with('failedDeleteTesti', 'Gagal menghapus data testimonial');
                
        }
    }
}
