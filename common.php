<?php

class Wave
{

    var $id = "";

    var $pid = "";

    var $level = 0;

    var $asc = 0;

    var $high = 0;

    var $low = 0;

    var $beginTime = 0;

    var $endTime = 0;

    var $count = 0;

    var $childWave = array();
}

class Pref
{

    var $prefBuy = 0;

    var $prefSell = 0;

    var $current = 0;

    var $high = 0;

    var $low = 0;

    var $concept = 0;
}

class KV
{

    var $redis;

    function __construct()
    {
        $this->$redis = new Redis();
        $this->$redis->connect('127.0.0.1', 6379);
        if (! $this->$redis)
            die("redis connect error:");
    }

    function get($key)
    {
        return json_decode($this->$redis->get($key),true);
    }

    function set($key, $value)
    {
        $this->$redis->set($key, json_encode($value));
    }
    
    function delete($key) {
        $this->$redis->del($key);
    }
}

$kv = new KV();

$holidays = [
    20171230,
    20171231,
    20180101,
    20180215,
    20180216,
    20180217,
    20180218,
    20180219,
    20180220,
    20180221,
    20180405,
    20180406,
    20180407,
    20180429,
    20180430,
    20180501,
    20180616,
    20180617,
    20180618,
    20180922,
    20180923,
    20180924,
    20181001,
    20181002,
    20181003,
    20181004,
    20181005,
    20181006,
    20181007
];

$indexList = [["399243.SZ", "科研指数"],["000077.SH", "信息等权"],["399244.SZ", "公共指数"],["399351.SZ", "深圳报业指数"],["399397.SZ", "OCT文化"],["000018.SH", "180金融"],["000025.SH", "180基建"],["000026.SH", "180资源"],["000033.SH", "上证材料"],["000035.SH", "上证可选"],["000037.SH", "上证医药"],["000038.SH", "上证金融"],["000039.SH", "上证信息"],["000043.SH", "超大盘"],["000054.SH", "上证海外"],["000055.SH", "上证地企"],["000066.SH", "上证商品"],["000068.SH", "上证资源"],["000070.SH", "能源等权"],["000071.SH", "材料等权"],["000072.SH", "工业等权"],["000073.SH", "可选等权"],["000078.SH", "电信等权"],["000092.SH", "资源50"],["000094.SH", "上证上游"],["000109.SH", "380医药"],["000110.SH", "380金融"],["000121.SH", "医药主题"],["000122.SH", "农业主题"],["000145.SH", "优势资源"],["000146.SH", "优势制造"],["000153.SH", "上证民企红利"],["000160.SH", "沪新丝路"],["399232.SZ", "采矿指数"],["399235.SZ", "建筑指数"],["399236.SZ", "批零指数"],["399241.SZ", "地产指数"],["399248.SZ", "文化指数"],["399249.SZ", "综企指数"],["399335.SZ", "深证央企"],["399355.SZ", "CBN长江"],["399357.SZ", "CBN渤海"],["399359.SZ", "国证基建"],["399395.SZ", "国证有色"],["399410.SZ", "苏州率先"],["399417.SZ", "新能源车"],["399423.SZ", "中关村50"],["399433.SZ", "国证交运"],["399434.SZ", "国证传媒"],["399441.SZ", "生物医药"],["399551.SZ", "央视创新"],["399555.SZ", "央视责任"],["399613.SZ", "深证能源"],["399621.SZ", "深证电信"],["399638.SZ", "深证环保"],["399652.SZ", "中创高新"],["399669.SZ", "深证农业"],["399704.SZ", "深证上游"],["000006.SH", "上证房地产指数"],["000015.SH", "上证红利"],["000016.SH", "上证50"],["000027.SH", "180运输"],["000032.SH", "上证能源"],["000034.SH", "上证工业"],["000036.SH", "上证消费"],["000040.SH", "上证电信"],["000041.SH", "上证公用"],["000042.SH", "上证央企"],["000049.SH", "上证民企"],["000050.SH", "50等权"],["000052.SH", "50基本"],["000062.SH", "上证沪企"],["000063.SH", "上证周期"],["000074.SH", "消费等权"],["000075.SH", "医药等权"],["000076.SH", "金融等权"],["000079.SH", "公用等权"],["000097.SH", "高端装备"],["000103.SH", "沪消费品"],["000104.SH", "380能源"],["000108.SH", "380消费"],["000111.SH", "380信息"],["000112.SH", "380电信"],["000113.SH", "380公用"],["000114.SH", "持续产业"],["000126.SH", "上证消费50"],["000134.SH", "上证银行"],["000147.SH", "优势消费"],["000149.SH", "上证180红利"],["000150.SH", "上证380红利"],["000151.SH", "上证国企红利"],["000152.SH", "上证央企红利"],["000158.SH", "上证环保"],["000970.SH", "ESG.SH"],["399231.SZ", "农林指数"],["399234.SZ", "水电指数"],["399237.SZ", "运输指数"],["399238.SZ", "餐饮指数"],["399240.SZ", "金融指数"],["399242.SZ", "商务指数"],["399310.SZ", "国证50"],["399321.SZ", "国证红利"],["399324.SZ", "深证红利"],["399328.SZ", "深证治理"],["399332.SZ", "深证创新"],["399350.SZ", "皖江30"],["399353.SZ", "国证物流"],["399356.SZ", "CBN珠江"],["399358.SZ", "泰达环保指数"],["399361.SZ", "国证商业"],["399365.SZ", "国证农业"],["399367.SZ", "巨潮地产"],["399368.SZ", "国证军工"],["399378.SZ", "南方低碳"],["399381.SZ", "1000能源"],["399385.SZ", "1000消费"],["399390.SZ", "1000公用"],["399396.SZ", "国证食品"],["399419.SZ", "国证高铁"],["399420.SZ", "国证保证"],["399431.SZ", "国证银行"],["399432.SZ", "国证汽车"],["399435.SZ", "国证农牧"],["399436.SZ", "国证煤炭"],["399437.SZ", "国证证券"],["399438.SZ", "国证电力"],["399439.SZ", "国证油气"],["399440.SZ", "国证钢铁"],["399550.SZ", "央视50"],["399552.SZ", "央视成长"],["399553.SZ", "央视回报"],["399554.SZ", "央视治理"],["399556.SZ", "央视生态"],["399557.SZ", "央视文化"],["399617.SZ", "深证消费"],["399618.SZ", "深证医药"],["399619.SZ", "深证金融"],["399622.SZ", "深证公用"],["399637.SZ", "深证地产"],["399639.SZ", "深证大宗"],["399646.SZ", "深消费50"],["399647.SZ", "深医药50"],["399649.SZ", "中小板红利"],["399650.SZ", "中小板治理"],["399651.SZ", "中小板责任"],["399654.SZ", "深证文化"],["399671.SZ", "深防御50"],["399672.SZ", "深红利50"],["399701.SZ", "深证F60"],["399001.SZ", "深证成指"],["000001.SH", "上证综指"],["399006.SZ", "创业板指"],["399005.SZ", "中小板指"],["399678.SZ", "深次新股"],["399239.SZ", "IT指数"],["399951.SZ", "300银行"],["399941.SZ", "新能源"]];

