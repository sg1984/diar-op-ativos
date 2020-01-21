<?php

namespace App\Http\Controllers;

use App\Regional;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * @var FileService
     */
    private $fileService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('guest');
        $this->fileService = new FileService();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $regionals = Regional::with('substations.measuringPoints')
            ->get();
        $treeXml = str_replace('<?xml version="1.0"?>', '', $this->fileService->getAllDataAsXml());


        return view('home', compact('treeXml'));
    }

    /**
     * @return string
     */
    public function getXml()
    {
        Storage::disk('local')->put('arvore.xml', $this->fileService->getAllDataAsXml());

        return Storage::get('arvore.xml');
    }
}
