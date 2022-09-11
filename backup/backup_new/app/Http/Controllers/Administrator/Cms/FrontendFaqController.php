<?php

namespace App\Http\Controllers\Administrator\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use Ramsey\Uuid\Uuid;
use App\Faq;
use Validator;
use DB;

class FrontendFaqController extends Controller
{
    public function faq()
    {
        return view('administrator/content-pages/cms/frontend.faq-page');
    }

    public function getFaq()
    {
        $faq = DB::table('faq')->select('*');
        return Datatables::of($faq)

        ->addColumn('action', function ($faq) {
            return '
           <a href="'.route('administrator.cms.frontend-edit-faq', ['id' => $faq->id]).'" class="mb-2 mr-2 btn btn-warning" style="color:#fff">Edit</a>
           <a href="#" class="mb-2 mr-2 btn btn-danger" id="delete-faq" data-id-faq="'.route('administrator.cms.frontend-delete-faq', ['id' => $faq->id]).'"  style="color:#fff">Delete</a>
            ';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function addFaq()
    {
        return view('administrator/content-pages/cms/frontend.form-add-faq');
    }

    public function addFaqProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question'   => 'required|string|max:191',
            'answer'   => 'required|string|max:2000',
        ]);

        if (! $validator->fails()) {
            
            $faq =  Faq::create([
                'question' => $request->question,
                'answer' => $request->answer
            ]);
            if($faq) {
                return redirect()
                ->route('administrator.cms.frontend-faq')
                ->with('successAddFaq', 'Berhasil menambah data FAQ');
            }

            return redirect()
            ->route('administrator.cms.frontend-faq')
            ->with('failedAddFaq', 'Gagal menambah data FAQ');
           
        } else {
            return redirect()
            ->back()
            ->withErrors($validator);
        }
    }

    public function editFaq($id)
    {
        $faq = Faq::findOrFail($id);
        return view('administrator/content-pages/cms/frontend.form-edit-faq', compact('faq'));
    }

    public function updateFaqProcess(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'question'   => 'required|string|max:191',
            'answer'     => 'required|string|max:2000',
        ]);

        if (! $validator->fails()) {
            $faqInput =  [
                'question' => $request->question ,
                'answer' => $request->answer
            ];
           
            if ($faq->fill($faqInput)->save()) {
                return redirect()
                ->route('administrator.cms.frontend-faq')
                ->with('successUpdateFaq', 'Berhasil merubah data FAQ');
            }

            return redirect()
                ->route('administrator.cms.frontend-sponsorship')
                ->with('failedUpdateFaq', 'Gagal merubah data FAQ');
        } else {
            return redirect()
            ->back()
            ->withErrors($validator);
        }
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        if (!is_null($faq)) {
            if ($faq->delete()) {
                return redirect()->back();
            }
        } else {
            return redirect()->back()->with('failedDeleteFaq', 'Gagal menghapus data testimonial');
        }
    }
}
