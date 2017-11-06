<?php
/**
 * 
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/11/6
 * 
 */
class File
{
    #文件名
    var $filename = null;
    var $type = null;
    var $data = null;

    public function __construct()
    {

    }

    /**
     * 输入数据
     *
     * @param $filename
     * @param $type
     * @param $data
     */
    public function input($filename, $type, $data)
    {
        $this->filename = $filename;
        $this->type = strtolower($type);
        $this->data = $data;
    }

    public function create()
    {
        switch ($this->type) {
            case 'pdf':
                $this->pdf($this->data);
                exit;
            case 'word':
                $this->word($this->data);
                exit;
            case 'csv':
                $this->csv($this->data);
                exit;
            case 'excel':
                $this->excel($this->data);
                exit;
            default:
                echo "文件格式有误";
                exit;
        }
    }

    /**
     * 生成pdf文件
     *
     * @param $data
     */
    public function pdf($data)
    {
        require_once dirname(__FILE__) . '/filelib/tcpdf/tcpdf.php';
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('TCPDF Example 061');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        //$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        //$pdf->SetFont('helvetica', '', 10);
        $pdf->SetFont('stsongstdlight', '', 10);
        // add a page
        $pdf->AddPage();

        $html = $data;

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->lastPage();
        $filename = $this->filename.'.pdf';
        /* 默认是I：在浏览器中打开，D：下载，F：在服务器生成pdf ，S：只返回pdf的字符串  */
        $pdf->Output($filename , 'D');
    }

    /**
     * 生成Word文件
     *
     * @param $data
     * @throws Exception
     */
    public function word($data)
    {
        require_once dirname(__FILE__) . '/filelib/PHPWord/PHPWord.php';
        $Word = new PHPWord();
        $section = $Word->createSection();
        $Word->addFontStyle('rStyle', array('bold'=>false, 'italic'=>false, 'size'=>16));
        $Word->addParagraphStyle('pStyle', array('align'=>'left', 'spaceAfter'=>100));
        $section->addText($data, 'rStyle', 'pStyle');

        $fileName = $this->filename;

        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition:attachment;filename=".$fileName.".docx");
        header('Cache-Control: max-age=0');
        $objWriter = PHPWord_IOFactory::createWriter($Word, 'Word2007');
        $objWriter->save('php://output');
    }

    /**
     *
     * 导出CSV前数据处理
     * @param array $data
     * $data['header'] = array('username']=>'用户名', 'truename'=>'真实姓名');
     * $data['datalist'] = array(array('username']=>'haha', 'truename'=>'查查'), array('username'=>'ling', 'truename'=>'零'));
     */
    public function csv($data)
    {
        $header = $data['header'];
        $filename = $this->filename;
        $string = "";
        $keylist = array();
        foreach ($header as $key => $val) {
            $keylist[] = $key;
            $string .= $val . ',';
        }
        $string = trim($string, ',') . "\n";
        $d = $data['datalist'];

        foreach ($d as $value) {
            $list = '';
            foreach ($keylist as $k) {
                $list .= $value[$k] . ',';
            }
            $list = trim($list, ',') . "\n";
            $string .= $list;
        }

        $this->export_csv($filename, $string);
    }

    private function export_csv($filename, $data)
    {
        $filename = $filename . '.csv';
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=" . $filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        echo $data;
    }

    public function excel($data)
    {
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);

        define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

        date_default_timezone_set('Europe/London');
        require_once dirname(__FILE__) . '/filelib/PHPExcel.php';

        $inputFileName = $this->filename . '.xls';

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();
        #var_dump($objPHPExcel);exit;
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Mill生产")
            ->setLastModifiedBy("Mill生产")
            ->setTitle("Mill生产")
            ->setSubject("Mill生产")
            ->setDescription("Mill生产")
            ->setKeywords("Mill生产")
            ->setCategory("Mill生产");

        $hStart = 'A';
        $header = $data['header'];
        $rows = count($header);
        for ($i = 1; $i < $rows + 1; $i++){
            $row = $hStart++;
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($row . '1', $header[$i - 1]);
        }

        $data = $data['datalist'];
        $count = count($data);
        for ($i = 2; $i <= $count+1; $i++) {
            $hStart = 'A';
            for($o = 1; $o < $rows + 1; $o++) {
                $row = $hStart++;
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($row . $i, $data[$i-2][$o-1]);
            }
        }
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('Simple');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $inputFileName . '"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0


        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }
}