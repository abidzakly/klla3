<?php

namespace App\Exports;

class MonitoringDoSpkExport extends BaseExport
{
    protected $columns = [
        'Nama Supervisor' => ['typeValue' => 'text', 'key' => 'nama_supervisor'],
        'Target DO' => ['typeValue' => 'integer', 'key' => 'target_do'],
        'Act DO' => ['typeValue' => 'integer', 'key' => 'act_do'],
        'GAP DO' => ['typeValue' => 'integer', 'key' => 'gap_do'],
        'Ach DO (%)' => ['typeValue' => 'decimal', 'key' => 'ach_do'],
        'Target SPK' => ['typeValue' => 'integer', 'key' => 'target_spk'],
        'Act SPK' => ['typeValue' => 'integer', 'key' => 'act_spk'],
        'GAP SPK' => ['typeValue' => 'integer', 'key' => 'gap_spk'],
        'Ach SPK (%)' => ['typeValue' => 'decimal', 'key' => 'ach_spk'],
        'Status' => ['typeValue' => 'text', 'key' => 'status'],
        'Tanggal Monitoring' => ['typeValue' => 'date', 'key' => 'date'],
    ];

    public function __construct($data, $fileName = null, $templateFileName = "")
    {
        $this->data = $data;
        $this->templateFileName = $templateFileName;
        $this->fileName = $fileName ?? 'Export_Monitoring_DO_SPK_' . now()->format('d_M_Y') . '.xlsx';

        parent::__construct($data, $this->columns, $this->fileName, $this->templateFileName);
    }
}
