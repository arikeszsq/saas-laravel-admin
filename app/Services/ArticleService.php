<?php
namespace App\Services;

use App\Models\Articles;
use App\Traits\FuncTrait;
use Carbon\Carbon;

class ArticleService extends BaseService
{
    use FuncTrait;

    /**
     * SystemCarouselService constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 文章列表
     * @param $params
     * @return mixed
     */
    public function articleList($params)
    {
        $list = Articles::query()->with('author')->where('status', 1)->orderBy('id','desc');

        if(isset($params['type']) && !empty($params['type'])){
            $list->where('type', $this->addslashes_str($params['type']));
        }

        if(isset($params['class']) && !empty($params['class'])){
            $list->where('class', $this->addslashes_str($params['class']));
        }

        if(isset($params['title']) && !empty($params['title'])){
            $list->where('title', 'like', '%'. $this->addslashes_str($params['title']) .'%');
        }
        $params['per_page'] = $params['per_page'] ?? 20;
        if (isset($params['per_page']) && $params['per_page']) {
            $data = $list->paginate($params['per_page'])->toArray();
            return $data;
        } else {
            return $list->get();
        }
    }

    /**
     * 删除
     * @param $id
     * @return mixed
     */
    public function delArticle($id)
    {
        $ad = Articles::query()->where('id', $id)->first();
        $ad->status = 2;
        $ad->deleted_at = Carbon::now();
        $ad->save();

        return $ad;
    }

    /**
     * 详情
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public function detail($id)
    {
        $article = Articles::query()->with('author')->where('id',$id)->first();
        return $article;
    }

}
