<?php

declare(strict_types=1);

namespace Http\Controllers\Admin\CRUD;

use Exception;
use Http\Controller;
use Http\Models\Plan;
use Http\Requests\CRUD\Plan\UpdatePlanRequest;
use Traits\RequiresAdminRights;

class PlanController extends Controller
{
    use RequiresAdminRights;

    public function index()
    {
        $plans = new Plan();
        $plans = $plans->find(
            [],
            ['order' => 'created_at DESC']
        );

        view('pages/admin/plans/index', [
            'title' => 'All plans',
            'plans' => $plans,
        ]);
    }

    public function edit(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $plan = new Plan();
        $plan->load(['id = ?', $id]);

        view('pages/admin/plans/edit', [
            'title' => 'plans',
            'plan' => $plan,
        ]);
    }

    public function update(\Base $hive)
    {
        $id = $hive->PARAMS['id'];
        $request = $this->request(UpdatePlanRequest::class);
        $request->validate();

        $plan = new Plan();
        $plan->load(['id = ?', $id]);

        if ($plan->dry()) {
            throw new Exception('Plan not found');
        }

        $plan->copyFrom($request->all());
        $plan->save();

        notify($hive->get('admin.plan_successfully_updated'));

        $hive->reroute("@admin_plans_edit(@id=$id)");
    }
}
