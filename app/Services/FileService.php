<?php

namespace App\Services;

use App\DTOs\MeasuringPointDTO;
use App\DTOs\RegionalCollectionDTO;
use App\DTOs\RegionalDTO;
use App\DTOs\SubstationDTO;
use App\Regional;
use Illuminate\Http\UploadedFile;
use Spatie\ArrayToXml\ArrayToXml;

class FileService
{
    /**
     * @var DataManagementService
     */
    private $dataManagementService;

    /**
     * FileService constructor.
     */
    public function __construct()
    {
        $this->dataManagementService = new DataManagementService();
    }

    /**
     * @param UploadedFile $file
     * @return bool
     */
    public function processFile(UploadedFile $file): bool
    {
        $xml = simplexml_load_file($file->path());
        $newRegionalData = $this->convertXml($xml);

        return $this->dataManagementService->processData($newRegionalData);
    }

    /**
     * @param \SimpleXMLElement $xml
     * @return RegionalCollectionDTO
     */
    private function convertXml(\SimpleXMLElement $xml): RegionalCollectionDTO
    {
        return $this->addRegionals($xml->regional);
    }

    /**
     * @param \SimpleXMLElement $regionalsXml
     * @return array
     */
    private function addRegionals(\SimpleXMLElement $regionalsXml): RegionalCollectionDTO
    {
        $regionalCollection = new RegionalCollectionDTO();
        foreach ($regionalsXml as $regional){
            $newRegional = new RegionalDTO($regional->nome);
            $this->addSubstations($newRegional, $regional->subestacao);
            $regionalCollection->addRegional($newRegional);
        }

        return $regionalCollection;
    }

    /**
     * @param RegionalDTO       $regionalDTO
     * @param \SimpleXMLElement $substationsXml
     * @return RegionalDTO
     */
    private function addSubstations(RegionalDTO $regionalDTO,\SimpleXMLElement $substationsXml): RegionalDTO
    {
        foreach ($substationsXml as $substation){
            $newSubstation = new SubstationDTO($substation->nome);
            $newSubstation = $this->addMeasuringPoints($newSubstation, $substation->ponto);
            $regionalDTO->addSubstation($newSubstation);
        }

        return $regionalDTO;
    }

    /**
     * @param SubstationDTO     $substationDTO
     * @param \SimpleXMLElement $measuringPointsXml
     * @return SubstationDTO
     */
    public function addMeasuringPoints(SubstationDTO $substationDTO,\SimpleXMLElement $measuringPointsXml): SubstationDTO
    {
        foreach ($measuringPointsXml as $measuringPoint){
            $newMeasuringPoint = new MeasuringPointDTO(
                $measuringPoint->nome,
                $measuringPoint->anormalidade == 'true' ? true : false,
                $measuringPoint->sistema
            );
            $substationDTO->addMeasuringPoint($newMeasuringPoint);
        }

        return $substationDTO;
    }

    public function getAllDataAsXml()
    {
        $regionals = Regional::with('substations.measuringPoints.annotations.user')
            ->get();

        $baseArray = [];
        $regionalsData = [];
        foreach ($regionals as $regional) {
            $substations = [];
            foreach ($regional->substations as $substation) {
                $measuringPoints = [];
                foreach ($substation->measuringPoints as $measuringPoint){
                    $measuringPoints[] = [
                        'nome' => $measuringPoint->name,
                        'anormalidade' => $measuringPoint->has_abnormality ? 'true' : 'false',
                        'sistema' => $measuringPoint->system,
                    ];
                }

                $substations[] = [
                    'nome' => $substation->name,
                    'ponto' => $measuringPoints
                ];
            }

            $regionalData[] = [
                'nome' => $regional->name,
                'subestacao' => $substations
            ];
            $regionalsData['regional'] = $regionalData;
        }

        $xml = new ArrayToXml($regionalsData, 'raiz');
        $xml->setDomProperties(['formatOutput' => true]);

        return $xml->toXml();
    }
}
