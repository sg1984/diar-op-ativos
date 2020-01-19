<?php

namespace App\Services;

use App\DTOs\RegionalCollectionDTO;
use App\MeasuringPoint;
use App\Regional;
use App\Substation;
use Illuminate\Support\Facades\DB;

class DataManagementService
{

    /**
     * @param RegionalCollectionDTO $regionalCollection
     * @return bool
     */
    public function processData(RegionalCollectionDTO $regionalCollection): bool
    {
        try {
            DB::beginTransaction();
            $this->clearData();
            $this->saveData($regionalCollection);
            DB::commit();

            return true;
        }catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    /**
     * @return bool
     */
    public function clearData(): bool
    {
        try {
            $regionals = Regional::with('substations.measuringPoints')
                ->get();

            foreach ($regionals as $regional){
                foreach($regional->substations as $substation){
                    foreach ($substation->measuringPoints as $measuringPoint){
                        $measuringPoint->delete();
                    }
                    $substation->delete();
                }
                $regional->delete();
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function saveData(RegionalCollectionDTO $regionalCollection)
    {
        foreach ($regionalCollection->getRegionals() as $regional) {
            $regionalData['name'] = $regional->getName();
            $regionalData['description'] = $regional->getName();
            $regionalData['created_by'] = auth()->id();
            $regionalData['updated_by'] = auth()->id();
            $newRegional = Regional::create($regionalData);

            foreach ($regional->getSubstations() as $substation){
                $substationData['name'] = $substation->getName();
                $substationData['description'] = $substation->getName();
                $substationData['regional_id'] = $newRegional->id;
                $substationData['created_by'] = auth()->id();
                $substationData['updated_by'] = auth()->id();
                $newSubstation = Substation::create($substationData);

                foreach ($substation->getMeasuringPoints() as $measuringPoint){
                    $measuringPointData['name'] = $measuringPoint->getName();
                    $measuringPointData['description'] = $measuringPoint->getName();
                    $measuringPointData['system'] = $measuringPoint->getSystem();
                    $measuringPointData['substation_id'] = $newSubstation->id;
                    $measuringPointData['created_by'] = auth()->id();
                    $measuringPointData['updated_by'] = auth()->id();
                    $measuringPointData['has_abnormality'] = $measuringPoint->hasAbnormality();
                    MeasuringPoint::create($measuringPointData);
                }
            }
        }

        return true;
    }
}
