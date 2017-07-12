<?php
function regenUrl($key = '', $val = '', $action = '', $pageName = 'page')
{
    $query = \App\Libraries\QueryString::getInstance();
    $query->add($_SERVER['QUERY_STRING']);
    $query->remove($pageName);

    if ($key) {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                if ($v === null) {
                    $query->remove($k);
                } else {
                    $query->add([
                        $v => $val === null ? $val : $val[$k],
                    ]);
                }
            }
        } else {
            $query->add([
                $key => $val,
            ]);
        }
    }

    $action = $action ? url($action) : url()->current();
    return url($action) . $query->get();
}

function arr2str($arr, $glue = ',')
{
    return implode($glue, $arr);
}

function str2arr($str, $glue = ',')
{
    return explode($glue, $str);
}

function html_encode($str)
{
    return htmlspecialchars($str);
}

function html_decode($str)
{
    return htmlspecialchars_decode($str);
}

if (!function_exists('sql_debug')) {
    function sql_debug()
    {
        // AppServiceProvider 配置文件夹 local 默认开启
        \DB::enableQueryLog();
    }
}
if (!function_exists('getSql')) {
    function getSql()
    {
        //若没有开启 sql_debug 则需要手动调用
        return \DB::getQueryLog();
    }
}


if (!function_exists('array_change_key_case_recursive')) {
    function array_change_key_case_recursive($arr)
    {
        return array_map(function ($item) {
            if (is_array($item)) $item = array_change_key_case_recursive($item);
            return $item;
        }, array_change_key_case($arr));
    }
}

function array_change_key_camel_recursive($arr)
{
    return array_map(function ($item) {
        if (is_array($item)) $item = array_change_key_camel_recursive($item);
        return $item;
    }, camel_case($arr));
}

function verify_idcard($idcard = '')
{
    if (strlen($idcard) == 15) {
        // 如果身份证顺序码是996 997 998 999,这些是为百岁以上老人的特殊编码
        if (array_search(substr($idcard, 12, 3), array('996', '997', '998', '999')) != false) {
            $idcard = substr($idcard, 0, 6) . '18' . substr($idcard, 6, 9);
        } else {
            $idcard = substr($idcard, 0, 6) . '19' . substr($idcard, 6, 9);
        }
        $idcard = $idcard . _idcard_verify_number($idcard);
    }
    if (strlen($idcard) != 18) {
        return false;
    }
    $aCity = array(
        11 => "北京",
        12 => "天津",
        13 => "河北",
        14 => "山西",
        15 => "内蒙古",
        21 => "辽宁",
        22 => "吉林",
        23 => "黑龙江",
        31 => "上海",
        32 => "江苏",
        33 => "浙江",
        34 => "安徽",
        35 => "福建",
        36 => "江西",
        37 => "山东",
        41 => "河南",
        42 => "湖北",
        43 => "湖南",
        44 => "广东",
        45 => "广西",
        46 => "海南",
        50 => "重庆",
        51 => "四川",
        52 => "贵州",
        53 => "云南",
        54 => "西藏",
        61 => "陕西",
        62 => "甘肃",
        63 => "青海",
        64 => "宁夏",
        65 => "新疆",
        71 => "台湾",
        81 => "香港",
        82 => "澳门",
        91 => "国外"
    );

    // 非法地区
    if (!array_key_exists(substr($idcard, 0, 2), $aCity)) {
        return false;
    }

    // 验证生日
    if (!checkdate(substr($idcard, 10, 2), substr($idcard, 12, 2), substr($idcard, 6, 4))) {
        return false;
    }

    // 校验码比对
    $idcard_base = substr($idcard, 0, 17);
    if (_idcard_verify_number($idcard_base) != strtoupper(substr($idcard, 17, 1))) {
        return false;
    } else {
        return true;
    }
}

function _idcard_verify_number($idcard_base)
{
    // 加权因子
    $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);

    // 校验码对应值
    $verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
    $checksum = 0;
    for ($i = 0; $i < strlen($idcard_base); $i++) {
        $checksum += (int)substr($idcard_base, $i, 1) * $factor[$i];
    }
    $mod = strtoupper($checksum % 11);
    $verify_number = $verify_number_list[$mod];

    return $verify_number;
}


