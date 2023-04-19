<?php

namespace App\Http\Controllers;

use App\Models\Departaments;
use App\Http\Requests\StoreDepartamentsRequest;
use App\Http\Requests\UpdateDepartamentsRequest;

class DepartamentsController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartamentsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Departaments $departaments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Departaments $departaments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartamentsRequest $request, Departaments $departaments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departaments $departaments)
    {
        //
    }
}