function formatDate($strDate) {
    return substr($strDate,0,4) . '-' . substr($strDate,4,2) . '-' .substr($strDate,6,2);
}

function getUrl($refresh)
{
    global $kv, $mysql, $icode;
    $ct = date('Y-m-d');
    $urls = $kv->get($ct);

    if (empty($urls) || $refresh) {
        $sql = "select preflist from candidate order by id limit 1";
        $result = $mysql->query($sql);
        $baseUrl = "http://hq.sinajs.cn/list=";
        $maxCount = 436;
        $counter = 0;
        $arr = array();
        $urls = array();
        if ($row = $result->fetch_row()) {
            $codes = $row[0];
            $arrCode = explode(',', $codes);

            foreach ($arrCode as $code) {

                $code = strtolower($code);
                $urlQuery = $baseUrl . $code;
                $html = file_get_contents($urlQuery);
                $html = str_replace("\"", "", $html);
                $items = explode(',', $html);
                if (isset($items[1]) && $items[1] != 0) {

                    array_push($arr, $code);
                    $counter ++;
                    if ($counter >= $maxCount) {
                        array_push($urls, $baseUrl . join(",", $arr));
                        $arr = array();
                        $counter = 0;
                    }
                }
            }

            if ($counter > 0) {
                array_push($urls, $baseUrl . join(",", $arr));
            }
        }
        $kv->set($ct, $urls);
    }
    return $urls;
}

function getAllUrl()
{
    global $mysql, $icode;
    $sql = "select preflist from candidate order by id limit 1";
    $result = $mysql->query($sql);
    $baseUrl = "http://hq.sinajs.cn/list=";
    $maxCount = 436;
    $counter = 0;
    $arr = array();
    $urls = array();
    if ($row = $result->fetch_row()) {
        $codes = $row[0];
        $arrCode = explode(',', $codes);

        foreach ($arrCode as $code) {

            $code = strtolower($code);
            $urlQuery = $baseUrl . $code;
            $html = file_get_contents($urlQuery);
            $html = str_replace("\"", "", $html);
            $items = explode(',', $html);
            if (isset($items[1]) && $items[1] != 0) {

                array_push($arr, $code);
                $counter ++;
                if ($counter >= $maxCount) {

                    array_push($urls, $baseUrl . join(",", $arr));
                    $arr = array();
                    $counter = 0;
                }
            }
        }

        if ($counter > 0) {

            array_push($urls, $baseUrl . join(",", $arr));
        }
    }

    return $urls;
}

