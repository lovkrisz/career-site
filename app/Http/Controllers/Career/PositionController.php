<?php

declare(strict_types=1);

namespace App\Http\Controllers\Career;

use App\Http\Controllers\Controller;
use App\Models\Career\Position;
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
     * Display the specified resource.
     */
    public function show(Position $position): View
    {
        return view('career.position.show', ['position' => $position]);
    }
}
