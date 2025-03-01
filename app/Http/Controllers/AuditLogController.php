<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * Display a list of audit log entries.
     */
    public function index()
    {
        $logs = AuditLog::latest()->get();
        return response()->json($logs);
    }
}
