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

class FrontendSponsorshipController extends Controller
{
    public function sponsorship()
    {
        return view('administrator/content-pages/cms/frontend.sponsorship-page');
    }

    public function getSponsorship()
    {
        $sponsorship = DB::table('sponsorship')->select('*');
        return Datatables::of($sponsorship)
        ->editColumn('logo_bu', function ($logo_bu) {
            return "<img src=".asset('storage/sponsorship/'.$logo_bu->logo_bu)." style='width:100px' class='img-fluid'>";
        })

        ->addColumn('action', function ($sponsorship) {
            return '
           <a href="'.route('administrator.cms.frontend-edit-sponsorship', ['id' => $sponsorship->id]).'" class="mb-2 mr-2 btn btn-warning" style="color:#fff">Edit</a>
           <a href="#" class="mb-2 mr-2 btn btn-danger" id="delete-sponsorship" data-id-sponsorship="'.route('administrator.cms.frontend-delete-sponsorship', ['id' => $sponsorship->id]).'"  style="color:#fff">Delete</a>
            ';
        })
        ->rawColumns(['action','logo_bu'])
        ->make(true);
    }

    public function addSponsorship()
    {
        return view('administrator/content-pages/cms/frontend.form-add-sponsorship');
    }

    public function addSponsorshipProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sponsorship'   => 'required|file|mimes:jpg,jpeg,png|max:10000',
        ]);

        if (! $validator->fails()) {
            $image = $request->file('sponsorship');
            $name = uuid::uuid4().'.'.$image->getClientOriginalExtension();
            $destinationPath = storage_path('app/public/sponsorship');
            $image->move($destinationPath, $name);
           
            $file =  Sponsorship::create([
                'logo_bu' => $name ,
            ]);
            return redirect()
                ->route('administrator.cms.frontend-sponsorship')
                ->with('successAddSponsorship', 'Berhasil menambah data testimonial');
        } else {
            return redirect()
            ->back()
            ->withErrors($validator);
        }
    }

    public function editSponsorship($id)
    {
        $sponsorship = Sponsorship::findOrFail($id);
        return view('administrator/content-pages/cms/frontend.form-edit-sponsorship', compact('sponsorship'));
    }

    public function updateSponsorshipProcess(Request $request, $id)
    {
        $sponsorship = Sponsorship::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'sponsorship'   => 'required|file|mimes:jpg,jpeg,png|max:10000',
        ]);

        if (! $validator->fails()) {
            $image = $request->file('sponsorship');
            $name = uuid::uuid4().'.'.$image->getClientOriginalExtension();
            $destinationPath = storage_path('app/public/sponsorship');
            $image->move($destinationPath, $name);
           
            $sponsorshipInput =  [
                'logo_bu' => $name ,
            ];
           
            if ($sponsorship->fill($sponsorshipInput)->save()) {
                return redirect()
                ->route('administrator.cms.frontend-sponsorship')
                ->with('successUpdateSponsorhip', 'Berhasil merubah data sponsorship');
            }

            return redirect()
                ->route('administrator.cms.frontend-sponsorship')
                ->with('failedUpdateSponsorship', 'Gagal merubah data testimonial');
        } else {
            return redirect()
            ->back()
            ->withErrors($validator);
        }
    }

    public function destroy($id)
    {
        $sponsorship = Sponsorship::findOrFail($id);
        if (!is_null($sponsorship)) {
            if ($sponsorship->delete()) {
                $path = public_path('storage/sponsorship/'.$sponsorship->logo_bu) ;
                File::delete($path);
                return redirect()->back();
            }
        } else {
            return redirect()->back()->with('failedDeleteTesti', 'Gagal menghapus data testimonial');
        }
    }
}
