<?php

/**
 * 商品分类挂件
 *
 * @return  array   $category_list
 */
class Gcategory_list_mallWidget extends BaseWidget
{
    var $_name = 'gcategory_list_mall';
    var $_ttl  = 86400;

    function _get_data()
    {
        $cache_server =& cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if($data === false)
        {
            $gcategory_mod =& bm('gcategory', array('_store_id' => 0));
            $gcategories = $gcategory_mod->get_list(-1, true);
    
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