<?php

namespace App\Domain\Career\Controllers;

use App\Domain\Career\Actions\CreatePositionApplicationAction;
use App\Domain\Career\Models\Position;
use App\Domain\Career\Requests\PositionApplyStoreRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Validator;

class PositionApplyController extends Controller
{

    public function index($slug): View
    {
        $position = Position::where('slug', $slug)->firstOrFail();
        return view('career.position.apply', compact('position'));
    }

    public function store(Request $request, Position $position, CreatePositionApplicationAction $action): RedirectResponse
    {
        $rules = [];
        if ($position->position_specific_questions) {
            foreach ($position->position_specific_questions as $option) {
                
                if ($option["required"]) {
                    $rules[$option["name"]] = 'required';
                } else {
                    $rules[$option["name"]] = 'nullable';
                }
                if ($option["format"] === 'input-text') {
                    $rules[$option["name"]] .= '|string';
                } elseif ($option["format"] === 'input-number') {
                    $rules[$option["name"]] .= '|integer';
                } elseif ($option["format"] === 'select') {
                    $rules[$option["name"]] .= '|in:' . $option["options"];
                }
            }
        }
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'email:rfc,dns', 'unique:applicants,email,NULL,id,position_id,' . $position->id],
            'mobile' => ['required', 'string'],
            'cv' => ['required', 'file', 'mimes:pdf,doc,docx,png'],
            'wage' => ['nullable', 'integer'],
            'introduction' => ['nullable', 'string'],
            'residence' => ['nullable', 'string'],
            'birthdate' => ['nullable', 'date'],
            ...$rules
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $action->handle($validator->validated(), json_encode($request->only(array_keys($rules))), $position);

        Session::flash('success', 'Application submitted successfully');
        return redirect()->route('position.apply', $position->slug);
    }

}
