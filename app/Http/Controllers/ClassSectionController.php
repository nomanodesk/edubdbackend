<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InstituteClass;
use App\Models\ClassSection;
use Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ClassSectionController extends Controller
{

    public function index(Request $request)
    {
        // dd($request->input('id'));
        // dd($request);
        $classinfo = InstituteClass::where('id', $request->id)->get();
      
        $classsections = ClassSection::where('institue_class_id', $request->id)->get();
        // dd($classinfo);
        // $class_id = $request->input('id');
        if ($classsections->isEmpty()) {
            return view('admin.section.addsection',  compact('classinfo', 'classsections'));
        } else {
            return view('admin.section.listsection', compact('classinfo', 'classsections'))->with('i', (request()->input('page', 1) - 1) * 100);
        }
    }
    
    public function create(Request $request): View
    {
        
        $classinfo = InstituteClass::where('id', $request->input('institue_class_id'))->get();
        // return view('admin.section.addsection', ['class_id' => $request->input('institue_class_id')]);
        // dd($classdata);
        return view('admin.section.addsection', compact('classinfo'));
    }


    public function store(Request $request)
    {

        // dd($request);
        $request->validate([
            'sectionName' => 'required',
            'class_shift' => 'required',
            'class_version' => 'required',
            'institue_class_id' => 'required',
        ]);
        $findclasses = ClassSection::where('institue_class_id', $request->input('institue_class_id'))
            ->where('sectionName', $request->input('sectionName'))
            ->where('class_shift', $request->input('class_shift'))
            ->where('class_version', $request->input('class_version'))
            ->get();
            // dd($findclasses);
        if ($findclasses->isEmpty()) {
            $input = $request->all();
            ClassSection::create($input);
            return redirect()->route('class_sections.index')->with('success', 'Class Section has been added successfully.');
            // return redirect()->route('class_sections.index', ['institue_class_id' => $request->input('institue_class_id')])->with('success', 'Class Section has been added successfully.');
        } else{
            // dd($findclasses);
            return redirect()->route('class_sections.index')->with('institue_class_id', 'Class Section already exists!!');
            // return redirect()->route('class_sections.index', ['institue_class_id' => $request->input('institue_class_id')])->with('error', 'Class Section already exists!!');

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
