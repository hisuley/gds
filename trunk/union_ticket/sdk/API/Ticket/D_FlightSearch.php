<?php
/**
 * 请求D_HotelSearch的服务（酒店列表查询）
 */
error_reporting(1);
class get_D_FlightSearch{
	/**
	 * @var城市的ID，必须填写
	 */
	var $currentDate = '2013-12-25';
	var $CityID="";
	var $SearchType = 'S';
	var $Routes = array(
		'FlightRoute' => array(
			'DepartCity'=>'BJS',
			'ArriveCity'=>'KWL',
			'DepartDate'=> '2013-12-25'
			)
		);
	var $DepartCity = 'BJS';
	var $ArriveCity = 'KWL';
	var $DepartDate = '2013-12-25';
	var $SendTicketCity = 'BJS';
	var $ResponseXML="";

	/**
	 *@var 构造请求体
	 */
	private  function getRequestXML()
	{
		/*
		 * 从config.php中获取系统的联盟信息(只读)
		 */
		$AllianceID='8257';
		$SID='178016';
		$KEYS='C9644F2F-1B13-4BED-8871-963E6195D592';
		$RequestType="D_FlightSearch";
		//构造权限头部
		$headerRight=getRightString($AllianceID,$SID,$KEYS,$RequestType);
		$SearchType="";
		if($this->SearchType!=""){
			$SearchType=<<<BEGIN
<SearchType>$this->SearchType</SearchType>
BEGIN;
		}
		//构造坐标的查询条件
		$Routes="";
		if($this->Routes!=0){
			$Routes=<<<BEGIN
 <Routes><FlightRoute><DepartCity>$this->DepartCity</DepartCity><ArriveCity>$this->ArriveCity</ArriveCity><DepartDate>$this->DepartDate</DepartDate>
</FlightRoute></Routes>
BEGIN;
		}
		$SendTicketCity = '';
		if($this->SendTicketCity != 0){
			$SendTicketCity = <<<BEGIN
<SendTicketCity>$this->SendTicketCity</SendTicketCity>
BEGIN;
		}

				$paravalues=<<<BEGIN
<?xml version="1.0"?>
<Request>
<Header $headerRight/>
<FlightSearchRequest>$SearchType$Routes$SendTicketCity</FlightSearchRequest>
</Request>
BEGIN;

				return  $paravalues;
			}
			/**
			 *
			 * 调用直接查询酒店列表的接口，获取到酒店的数据
			 */
			function main(){
				try{
					$requestXML=$this->getRequestXML();
					$commonRequestDo=new commonRequest();//常用数据请求
					$commonRequestDo->requestURL= OTA_FlightSearch_Url;
					$commonRequestDo->requestXML=$requestXML;
					$commonRequestDo->requestType=System_RequestType;//取config中的配置
					$commonRequestDo->doRequest();
					$returnXML=$commonRequestDo->responseXML;
					//print_r($commonRequestDo);die;
	    // echo json_encode($returnXML);die;//校验请求数据-临时用
					//调用Common/RequestDomXml.php中函数解析返回的XML
					$this->ResponseXML=getXMLFromReturnString($returnXML);
					//return $requestXML;
				}
				catch(Exception $e)
				{
					$this->ResponseXML=null;
				}
			}
		
		}
		?>