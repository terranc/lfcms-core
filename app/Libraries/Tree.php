<?php

namespace App\Libraries;
/**
 * 通用的树型类，可以生成任何树型结构
 */
class Tree
{

    /**
     * 生成树型结构所需要的2维数组
     *
     * @var array
     */
    public $arr = [];

    /**
     * 生成树型结构所需修饰符号，可以换成图片
     *
     * @var array
     */
    public $icon = ['│', '├', '└'];
    public $nbsp = "&nbsp;";
    private $str = '';

    public $child_key = '_children';
    /**
     * @access private
     */
    public $ret = '';

    /**
     * 构造函数，初始化类
     *
     * @param array 2维数组，例如：
     *              array(
     *              1 => array('id'=>'1','parent_id'=>0,'name'=>'一级栏目一'),
     *              2 => array('id'=>'2','parent_id'=>0,'name'=>'一级栏目二'),
     *              3 => array('id'=>'3','parent_id'=>1,'name'=>'二级栏目一'),
     *              4 => array('id'=>'4','parent_id'=>1,'name'=>'二级栏目二'),
     *              5 => array('id'=>'5','parent_id'=>2,'name'=>'二级栏目三'),
     *              6 => array('id'=>'6','parent_id'=>3,'name'=>'三级栏目一'),
     *              7 => array('id'=>'7','parent_id'=>3,'name'=>'三级栏目二')
     *              )
     *
     * @return array
     */
    public function init($arr = [])
    {
        $this->arr = $arr;
        $this->ret = '';
        return is_array($arr);
    }

    /**
     * 得到子级数组
     *
     * @param int
     *
     * @return array
     */
    protected function getChild($myId)
    {
        $newArr = [];
        if (is_array($this->arr)) {
            foreach ($this->arr as $id => $a) {

                if ($a['parent_id'] == $myId) {
                    $newArr[$id] = $a;
                }
            }
        }

        return $newArr ? $newArr : false;
    }

    /**
     * 得到树型结构
     *
     * @param int    ID，表示获得这个ID下的所有子级
     * @param string 生成树型结构的基本代码，例如："<option value=\$id \$selected>\$spacer\$name</option>"
     * @param int    被选中的ID，比如在做树型下拉框的时候需要用到
     *
     * @return string
     */
    public function getTree($myId, $str, $sid = 0, $adds = '', $str_group = '')
    {
        $number = 1;
        //一级栏目
        $child = $this->getChild($myId);

        if (is_array($child)) {
            $total = count($child);

            foreach ($child as $key => $value) {
                $j = $k = '';
                if ($number == $total) {
                    $j .= $this->icon[2];
                } else {
                    $j .= $this->icon[1];
                    $k = $adds ? $this->icon[0] : '';
                }
                $spacer = $adds ? $adds . $j : '';
                $selected = $value['id'] == $sid ? 'selected' : '';
                $id = 0;
                $nstr = '';
                @extract($value);

                $parentId = $value['parent_id'];


                $parentId == 0 && $str_group ? eval("\$nstr = \"$str_group\";") : eval("\$nstr = \"$str\";");

                $this->ret .= $nstr;
                $nbsp = $this->nbsp;
                $this->getTree($id, $str, $sid, $adds . $k . $nbsp, $str_group);
                $number++;
            }
        }
        return $this->ret;
    }

    public function getChildrenIds($myId = 0, $maxLevel = 0, $level = 1)
    {
        $returnArray = [];

        //一级数组
        $children = $this->getChild($myId);
        if (is_array($children)) {
            foreach ($children as $child) {
                $returnArray[] = $child['id'];
                if ($maxLevel === 0 || ($maxLevel !== 0 && $maxLevel > $level)) {
                    $mLevel = $level + 1;
                    $_children = $this->getChildrenIds($child['id'], $maxLevel, $mLevel);
                    if ($_children) {
                         foreach ( $_children as $_child) {
                             $returnArray[] = $_child;
                         }
                    }
                }

            }
        }

        return $returnArray;
    }

    /**
     * 生成树型结构数组
     *
     * @param     int       myID，表示获得这个ID下的所有子级
     * @param int $maxLevel 最大获取层级,默认不限制
     * @param int $level    当前层级,只在递归调用时使用,真实使用时不传入此参数
     *
     * @return array
     */
    public function getTreeArray($myId = 0, $maxLevel = 0, $level = 1)
    {
        $returnArray = [];

        //一级数组
        $children = $this->getChild($myId);

        if (is_array($children)) {
            foreach ($children as $child) {
                $child['_level'] = $level;
                $retArr = $child;
                if ($maxLevel === 0 || ($maxLevel !== 0 && $maxLevel > $level)) {

                    $mLevel = $level + 1;
                    $_children = $this->getTreeArray($child['id'], $maxLevel, $mLevel);
                    if ($_children) {
                        $retArr[$this->child_key] = $_children;
                    }
                }
                $returnArray[] = $retArr;

            }
        }

        return $returnArray;
    }

    /**
     * 同上一方法类似,但允许多选
     */
    public function getTreeMulti($myId, $str, $sid = 0, $adds = '')
    {
        $number = 1;
        $child = $this->getChild($myId);
        if (is_array($child)) {
            $total = count($child);
            foreach ($child as $id => $a) {
                $j = $k = '';
                if ($number == $total) {
                    $j .= $this->icon[2];
                } else {
                    $j .= $this->icon[1];
                    $k = $adds ? $this->icon[0] : '';
                }
                $spacer = $adds ? $adds . $j : '';

                $selected = $this->have($sid, $id) ? 'selected' : '';
                @extract($a);
                eval("\$nstr = \"$str\";");
                $this->ret .= $nstr;
                $this->getTreeMulti($id, $str, $sid, $adds . $k . '&nbsp;');
                $number++;
            }
        }
        return $this->ret;
    }

    /**
     * @param integer $myId 要查询的ID
     * @param string  $str  第一种HTML代码方式
     * @param string  $str2 第二种HTML代码方式
     * @param integer $sid  默认选中
     * @param integer $adds 前缀
     */
    public function getTreeCategory($myId = 0, $str, $str2, $sid = 0, $adds = '')
    {
        $number = 1;
        $child = $this->getChild($myId);
        if (is_array($child)) {
            $total = count($child);
            foreach ($child as $id => $a) {
                $j = $k = '';
                if ($number == $total) {
                    $j .= $this->icon[2];
                } else {
                    $j .= $this->icon[1];
                    $k = $adds ? $this->icon[0] : '';
                }
                $spacer = $adds ? $adds . $j : '';

                $selected = $this->have($sid, $id) ? 'selected' : '';
                @extract($a);
                if (empty($html_disabled)) {
                    eval("\$nstr = \"$str\";");
                } else {
                    eval("\$nstr = \"$str2\";");
                }
                $this->ret .= $nstr;
                $this->getTreeCategory($id, $str, $str2, $sid, $adds . $k . '&nbsp;');
                $number++;
            }
        }
        return $this->ret;
    }

    private function have($list, $item)
    {
        return (strpos(',,' . $list . ',', ',' . $item . ','));
    }


}