function saveWave(&$g, $w)
{
    if (empty($g)) {
        $g = json_decode(json_encode($w));
    } else {
        if ($g->level == $w->level) {
            if ($w->asc) {
                if ($w->high > $g->high) {
                    saveGlobal($g);
                    $g = json_decode(json_encode($w));
                } else {
                    $c = json_decode(json_encode($g));
                    $g->id = uniqid();
                    $g->level = $g->level + 1;
                    $g->childWave = array();
                    $c->pid = $g->id;
                    $g->childWave[] = $c;
                    saveHistory($g);
                    $w->pid = $g->id;
                    $g->childWave[] = $w;
                }
            } else {
                if ($w->low < $g->low) {
                    saveGlobal($g);
                    $g = json_decode(json_encode($w));
                } else {
                    $c = json_decode(json_encode($g));
                    $g->id = uniqid();
                    $g->level = $g->level + 1;
                    $g->childWave = array();
                    $c->pid = $g->id;
                    $g->childWave[] = $c;
                    saveHistory($g);
                    $w->pid = $g->id;
                    $g->childWave[] = $w;
                }
            }
        } else if ($g->level > $w->level) {
            $node = $g;
            $parentNode = null;
            while ($node->level > $w->level + 1) {
                if (empty($node->childWave)) {
                    $parentNode = $node;
                    $node = json_decode(json_encode($node));
                    $node->id = uniqid();
                    $node->level = $parentNode->level - 1;
                    $node->childWave = array();
                    $node->pid = $parentNode->id;
                    $parentNode->childWave[] = $node;
                } else {
                    $parentNode = $node;
                    $node = $node->childWave[count($node->childWave) - 1];
                }
            }

            if ($w->asc) {
                if ($node->asc) {
                    if ($w->high >= $node->high) { // ��������
                        saveHistory($node);
                        $w->pid = $node->id;
                        $node->childWave[] = $w;
                        $node->high = $w->high;
                        $node->endTime = $w->endTime;
                        while (! empty($parentNode)) {
                            if ($parentNode->asc) {
                                if ($w->high > $parentNode->high) {
                                    $parentNode->high = $w->high;
                                    $parentNode->endTime = $w->endTime;
                                    $parentNode = findNodeById($g, $parentNode->pid);
                                } else {
                                    break;
                                }
                            } else {
                                $node = array_pop($parentNode->childWave);
                                saveWave($g, $node);
                                break;
                            }
                        }
                    } else { // ��ת����
                        if (! empty($parentNode)) {
                            $node = array_pop($parentNode->childWave);
                            saveWave($g, $node);
                        }
                        $temp = array_pop($node->childWave);
                        $nw = new Wave();
                        $nw->id = uniqid();
                        $nw->level = $node->level;
                        $nw->asc = 1 - $node->asc;
                        if (empty($temp)) {
                            $nw->high = $w->high;
                            $nw->low = $w->low;
                            $nw->beginTime = $w->beginTime;
                            $nw->endTime = $w->endTime;
                        } else {
                            $nw->high = $temp->high;
                            $nw->low = $temp->low;
                            $nw->beginTime = $temp->beginTime;
                            $nw->endTime = $temp->endTime;
                            $temp->pid = $nw->id;
                            $nw->childWave[] = $temp;
                        }
                        saveHistory($nw);
                        $w->pid = $nw->id;
                        $nw->childWave[] = $w;
                        $nw->endTime = $w->endTime;
                        saveWave($g, $nw);
                    }
                } else { // ����������
                    if ($w->high >= $node->high) {
                        if (! empty($parentNode)) {
                            $node = array_pop($parentNode->childWave);
                            saveWave($g, $node);
                        }
                        $nw = json_decode(json_encode($w));
                        $nw->childWave = array();
                        $nw->id = uniqid();
                        $nw->level = $w->level + 1;
                        $w->pid = $nw->id;
                        $nw->childWave[] = $w;
                        saveWave($g, $nw);
                    } else {
                        saveHistory($node);
                        $w->pid = $node->id;
                        $node->childWave[] = $w;
                    }
                }
            } else { // ��������
                if (! $node->asc) { // ��������
                    if ($w->low <= $node->low) { // ��������
                        saveHistory($node);
                        $w->pid = $node->id;
                        $node->childWave[] = $w;
                        $node->low = $w->low;
                        $node->endTime = $w->endTime;

                        while (! empty($parentNode)) {
                            if (! $parentNode->asc) {
                                if ($w->low < $parentNode->low) {
                                    $parentNode->low = $w->low;
                                    $parentNode->endTime = $w->endTime;
                                    $parentNode = findNodeById($g, $parentNode->pid);
                                } else {
                                    break;
                                }
                            } else {
                                $node = array_pop($parentNode->childWave);
                                saveWave($g, $node);
                                break;
                            }
                        }
                    } else { // ��ת����
                        if (! empty($parentNode)) {
                            $node = array_pop($parentNode->childWave);
                            saveWave($g, $node);
                        }
                        $temp = array_pop($node->childWave);
                        $nw = new Wave();
                        $nw->id = uniqid();
                        $nw->level = $node->level;
                        $nw->asc = 1 - $node->asc;
                        if (empty($temp)) {
                            $nw->high = $w->high;
                            $nw->low = $w->low;
                            $nw->beginTime = $w->beginTime;
                            $nw->endTime = $w->endTime;
                        } else {
                            $nw->high = $temp->high;
                            $nw->low = $temp->low;
                            $nw->beginTime = $temp->beginTime;
                            $nw->endTime = $temp->endTime;
                            $temp->pid = $nw->id;
                            $nw->childWave[] = $temp;
                        }
                        saveHistory($nw);
                        $w->pid = $nw->id;
                        $nw->childWave[] = $w;
                        saveWave($g, $nw);
                    }
                } else { // ����������
                    if ($w->low <= $node->low) {
                        if (! empty($parentNode)) {
                            $node = array_pop($parentNode->childWave);
                            saveWave($g, $node);
                        }
                        $nw = json_decode(json_encode($w));
                        $nw->id = uniqid();
                        $nw->level = $w->level + 1;
                        $w->pid = $nw->id;
                        $nw->childWave = array();
                        $nw->childWave[] = $w;
                        saveWave($g, $nw);
                    } else {
                        saveHistory($node);

                        $w->pid = $node->id;
                        $node->childWave[] = $w;
                    }
                }
            }
        }
    }
}

