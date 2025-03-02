<?php

namespace App\Http\Controllers;

use App\Services\CompanyPerksService;
use Illuminate\Http\Request;

class PerksController extends Controller
{
    protected $perksService;

    public function __construct(CompanyPerksService $perksService)
    {
        $this->perksService = $perksService;
    }

    /**
     * Get company perks.
     */
    public function index(Request $request)
    {
        $perks = $this->perksService->getPerks();

        if ($perks) {
            return response()->json(['perks' => $perks]);
        }

        return response()->json(['message' => 'Unable to fetch perks.'], 500);
    }
}
