<?
/**
 * @����: uncallcc API DEMO
 * @����: �޽�
 * @���ڣ�2013 09 10
 */

//���Կ���
//ini_set('display_errors', true);
//����Ӧ���õ�ַ
define('DIAL_SERVERES_ADDRESS_WSDL_API',"http://192.168.1.200/uncall_api/index.php?wsdl");
//ʵ�����ӿ�
$soapClient = new SoapClient(DIAL_SERVERES_ADDRESS_WSDL_API); //���ýӿ�	
//�ӿڵ���
$reslut=$soapClient->OnClickCall("801","18681981812","");
var_dump($reslut);
echo "<test>";
?>