function findNodeById($node, $id)
{
    if ($node->id == $id) {
        return $node;
    } else {
        $rnode = null;
        foreach ($node->childWave as $sn) {
            $rnode = findNodeById($sn, $id);
            if (! empty($rnode)) {
                return $rnode;
            }
        }
    }
    return null;
}

function transfer(&$w)
{
    $w->beginTime = date("Y-m-d H:i:s", $w->beginTime);
    $w->endTime = date("Y-m-d H:i:s", $w->endTime);
    foreach ($w->childWave as $cw) {
        transfer($cw);
    }
}

function getArrow($gw)
{
    if (empty($gw)) {
        return '';
    } else {
        $r = '';
        while ($gw->level > 4) {
            $cn = count($gw->childWave);
            while($cn>15){
                $cn = $cn - 2;
            }
            $cn = substr(dechex($cn),0,1);

            $r = $r . $cn . $gw->asc;
            $gw = $gw->childWave[$cn - 1];
        }
        return $r;
    }
}

function countArrow($gw)
{
    if (empty($gw)) {
        return 0;
    } else {
        $r = 0;
        while ($gw->level > 5) {
            if ($gw->asc) {
                $r ++;
            } else {
                $r = 0;
            }
            $cn = count($gw->childWave);
            $gw = $gw->childWave[$cn - 1];
        }
        return $r;
    }
}

function popular($fTime, $lTime, $asc)
{
    global $mysql, $kv;
    $strUpdate = "select (l.current - f.current)/l.close as main  from (SELECT code,name,close,current FROM `indexrecord` WHERE (time >= " . $fTime . " and time < " . ($fTime + 60) . ") and code = 'sh000001') f LEFT JOIN (SELECT code,name,close,current FROM indexrecord WHERE (time > " . ($lTime - 60) . " AND time <= " . $lTime . ") and code = 'sh000001') l ON f.code = l.code";
    $result = $mysql->query($strUpdate);
    $main = 0;
    if($result){
        $main = $result->fetch_row();
    }
    
    $strUpdate = "select (l.current - f.current)/l.close as main  from (SELECT code,name,close,current FROM `indexrecord` WHERE (time >= " . $fTime . " and time < " . ($fTime + 60) . ") and code = 'sz399006') f LEFT JOIN (SELECT code,name,close,current FROM indexrecord WHERE (time > " . ($lTime - 60) . " AND time <= " . $lTime . ") and code = 'sz399006') l ON f.code = l.code";
    $result = $mysql->query($strUpdate);
    $concept = 0;
    if($result){
        $concept = $result->fetch_row();
    }
    return 100 * ($concept[0] - $main[0]);
}

