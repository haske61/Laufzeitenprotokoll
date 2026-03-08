<?php

namespace App\Http\Controllers;

use App\Models\BeanDelivery;
use App\Models\Machine;
use App\Models\MachineBreakdown;
use App\Models\ProductionLog;
use App\Models\ProductionOrder;
use App\Models\QualityCheck;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'machineCount' => Machine::count(),
            'beanDeliveryCount' => BeanDelivery::count(),
            'productionOrderCount' => ProductionOrder::count(),
            'productionLogCount' => ProductionLog::count(),
            'activeBreakdownCount' => MachineBreakdown::whereNull('resolved_at')->count(),
            'qualityCheckCount' => QualityCheck::count(),

            'recentDeliveries' => BeanDelivery::with('user')->latest()->take(5)->get(),
            'recentOrders' => ProductionOrder::with('user')->latest()->take(5)->get(),
            'recentBreakdowns' => MachineBreakdown::with(['machine', 'reportedBy'])->latest()->take(5)->get(),
            'recentLogs' => ProductionLog::with(['productionOrder', 'user'])->latest()->take(5)->get(),
        ];

        return view('dashboard', $data);
    }
}