/**
 * 字节格式化 把字节数格式为 B K M G T 描述的大小
 *
 * @return string
 */

function byte_format($size, $dec = 2)
{
    $a = array("B", "KB", "MB", "GB", "TB", "PB");
    $pos = 0;
    while ($size >= 1024) {
        $size /= 1024;
        $pos++;
    }
    return round($size, $dec) . " " . $a[$pos];
}

// 自动转换字符集 支持数组转换

function auto_charset($fContents, $from = 'gbk', $to = 'utf-8')
{
    $from = strtoupper($from) == 'UTF8' ? 'utf-8' : $from;
    $to = strtoupper($to) == 'UTF8' ? 'utf-8' : $to;
    if (strtoupper($from) === strtoupper($to) || empty($fContents) || (is_scalar($fContents) && !is_string($fContents))) {
        //如果编码相同或者非字符串标量则不转换
        return $fContents;
    }
    if (is_string($fContents)) {
        if (function_exists('mb_convert_encoding')) {
            return mb_convert_encoding($fContents, $to, $from);
        } elseif (function_exists('iconv')) {
            return iconv($from, $to, $fContents);
        } else {
            return $fContents;
        }
    } elseif (is_array($fContents)) {
        foreach ($fContents as $key => $val) {
            $_key = auto_charset($key, $from, $to);
            $fContents[$_key] = auto_charset($val, $from, $to);
            if ($key != $_key) unset($fContents[$key]);
        }
        return $fContents;
    } else {
        return $fContents;
    }
}


function get_zodiac($date)
{
    if (strstr($date, '-') === false && strlen($date) !== 8) $date = date("Y-m-d", $date);
    if (strlen($date) === 8) {
        if (eregi('([0-9]{4})([0-9]{2})([0-9]{2})$', $date, $bir)) $date = "{$bir[1]}-{$bir[2]}-{$bir[3]}";
    }
    if (strlen($date) < 8) return false;
    $tmpstr = explode('-', $date);
    if (count($tmpstr) !== 3) return false;
    $month = substr($date, 5, 2); //取出月份
    $day = substr($date, 8, 2); //取出日期
    $y = ( int )$tmpstr [0];
    $m = ( int )$tmpstr [1];
    $d = ( int )$tmpstr [2];
    $result = array();
    $xzdict = array('摩羯', '宝瓶', '双鱼', '白羊', '金牛', '双子', '巨蟹', '狮子', '处女', '天秤', '天蝎', '射手');
    $zone = array(1222, 122, 222, 321, 421, 522, 622, 722, 822, 922, 1022, 1122, 1222);
    if ((100 * $m + $d) >= $zone [0] || (100 * $m + $d) < $zone [1]) {
        $i = 0;
    } else {
        for ($i = 1; $i < 12; $i++) {
            if ((100 * $m + $d) >= $zone [$i] && (100 * $m + $d) < $zone [$i + 1]) break;
        }
    }
    $result ['xz'] = $xzdict [$i] . '座';
    $gzdict = array(
        array('甲', '乙', '丙', '丁', '戊', '己', '庚', '辛', '壬', '癸'),
        array('子', '丑', '寅', '卯', '辰', '巳', '午', '未', '申', '酉', '戌', '亥')
    );
    $i = $y - 1900 + 36;
    $result ['gz'] = $gzdict [0] [($i % 10)] . $gzdict [1] [($i % 12)];

    $sxdict = array('鼠', '牛', '虎', '兔', '龙', '蛇', '马', '羊', '猴', '鸡', '狗', '猪');
    $result ['sx'] = $sxdict [(($y - 4) % 12)];
    return $result;
}


/**
 *
 * +--------------------------------------------------------------------
 * Description 递归创建目录
 * +--------------------------------------------------------------------
 *
 * @param  string $dir 需要创新的目录
 *                     +--------------------------------------------------------------------
 *
 * @return 若目录存在,或创建成功则返回为TRUE
 * +--------------------------------------------------------------------
 * @author gongwen
 * +--------------------------------------------------------------------
 */

