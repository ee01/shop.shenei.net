<?php

/**
 * 每日推荐商品挂件
 *
 * @param   int     $img_recom_id   图文推荐id
 * @param   int     $txt_recom_id   文字推荐id
 * @return  array
 */
class Sale_everydayWidget extends BaseWidget
{
    var $_name = 'sale_everyday';
    var $_ttl  = 1800;

    function _get_data()
    {
        $cache_server =& cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if($data === false)
        {
            $recom_mod =& m('recommend');
            $img_goods_list = $recom_mod->get_recommended_goods($this->options['img_recom_id'], 3, true, $this->options['img_cate_id']);
//            $txt_goods_list = $recom_mod->get_recommended_goods($this->options['txt_recom_id'], 4, true, $this->options['txt_cate_id']);
//Add By 01↓
			if ($this->options['img_cate_id'] == $this->options['txt_cate_id']) {
				$imgs = 3;
				$txts = 4;
				$txt_goods_list = $recom_mod->get_recommended_goods($this->options['txt_recom_id'], $imgs+$txts, true, $this->options['txt_cate_id']);
				for ($i=$imgs;$i<$imgs+$txts;$i++) {
					$txt_goods_list[$i-$imgs]	= $txt_goods_list[$i];
					if ($i >= $txts) {unset($txt_goods_list[$i]);}
				}
			}else{
				$txt_goods_list = $recom_mod->get_recommended_goods($this->options['txt_recom_id'], 4, true, $this->options['txt_cate_id']);
			}
//Add By 01↑
            $cache_server->set($key, array(
                'img_goods_list'=> $img_goods_list,
                'txt_goods_list'=> $txt_goods_list,
            ), $this->_ttl);
        }

        return array(
            'img_goods_list'=> $data['img_goods_list'],
            'txt_goods_list'=> $data['txt_goods_list'],
        );
    }

    function get_config_datasrc()
    {
        // 取得推荐类型
        $this->assign('recommends', $this->_get_recommends());

        // 取得一级商品分类
        $this->assign('gcategories', $this->_get_gcategory_options(1));
    }

    function parse_config($input)
    {
        if ($input['img_recom_id'] >= 0)
        {
            $input['img_cate_id'] = 0;
        }
        if ($input['txt_recom_id'] >= 0)
        {
            $input['txt_cate_id'] = 0;
        }

        return $input;
    }
}

?>