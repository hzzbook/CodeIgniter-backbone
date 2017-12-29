<?php
/**
 * 标签系统设计
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/12/26
 * 
 */
include_once 'tutorial.php';
class tag extends tutorial
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 产品查询
     */
    public function product()
    {
        $proid = 1;
        $sql = "select * from "
            . $this->db->dbprefix('test_tag') . ' as tag ,'
            . $this->db->dbprefix('test_tagpro'). ' as tagpro '
            . " where tagpro.tagid = tag.tagid and tagpro.proid=$proid";

        #echo $sql;
        $result = $this->getResult($sql);
        var_dump($result);

    }

    /**
     * 根据tag查询，这个标签下的产品
     */
    public function searchByTag()
    {
        $tagname = 'php';
        $sql = "select tagid from "
            . $this->db->dbprefix('test_tag')
            ." where tagname='{$tagname}'";
        $tag_res = $this->getRow($sql);
        if ($tag_res == false) {
            echo '标签不存在';exit;
        } else {
            $sql = "select * from "
                . $this->db->dbprefix('test_product') . ' as pro, '
                . $this->db->dbprefix('test_tagpro'). ' as tagpro '
                . " where tagpro.proid=pro.id and tagpro.tagid='{$tag_res['tagid']}'";
            $pro_list = $this->getResult($sql);
            var_dump($pro_list);
        }

    }

    #创建标签
    public function addTag()
    {
        $tagname = 'php';
        $sql = "select tagid from "
            . $this->db->dbprefix('test_tag')
            ." where tagname='{$tagname}'";
        $tag_res = $this->getRow($sql);
        if ($tag_res == false) {
            $tagData = array(
                'tagname' => $tagname
            );
            $this->db->insert('test_tag', $tagData);
            $id = $this->db->insert_id().'：新插入';
        } else {
            $id  = $tag_res['tagid'];
        }
        var_dump($id);
    }

    #绑定标签和产品的关系
    public function addTagpro()
    {
        $taglist = array(
            1
        );
        $proid = 2;
        foreach ($taglist as $key) {
            $tagpro  = array(
                'tagid' => $key,
                'proid' => $proid
            );
            $this->db->insert('test_tagpro', $tagpro);
        }
    }

    public function deleteTag()
    {
        $proid = 1;
        $this->db->where('proid', $proid);
        $this->db->delete('test_tagpro');
    }

    #标签热度
    public function tagHot()
    {
        $sql = "select tag.tagid, tag.tagname, count(tagpro.proid) hot from "
            . $this->db->dbprefix('test_tagpro') . ' as tagpro, '
            . $this->db->dbprefix('test_tag'). ' as tag '
            . " where tag.tagid = tagpro.tagid group by tagpro.tagid order by hot limit 20";

        $result = $this->getResult($sql);
        var_dump($result);
    }

}