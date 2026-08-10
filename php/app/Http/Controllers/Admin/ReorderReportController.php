<?php

declare(strict_types=1);

namespace Http\Controllers\Admin;

use Exception;
use Support\Auth;
use Http\Controller;
use Http\Models\Report;
use Http\Requests\Report\ReorderReportRequest;

class ReorderReportController extends Controller
{
    public function beforeroute(\Base $hive)
    {
        if (! Auth::check()) {
            $hive->reroute('@login');
        }
    }

    public function update(\Base $hive)
    {
        $request = $this->request(ReorderReportRequest::class);
        $request->validate();

        $target = new Report();
        $target->load(['id = ?', $request->input('target_id')]);

        if ($target->dry()) {
            throw new Exception('Target not found');
        }

        $dragged = new Report();
        $dragged->load(['id = ?', $request->input('dragged_id')]);

        if ($dragged->dry()) {
            throw new Exception('dragged not found');
        }

        $tmp = $target->priority;
        $target->priority = $dragged->priority;
        $dragged->priority = $tmp;

        $target->save();
        $dragged->save();

        $hive->reroute("@admin_reports_index");
    }
}
