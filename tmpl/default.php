<?php
/*
*Имя приложения: Embed YouTune
*Версия:1
*Автор:Boyko Dmitry
*Дата:10.06.2018
*Описание:Вставляет видео с YouTune.
*/
defined('_JEXEC') or die; 
//Поиск ID YouTune вмдео.
$YT_LINK=$params['YouTubeLink'];
//Поиск похожих парамтров для вырезки ID видео
$PosIframe=strpos($YT_LINK,'iframe');
$PosURL=strpos($YT_LINK,'watch?v=');
$PosShort=strpos($YT_LINK,'youtu.be/');
if($PosIframe>0){//IFrame
	$PosIframe=strpos($YT_LINK,'/embed/');
	$len=strlen('/embed/');
	$stop=strpos($YT_LINK,'?',$PosIframe+$len);
	if($stop>0){
		$YT_ID=substr($YT_LINK,$PosIframe+$len,$stop-($PosIframe+$len));
	}else{
		$YT_ID=substr($YT_LINK,$PosIframe+$len);
	}
	
}
if($PosURL>0){//Cсылка на страницу с видео
	$len=strlen('watch?v=');
	$stop=strpos($YT_LINK,'&',$PosURL+$len);
	if($stop>0){
		$YT_ID=substr($YT_LINK,$PosURL+$len,$stop-($PosURL+$len));
	}else{
		$YT_ID=substr($YT_LINK,$PosURL+$len);
	}
	
}
if($PosShort>0){//Короткая ссылка
	$len=strlen('youtu.be/');
	$YT_ID=substr($YT_LINK,$PosShort+$len);
}
if($PosIframe=='' AND $PosURL=='' AND $PosShort=='')$YT_ID=$YT_LINK;//ID
$YT_Domien='www.youtube.com';
/*******************************************/
//Параметры видео
$Width=$params['VudeoWidth'];
$Height=$params['VideoHeight'];
$Size='width="'.$Width.'" height="'.$Height.'"';
/*******************************************/
$YT_LS='';//Настроки видео
if($params['SimilarVideo']==0){
	$YT_LS='rel=0';
}
if($params['ControlPanel']==0){
	if(!empty($YT_LS))$YT_LS.='&';
	$YT_LS.='controls=0';
}
if($params['TitleVideo']==0){
	if(!empty($YT_LS))$YT_LS.='&';
	$YT_LS.='showinfo=0';
}
if($params['StartTime']!='0:00'){
	if(!empty($YT_LS))$YT_LS.='&';
	$ArrST=explode(':',$params['StartTime']);
	$time=0;
	if(count($ArrST)==2){
		$time=$ArrST[0]*60+$ArrST[1];
	}
	if(count($ArrST)==3){
		$time=($ArrST[0]*60+$ArrST[1])*60+$ArrST[2];
	}
	$YT_LS.='start='.$time;
}
if(!empty($YT_LS)){
	$YT_ID.='?'.$YT_LS;
}
/*******************************************/
if($params['PrivacyMode']==1){
	$YT_Domien='www.youtube-nocookie.com';
}

/*******************************************/
$AutiSize=$params['AutoSize'];
?>
<?php if($AutiSize==1):?>
<style>
.mod_embed_yt_auto_<?=$module->id?>{
  position: relative;
  padding-bottom: 56.25%;
  padding-top: 30px;
  height: 0;
  overflow: hidden;
}
.mod_embed_yt_auto_<?=$module->id?> iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
</style>
<div class="mod_embed_yt_auto_<?=$module->id?>">
<?php endif;?>

<iframe <?php echo $Size; ?> src="https://<?php echo $YT_Domien;?>/embed/<?php echo $YT_ID; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>


<?php if($AutiSize==1):?></div><?php endif;?>
