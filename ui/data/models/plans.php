
<?php

use Enums\PlanSlug;

$hive = \Base::instance();

return [
    PlanSlug::ONE_TIME->value => [
        'image' => '/assets/images/pages/plans/plan-1/plan-1',
        'headline' => $hive->get("web.вопроса_ответа")
,
        'description' => $hive->get("web.когда_нужен_ответ_на_то_что_волнует_прямо_сейчас")
,
    ],
    PlanSlug::MONTHLY->value => [
        'image' => '/assets/images/pages/plans/plan-2/plan-2',
        'headline' => $hive->get("web.неограниченное_число_обращений")
,
        'description' => $hive->get("web.в_период_когда_один_разговор_не_решает_все")
,
    ],
    PlanSlug::YEARLY->value => [
        'image' => '/assets/images/pages/plans/plan-3/plan-3',
        'headline' => $hive->get("web.неограниченное_число_обращений")
,
        'description' => $hive->get("web.когда_хочется_чтобы_пространство_для_размышлений_было_рядом_дней_в_году")
,
    ],
    PlanSlug::PERSONAL->value => [
        'image' => '/assets/images/pages/plans/plan-4/plan-4',
        'headline' => $hive->get("web.персональный_разбор")
,
        'description' => $hive->get("web.заполните_форму_выберите_формат_и_получите_личный_ответ_от_на_почту_в_течение_дней")
,
    ],
];
