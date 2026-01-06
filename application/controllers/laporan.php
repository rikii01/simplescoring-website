<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Laporan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // Sesuaikan kalau kamu punya auth/role check:
        // if ($this->session->userdata('role') !== 'admin') redirect('dashboard');

        $this->load->model('Criteria_model', 'criteria');
        $this->load->model('Alternative_model', 'alternative');
        $this->load->model('Alternative_score_model', 'alt_score');
        $this->load->library('Dss_simple_scoring', null, 'dss');
    }

    /**
     * Download laporan SPK Simple Scoring (XLSX)
     * URL: /index.php/laporan/excel
     */
    public function excel()
    {
        // ========== Ambil data dasar ==========
        $criterias     = $this->criteria->all();
        $alternatives  = $this->alternative->get_all_with_score_count(); // untuk nama + id
        $dss           = $this->dss->run();

        if (!empty($dss['errors'])) {
            $this->session->set_flashdata('error', implode(' | ', $dss['errors']));
            redirect('alternatif');
        }

        $ranking = $dss['ranking'];
        $rankMap = [];
foreach ($ranking as $r) {
    $rankMap[(int)$r['alternative_id']] = (int)$r['rank'];
}
 

        // ========== Ambil raw score dari DB untuk bikin matrix ==========
        // Kita butuh raw matrix supaya laporan lengkap (sesuai excel)
        // Pastikan Alternative_score_model punya get_all(), kalau belum: tambahkan
        // return $this->db->get('alternative_scores')->result();
        $scores = $this->alt_score->get_all();

        // RAW matrix [alt_id][criteria_id] = score
        $raw = [];
        foreach ($scores as $s) {
            $raw[(int)$s->alternative_id][(int)$s->criteria_id] = (float)$s->score;
        }
        // lengkapi missing jadi 0
        foreach ($alternatives as $a) {
            foreach ($criterias as $c) {
                if (!isset($raw[(int)$a->id][(int)$c->id])) {
                    $raw[(int)$a->id][(int)$c->id] = 0;
                }
            }
        }

        // ========== Hitung bobot normalisasi (harus sama dengan DSS kamu) ==========
        $totalWeight = 0;
        foreach ($criterias as $c) $totalWeight += (float)$c->weight;
        if ($totalWeight <= 0) {
            $this->session->set_flashdata('error', 'Total bobot 0. Periksa bobot kriteria.');
            redirect('kriteria');
        }

        $weightNorm = []; // [criteria_id] => norm
        foreach ($criterias as $c) {
            $weightNorm[(int)$c->id] = (float)$c->weight / $totalWeight;
        }

        // ========== Hitung max/min per kriteria (harus sama dengan DSS kamu) ==========
        $max = [];
        $min = [];
        foreach ($criterias as $c) {
            $vals = [];
            foreach ($alternatives as $a) {
                $vals[] = (float)$raw[(int)$a->id][(int)$c->id];
            }
            $max[(int)$c->id] = max($vals);
            $min[(int)$c->id] = min($vals);
        }

        // ========== Normalisasi nilai (harus sama dengan DSS kamu) ==========
        $norm = [];
        foreach ($alternatives as $a) {
            foreach ($criterias as $c) {
                $x = (float)$raw[(int)$a->id][(int)$c->id];

                if ($c->type === 'benefit') {
                    $den = (float)$max[(int)$c->id];
                    $norm[(int)$a->id][(int)$c->id] = ($den > 0) ? ($x / $den) : 0;
                } else {
                    $norm[(int)$a->id][(int)$c->id] = ($x > 0) ? ((float)$min[(int)$c->id] / $x) : 0;
                }
            }
        }

        // ========== Build spreadsheet ==========
        $spreadsheet = new Spreadsheet();

        // ===================== SHEET 1: RANKING =====================
        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Ranking');

        $sheet1->setCellValue('A1', 'Rank');
        $sheet1->setCellValue('B1', 'Alternatif');
        $sheet1->setCellValue('C1', 'Skor Akhir');

        $r = 2;
        foreach ($ranking as $row) {
            $sheet1->setCellValue('A'.$r, (int)$row['rank']);
            $sheet1->setCellValue('B'.$r, (string)$row['alternative']);
            $sheet1->setCellValue('C'.$r, (float)$row['score']);
            $r++;
        }

        $sheet1->getStyle('A1:C1')->getFont()->setBold(true);
        $sheet1->getColumnDimension('A')->setWidth(8);
        $sheet1->getColumnDimension('B')->setWidth(30);
        $sheet1->getColumnDimension('C')->setWidth(18);

        // ===================== SHEET 2: KRITERIA & BOBOT NORMALISASI =====================
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Kriteria');

        $sheet2->setCellValue('A1', 'Kode');
        $sheet2->setCellValue('B1', 'Nama Kriteria');
        $sheet2->setCellValue('C1', 'Tipe');
        $sheet2->setCellValue('D1', 'Bobot (w)');
        $sheet2->setCellValue('E1', "Bobot Normalisasi (w')");

        $row = 2;
        foreach ($criterias as $c) {
            $sheet2->setCellValue('A'.$row, (string)$c->code);
            $sheet2->setCellValue('B'.$row, (string)$c->name);
            $sheet2->setCellValue('C'.$row, strtoupper((string)$c->type));
            $sheet2->setCellValue('D'.$row, (int)$c->weight);
            $sheet2->setCellValue('E'.$row, (float)$weightNorm[(int)$c->id]);
            $row++;
        }

        $sheet2->setCellValue('C'.$row, 'TOTAL');
        $sheet2->setCellValue('D'.$row, (float)$totalWeight);
        $sheet2->setCellValue('E'.$row, 1);

        $sheet2->getStyle('A1:E1')->getFont()->setBold(true);
        foreach (['A'=>10,'B'=>30,'C'=>12,'D'=>12,'E'=>22] as $col=>$w) {
            $sheet2->getColumnDimension($col)->setWidth($w);
        }

        // ===================== SHEET 3: MATRIX RAW =====================
        $sheet3 = $spreadsheet->createSheet();
        $sheet3->setTitle('Matrix_Raw');

        // Header
        $sheet3->setCellValue('A1', 'Alternatif');
        $colIndex = 2;
        foreach ($criterias as $c) {
            $cell = Coordinate::stringFromColumnIndex($colIndex) . '1';
            $sheet3->setCellValue($cell, (string)$c->code);
            $colIndex++;
        }

        // Body
        $row = 2;
        foreach ($alternatives as $a) {
            $sheet3->setCellValue('A'.$row, (string)$a->name);

            $colIndex = 2;
            foreach ($criterias as $c) {
                $cell = Coordinate::stringFromColumnIndex($colIndex) . $row;
                $sheet3->setCellValue($cell, (float)$raw[(int)$a->id][(int)$c->id]);
                $colIndex++;
            }
            $row++;
        }

        $sheet3->getStyle('A1:'.Coordinate::stringFromColumnIndex(count($criterias)+1).'1')->getFont()->setBold(true);
        $sheet3->getColumnDimension('A')->setWidth(30);

        // ===================== SHEET 4: MATRIX NORMALISASI =====================
        $sheet4 = $spreadsheet->createSheet();
        $sheet4->setTitle('Matrix_Normalisasi');

        $sheet4->setCellValue('A1', 'Alternatif');
        $colIndex = 2;
        foreach ($criterias as $c) {
            $cell = Coordinate::stringFromColumnIndex($colIndex) . '1';
            $sheet4->setCellValue($cell, (string)$c->code);
            $colIndex++;
        }

        $row = 2;
        foreach ($alternatives as $a) {
            $sheet4->setCellValue('A'.$row, (string)$a->name);

            $colIndex = 2;
            foreach ($criterias as $c) {
                $cell = Coordinate::stringFromColumnIndex($colIndex) . $row;
                $sheet4->setCellValue($cell, round((float)$norm[(int)$a->id][(int)$c->id], 6));
                $colIndex++;
            }
            $row++;
        }

        $sheet4->getStyle('A1:'.Coordinate::stringFromColumnIndex(count($criterias)+1).'1')->getFont()->setBold(true);
        $sheet4->getColumnDimension('A')->setWidth(30);

        // ===================== SHEET 5: DETAIL SKOR (w' * r_ij) + TOTAL =====================
        $sheet5 = $spreadsheet->createSheet();
        $sheet5->setTitle('Skor_Detail');

        $sheet5->setCellValue('A1', 'Alternatif');
        $colIndex = 2;
        foreach ($criterias as $c) {
            $cell = Coordinate::stringFromColumnIndex($colIndex) . '1';
            $sheet5->setCellValue($cell, (string)$c->code);
            $colIndex++;
        }
        $sheet5->setCellValue(Coordinate::stringFromColumnIndex($colIndex) . '1', 'TOTAL');

        $row = 2;
        foreach ($alternatives as $a) {
            $sheet5->setCellValue('A'.$row, (string)$a->name);

            $colIndex = 2;
            $total = 0;
            foreach ($criterias as $c) {
                $val = (float)$weightNorm[(int)$c->id] * (float)$norm[(int)$a->id][(int)$c->id];
                $total += $val;

                $cell = Coordinate::stringFromColumnIndex($colIndex) . $row;
                $sheet5->setCellValue($cell, round($val, 6));
                $colIndex++;
            }

            $sheet5->setCellValue(Coordinate::stringFromColumnIndex($colIndex) . $row, round($total, 6));
            $row++;
        }

        $sheet5->getStyle('A1:'.Coordinate::stringFromColumnIndex(count($criterias)+2).'1')->getFont()->setBold(true);
        $sheet5->getColumnDimension('A')->setWidth(30);

        // ========== Output download ==========
        $filename = 'Laporan_SPK_simplescoring.xlsx';

        // penting: jangan ada output sebelum header
        while (ob_get_level() > 0) { ob_end_clean(); }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');
        header('Pragma: public');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
