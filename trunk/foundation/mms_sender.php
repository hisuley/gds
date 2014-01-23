<?PHP


class mms_sender {
    private $mmsContent = array('images'=>array(), 'text'=>array());
    private $imageFrameNumber = 1;
    private $txtFrameNumber = 1;
    private $mobile = array();
    private $title = 'DMS系统订单信息';
    const TYPE_TXT = '1';
    const TYPE_JPG = '2';

    public function __construct($mobile, $title = 'DMS系统订单信息'){
        if(is_array($mobile)){
            $this->mobile = $mobile;
        }else{
            array_push($this->mobile, $mobile);
        }
        $this->title = iconv('UTF-8', "gb2312//IGNORE", $title);
    }
    private function configs(){
        return array(
            'sn'=>'SDK-BBX-010-18406', //换成您自己的序列号
            'pwd'=>'6ACE1A436CAD45D2B66078E0A8D40D3E', //此处密码需要加密 加密方式为 md5(sn+password)
            'title'=>$this->title,
            'mobile'=>'',//手机号 多个用英文的逗号隔开 post理论没有长度限制.推荐群发一次小于等于10000个手机号
            'content'=>'',//彩信信内容//base64_encode();
            'ext'=>'',
            'rrid'=>'',//默认空 如果空返回系统生成的标识串 如果传值保证值唯一 成功则返回传入的值
            'stime'=>''//定时时间 格式为2011-6-29 11:09:21
        );
    }
    public function addFrame($type, $content, $Imagetype = 'jpg', $raw = false){
        if(intval($type) == self::TYPE_JPG){
            if($raw){
                $picContent = base64_encode($content);
            }else{

                $fp = fopen($content, "r");
                if(!$fp){
                    echo 'no exists';
                    return false;
                }
                $picContent = base64_encode(fread($fp,filesize($content)));
            }

            $picContent = $this->imageFrameNumber."_2.".$Imagetype.",".$picContent;
            array_push($this->mmsContent['images'], $picContent);
            $this->imageFrameNumber++;
        }elseif(intval($type) == self::TYPE_TXT){
            $txtContent =base64_encode(iconv( "UTF-8", "gb2312//IGNORE" ,$content));
            $txtContent = $this->txtFrameNumber."_1.txt,".$txtContent;
            array_push($this->mmsContent['text'], $txtContent);
            $this->txtFrameNumber++;

        }

    }
    public function send(){
        $argv = $this->configs();
        $output = $this->organize();
        $argv['content'] = $output;
        $argv['mobile'] = implode(',', $this->mobile);
        $flag = 0;
        $params = '';
        //构造要post的字符串
        foreach ($argv as $key=>$value) {
            if ($flag!=0) {
                $params .= "&";
                $flag = 1;
            }
            $params.= $key."="; $params.= urlencode($value);
            $flag = 1;
        }
        $length = strlen($params);
        //创建socket连接
        $fp = fsockopen("sdk3.entinfo.cn",8060,$errno,$errstr,10) or exit($errstr."--->".$errno);
        //构造post请求的头
        $header = "POST /webservice.asmx/mdMmsSend HTTP/1.1\r\n";
        $header .= "Host:sdk3.entinfo.cn\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: ".$length."\r\n";
        $header .= "Connection: Close\r\n\r\n";
        //添加post的字符串
        $header .= $params."\r\n";
        //发送post的数据
        fputs($fp,$header);
        $inheader = 1;
        while (!feof($fp)) {
            $line = fgets($fp,1024); //去除请求包的头只显示页面的返回数据
            if ($inheader && ($line == "\n" || $line == "\r\n")) {
                $inheader = 0;
            }
            if ($inheader == 0) {
                // echo $line;
            }
        }
        //<string xmlns="http://tempuri.org/">-5</string>
        $line=str_replace("<string xmlns=\"http://tempuri.org/\">","",$line);
        $line=str_replace("</string>","",$line);
        $result=explode("-",$line);
        $resultMsg = array('message'=>'', 'code'=>0, 'raw'=>0);
        if(count($result)>1){
            $resultMsg['code'] = 0;
            $resultMsg['message'] = '发送失败返回值为:'.$line;
            $resultMsg['raw'] = $params;
        }else{
            $resultMsg['code'] = 1;
            $resultMsg['message'] = '发送成功 返回值为:'.$line;
        }
        return $resultMsg;
    }

    private function organize(){
        $output = '';
        if(!empty($this->mmsContent['images'])){
            $output .= implode(';', $this->mmsContent['images']);
        }
        if(!empty($this->mmsContent['text'])){
            $output .= implode(';', $this->mmsContent['text']);
        }
        return $output;
    }
}