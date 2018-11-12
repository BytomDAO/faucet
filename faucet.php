<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>比原链测试网水龙头</title>
  <link rel="stylesheet" href="./assets/main.css">
  <script src="./assets/main.js"></script>
</head>


<body>
<?php
/* PPK Testnet Faucet DEMO baesd Bytom Blockchain */
/*         PPkPub.org  20180917                   */  
/*    Released under the MIT License.             */

require_once "inc.php";

define('FAUCET_AMOUNT_mBTM',10*1000); //注意单位:mBTM

$your_address = addslashes(@$_REQUEST['your_address']); //避免异常输入字符的安全性问题
$address_flag=substr($your_address,0,1);
if( !(strcasecmp($address_flag,'t')==0 || strcasecmp($address_flag,'s')==0) ){
?>
<div id="particles">
<div class="overlay"></div>
<div id="intro">
  <h1>比原链测试网水龙头 <br>（BytomGmTestnetFaucet）</h1>
  <p>请输入比原链测试网钱包地址（以tm起始）来领取测试币。</p>
  <p>Please input Bytom testnet address which is start from tm...</p>
  <form name="form_faucet" id="form_faucet" action="faucet.php" method="get">
    <p>您的比原测试钱包地址(Wallet Address)：<input size="50" name="your_address" id="your_address" autofocus="true" type="text"></p>
    <button type="submit" id="game_send_trans_btn" class="btn">免费领取（Get now for free!）</button>
  </form>
  <p>比原官方钱包下载和安装请参考：<a target="_blank" href="http://8btc.com/thread-181537-1-1.html">使用说明</a> （注意运行钱包时选择测试网络才能参与领取测试币）</p>
</div>
</div>

<?php
  exit(0);
}

$asset_id=addslashes(@$_REQUEST['asset_id']); //避免异常输入字符的安全性问题

$current_account_info=getNextAccountInfo();

$tmp_url=BTM_NODE_API_URL.'build-transaction';

if(strlen($asset_id)==0){
  $tmp_post_data='{
    "base_transaction": null,
    "actions": [
      {
        "account_id": "'.$current_account_info['id'].'",
        "amount": '.( FAUCET_AMOUNT_mBTM+TX_GAS_AMOUNT_mBTM ).'00000,
        "asset_id": "'.BTM_ASSET_ID.'",
        "type": "spend_account"
      },
      {
        "amount": '.FAUCET_AMOUNT_mBTM.'00000,
        "asset_id": "'.BTM_ASSET_ID.'",
        "address": "'.$your_address.'",
        "type": "control_address"
      }
    ],
    "ttl": 0,
    "time_range": '.time().'
  }';
}else{
  $faucet_token_amount=1000;
  $tmp_post_data='{
    "base_transaction": null,
    "actions": [
      {
        "account_id": "'.$current_account_info['id'].'",
        "amount": '.TX_GAS_AMOUNT_mBTM .'00000,
        "asset_id": "'.BTM_ASSET_ID.'",
        "type": "spend_account"
      },
      {
        "account_id": "'.$current_account_info['id'].'",
        "amount": '.$faucet_token_amount .',
        "asset_id": "'.$asset_id.'",
        "type": "spend_account"
      },
      {
        "amount": '.$faucet_token_amount.',
        "asset_id": "'.$asset_id.'",
        "address": "'.$your_address.'",
        "type": "control_address"
      }
    ],
    "ttl": 0,
    "time_range": '.time().'
  }';
}

$obj_resp=sendBtmTransaction($tmp_post_data,$current_account_info);

if(strcmp($obj_resp['status'],'success')!==0){
  $tx_err=json_encode($obj_resp);
  echo "<script>alert(\"发送失败，请稍后重试！Failed to send transaction，please try later！ ".$tx_err."\"),location.href=\"faucet.php\";</script>";
    exit(-1);
}else{
  $tx_id=$obj_resp['data']['tx_id'];
  echo "<script>alert(\"发送成功，交易ID: ".$tx_id."\"),location.href=\"faucet.php\";</script>";
}

?>

</body>

</html>