function prefPrice($code)
{
    global $mysql, $kv;

    $time = time();
    $ct = date('Y-m-d');
    $deltaTime = $time - strtotime($ct);
    $calTime = $time;
    $baseUrl = "http://hq.sinajs.cn/list=";
    $urlQuery = $baseUrl . $code;
    $html = file_get_contents($urlQuery);
    $html = str_replace("\"", "", $html);
    $items = explode(',', $html);

    $todayCurrent = $items[8];

    $strQuery = "SELECT close,current, high, low, clmn FROM `stockrecord` WHERE code = '" . $code . "' and date < '" . $ct . "' and time - unix_timestamp(date) = $deltaTime ";

    $result = $mysql->query($strQuery);
    $currentResult = array();
    if (empty($result)) {
        return null;
    } else {
        while ($result && $mr = $result->fetch_array(MYSQLI_ASSOC)) {
            array_push($currentResult, $mr);
        }
    }
    mysqli_free_result($result);
    $cnt = count($currentResult);

    $totalClmn = 0;
    for ($i = 0; $i < $cnt; $i ++) {
        $totalClmn += $currentResult[$i]['clmn'];
    }

    if ($cnt > 0) {
        $clmnRate = $items[8] * $cnt / $totalClmn;
    } else {
        $clmnRate = 1;
    }

    $strQuery = "SELECT close,high,low,clmn,(SELECT group_concat(name) FROM `category` WHERE locate('$code',content)>1) as concept FROM `stockrecord` WHERE code = '" . $code . "' and date < '" . $ct . "' and time - unix_timestamp(date)= 53760 ";

    $result = $mysql->query($strQuery);
    $endResult = array();
    while ($result && $mr = $result->fetch_array(MYSQLI_ASSOC)) {
        array_push($endResult, $mr);
    }

    $query = "SELECT current FROM daily where code='$code' order by date desc limit 4";
    $result = $mysql->query($query);
    $prices = array();
    while ($result && $mr = $result->fetch_array()) {
        array_push($prices, $mr[0]);
    }

    $price4 = ($prices[0] + $prices[1] + $prices[2] + $prices[3]) / 4;
    $price3 = ($prices[0] + $prices[1] + $prices[2]) / 3;

    mysqli_free_result($result);
    $totalClmn = 0;
    $totalWidth = 0;
    for ($i = 0; $i < count($endResult); $i ++) {
        $totalClmn += $endResult[$i]['clmn'];
        $totalWidth += ($endResult[$i]['high'] - $endResult[$i]['low']) / $endResult[$i]['close'];
        $concept = $endResult[$i]['concept'];
    }

    $rateRange = $clmnRate * $totalWidth / count($endResult);
    $prefBuy = $items[4] - $rateRange * $items[2];
    $prefSell = $items[5] + $rateRange * $items[2];
    $top = $items[2] * 1.1;
    $bottom = $items[2] * 0.9;
    $currentPrice = $items[3];
    $high = $items[4];
    $low = $items[5];
    $prefBuy = $prefBuy > $bottom ? $prefBuy : $bottom;
    $prefSell = $prefSell < $top ? $prefSell : $top;
    $prefBuy = $prefBuy < $currentPrice ? $prefBuy : $currentPrice;
    $prefSell = $prefSell > $currentPrice ? $prefSell : $currentPrice;

    $pref = new Pref();
    $pref->prefBuy = $prefBuy;
    $pref->prefSell = $prefSell;
    $pref->current = $currentPrice;
    $pref->high = $high;
    $pref->low = $low;
    $pref->concept = $concept;
    $pref->price4 = number_format($price4, 2);
    $pref->price3 = number_format($price3, 2);
    return $pref;
}