function mkdirs($dir, $mode = 0777)
{
    if (is_dir($dir) || mkdir($dir, $mode)) return TRUE;
    if (!mkdirs(dirname($dir), $mode)) return FALSE;
    return mkdir($dir, $mode);
}


//生成16位md5
function md5_16($str)
{
    return substr(md5($str), 8, 16);
}


// 分析枚举类型配置值 格式 a:名称1,b:名称2
function parse_config_attr($string)
{
    $array = preg_split('/[,;\r\n]+/', trim($string, ",;\r\n"));
    if (strpos($string, ':')) {
        $value = array();
        foreach ($array as $val) {
            list($k, $v) = explode(':', $val);
            $v = explode('|', $v);
            if (count($v) > 1) {
                $value[$k] = array_map(function ($item) {
                    return trim($item);
                }, $v);
            } else {
                $value[$k] = trim($v[0]);
            }
        }
    } else {
        $value = $array;
    }
    return $value;
}

// 分析数组配置 格式 a:名称1,b:名称2
function parse_array_config($string)
{
    $string = trim($string);
    if (empty($string)) {
        return null;
    }
    if (0 === strpos($string, ':')) {
        // 采用函数定义
        return eval('return ' . substr($string, 1) . ';');
    } elseif (0 === strpos($string, '[config.')) {
        // 支持读取配置参数（必须是数组类型）
        return config(substr($string, 8, -1));
    }

    $array = preg_split('/[,;\r\n]+/', trim($string, ",;\r\n"));
    $value = array();
    foreach ($array as $val) {
        if (strpos($val, ':') !== FALSE) {
            list($k, $v) = explode(':', $val);
            $v = explode('|', $v);
            if (count($v) > 1) {
                $value[$k] = array_map(function ($item) {
                    return trim($item);
                }, $v);
            } else {
                $value[$k] = trim($v[0]);
            }
        } else {
            $value[] = $val;
        }
    }
    return $value;
}

// 还原数组配置
function revert_array_config($arr = [])
{
    if (is_array($arr)) {
        $str = '';
        foreach ($arr as $k => $v) {
            if (is_array($v)) {
                $str .= $k . ':';
                $str .= join('|', $v);
                $str .= "\n";
            } else {
                $str .= $k . ':' . $v . "\n";
            }
        }
        return trim($str);
    } else {
        return null;
    }
}

// 解析枚举配置
function parse_enum_config($str = '')
{
    $str = trim($str);
    if (strpos($str, '*') === FALSE) {
        return '';
    }
    $array = preg_split('/[,;\r\n]+/', trim($str, ",;\r\n"));
    foreach ($array as $val) {
        if (substr($val, -1) === '*') {
            $value = substr($val, 0, -1);
        }
    }
    if (is_null($value)) {
        $value = array_shift($array);
    }
    return $value;
}

