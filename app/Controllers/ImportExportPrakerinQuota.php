<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use App\Controllers\BaseController;

use App\Models\PrakerinQuotaModel;

class ImportExportPrakerinQuota extends BaseController
{
    public function __construct()
    {
        $prakerin = new PrakerinQuotaModel();
        helper('alert');
    }

    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Format Bulan : 1,2,3,4,5,6,7,8,9,10,11,12')->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('4ED0A5');

        $sheet->setCellValue('A2', 'Format Tahun : YYYY')->mergeCells('A2:E2');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('4ED0A5');

        $sheet->setCellValue('A3', 'Format Tanggal Pengakuan Progress : YYYY-MM-DD')->mergeCells('A3:E3');
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->getStyle('A3')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('4ED0A5');

        $sheet->setCellValue('A5', 'BULAN');
        $sheet->setCellValue('B5', 'PKL');
        $sheet->setCellValue('C5', 'TAHUN');
        $sheet->setCellValue('D5', "PLANNING (P)\nREALISASI (R)");
        $sheet->setCellValue('E5', "TANGGAL\nPENGAKUAN PROGRESS");

        $sheet->getStyle('A5:E5')->getFont()->setBold(true)
            ->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A5:E5')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0E5872');

        // ================Untuk Alignment Center==============
        $styleColumn = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle('A5:E5')->applyFromArray($styleColumn);
        $sheet->getStyle('A5:E5')->getAlignment()->setWrapText(true);

        // =================Untuk Border=========================
        $borderArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ]
            ],
        ];
        $sheet->getStyle('A5:E1000')->applyFromArray($borderArray);

        $sheet->getColumnDimension('A')->setWidth(75, 'px');
        $sheet->getColumnDimension('B')->setWidth(75, 'px');
        $sheet->getColumnDimension('C')->setWidth(75, 'px');
        $sheet->getColumnDimension('D')->setWidth(125, 'px');
        $sheet->getColumnDimension('E')->setWidth(175, 'px');

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=Template_Upload_Prakerin.xlsx');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }
}
