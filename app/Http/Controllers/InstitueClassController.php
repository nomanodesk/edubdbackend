<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InstituteClass;

use Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class InstitueClassController extends Controller
{

    public function index()
    {
        $instituteclasses = InstituteClass::where('institution_id', Auth::user()->id)->simplepaginate(100);
        // dd($findinstitue);
        if ($instituteclasses->isEmpty()) {
            return view('admin.class.addclass');
        } else {
            return view('admin.class.listclass', compact('instituteclasses'))->with('i', (request()->input('page', 1) - 1) * 100);
        }
    }
    public function create()
    {
        return view('admin.class.addclass');
    }

    public function store(Request $request)
    {

        // dd($request);
        $request->validate([

            'className' => 'required',
            'class_level' => 'required',
            'institution_id' => 'required',
        ]);
        $findclasses = InstituteClass::where('institution_id', Auth::user()->id)->where('className', $request->input('className'))->get();
        if ($findclasses->isEmpty()) {
            $input = $request->all();
            InstituteClass::create($input);

            return redirect()->route('institute_classes.index')->with('success', 'Class has been added successfully.');
        } else if ($findclasses->isNotEmpty()) {
            return redirect()->route('institute_classes.index')->with('error', 'Class data already exists!!');
        }
    }


    public function edit(InstituteClass $instituteclass): View
    {
        return view('admin.class.editclass', compact('instituteclass'));
    }
    public function destroy(InstituteClass $instituteclass): RedirectResponse

    {
        $instituteclass->delete();
        return redirect()->route('instituteclasses.index')
            ->with('success', 'Class deleted successfully');
    }
}
