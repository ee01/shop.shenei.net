<?php

/**
 * 商品分类挂件
 *
 * @return  array   $category_list
 */
class Scategory_list_mallWidget extends BaseWidget
{
    var $_name = 'scategory_list_mall';
    var $_ttl  = 86400;

    function _get_data()
    {
        $cache_server =& cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if($data === false)
        {
            $gcategory_mod =& m('scategory');
            $gcategories = $gcategory_mod->get_list(-1);
    
            import('tree.lib');
            $tree = new Tree();
            $tree->setTree($gcategories, 'cate_id', 'parent_id', 'cate_name' );
    
            $data = $tree->getArrayList(0);
            $cache_server->set($key, $data, $this->_ttl);
        }

        return $data;
    }
}

?>