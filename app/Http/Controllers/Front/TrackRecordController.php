<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\TrackRecordService;
use Illuminate\View\View;

class TrackRecordController extends Controller
{
    public function __construct(protected TrackRecordService $trackRecordService)
    {
    }

    public function index(): View
    {
        return view('front.track-record', $this->trackRecordService->getTrackRecordData());
    }
}
