<?php

namespace App\Admin\Extensions;

use Encore\Admin\Admin;
use Illuminate\Support\Facades\DB;

class CheckRow
{
    protected $id;
    protected $mobile;

    public function __construct($id)
    {
        $this->id = $id;
        $user = DB::table('jf_user')->where('id', $id)->first();
        $this->mobile = $user->mobile;
    }

    protected function script()
    {
        return <<<SCRIPT
$('.call_mobile').on('click', function () {
    alert($(this).data('id'));
});
SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());
        Admin::js('/static/js/app.js');

        return "<a class='btn btn-xs btn-success call_mobile' data-id='{$this->mobile}'><i class=\"fa fa-phone\" aria-hidden=\"true\"></i>拨号</a>
<a class='btn btn-xs btn-danger' data-id='{$this->mobile}'>挂机</a>";

    }

    public function __toString()
    {
        return $this->render();
    }
}
