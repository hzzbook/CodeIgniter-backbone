<?php
class Wxformat {
	
	public function __construct() {
		
	}
	
	public function transmit($object, $content, $newtype = 'text') {
		switch ($newtype) {
			case 'text':	#文本消息
				$result = $this->transmitText($object, $content);
				break;
			case 'image':	#图片消息
				$result = $this->transmitImage($object, $content);
				break;
			case 'voice':	#语音
				$result = $this->transmitVoice($object, $content);
				break;
			case 'news':	#图文
				$result = $this->transmitNews($object, $content);
				break;
			case 'music':	#音乐
				$result = $this->transmitMusic($object, $content);
				break;
			case 'video':	#视频
				$result = $this->transmitVideo($object, $content);
				break;
			case 'service':	#客服服务
				$result = $this->transmitService($object);
				break;
			default:
				$result = $this->transmitText($object, $content);
				break;
		}
		return $result;
	}
	
    //回复文本消息
    public function transmitText($object, $content)
    {
        $xmlTpl = "<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[text]]></MsgType>
		<Content><![CDATA[%s]]></Content>
		</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }

    //回复图片消息
    public function transmitImage($object, $imageArray)
    {
        $itemTpl = "<Image>
		    <MediaId><![CDATA[%s]]></MediaId>
			</Image>";

        $item_str = sprintf($itemTpl, $imageArray['MediaId']);

        $xmlTpl = "<xml>
			<ToUserName><![CDATA[%s]]></ToUserName>
			<FromUserName><![CDATA[%s]]></FromUserName>
			<CreateTime>%s</CreateTime>
			<MsgType><![CDATA[image]]></MsgType>
			$item_str
			</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复语音消息
    public function transmitVoice($object, $voiceArray)
    {
        $itemTpl = "<Voice>
		    <MediaId><![CDATA[%s]]></MediaId>
			</Voice>";

        $item_str = sprintf($itemTpl, $voiceArray['MediaId']);

        $xmlTpl = "<xml>
			<ToUserName><![CDATA[%s]]></ToUserName>
			<FromUserName><![CDATA[%s]]></FromUserName>
			<CreateTime>%s</CreateTime>
			<MsgType><![CDATA[voice]]></MsgType>
			$item_str
			</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复视频消息
    public function transmitVideo($object, $videoArray)
    {
        $itemTpl = "<Video>
		    <MediaId><![CDATA[%s]]></MediaId>
		    <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
		    <Title><![CDATA[%s]]></Title>
		    <Description><![CDATA[%s]]></Description>
			</Video>";

        $item_str = sprintf($itemTpl, $videoArray['MediaId'], $videoArray['ThumbMediaId'], $videoArray['Title'], $videoArray['Description']);

        $xmlTpl = "<xml>
			<ToUserName><![CDATA[%s]]></ToUserName>
			<FromUserName><![CDATA[%s]]></FromUserName>
			<CreateTime>%s</CreateTime>
			<MsgType><![CDATA[video]]></MsgType>
			$item_str
			</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复图文消息
    public function transmitNews($object, $newsArray)
    {
        if(!is_array($newsArray)){
            return;
        }
        $itemTpl = "    <item>
	        <Title><![CDATA[%s]]></Title>
	        <Description><![CDATA[%s]]></Description>
	        <PicUrl><![CDATA[%s]]></PicUrl>
	        <Url><![CDATA[%s]]></Url>
		    </item>	";
        $item_str = "";
        foreach ($newsArray as $item){
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
        $xmlTpl = "<xml>
			<ToUserName><![CDATA[%s]]></ToUserName>
			<FromUserName><![CDATA[%s]]></FromUserName>
			<CreateTime>%s</CreateTime>
			<MsgType><![CDATA[news]]></MsgType>
			<ArticleCount>%s</ArticleCount>
			<Articles>
			$item_str</Articles>
			</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
        return $result;
    }

    //回复音乐消息
    public function transmitMusic($object, $musicArray)
    {
        $itemTpl = "<Music>
		    <Title><![CDATA[%s]]></Title>
		    <Description><![CDATA[%s]]></Description>
		    <MusicUrl><![CDATA[%s]]></MusicUrl>
		    <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
			</Music>";

        $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);

        $xmlTpl = "<xml>
			<ToUserName><![CDATA[%s]]></ToUserName>
			<FromUserName><![CDATA[%s]]></FromUserName>
			<CreateTime>%s</CreateTime>
			<MsgType><![CDATA[music]]></MsgType>
			$item_str
			</xml>";

        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }

    //回复多客服消息
    public function transmitService($object)
    {
        $xmlTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[transfer_customer_service]]></MsgType>
</xml>";
        $result = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time());
        return $result;
    }
	
}