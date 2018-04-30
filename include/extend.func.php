<?php
function litimgurls($imgid=0)
{
    global $lit_imglist,$dsql;
    //获取附加表
    $row = $dsql->GetOne("SELECT c.addtable FROM #@__archives AS a LEFT JOIN #@__channeltype AS c 
                                                            ON a.channel=c.id where a.id='$imgid'");
    $addtable = trim($row['addtable']);
    
    //获取图片附加表imgurls字段内容进行处理
    $row = $dsql->GetOne("Select imgurls From `$addtable` where aid='$imgid'");
    
    //调用inc_channel_unit.php中ChannelUnit类
    $ChannelUnit = new ChannelUnit(2,$imgid);
    
    //调用ChannelUnit类中GetlitImgLinks方法处理缩略图
    $lit_imglist = $ChannelUnit->GetlitImgLinks($row['imgurls']);
    
    //返回结果
    return $lit_imglist;
}
function strreplace($dbstr){
	if(count(explode('更新', $dbstr)>1)){
		return '<font color="#FF0000">'.$dbstr.'</font>';
	}
}
//格式化资源下载
function GetMurls($dbstr){
	$restr = '';
	$patchArr = explode("\r\n", $dbstr);
	if(count($patchArr)>1){
		foreach($patchArr as $key => $val){
			if(!empty($val)){
				$nowval = explode('$$$$', $val);
				if(count($nowval)>1) $restr .= "<li>{$nowval[0]}<a href=\"javascript:void(0);\" onclick=\"copyUrl('{$nowval[1]}')\">复制下载地址</a><A oncontextmenu=ThunderNetwork_SetHref(this) onclick=\"return OnDownloadClick_Simple(this,2,4)\" href=\"#\" thunderResTitle=\"{$nowval[0]}\" thunderType=\"\" thunderPid=\"131852\" thunderHref=\"{$nowval[1]}\" style=\"color:red;\">迅雷专用高速下载</A><a style=\"color:red;\" onclick=\"start('{$nowval[1]}')\" href=\"javascript:;\" title=\"迅雷看看观看{$nowval[0]}\">迅雷看看观看</a></li>\r\n"; 
			}
		}
	}else{
		$nowval = explode('$$$$', $dbstr);
		if(count($nowval)>1) $restr = "<li>{$nowval[0]}<a href=\"javascript:void(0);\" onclick=\"copyUrl('{$nowval[1]}')\">复制下载地址</a><A oncontextmenu=ThunderNetwork_SetHref(this) onclick=\"return OnDownloadClick_Simple(this,2,4)\" href=\"#\" thunderResTitle=\"{$nowval[0]}\" thunderType=\"\" thunderPid=\"131852\" thunderHref=\"{$nowval[1]}\" style=\"color:red;\">迅雷专用高速下载</A><a style=\"color:red;\" onclick=\"start('{$nowval[1]}')\" href=\"javascript:;\" title=\"迅雷看看观看{$nowval[0]}\">迅雷看看观看</a></li>\r\n"; 
	}
	
	if(empty($restr)){
		return "<li>更新中暂无下载地址</li>";
	}else{
		return $restr;
	}
	
}
//<li>fdsfdsfdsfds<a href="ftp://www:piaohua.com@dy125.piaohua.com:8817/飘花电影piaohua.com纽约两日情BD中英双字1280高清.rmvb">直接下载</a><a href="ftp://www:piaohua.com@dy125.piaohua.com:8817/飘花电影piaohua.com纽约两日情BD中英双字1280高清.rmvb">迅雷看看</a><a href="ftp://www:piaohua.com@dy125.piaohua.com:8817/飘花电影piaohua.com纽约两日情BD中英双字1280高清.rmvb">迅雷下载</a></li>