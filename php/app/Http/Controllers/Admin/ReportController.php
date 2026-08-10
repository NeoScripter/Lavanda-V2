<?php

declare(strict_types=1);

namespace Http\Controllers\Admin;

use Exception;
use Support\Auth;
use Http\Controller;
use Http\Models\Report;
use Http\Requests\Report\StoreReportRequest;
use Http\Requests\Report\UpdateReportRequest;

class ReportController extends Controller
{
    public function beforeroute(\Base $hive)
    {
        if (! Auth::check()) {
            $hive->reroute('@login');
        }
    }

    public function index()
    {
        $reports = new Report();
        $reports = $reports->find(null, ['order' => 'priority DESC']);

        view('pages/admin/reports/index', [
            'title' => 'All Reportletters',
            'reports' => $reports,
        ]);
    }

    public function create()
    {
        view('pages/admin/reports/create');
    }

    public function edit(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $report = new Report();
        $report->load(['id = ?', $id]);

        view('pages/admin/reports/edit', [
            'title' => $report->title,
            'report' => $report,
        ]);
    }

    public function store(\Base $hive)
    {
        $request = $this->request(StoreReportRequest::class);
        $request->validate();
        $data = $request->all();
        $data['src'] = $request->input('src')[0];

        $rows = $hive->DB->exec("SELECT MAX(priority) FROM reports");
        $priority = (empty($rows) || empty($rows[0]['max'])) ? 1 : ((int) $rows[0]['max']) + 1;

        $data['priority'] = $priority;

        $report = new Report();
        $report->copyFrom($data);
        $report->save();

        notify('Report successfully created!');
        $hive->reroute('@admin_reports_index');
    }

    public function update(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $request = $this->request(UpdateReportRequest::class);
        $request->validate();

        $report = new Report();
        $report->load(['id = ?', $id]);

        if ($report->dry()) {
            throw new Exception('Report not found');
        }

        $data = $request->all();

        if (! empty($request->input('src'))) {
            purge_file($report->src);
            $data['src'] = $request->input('src')[0];
        }

        $report->copyFrom($data);
        $report->save();

        notify('Report successfully updated!');
        $hive->reroute("@admin_reports_edit(@id=$id)");
    }

    public function destroy(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $report = new Report();
        $report->load(['id = ?', $id]);
        $report->erase();

        notify('Report successfully deleted!');
        $hive->reroute("@admin_reports_index");
    }
}
