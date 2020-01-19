<?php

namespace App\Http\Controllers;

use App\Services\FileService;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class FileController extends Controller
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
        $this->middleware('auth');
        $this->fileService = new FileService();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function upload(Request $request)
    {
        $file = $request->file('file');
        if(empty($file)){
            return back()->with('error', 'Nenhum arquivo enviado!');
        }
        $this->fileService->processFile($file);

        return back()->with('success', 'Arquivo enviado com sucesso');
    }
}
