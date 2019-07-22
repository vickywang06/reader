<?php

/*
 * 定义一些常用的函数
 * */
//post请求
function http_post($url, $post_data = '', $timeout = 5){

	$ch = curl_init();

	curl_setopt ($ch, CURLOPT_URL, $url);

	curl_setopt ($ch, CURLOPT_POST, 1);

	if($post_data != ''){

		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

	}

	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

	curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

	curl_setopt($ch, CURLOPT_HEADER, false);

	$file_contents = curl_exec($ch);

	curl_close($ch);

	return $file_contents;

}
//返回全新的正确的包含sign的数组
function returnarr($arr){
	foreach($arr as $k=>$v){
		if($k=='sign'){
			unset($arr[$k]);
		}
	}
	$params=$arr;
	ksort($params);

	$paramsStrExceptSign = '';
	foreach ($params as $val) {
		$paramsStrExceptSign .= $val;
	}

	$arr['sign']=md5($paramsStrExceptSign);
	return $arr;
}
//打印数组或对象
function v($arr){
	echo '<pre>';
	var_dump($arr);
	echo '</pre>';die;
}
//从远程地址取出文本json并转为数组
function getremotedata($url){
	$res=file_get_contents($url);
	$res = trim($res, "\xEF\xBB\xBF");
	$resdata=json_decode($res,true);
	return $resdata['data'];
}
function getapidata($url,$data){
	$res=http_post($url,returnarr($data));
	$res = trim($res, "\xEF\xBB\xBF");
	return json_decode($res,true)['data'];
}
/**
 * 生成分页数据
 * @param int $currentPage 当前页码
 * @param int $totalCount 总记录数
 * @param string $url 要生成的 url 格式，页码占位符请使用 *，如果未写占位符，系统将自动生成
 * @param int $pageSize 分页大小
 * @return string 分页HTML
 */
function pagination($tcount, $pindex, $psize = 15, $url = '', $context = array('before' => 5, 'after' => 4, 'ajaxcallback' => '','isajax'=>false)) {
	$cururl= URL::full();//当前页面地址
	$pdata = array(
		'tcount' => 0,
		'tpage' => 0,
		'cindex' => 0,
		'findex' => 0,
		'pindex' => 0,
		'nindex' => 0,
		'lindex' => 0,
		'options' => ''
	);
	if($context['ajaxcallback']) {
		$context['isajax'] = true;
	}

	$pdata['tcount'] = $tcount;
	$pdata['tpage'] = ceil($tcount / $psize);
	//echo $pdata['tpage'];
	if($pdata['tpage'] <= 1) {
		return '';
	}
	$cindex = $pindex;
	$cindex = min($cindex, $pdata['tpage']);
	$cindex = max($cindex, 1);
	$pdata['cindex'] = $cindex;
	$pdata['findex'] = 1;
	$pdata['pindex'] = $cindex > 1 ? $cindex - 1 : 1;
	$pdata['nindex'] = $cindex < $pdata['tpage'] ? $cindex + 1 : $pdata['tpage'];
	$pdata['lindex'] = $pdata['tpage'];

	if($context['isajax']) {
		if(!$url) {
			$url = $cururl . '?' . http_build_query($_GET);
		}
		$pdata['faa'] = 'href="javascript:;" onclick="p(\'' . $cururl . $url . '\', \'' . $pdata['findex'] . '\', ' . $context['ajaxcallback'] . ')"';
		$pdata['paa'] = 'href="javascript:;" onclick="p(\'' . $cururl . $url . '\', \'' . $pdata['pindex'] . '\', ' . $context['ajaxcallback'] . ')"';
		$pdata['naa'] = 'href="javascript:;" onclick="p(\'' . $cururl . $url . '\', \'' . $pdata['nindex'] . '\', ' . $context['ajaxcallback'] . ')"';
		$pdata['laa'] = 'href="javascript:;" onclick="p(\'' . $cururl . $url . '\', \'' . $pdata['lindex'] . '\', ' . $context['ajaxcallback'] . ')"';
	} else {
		if($url) {
			$pdata['faa'] = 'href="?' . str_replace('*', $pdata['findex'], $url) . '"';
			$pdata['paa'] = 'href="?' . str_replace('*', $pdata['pindex'], $url) . '"';
			$pdata['naa'] = 'href="?' . str_replace('*', $pdata['nindex'], $url) . '"';
			$pdata['laa'] = 'href="?' . str_replace('*', $pdata['lindex'], $url) . '"';
		} else {
			$_GET['page'] = $pdata['findex'];
			$pdata['faa'] = 'href="' . $cururl . '?' . http_build_query($_GET) . '"';
			$_GET['page'] = $pdata['pindex'];
			$pdata['paa'] = 'href="' . $cururl . '?' . http_build_query($_GET) . '"';
			$_GET['page'] = $pdata['nindex'];
			$pdata['naa'] = 'href="' . $cururl . '?' . http_build_query($_GET) . '"';
			$_GET['page'] = $pdata['lindex'];
			$pdata['laa'] = 'href="' . $cururl . '?' . http_build_query($_GET) . '"';
		}
	}

	$html = '<div class="pagination pagination-centered"><ul class="pagination pagination-centered">';
	if($pdata['cindex'] > 1) {
		$html .= "<li><a {$pdata['faa']} class=\"pager-nav\">首页</a></li>";
		$html .= "<li><a {$pdata['paa']} class=\"pager-nav\">&laquo;上一页</a></li>";
	}
	//页码算法：前5后4，不足10位补齐
	if(!$context['before'] && $context['before'] != 0) {
		$context['before'] = 5;
	}
	if(!$context['after'] && $context['after'] != 0) {
		$context['after'] = 4;
	}

	if($context['after'] != 0 && $context['before'] != 0) {
		$range = array();
		$range['start'] = max(1, $pdata['cindex'] - $context['before']);
		$range['end'] = min($pdata['tpage'], $pdata['cindex'] + $context['after']);
		if ($range['end'] - $range['start'] < $context['before'] + $context['after']) {
			$range['end'] = min($pdata['tpage'], $range['start'] + $context['before'] + $context['after']);
			$range['start'] = max(1, $range['end'] - $context['before'] - $context['after']);
		}
		for ($i = $range['start']; $i <= $range['end']; $i++) {
			if($context['isajax']) {
				$aa = 'href="javascript:;" onclick="p(\'' . $cururl . $url . '\', \'' . $i . '\', ' . $context['ajaxcallback'] . ')"';
			} else {
				if($url) {
					$aa = 'href="?' . str_replace('*', $i, $url) . '"';
				} else {
					$_GET['page'] = $i;
					$aa = 'href="?' . http_build_query($_GET) . '"';
				}
			}
			$html .= ($i == $pdata['cindex'] ? '<li class="active"><a href="javascript:;">' . $i . '</a></li>' : "<li><a {$aa}>" . $i . '</a></li>');
		}
	}

	if($pdata['cindex'] < $pdata['tpage']) {
		$html .= "<li><a {$pdata['naa']} class=\"pager-nav\">下一页&raquo;</a></li>";
		$html .= "<li><a {$pdata['laa']} class=\"pager-nav\">尾页</a></li>";
	}
	$html .= '</ul></div>';
	return $html;
}