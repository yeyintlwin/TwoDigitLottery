<?php

/**
 * Developer-Ye Yint Lwin
 * 2017
 **/

function get_data($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, "Dalvik/2.1.0 (Linux; U; Android 6.0.1; SM-P355 Build/MMB29M)");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
$html = get_data('http://marketdata.set.or.th/mkt/marketsummary.do?language=en&country=US');
$dom = new DOMDocument();
$dom->validateOnParse = true;
@$dom->loadHTML($html);
$dompath = new DOMXPath($dom);
$table = $dompath->query("//tbody")->item(0);
$rows = $table->getElementsByTagName('tr')->item(0);
$set = $rows->getElementsByTagName('td')->item(1)->nodeValue;
$val = $rows->getElementsByTagName('td')->item(7)->nodeValue;
$status = $dompath->query('//*[@class="marketstatus"]')->item(0)->textContent;
$date = $dompath->query('//*[@class="row text-right table-noborder"]')->item(0)->nodeValue;
$date = str_replace("Last Update", "", $date);
$date = str_replace("*", "", $date);
$date = str_replace("\r\n", "", $date);
$date = preg_replace("~\x{00a0}~siu", "", $date);
$arr = array("date" => $date, "status" => $status, "set" => $set, "val" => $val);
echo json_encode($arr);
