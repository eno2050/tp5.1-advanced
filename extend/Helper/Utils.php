<?php
/**
 * Created by PhpStorm.
 * User: Saviorlv(mrk-s)
 * Date: 2018/11/2
 * Time: 9:32
 * Email: 1042080686@qq.com
 */

namespace Helper;

use Overtrue\Pinyin\Pinyin;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Utils
{

    /**
     * 文件导出
     * @param $data
     * @param array $header
     * @param string $filename
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public static function exportExcel($data,$header=[],$filename='test_tpl'){
        $len = count($data);
        $cellNum = count($header);
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()->setCreator('erp-sys')
            ->setLastModifiedBy('php')
            ->setTitle('Office 2007 XLSX Document')
            ->setSubject('Office 2007 XLSX Document')
            ->setDescription('document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('export file');
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
        // Create a first sheet

        $spreadsheet->setActiveSheetIndex(0);
        if(is_array($header) && count($header)>0){
            foreach ($header as $k=>$v){
                $spreadsheet->getActiveSheet()->setCellValue($cellName[$k].'1', $v);
            }
        }
        // Add data
        if(is_array($header) && $cellNum>0){
            for($j=2;$j<=$len+1;$j++){
                foreach ($data[$j-2] as $k=>$v){
                    if(!is_numeric($v)){
                        $type = \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING;
                    }else{
                        $type = \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC;
                    }
                    if($k<1){
                        $type = \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING;
                    }
                    $spreadsheet->getActiveSheet()->setCellValueExplicit($cellName[$k].$j, $v, $type);
                }
            }
        }else{
            for($j=1;$j<=$len;$j++){
                foreach ($data[$j-1] as $k=>$v){
                    if(!is_numeric($v)){
                        $type = \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING;
                    }else{
                        $type = \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC;
                    }
                    if($k<1){
                        $type = \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING;
                    }
                    $spreadsheet->getActiveSheet()->setCellValueExplicit($cellName[$k].$j, $v, $type);
                }
            }
        }

        // Redirect output to a client’s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save('php://output');
        unset($spreadsheet);
        exit;
    }

    /**
     * 文件读取
     * @param null $filename
     * @return array
     */
    public static function importExcel($filename=null){
        if(null===$filename){
            return self::returnMsg('500','请添加需要读取的文件');
        }
        if(!is_file($filename)){
            return self::returnMsg('404','需要读取的文件不存在');
        }
        $ext = pathinfo($filename,PATHINFO_EXTENSION);

        if(!in_array($ext,['xlsx','xls'])){
            return self::returnMsg('500','该文件文件无法读取');
        }
        try {
            $inputFileType = IOFactory::identify($filename);
            $reader = IOFactory::createReader($inputFileType);
            $spreadsheet = $reader->load($filename);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
            @unlink($filename);
            return self::returnMsg('0','文件读取成功',$sheetData);
        }catch (Exception $e){
            return self::returnMsg('403','该文件文件读取读取失败');
        }
    }

    /**
     * @param string $Code
     * @param string $Msg
     * @param array $Data
     * @return array
     */
    public static function returnMsg($Code = '0',$Msg='',$Data=[]){
        return ['Code'=>$Code,'Msg'=>$Msg,'Data'=>$Data];
    }

    /**
     * 汉字转拼音截取首字母
     * @param string $string
     * @return bool|string
     */
    public static function transHans($string=''){
        if(!$string){
            return '';
        }
        // 小内存型
        //$pinyin = new Pinyin(); // 默认
        // 内存型
        $pinyin = new Pinyin('Overtrue\Pinyin\MemoryFileDictLoader');
        // I/O型
        // $pinyin = new Pinyin('Overtrue\Pinyin\GeneratorFileDictLoader');

        $str = strtoupper(substr($pinyin->abbr($string),0,1));

        return $str;
    }

    /**
     * 生成随机code
     * @param string $prefix
     * @param int $length
     * @return string
     */
    public static function generateRandCode($prefix="",$length=6){
        $num = rand(1,999999);

        $code = $prefix.strval(str_pad($num,6,'0',STR_PAD_LEFT));

        return $code;
    }
}