function prefIndex($code)
{
    global $mysql, $kv;

    $time = time();
    $ct = date('Y-m-d');
    $deltaTime = $time - strtotime($ct);
    $calTime = $time;
    $baseUrl = "http://hq.sinajs.cn/list=";
    $urlQuery = $baseUrl . $code;
    $html = file_get_contents($urlQuery);
    $html = str_replace("\"", "", $html);
    $items = explode(',', $html);

    $todayCurrent = $items[8];

    $strQuery = "SELECT close,current, high, low, clmn FROM `indexrecord` WHERE code = '" . $code . "' and date < '" . $ct . "' and time - unix_timestamp(date) = $deltaTime ";

    $result = $mysql->query($strQuery);
    $currentResult = array();
    if (empty($result)) {
        return null;
    } else {
        while ($result && $mr = $result->fetch_array(MYSQLI_ASSOC)) {
            array_push($currentResult, $mr);
        }
    }
    mysqli_free_result($result);
    $cnt = count($currentResult);

    $totalClmn = 0;
    for ($i = 0; $i < $cnt; $i ++) {
        $totalClmn += $currentResult[$i]['clmn'];
    }

    if ($cnt > 0) {
        $clmnRate = $items[8] * $cnt / $totalClmn;
    } else {
        $clmnRate = 1;
    }

    $strQuery = "SELECT close,high,low,clmn,(SELECT group_concat(name) FROM `category` WHERE locate('$code',content)>1) as concept FROM `indexrecord` WHERE code = '" . $code . "' and date < '" . $ct . "' and time - unix_timestamp(date)= 53760 ";

    $result = $mysql->query($strQuery);
    $endResult = array();
    while ($result && $mr = $result->fetch_array(MYSQLI_ASSOC)) {
        array_push($endResult, $mr);
    }
    mysqli_free_result($result);
    $totalClmn = 0;
    $totalWidth = 0;
    for ($i = 0; $i < count($endResult); $i ++) {
        $totalClmn += $endResult[$i]['clmn'];
        $totalWidth += ($endResult[$i]['high'] - $endResult[$i]['low']) / $endResult[$i]['close'];
        $concept = $endResult[$i]['concept'];
    }

    $rateRange = $clmnRate * $totalWidth / count($endResult);
    $prefBuy = $items[4] - $rateRange * $items[2];
    $prefSell = $items[5] + $rateRange * $items[2];
    $top = $items[2] * 1.1;
    $bottom = $items[2] * 0.9;
    $currentPrice = $items[3];
    $high = $items[4];
    $low = $items[5];
    $prefBuy = $prefBuy > $bottom ? $prefBuy : $bottom;
    $prefSell = $prefSell < $top ? $prefSell : $top;
    $prefBuy = $prefBuy < $currentPrice ? $prefBuy : $currentPrice;
    $prefSell = $prefSell > $currentPrice ? $prefSell : $currentPrice;

    $pref = new Pref();
    $pref->prefBuy = $prefBuy;
    $pref->prefSell = $prefSell;
    $pref->current = $currentPrice;
    $pref->high = $high;
    $pref->low = $low;
    $pref->concept = $concept;
    return $pref;
}

function ting()
{
    global $mysql, $kv;

    $label = 'ting' . date('Y-m-d');

    if (empty($kv->get($label))) {
        $ct60 = date("Y-m-d", strtotime("-60 day"));
        $ct120 = date("Y-m-d", strtotime("-120 day"));
        $ct800 = date("Y-m-d", strtotime("-800 day"));
        $d = $_REQUEST['d'];
        if (empty($d))
            $d = 1.5;

        $sql50 = "select t.code from (select code,current from daily where date > '$ct120' and code in (SELECT code FROM daily WHERE date < '$ct800' GROUP by code HAVING COUNT(code) > 0) and (SUBSTRING(code,3,1)='6' or SUBSTRING(code,3,1)='0')) t GROUP by t.code order by max(t.current)/min(t.current) limit 1000";

        $result = $mysql->query($sql50);
        $codes = array();

        while ($result && $mr = $result->fetch_array(MYSQLI_ASSOC)) {
            $code = $mr['code'];
            $codes[] = "'" . $code . "'";
        }

        $codes180 = join(",", $codes);

        $sql = "select z.code,count(z.code) as count from (select b.code from 
		(SELECT code,current,date,@rownum1:=@rownum1+1 as rownum FROM (select @rownum1:=0) a, daily where date > '$ct60' and code in ($codes180) ORDER by code,date DESC ) b
		INNER JOIN (SELECT code,current,date,@rownum2:=@rownum2+1 as rownum FROM (select @rownum2:=0) a, daily where date > '$ct60' and code in ($codes180) ORDER by code,date DESC) t
		on b.rownum-1=t.rownum and b.code=t.code where t.current/b.current > 1.095) z group by z.code";

        $result = $mysql->query($sql);

        $codes = array();
        while ($result && $mr = $result->fetch_array(MYSQLI_ASSOC)) {
            $codes[$mr['code']] = $mr['count'];
        }

        mysqli_free_result($result);
        $mysql->close();

        $kv->set($label, $codes);
    } else {
        $codes = $kv->get($label);
    }

    return $codes;
}

function ting1()
{
    global $mysql, $kv;

    $label = 'ting1' . date('Y-m-d');

    if (empty($kv->get($label))) {
        $ct60 = date("Y-m-d", strtotime("-60 day"));
        $ct120 = date("Y-m-d", strtotime("-120 day"));

        $sql = "select z.code,count(z.code) as count from (select b.code from 
		(SELECT code,current,date,@rownum1:=@rownum1+1 as rownum FROM (select @rownum1:=0) a, daily where date > '$ct120' ORDER by code,date DESC ) b
		INNER JOIN (SELECT code,current,date,@rownum2:=@rownum2+1 as rownum FROM (select @rownum2:=0) a, daily where date > '$ct120' ORDER by code,date DESC) t
		on b.rownum-1=t.rownum and b.code=t.code where t.current/b.current > 1.095) z group by z.code";

        $result = $mysql->query($sql);

        $codes = array();
        while ($result && $mr = $result->fetch_array(MYSQLI_ASSOC)) {
            $codes[$mr['code']] = $mr['count'];
        }

        mysqli_free_result($result);
        $mysql->close();

        $kv->set($label, $codes);
    } else {
        $codes = $kv->get($label);
    }

    return $codes;
}