// 数字转成中文
if (!function_exists('numToZh')) {
    function numToZh($num, $type)
    {
        // 如果开头是 0，系统默认是八进制/十六进制，暂时不考虑
        if (substr($num, 0, 2) != '0.' && substr($num, 0, 1) == 0) {
            return '数据格式不正确，请检查';
        }
        $number = explode('.', $num);
        $count = count($number);
        $integer = $count >= 1 ? $number[0] : '';
        $decimal = $count >= 2 ? str_split($number[1], 1) : '';   // 直接处理成数组
        $decimalZh = $decimal == '' ? '' : '点' . decimalFourFormat($decimal, $type);
        $integerZh = doTrans($integer, $type, 1);
        $filter = $integerZh . $decimalZh;
        if (mb_substr($filter, 0, 1) == '零') {
            if (mb_substr($filter, 0, 2) == '零点') {
                return $filter;
            }
            return mb_substr($filter, 1);
        } else {
            return str_replace('零点', '点', $integerZh . $decimalZh);
        }
    }
}
// 执行转换的过程
if (!function_exists('doTrans')) {
    function doTrans($number, $type, $isNeedUnit)
    {
        // 补位数字，如果不能被 4 整除，在前面补位缺少个数的 0
        $substitution = '0000';
        $need = strlen($number) % 4 ? 4 - strlen($number) % 4 : 0;
        $formatInteger = substr($substitution, 0, $need) . $number;
        // 单位数组，为了超过 4 位的数字准备
        $unitArray = ['', '万', '亿', '万'];
        $formatNumberArray = array_chunk(str_split($formatInteger, 1), 4, false);
        $str = '';
        foreach ($formatNumberArray as $key => $val) {
            $count = count($formatNumberArray);
            $unit = $count >= 2 ? $unitArray[$count - ($key + 1)] : '';
            $str .= integerFourFormat($val, $type, $isNeedUnit) . $unit;
        }
        return $str;
    }
}
// 四位为单位进行转换,带单位
if (!function_exists('integerFourFormat')) {
    function integerFourFormat($array, $type, $isNeedUnit = 1)
    {
        $zhSpecialArray = $type == 'chs' ? ['千', '百', '十', '零'] : ['仟', '佰', '拾', '零'];
        $zhPrimaryArray = getDataByType($type);
        // 千百十个的单位，用于处理整体超过5位，后几位是000x类的
        if ($array[0] == 0) {
            $thousand = '零';
        } else {
            $thousand = isset($array[0]) && $array[0] ? $zhPrimaryArray[$array[0]] . ($isNeedUnit ? $zhSpecialArray[0] : '') : '';
        }
        $hundred = isset($array[1]) && $array[1] ? $zhPrimaryArray[$array[1]] . ($isNeedUnit ? $zhSpecialArray[1] : '') : '';
        $decade = isset($array[2]) && $array[2] ? $zhPrimaryArray[$array[2]] . ($isNeedUnit ? $zhSpecialArray[2] : '') : '';
        $unit = isset($array[3]) && $array[3] ? $zhPrimaryArray[$array[3]] : '';
        return $thousand . $hundred . $decade . $unit;
    }
}
// 四位为单位进行转换,带单位
if (!function_exists('decimalFourFormat')) {
    function decimalFourFormat($array, $type)
    {
        $zhPrimaryArray = getDataByType($type);
        $str = '';
        foreach ($array as $key => $value) {
            $str .= $zhPrimaryArray[$value];
        }
        return $str;
    }
}
// 根据type 来获取数组
if (!function_exists('getDataByType')) {
    function getDataByType($type)
    {
        $zhs = ['零', '一', '二', '三', '四', '五', '六', '七', '八', '九', '十'];
        $zht = ['零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖', '拾'];
        return $type == 'chs' ? $zhs : $zht;
    }
}

function upload_image($file, $dir = null, $savename = null)
{
    $ret = (new \App\Services\UploadService())->upload($file, $dir, $savename);
    return $ret;
}

function get_thumb_url($path = '', $dimension = '')
{
    return (new \App\Services\UploadService())->getThumbUrl($path, $dimension);
}


/**
 * 把返回的数据集转换成Tree
 *
 * @param array  $list  要转换的数据集
 * @param string $pid   parent标记字段
 * @param        string $ child children 标记字段
 *
 * @return array
 */
function array_tree($list, $pk = 'id', $parent_id = 'parent_id', $child = '_child', $root = 0)
{
    // 创建Tree
    $tree = array();
    if (is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$parent_id];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}


/**
 * 在数据列表中搜索（支持多维数组）
 *
 * @access public
 *
 * @param array $list      数据列表
 * @param mixed $condition 查询条件
 *                         支持 array('name'=>$value) 或者 name=$value
 *
 * @return array
 */
function array_where_recursive($list, $condition)
{
    if (is_string($condition))
        parse_str($condition, $condition);
    // 返回的结果集合
    $resultSet = array();
    foreach ($list as $key => $data) {
        $find = false;
        foreach ($condition as $field => $value) {
            if (isset($data[$field])) {
                if (0 === strpos($value, '/')) {
                    $find = preg_match($value, $data[$field]);
                } elseif ($data[$field] == $value) {
                    $find = true;
                }
            }
        }
        if ($find)
            $resultSet[] =   &$list[$key];
    }
    return $resultSet;
}

/**
 * Array 转 Object
 */
function array2object($arr)
{
    return json_decode(json_encode($arr));
}
