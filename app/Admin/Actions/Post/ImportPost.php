<?php

namespace App\Admin\Actions\Post;

use App\Models\User;
use App\Models\UserExcel;
use App\Traits\UserTrait;
use Encore\Admin\Actions\Action;
use Encore\Admin\Facades\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;


class ImportPost extends Action
{
    use UserTrait;
    public $name = '导入数据';
    protected $selector = '.import-post';

    public function handle(Request $request)
    {
        $file = $request->file('file');
        $extension = $file->extension();
        $real_path = $file->getRealPath();
        $new_name = date('YmdHis') . mt_rand(100, 999) . '.' . $extension;
        $path = public_path('/uploads/excel/' . date('Y-m-d', time()));
        File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
        $file->move($path, $new_name);

        $file_path = 'uploads/excel/' . date('Y-m-d', time()) . '/' . $new_name;
        $spreadsheet = IOFactory::load($file_path);
        $sheet = $spreadsheet->getActiveSheet();
        // 取得总行数
        $highestRow = $sheet->getHighestRow();
        // 取得总列数
        $highestColumn = $sheet->getHighestColumn();
        $data = [];
        $i = 0;
        for ($j = 2; $j <= $highestRow; $j++) {
            $data[$i]['company_name'] = $sheet->getCell("A" . $j)->getValue();
            $data[$i]['user_name'] = $sheet->getCell("B" . $j)->getValue();
            $data[$i]['mobile'] = $sheet->getCell("C" . $j)->getValue();
            $data[$i]['web_id'] = static::webId();
            $data[$i]['user_id'] = static::userId();
            $data[$i]['master_id'] = static::userId();
            $data[$i]['created_at'] = date('Y-m-d H:i:s',time());
            $data[$i]['updated_at'] = date('Y-m-d H:i:s',time());
            $i++;
        }
        try {
            UserExcel::query()->insert($data);
            return $this->response()->success('成功导入' . count($data) . '条数据')->refresh();
        } catch (\Exception $exception) {
            admin_error('导入失败，请检查数据格式' . $exception->getMessage());
        }
        return $this->response()->refresh();
    }

    public function form()
    {
//        $this->file('file', '请选择文件')
//            ->rules('required|max:1024|mimetypes:text/xls,text/xlsx');
        $this->file('file', '请选择文件')
            ->options(['showPreview' => false,
                'allowedFileExtensions' => ['xlsx', 'xls'],
                'showUpload' => false
            ]);
    }

    public function html()
    {
        return <<<HTML
        <a class="btn btn-sm btn-danger import-post"><i class="fa fa-upload"></i> 导入数据</a>
HTML;
    }
}
