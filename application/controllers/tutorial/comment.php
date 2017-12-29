<?php
/**
 * 评论，评价系统
 * 说明：
 * 
 * @Author: hzz
 * @Date: 2017/12/27
 * 
 */
include_once 'tutorial.php';
class comment extends tutorial
{
    public function __construct()
    {
        parent::__construct();
    }

    public function addComment()
    {
        $postid = 1;
        $comment = 'good time';
        $commentData = array(
            'postid' => $postid,
            'content' => $comment,
            'logtime' => date('Y-m-d H:i:s'),
            'parentid' => 1
        );
        $this->db->insert('test_comment', $commentData);

    }

    public function deleteComment()
    {
        $proid = 1;
        $this->db->where('proid', $proid);
        $this->db->delete('test_comment');
    }

    #读取评论
    public function showComment()
    {
        $artid = 1;
        $sql = "select * from "
            . $this->db->dbprefix('test_comment'). ' as comment '
            . " where postid = '{$artid}'";

        $comment_list = $this->getResult($sql);
        var_dump($comment_list);

    }

    public function upComment()
    {
        $commentid = 1;
        $userid = 1;

        $sql = "select * from "
            . $this->db->dbprefix('test_updown'). ' as updown '
            . " where userid='{$userid}' and commentid='{$commentid}' and type=1";
        $updown = $this->getRow($sql);
        if ($updown == false) {
            $sql = "select * from "
                . $this->db->dbprefix('test_comment') . ' as comment '
                . " where id='{$commentid}'";
            $comment = $this->getRow($sql);

            if ($comment != false) {
                $upnum = $comment['upnum'] + 1;
                $upData = array(
                    'upnum' => $upnum
                );
                $table = 'test_comment';
                $this->db->where('id', $commentid);
                $this->db->update($table, $upData);

                $updownData = array(
                    'userid' => $userid,
                    'commentid' => $commentid,
                    'type' => 1
                );
                $this->db->insert('test_updown', $updownData);
            }
        } else {
            echo "您已经点过赞了";
        }
    }

    public function cancelUpComment()
    {
        $commentid = 1;
        $userid = 1;

        $sql = "select * from "
            . $this->db->dbprefix('test_updown'). ' as updown '
            . " where userid='{$userid}' and commentid='{$commentid}' and type=1";
        $updown = $this->getRow($sql);
        if ($updown != false) {
            $this->db->where('id', $updown['id']);
            $this->db->delete('test_updown');

            $sql = "select * from "
                . $this->db->dbprefix('test_comment') . ' as comment '
                . " where id='{$commentid}'";
            $comment = $this->getRow($sql);
            if ($comment != false) {
                $upnum = $comment['upnum'] - 1;
                $upData = array(
                    'upnum' => $upnum
                );
                $table = 'test_comment';
                $this->db->where('id', $commentid);
                $this->db->update($table, $upData);
            }
        }
    }

    public function downComment()
    {
        $commentid = 1;
        $userid = 1;

        $sql = "select * from "
            . $this->db->dbprefix('test_updown'). ' as updown '
            . " where userid='{$userid}' and commentid='{$commentid}' and type=2";
        $updown = $this->getRow($sql);
        if ($updown != false) {
            $sql = "select * from "
                . $this->db->dbprefix('test_comment') . ' as comment '
                . " where id='{$commentid}'";
            $comment = $this->getRow($sql);
            if ($comment != false) {
                $upnum = $comment['downnum'] - 1;
                $upData = array(
                    'downnum' => $upnum
                );
                $table = 'test_comment';
                $this->db->where('id', $commentid);
                $this->db->update($table, $upData);

                $updownData = array(
                    'userid' => $userid,
                    'commentid' => $commentid,
                    'type' => 2
                );
                $this->db->insert('test_updown', $updownData);
            }
        } else {
            echo "您已经点down了";
        }
    }

    public function cancelDownComment()
    {
        $commentid = 1;
        $userid = 1;

        $sql = "select * from "
            . $this->db->dbprefix('test_updown'). ' as updown '
            . " where userid='{$userid}' and commentid='{$commentid}' and type=2";
        $updown = $this->getRow($sql);
        if ($updown != false) {
            $this->db->where('id', $updown['id']);
            $this->db->delete('test_updown');

            $sql = "select * from "
                . $this->db->dbprefix('test_comment') . ' as comment '
                . " where id='{$commentid}'";
            $comment = $this->getRow($sql);
            if ($comment != false) {
                $upnum = $comment['downnum'] + 1;
                $upData = array(
                    'downnum' => $upnum
                );
                $table = 'test_comment';
                $this->db->where('id', $commentid);
                $this->db->update($table, $upData);
            }
        }
    }


}


