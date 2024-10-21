<?php

namespace App\Http\Controllers;

use App\Services\ApiDataService;
use Illuminate\Http\JsonResponse;

class ApiDataController extends Controller
{
    public function __construct(protected ApiDataService $apiDataService)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function fetchData(): JsonResponse
    {
        $this->apiDataService->fetchAndStoreData();
        return response()->json(['message' => 'Data fetched and stored successfully']);
    }
}