function ting2()
{
    global $mysql, $kv;

    $ct60 = date("Y-m-d", strtotime("-60 day"));
    $ct120 = date("Y-m-d", strtotime("-120 day"));

    $sql = "select z.code,count(z.code) as count from (select b.code from 
		(SELECT code,current,date,@rownum1:=@rownum1+1 as rownum FROM (select @rownum1:=0) a, daily where date > '$ct120' ORDER by code,date DESC ) b
		INNER JOIN (SELECT code,current,date,@rownum2:=@rownum2+1 as rownum FROM (select @rownum2:=0) a, daily where date > '$ct120' ORDER by code,date DESC) t
		on b.rownum-1=t.rownum and b.code=t.code where t.current/b.current > 1.095) z group by z.code";

    $result = $mysql->query($sql);
    $list = array();

    while ($result && $mr = $result->fetch_array(MYSQLI_ASSOC)) {
        $list[$mr['code']] = $mr['count'];
        $codes[] = "'" . $mr['code'] . "'";
    }

    $codes120 = join(",", $codes);

    $sql120 = "select c.code,c.current/a.current from (SELECT d.code,d.date,d.current FROM daily d inner join (select code,max(date) as date from daily group by code) m on d.code = m.code and d.date = m.date where d.code in ($codes120) c inner join (select code,avg(current) as current from daily where date > '$ct60' group by code) a on c.code=a.code order by c.current/a.current limit 200";

    $result = $mysql->query($sql120);

    $codes = array();
    while ($result && $mr = $result->fetch_array(MYSQLI_ASSOC)) {
        $codes[$mr['code']] = $list[$mr['code']];
    }

    mysqli_free_result($result);
    $mysql->close();

    $kv->set($label, $codes);
}

function checkHoliday()
{
    global $holidays;

    $date = (int) date('Ymd');

    if (in_array($date, $holidays)) {
        exit();
    }
}

function sendMessage($msg)
{
    // $channel = new SaeChannel();
    // $ret = $channel->sendMessage('ichess', $msg);
}

function sendSms($msg)
{
    $url = "http://sms.api.bz/fetion.php?username=13624914663&password=Tangyc123&sendto=13624914663&message=$msg";
    $result = file_get_contents($url);
    echo $result; // 返回信息默认为UTF-8编码的汉字，如果你的页面编码为gb2312，请使用下行语句输出返回信息。
                  // echo iconv("UTF-8", "GBK", $result);
}

function saveMessage($code, $name, $message, $flag)
{
    global $mysql;

    $obj = new stdClass();
    $obj->title = $code . ' ' . $name;
    $obj->message = $message;

    $msg = json_encode($obj);

    sendMessage($msg);

    $sql = "insert into message(code,name,message,flag,time) values('$code','$name','$message',$flag,now())";

    $mysql->query($sql);
}

function updateInspect($id)
{
    global $mysql;

    $sql = "update inspect set flag=1 where id=$id";
    $mysql->query($sql);
}

function updateMessage($code, $flag)
{
    global $mysql;

    $sql = "update message set flag = $flag, updatetime = now() where code = '$code' ";

    $mysql->query($sql);
}

function sendMail($title, $content)
{
    $to = "11228856@qq.com";
    $headers = "From: hb_java@sina.com";
    $result = mail($to, $title, $content, $headers);
    $test = $result;
}

function arrStable($arr)
{
    $arrMax = - 999999;
    $arrMin = 999999;
    $maxIndex = 1;
    $minIndex = 0;
    for ($i = 0; $i < count($arr); $i ++) {
        if ($arr[$i]['strong'] > $arrMax) {
            $arrMax = $arr[$i]['strong'];
            $maxIndex = $i;
        }
        if ($arr[$i]['strong'] < $arrMin) {
            $arrMin = $arr[$i]['strong'];
            $minIndex = $i;
        }
    }

    if ($arrMax - $arrMin > 20) {
        return null;
    } else {
        return [
            count($arr) / ($arrMax - $arrMin),
            round($arrMin),
            round($arrMax),
            $minIndex,
            $maxIndex
        ];
    }
}

