<?php

namespace App\Http\Controllers\Administrator\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Ramsey\Uuid\Uuid;
use App\Sponsorship;
use Validator;
use DB;
use File;
use Illuminate\Support\Facades\Storage;
class FrontendWarningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('administrator/content-pages/create_warning.warning-page');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('administrator/content-pages/create_warning.form-add-warning');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $validator = Validator::make($request->all(), [
            'image'   => 'required|file|mimes:jpg,jpeg,png|max:10000',
        ]);

        // dd($request->all());

        if (! $validator->fails()) {
            $image = $request->file('image');
            $name = uuid::uuid4().'.'.$image->getClientOriginalExtension();
            $destinationPath = storage_path('app/public/warning');
            $image->move($destinationPath, $name);
           
            $file =  \App\M_warning::create([
                'image' => $name ,
                'title' => $request->title ,
                'description' => $request->description ,
                'status' => $request->status ,
            ]);
            return redirect()
                ->route('warning.index')
                ->with('successAddWarning', 'Berhasil menambah data pemberitahuan');
        } else {
            return redirect()
            ->back()
            ->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $warning = \App\M_warning::find($id);
        return view('administrator/content-pages/create_warning/form-edit-warning', compact('warning'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $warning = \App\M_warning::find($id);
        // $validator = Validator::make($request->all(), [
        //     'image_update'   => 'required|file|mimes:jpg,jpeg,png|max:10000',
        // ]);

        // if (! $validator->fails()) 
        // {
            $image = $request->file('image_update');
            

            if(!empty($image))
            {
                $name = uuid::uuid4().'.'.$image->getClientOriginalExtension();
                $data_update =  [
                    'image' => $name ,
                    'title'=>$request->title,
                    'description'=>$request->description,
                    'status'=>$request->status,
                ];
                $destinationPath = storage_path('app/public/warning');
                $image->move($destinationPath, $name);
            }
            else
            {

                
                $data_update =  [
                    'title'=>$request->title,
                    'description'=>$request->description,
                    'status'=>$request->status,
                ];
                $data_update_status = ['status'=>'tidak_aktif'];
                \App\M_warning::update($data_update_status);
            }
           
           
            if ($warning->fill($data_update)->save()) {
                return 
                redirect()
                 ->route('warning.index')
                ->with('successAddWarning', 'Berhasil menambah data pemberitahuan');
            }

            return redirect()
                ->route('warning.index')
                ->with('successAddWarning', 'Berhasil menambah data pemberitahuan');
        // } else {
        //     return redirect()
        //     ->back()
        //     ->withErrors($validator);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $warning = \App\M_warning::where('id_warning',$id);
        // dd($warning->image);
        if (!is_null($warning)) {
                
                $image = \App\M_warning::where('id_warning',$id)->first();
                // $path = Storage::delete('warning/'.$image->image);
                //$path = public_path('storage/warning/'.$image->image) ;
                //File::delete($path);
                $warning->delete();
                
                // return redirect()->back();
                
        } else {
            return redirect()->back()->with('failedDeleteTesti', 'Gagal menghapus data testimonial');
                
        }
    }

    public function get_data()
    {
        //
        $warning = \App\M_warning::all();
        return Datatables::of($warning)
        ->editColumn('image', function ($image) {
            return "<img src=".asset('storage/warning/'.$image->image)." style='width:100px' class='img-fluid'>";
        })

        ->addColumn('action', function ($warning) {
            return '
           <a href="'.route('warning.edit', ['id' => $warning->id_warning]).'" class="mb-2 mr-2 btn btn-warning" style="color:#fff">Edit</a>
           <a href="#" class="mb-2 mr-2 btn btn-danger" id="delete-warning" get-id="'.$warning->id_warning.'" 
             style="color:#fff">Delete</a>
            ';
        })
        ->rawColumns(['action','image'])
        ->make(true);
    }
}
