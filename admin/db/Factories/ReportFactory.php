<?php

declare(strict_types=1);

namespace Factories;

use Http\Models\Report;
use Support\ImageHandler;

class ReportFactory
{
    public static function create(array $data)
    {
        $report_path =  APP_DIR . '/public' . $data['src'];
        $filename = substr($data['src'], strrpos($data['src'], '/') + 1);
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        if (!file_exists($report_path)) {
            throw new \RuntimeException("Report file not found: $report_path");
        }

        $new_dir = UPLOAD_DIR . "reports/";
        if (!is_dir($new_dir)) {
            mkdir($new_dir, 0755, true);
        }

        if (!copy($report_path, $new_dir . $filename)) {
            throw new \RuntimeException("Failed to copy $report_path to $new_dir");
        }

        $report = new Report();
        $data['src'] = ImageHandler::normalize_path($new_dir . $filename) . ".{$ext}";
        $report->copyFrom($data);
        $report->save();

        return $report;
    }
}
