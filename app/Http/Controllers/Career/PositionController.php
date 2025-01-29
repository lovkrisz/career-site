<?php

declare(strict_types=1);

namespace App\Http\Controllers\Career;

use App\Http\Controllers\Controller;
use App\Models\Career\Position;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('welcome');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Position $position): View
    {
        return view('career.position.show', ['position' => $position]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Position $position): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Position $position): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position): void
    {
        //
    }
}
