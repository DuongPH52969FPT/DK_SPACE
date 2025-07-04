<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCandidateRequest;
use App\Models\Candidate;
use App\Models\Canditate;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('candidate.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCandidateRequest $request)
    {
        $data = $request->validated();

        if($request->hasFile('avatar_path')) {
            $data['avatar_path'] = $request->file('avatar_path')->store('candidates/avatars', 'public');
        }

        if($request->hasFile('cv_path')) {
            $data['cv_path'] = $request->file('cv_path')->store('candidates/cvs', 'public');
        }
        Candidate::create($data);

        return redirect()->route('candidate.create')->with('success', 'Hồ sơ đã được gửi thành công!');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
