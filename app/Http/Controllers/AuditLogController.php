<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin');
    }

    public function index()
    {
        $auditLogs = AuditLog::with('user')->latest()->get();
        return view('backend.audit-logs.index', compact('auditLogs'));
    }

    public function show(AuditLog $auditLog)
    {
        return view('backend.audit-logs.show', compact('auditLog'));
    }
}