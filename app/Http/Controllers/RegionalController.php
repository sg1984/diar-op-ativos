<?php

namespace App\Http\Controllers;

use App\Regional;
use Illuminate\Http\Request;

class RegionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regionals = Regional::all();

        return view('regional.index', compact('regionals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth()->check()) {
            return redirect('/regional');
        }

        return view('regional.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!auth()->check()) {
            return redirect('/regional');
        }

        try {
            $storeData = $request->validate([
                'name' => 'required|max:255',
                'description' => 'required|max:255',
            ]);
            $storeData['created_by'] = auth()->id();
            $storeData['updated_by'] = auth()->id();
            Regional::create($storeData);

            return redirect('/regional')->with('success', 'Regional salva com sucesso');
        } catch (\Exception $e) {
            return redirect('/regional')->with('error', 'Não foi possível salvar a regional! Favor tentar novamente.');
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
        try {
            $regional = Regional::findOrFail($id);

            return view('regional.show', compact('regional'));
        } catch (\Exception $e) {
            return redirect('/regional')->with('error', 'Não foi possível encontrar a regional com id ' . $id);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!auth()->check()) {
            return redirect('/regional');
        }

        try {
            $regional = Regional::findOrFail($id);

            return view('regional.edit', compact('regional'));
        } catch (\Exception $e) {
            return redirect('/regional')->with('error', 'Não foi possível encontrar a regional com id ' . $id);
        }
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
        if(!auth()->check()) {
            return redirect('/regional');
        }

        try {
            $updateData = $request->validate([
                'name' => 'required|max:255',
                'description' => 'required|max:255',
            ]);
            $storeData['updated_by'] = auth()->id();
            Regional::whereId($id)->update($updateData);

            return redirect('/regional')->with('success', 'Regional atualizada');
        } catch (\Exception $e){
            return redirect('/regional')->with('error', 'Não foi possível atualizar a regional! Favor tentar novamente.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(!auth()->check()) {
            return redirect('/regional');
        }

        try {
            Regional::whereId($id)->delete();

            return redirect('/regional')->with('success', 'Regional apagada!');
        } catch (\Exception $e){
            return redirect('/regional')->with('error', 'Não é possível excluir uma regional com subestações!');
        }
    }
}
