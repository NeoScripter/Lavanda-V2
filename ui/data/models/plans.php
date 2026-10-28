
<?php

use Enums\PlanSlug;

return [
    PlanSlug::ONE_TIME->value => [
        'image' => '/assets/images/pages/plans/plan-1/plan-1',
        'headline' => qquila13 вопроса - 3 ответаqquila2
,
        'description' => qquila1Когда нужен ответ на то, что волнует прямо сейчасqquila2
,
    ],
    PlanSlug::MONTHLY->value => [
        'image' => '/assets/images/pages/plans/plan-2/plan-2',
        'headline' => qquila1Неограниченное число обращенийqquila2
,
        'description' => qquila1В период, когда один разговор не решает всеqquila2
,
    ],
    PlanSlug::YEARLY->value => [
        'image' => '/assets/images/pages/plans/plan-3/plan-3',
        'headline' => qquila1Неограниченное число обращенийqquila2
,
        'description' => qquila1Когда хочется чтобы пространство для размышлений было рядом 365 дней в годуqquila2
,
    ],
    PlanSlug::PERSONAL->value => [
        'image' => '/assets/images/pages/plans/plan-4/plan-4',
        'headline' => qquila1Персональный разборqquila2
,
        'description' => qquila1Заполните форму, выберите формат и получите личный ответ от Lavanda на почту в течение 3 днейqquila2
,
    ],
];
