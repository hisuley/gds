<?php
if(!$IWEB_SHOP_IN){
	die('Hacking attempt');
}

//引入语言包
$a_langpackage=new adminlp;

$article_id = intval(get_args('id'));
$audit = intval(get_args('audit'));
if(!$article_id || !$audit) {
	trigger_error($a_langpackage->a_error);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link rel="stylesheet" type="text/css" href="skin/css/admin.css">
<link rel="stylesheet" type="text/css" href="skin/css/main.css">
<style>
td span {color:red;}
</style>
</head>
<body>
<div id="maincontent">
<?php  include("messagebox.php");?>
	<div class="wrap">
	<div class="crumbs"><?php echo $a_langpackage->a_location; ?> &gt;&gt; <?php echo $a_langpackage->a_content;?> &gt;&gt; <?php echo $a_langpackage->a_news_audit_note; ?></div>
        <hr />
	<div class="infobox">
	<h3><span class="left"><?php echo $a_langpackage->a_news_audit_note; ?></span><span class="right" style="margin-right:15px;"><?php if($audit === 2){ ?> <a href="m.php?app=news_first_list"><?php echo $a_langpackage->a_news_first_list; ?></a></span><?php } ?><?php if($audit === 3){ ?><a href="m.php?app=news_recheck_list"><?php echo $a_langpackage->a_news_recheck_list; ?></a></span><?php } ?></h3>
    <div class="content2">
		<form method="post" action="a.php?act=news_audit" name="form_news_audit" onsubmit="return check_form(this)">
		<table>
			<tr><input type="hidden" name="audit" value="<?php echo $audit; ?>"/><input type="hidden" name="id" value="<?php echo $article_id; ?>"/>
				<td width="40px;"><?php echo $a_langpackage->a_words_beizhu; ?>：</td>
				<td><input type="text" name="audit_note" style="width:200px" /><span class="red">*</span></td>
			</tr>
			<tr>
				<td colspan="2"><span class="button-container"><input class="regular-button" type="submit" name="btn_submit" value="<?php echo $a_langpackage->a_news_audit_note; ?>"  /></span></td>
			</tr>
		</table>
		</form>
	  </div>
	 </div>
   </div>
</div>
</body>
</html>
<script language="JavaScript" type="text/javascript">
	function check_form(obj){
		if(obj.audit_note.value==''){
			ShowMessageBox("<?php echo $a_langpackage->a_check_complay; ?>","0")
			return false;
		}
		
	}
</script>