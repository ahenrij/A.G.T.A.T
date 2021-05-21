<?php

namespace App\Http\Controllers;

use App\Log;
use App\Repositories\LogRepository;

class LogController extends Controller
{
    protected $log;
    protected $logRepository;

    public function __construct(LogRepository $logRepository)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->logRepository = $logRepository;
    }

    public function index()
    {
        $logs = Log::latest()->get();
        return view('logs.index',compact('logs'));
    }

    public function show($id)
    {
        $log = $this->logRepository->getById($id);
        return view('logs.show', compact('log'));
    }

}
