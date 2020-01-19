<?php

namespace App\Http\Controllers;

use App\AnnotationLog;
use App\MeasuringPoint;
use App\Substation;
use Illuminate\Http\Request;

class MeasuringPointController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $measuringPoints = MeasuringPoint::all();

        return view('measuring-point.index', compact('measuringPoints'));
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

        $substations = Substation::all();

        return view('measuring-point.create', compact('substations'));
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
            return redirect('/measuring-point');
        }

        try {
            $storeData = $request->validate([
                'name' => 'required|max:255',
                'description' => 'required|max:255',
                'system' => 'required|max:255',
                'substation_id' => 'required',
            ]);
            $storeData['created_by'] = auth()->id();
            $storeData['updated_by'] = auth()->id();
            $storeData['has_abnormality'] = $request->has('has_abnormality') ? 1 : 0;
            MeasuringPoint::create($storeData);

            return redirect()->route('substation.show', $request->get('substation_id'))->with('success', 'Ponto de medição salvo com sucesso');
        }catch (\Exception $e) {
            return redirect()->route('substation.show', $request->get('substation_id'))->with('error', 'Não foi possível salvar o ponto de medição! Favor tentar novamente.');
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
            $measuringPoint = MeasuringPoint::with('annotations.user')->findOrFail($id);

            return view('measuring-point.show', compact('measuringPoint'));
        } catch (\Exception $e) {
            return redirect('/regional')->with('error', 'Não foi possível encontrar o ponto de medição com id ' . $id);
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
            return redirect('/measuring-point');
        }

        try {
            $measuringPoint = MeasuringPoint::findOrFail($id);
            $substations = Substation::all();

            return view('measuring-point.edit', compact('measuringPoint', 'substations'));
        } catch (\Exception $e) {
            return redirect('/measuring-point')->with('error', 'Não foi possível encontrar o ponto de medição com id ' . $id);
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
            return redirect('/measuring-point');
        }

        try {
            $updateData = $request->validate([
                'name' => 'required|max:255',
                'description' => 'required|max:255',
                'system' => 'required|max:255',
                'substation_id' => 'required',
            ]);
            $updateData['created_by'] = auth()->id();
            $updateData['updated_by'] = auth()->id();
            $updateData['has_abnormality'] = $request->has('has_abnormality') ? 1 : 0;
            MeasuringPoint::whereId($id)->update($updateData);

            $annotation = $request->get('annotation');
            if(!empty($annotation)) {
                $annotationData['measuring_point_id'] = $id;
                $annotationData['annotation'] = $annotation;
                $annotationData['created_by'] = auth()->id();
                AnnotationLog::create($annotationData);
            }

            return redirect()->route('substation.show', $request->get('substation_id'))->with('success', 'Ponto de medição atualizado com sucesso');
        }catch (\Exception $e) {
            return redirect()->route('substation.show', $request->get('substation_id'))->with('error', 'Não foi possível atualizar o ponto de medição! Favor tentar novamente.');
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
            $measuringPoint = MeasuringPoint::findOrFail($id);
            $substationId = $measuringPoint->substation_id;
            $measuringPoint->delete();

            return redirect()->route('substation.show', $substationId)->with('success', 'Ponto de medição apagado!');
        } catch (\Exception $e){
            return redirect('/regional')->with('error', 'Não é possível excluir o ponto de medição! Favor tentar novamente.');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveAnnotation(Request $request)
    {
        if(!auth()->check()) {
            return redirect('/regional');
        }

        try{
            $annotation = $request->get('annotation');
            $measuringPointId = $request->get('measuring_point_id');
            if(!empty($annotation)) {
                $annotationData['measuring_point_id'] = $measuringPointId;
                $annotationData['annotation'] = $annotation;
                $annotationData['created_by'] = auth()->id();
                AnnotationLog::create($annotationData);
            }

            return redirect()->route('measuring-point.show', $measuringPointId)->with('success', 'Anotação salva com sucesso');
        }catch (\Exception $e) {
            return redirect()->route('measuring-point.show', $measuringPointId)->with('error', 'Não foi possível salvar a anotação! Favor tentar novamente.');
        }
    }
}
