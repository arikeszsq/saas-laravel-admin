<?php

namespace App\Http\Controllers;

use App\Models\AddUserCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $inputs = $request->all();
        $web_id = isset($inputs['web_id']) && $inputs['web_id'] ? $inputs['web_id'] : 0;
        $id = isset($inputs['id']) && $inputs['id'] ? $inputs['id'] : 0;
        if ($web_id) {
            $obj = AddUserCode::query()->where('id', $id)->first();
            $data_index = [
                'color' => $obj->body_color,
                'image' => $obj->banner_img,
                'web_id' => $obj->web_id,
            ];
            return view('index', $data_index);
        } else {
            $user = User::query()->find($id);
            $data_update = [
                'id' => $id,
                'company_name' => $user->company_name,
            ];
            return view('update', $data_update);
        }
    }

    public function add(Request $request)
    {
        $inputs = $request->all();
        $validator = \Validator::make($inputs, [
            'company_name' => 'required',
            'user_name' => 'required',
            'mobile' => 'required',
            'id_card' => 'required'
        ], [
            'company_name' => '企业名称必填',
            'user_name' => '联系人必填',
            'mobile' => '手机号必填',
            'id_card' => '身份证号码必填'
        ]);
        if ($validator->fails()) {
            return self::parametersIllegal($validator->messages()->first());
        }
        try {
            $data = [
                'web_id' => $inputs['web_id'],
                'company_name' => $inputs['company_name'],
                'user_name' => $inputs['user_name'],
                'mobile' => $inputs['mobile'],
                'id_card' => $inputs['id_card'],
            ];
            $ret = DB::table('jf_user')->insert($data);
            User::addLinkUrl();
            return self::success($ret);
        } catch (\Exception $e) {
            return self::error($e->getCode(), $e->getMessage());
        }
    }

    public function resultPage()
    {
        return view('result', ['msg' => '成功']);
    }

    public function update(Request $request)
    {
        $inputs = $request->all();
        $data = [
            'company_tax_no' => $this->getKeyValue('company_tax_no', $inputs),
            'money_need' => $this->getKeyValue('money_need', $inputs),
            'legal_name' => $this->getKeyValue('legal_name', $inputs),
            'legal_id_card' => $this->getKeyValue('legal_id_card', $inputs),
            'legal_mobile' => $this->getKeyValue('legal_mobile', $inputs),
            'legal_bank_no' => $this->getKeyValue('legal_bank_no', $inputs),
            'bank' => $this->getKeyValue('bank', $inputs),
            'legal_company' => $this->getKeyValue('legal_company', $inputs),
            'legal_house' => $this->getKeyValue('legal_house', $inputs),
            'edu' => $this->getKeyValue('edu', $inputs),
            'marry' => $this->getKeyValue('marry', $inputs),
            'marry_name' => $this->getKeyValue('marry_name', $inputs),
            'marry_mobile' => $this->getKeyValue('marry_mobile', $inputs),
            'marry_id_card' => $this->getKeyValue('marry_id_card', $inputs),
            'marry_work_detail' => $this->getKeyValue('marry_work_detail', $inputs),
            'pre_mobile' => $this->getKeyValue('pre_mobile', $inputs),
            'relation_o' => $this->getKeyValue('relation_o', $inputs),
            'relation_mob_o' => $this->getKeyValue('relation_mob_o', $inputs),
            'relation_t' => $this->getKeyValue('relation_t', $inputs),
            'relation_mob_t' => $this->getKeyValue('relation_mob_t', $inputs),
            'cert_pic' => json_encode($this->getKeyValue('cert_pic', $inputs)),
            'id_card_pic' => json_encode($this->getKeyValue('id_card_pic', $inputs))
        ];
        try {
            $ret = User::query()->where('id', $inputs['id'])->update($data);
            return self::success($ret);
        } catch (\Exception $e) {
            return self::error($e->getCode(), $e->getMessage());
        }

    }

    function getKeyValue($key, $inputs)
    {
        return isset($inputs[$key]) && $inputs[$key] ? $inputs[$key] : '';
    }


    public function upload(Request $request)
    {
        $file = $request->file('file');
        $url_path = 'images/' . date('Y-m-d') . '/';
        if (!file_exists($url_path)) {
            mkdir($url_path, 0700, true);
        }
        $rule = ['jpg', 'png', 'gif', 'jpeg', 'bmp'];
        if ($file->isValid()) {
            $clientName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            if (!in_array($extension, $rule)) {
                return '图片格式支持gif,jpg,jpeg,bmp,png';
            }
            $newName = md5(date("Y-m-d H:i:s") . $clientName) . "." . $extension;
            $file->move($url_path, $newName);
            return $url_path . $newName;
        }
    }


}
