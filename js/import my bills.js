//功能： 将青果记账的数据批量导入多多记账
// 本代码仅在已登录微信的页面生效，可借助qq浏览器微信登录插件登录微信
// 登录后打开多多记账，进入自己的账单页面，然后即可执行以下代码快速批
// 量导入自己的账单;

/******自己的数据*******/
//待导入的数据，需替换为自己要导入的
var data = {
  "2016-09-04": [
    {
      "id": 863594,
      "owner": 2,
      "currency": 4,
      "currency_type": 1,
      "type": 0,
      "category": 1,
      "reimburse": 0,
      "audio": "",
      "photo": "",
      "location": "",
      "memo": "早餐四块。",
      "user_id": 47551,
      "weixin_id": "",
      "datetime": "2016-09-04"
    },
    {
      "id": 863593,
      "owner": 2,
      "currency": 23,
      "currency_type": 1,
      "type": 0,
      "category": 1,
      "reimburse": 0,
      "audio": "",
      "photo": "",
      "location": "",
      "memo": "周末餐饮二十三。",
      "user_id": 47551,
      "weixin_id": "",
      "datetime": "2016-09-04"
    }
  ]
};
//在微信登录的情况下打开多多记账之后可以看到页面已经发送的请求里有一个
//auth_token，把它记录下来，替换下面
var auth_token = "eyJ1aWQiOjE3ODIzNiwidWtleSI6IjA0ZDJjZTk1OWQxYmRkMDcwYjI2ODdlMDkxOWE4NmI5In0=";
/*******end*******/

//js暂停函数
function sleep(numberMillis) { 
	var now = new Date(); 
	var exitTime = now.getTime() + numberMillis; 
	while (true) { 
		now = new Date(); 
		if (now.getTime() > exitTime) 
			return; 
	} 
}

//导入用函数
function importBill(auth_token,datetime,money,remark,categoryId){
	console.log('导入条目 ' + datetime + ' ' + remark);
	window.xhttp.open("POST","http://duo.qq.com/api/addBill",true);
	window.xhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded;charset=UTF-8");
	window.xhttp.setRequestHeader("Accept","application/json, text/plain, */*");
	window.xhttp.setRequestHeader("Auth-Token",auth_token);
	window.xhttp.send("categoryId=" + categoryId + "&recordTime="+datetime+"&money="+ money +"&remark=" + remark);
}

var xhttp = new XMLHttpRequest;

var day_data;
var one_bill;

for(day in data){
	day_data=data[day];
	for(bill in day_data){
		one_bill = day_data[bill];
		importBill(auth_token,one_bill.datetime,one_bill.currency,one_bill.memo,203);
		sleep(1000);
	}
}