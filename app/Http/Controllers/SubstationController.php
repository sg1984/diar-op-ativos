<?php

namespace App\Http\Controllers;

use App\MeasuringPoint;
use App\Regional;
use App\Substation;
use Illuminate\Http\Request;

class SubstationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $substations = Substation::all();

        return view('substation.index', compact('substations'));
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

        $regionals = Regional::all();

        return view('substation.create', compact('regionals'));
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
            return redirect('/substation');
        }

        try {
            $storeData = $request->validate([
                'name' => 'required|max:255',
                'description' => 'required|max:255',
                'regional_id' => 'required',
            ]);
            $storeData['created_by'] = auth()->id();
            $storeData['updated_by'] = auth()->id();
            Substation::create($storeData);

            return redirect()->route('regional.show', $request->get('regional_id'))->with('success', 'Subestação salva com sucesso');
        }catch (\Exception $e) {
            return redirect()->route('regional.show', $request->get('regional_id'))->with('error', 'Não foi possível salvar a subestação! Favor tentar novamente.');
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
            $substation = Substation::findOrFail($id);
            $measuringPoints = MeasuringPoint::all();

            return view('substation.show', compact('substation', 'measuringPoints'));
        } catch (\Exception $e) {
            return redirect('/regional')->with('error', 'Não foi possível encontrar a subestação com id ' . $id);
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
            $substation = Substation::findOrFail($id);
            $regionals = Regional::all();

            return view('substation.edit', compact('substation', 'regionals'));
        } catch (\Exception $e) {
            return redirect('/regional')->with('error', 'Não foi possível encontrar a subestação com id ' . $id);
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
        if (!auth()->check()) {
            return redirect('/substation');
        }

        try {
            $updateData = $request->validate([
                'name' => 'required|max:255',
                'description' => 'required|max:255',
                'regional_id' => 'required',
            ]);
            $updateData['updated_by'] = auth()->id();
            Substation::whereId($id)->update($updateData);

            return redirect()->route('regional.show', $request->get('regional_id'))->with('success', 'Subestação atualizada com sucesso!');
        } catch (\Exception $e){
            return redirect()->route('regional.show', $request->get('regional_id'))->with('error', 'Não foi possível atualizar a subestação! Favor tentar novamente.');
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
            $substation = Substation::findOrFail($id);
            $regionalId = $substation->regional_id;
            $substation->delete();

            return redirect()->route('regional.show', $regionalId)->with('success', 'Subestação removida com sucesso!');
        } catch (\Exception $e){
            return redirect('/regional')->with('error', 'Não foi possível excluir a subestação com id ' . $id);
        }
    }
}