function calStable($code)
{
    global $mysql, $kv;
    $n = 1;
    $t = 0;

    $sqlRate = 'select max(high) as high,min(low) as low,code from indexrecord where code="' . $code . '" or code="sh000001" group by code ';

    $result = $mysql->query($sqlRate);
    $strongs = array();
    while ($result && $mr = $result->fetch_array(MYSQLI_ASSOC)) {
        if ($mr['code'] == 'sh000001') {
            $base = (float) $mr['high'] + (float) $mr['low'];
        } else {
            $rating = (float) $mr['high'] + (float) $mr['low'];
        }
    }

    $rate = $base / $rating;

    $sql = "select sh.time as time,sz.strong-sh.current as strong from (select current * $rate as strong,time from indexrecord where code = '$code' order by time desc limit 240) sz inner join (select current,time from indexrecord where code = 'sh000001' order by time desc limit 240) sh on sz.time=sh.time order by time";

    $result = $mysql->query($sql);
    $strongs = array();
    while ($result && $mr = $result->fetch_array(MYSQLI_ASSOC)) {
        $strongs[] = $mr;
    }

    mysqli_free_result($result);

    $maxStable = null;

    for ($i = 0; $i < 240 - 120; $i ++) {
        $stable = arrStable($strongs);
        if ($maxStable == null) {
            $maxStable = $stable;
        } else if ($stable != null && $stable[0] > $maxStable[0]) {
            $maxStable = $stable;
        }

        array_shift($strongs);
    }
    ;

    $oldStable = $kv->get('stable' . $code);

    $codeList = array(
        'sz399006' => 'cy',
        'sz399678' => 'cx',
        'sz399001' => 'sc',
        'sh000016' => 'sz',
        'sz399807' => 'gtcy',
        'sz399991' => 'ydyl',
        'sz399995' => 'Building',
        'sz399959' => 'jg',
        'sz399239' => 'it',
        'sz399803' => 'gy4.0',
        'sz399417' => 'xnyc',
        'sz399441' => 'swyy',
        'sz399994' => 'xxaq',
        'sz399970' => 'ydhl',
        'sz399971' => 'cm',
        'sz399232' => 'ck',
        'sz399998' => 'mt',
        'sz399806' => 'hj',
        'sz399814' => 'dny',
        'sz399989' => 'medical',
        'sz399997' => 'bj',
        'sz399996' => 'Home Design',
        'sz399812' => 'Yanglao',
        'sz399240' => 'jr',
        'sz399986' => 'yh',
        'sz399975' => 'zq',
        'sz399809' => 'bx'
    );

    if ($oldStable == null) {
        $kv->set('stable' . $code, $maxStable);
    } else if ($maxStable == null) {
        $kv->set('stable' . $code, $maxStable);

        $title = ' Stable is changing ' . $codeList[$code] . ' ' . $oldStable[0] * ($oldStable[2] - $oldStable[1]);
        $content = 'Stable is changing ' . $code . ' ' . ($oldStable[2] - $oldStable[1]);

        if ($oldStable[0] * ($oldStable[2] - $oldStable[1]) > 120) {
            $stableTime = $kv->get('stableTime' . $code);
            if ($stableTime == null)
                $stableTime = 0;
            if (time() - $stableTime > 60 * 60) {
                $kv->set('stableTime' . $code, time());
                sendMail($title, $content);
                saveMessage($code, $title, $content, 0);
            }
        }
    } else if ($oldStable[1] > $maxStable[1] + 2 || $oldStable[2] < $maxStable[2] - 2) {
        if ($oldStable[1] > $maxStable[1]) {
            $title = 'Descending ' . $codeList[$code] . ' ' . $maxStable[0] * ($maxStable[2] - $maxStable[1]);
        } else {
            $title = 'Ascending ' . $codeList[$code] . ' ' . $maxStable[0] * ($maxStable[2] - $maxStable[1]);
        }
        $content = ($maxStable[2] - $maxStable[1]) . ' ' . $code;
        if ($maxStable[0] * ($maxStable[2] - $maxStable[1]) > 120) {
            $stableTime = $kv->get('stableTime' . $code);
            if ($stableTime == null)
                $stableTime = 0;
            if (time() - $stableTime > 60 * 60) {
                $kv->set('stableTime' . $code, time());
                sendMail($title, $content);
                saveMessage($code, $title, $content, 0);
            }
        }
        $kv->set('stable' . $code, $maxStable);
    }
}

function dayBefore($days, $flag)
{
    global $holidays;
    for ($i = $flag; $i <= $days + $flag; $i ++) {
        $idayStr = date("Ymd", strtotime("-$i day"));
        $idayWeek = date("w", strtotime("-$i day"));

        if (in_array($idayStr, $holidays) || $idayWeek == '0' || $idayWeek == '6')
            $days ++;
    }
    return date("Y-m-d", strtotime("" . 1 - $i . " day"));
}

function exception_handler(Throwable $e)
{
    error_log($e->getFile() . ' ' . $e->getLine() . ' ' . 'catch Error:' . $e->getCode() . ':' . $e->getMessage() . '<br/>', 0);

    error_log($e->getTraceAsString());
}

set_exception_handler('exception_handler');