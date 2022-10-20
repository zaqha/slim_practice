<?php

declare(strict_types = 1);

namespace App\Domain;

use Psr\Log\LoggerInterface;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Shared\File;

class FileHandling
{

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function excel_parse($file): array
    {

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($file);

        $sheet = $spreadsheet->getActiveSheet();

        $res = array();
        foreach ($sheet->getRowIterator(1) as $row) {
            $tmp = array();
            foreach ($row->getCellIterator() as $cell) {
                //$tmp[] = $cell->getValue();
                $tmp[] = $cell->getFormattedValue();
            }
            // $res[$row->getRowIndex()] = $tmp;
            $res[] = $tmp;
        }

        //for chinese-zh , Encode multibyte Unicode characters literally (default is to escape as \uXXXX)
        return $res;
    }

    public function excel_export($title,$data)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $max_col_alpha = count($title);
        //全部欄位水平置中
        $sheet->getStyle("A1:".$this->IntToChr($max_col_alpha-1).(count($data)+1))->getAlignment()->setHorizontal('center');
        //全部欄位垂直置中
        $sheet->getStyle("A1:".$this->IntToChr($max_col_alpha-1).(count($data)+1))->getAlignment()->setvertical('center');
        //全部欄位框線顏色為黑色
        $styleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => '000000')
                ),
            ),
        );
        $sheet->getStyle("A1:".$this->IntToChr($max_col_alpha-1).(count($data)+1))->applyFromArray($styleArray);
        $mergestart = "";
        // //寫入title內容
        // //遇到空白將與前面一格合併
        for ($i=0; $i < count($title); $i++) { 
            $col=$this->IntToChr($i)."1";
            if (mb_strlen(strval($title[$i])) == 0 && $mergestart == "") {
                if ($i != 0) {
                    $mergestart = $this->IntToChr($i-1)."1";
                } else {
                    $mergestart = $col;
                }
            } else if (mb_strlen(strval($title[$i])) != 0 && $mergestart != "") {
                $sheet->mergeCells($mergestart.":".$this->IntToChr($i-1)."1");
                $mergestart = "";
                $sheet->setCellValue($col, $title[$i]);
            } else if (mb_strlen(strval($title[$i])) != 0 && $mergestart == "") {
                $sheet->setCellValue($col, $title[$i]);
            }
            if ($i == count($title) - 1 && $mergestart != "") {
                $sheet->mergeCells($mergestart.":".$col);
                $mergestart = "";
            }
        }
        //寫入data內容
        //遇到空白將與前面一格合併
        for ($i=0; $i < count($data); $i++) { 
            $y=0;
            foreach ($data[$i] as $value) {
                $col=$this->IntToChr($y).($i+2);
                if (mb_strlen(strval($value)) == 0 && $mergestart == "") {
                    if ($y != 0) {
                        $mergestart = $this->IntToChr($y-1).($i+2);
                    } else {
                        $mergestart = $col;
                    }
                } else if (mb_strlen(strval($value)) != 0 && $mergestart != "") {
                    $sheet->mergeCells($mergestart.":".$this->IntToChr($y-1).($i+2));
                    $mergestart = "";
                    $sheet->setCellValue($col, $value);
                } else if (mb_strlen(strval($value)) != 0 && $mergestart == "") {
                    $sheet->setCellValue($col, $value);
                }
                if ($y == (count($data[$i]) - 1) && $mergestart != "") {
                    $sheet->mergeCells($mergestart.":".$col);
                    $mergestart = "";
                }
                $y++;
            }
        }
        //寫入title內容
        for ($i=0; $i < count($title); $i++) { 
            $col=$this->IntToChr($i)."1";
            $sheet->setCellValue($col, $title[$i]);
        }
        //寫入data內容
        //遇到空白將與前面一格合併
        for ($i=0; $i < count($data); $i++) { 
            $y=0;
            foreach ($data[$i] as $value) {
                $col=$this->IntToChr($y).($i+2);
                $sheet->setCellValue($col, $value);
                $y++;
            }
        }
        //自動欄位寬度調整
        foreach (range(0, $max_col_alpha) as $columnID) {
            $sheet->getColumnDimensionByColumn($columnID)->setAutoSize(true);
        }
        $writer = new Xlsx($spreadsheet);
        $path = "excel_export_file";
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $savename = "excel_export_file/" . date("YmdHis").str_pad(strval(rand(0,100)),3,"0",STR_PAD_LEFT).".xlsx";
        $writer->save($savename);
        return $savename;
    }
    //數字轉英文(0=>A、1=>B、26=>AA...以此類推)
    function IntToChr($n) {
        for ($r = ""; $n >= 0; $n = intval($n / 26) - 1)
            $r = chr($n % 26 + 0x41) . $r;
        return $r;
    }

}
