<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE11">
<meta name="viewport" content="width=320,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,minimal-ui">
<meta name="apple-mobile-web-app-title" content="nowisee" />
<meta name="description" content="音楽を中心に映像や物語が一体となって織りなされるクロスコンテンツプロジェクトnowisee(ノイズ)のオフィシャルサイト--現代の全ての若者たちへ、生きる意味を問う。" />
<meta name="keywords" content="nowisee,ノイズ,クロスコンテンツ" />
<meta property="og:title" content="nowisee">
<meta property="og:type" content="website">
<meta property="og:site_name" content="nowisee">
<meta property="og:url" content="http://nowisee.jp/">
<meta property="og:description" content="nowisee オフィシャルサイト">
<meta property="og:image" content="http://nowisee.jp/images/ogp.jpg">
<link rel="apple-touch-icon-precomposed apple-touch-icon" href="http://nowisee.jp/apple-touch-icon.png" />
<link rel="shortcut icon" href="/favicon.ico" />
<link rel="home" href="http://nowisee.jp/" title="nowisee" />
<title>パンツイ</title>

<!--[if lt IE 10]>
<meta http-equiv="refresh" content="0; URL=oldie.html">
<![endif]-->
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
var lat = 35.6811691;
var lon = 139.7665038;
var setLatLon = function(lat, lon){
	var lists = new Vue({
		el: '#list',
		data: {
			lat: lat,
			lon: lon,
			lists: []
		}
	});
	var app = new Vue({
		el: '#app',
		data: {
			lat: lat,
			lon: lon
		},
		beforeCreate() {
			axios.get("./api.php?lat=" + lat + "&lon=" + lon,{'responseType':'json'})
			.then(function (response) {
				console.log(response);				
				lists.lists = response["data"]["rest"];
				lists.$forceUpdate();
			})
			.catch(function (error) {
				console.log(error);
			});
		}
	});
}
if( navigator.geolocation )
{
	// 現在位置を取得できる場合の処理
	navigator.geolocation.getCurrentPosition(function(position) {
		lat = position.coords.latitude;
		lon = position.coords.longitude;
		setLatLon(lat, lon);
	});
}

// https://api.gnavi.co.jp/RestSearchAPI/20150630/?keyid=9543a647f939cabad7f1982c54167ea1&format=json&input_coordinates_mode=1&latitude=35.6811691&longitude=139.7665038&range=3&category_s=RSFST18007
// https://api.gnavi.co.jp/master/CategorySmallSearchAPI/20150630/?keyid=9543a647f939cabad7f1982c54167ea1
</script>
<body>
	<div id="app"></div>
	<div id="list">
		
		<ul>
			<li v-for="list in lists">{{ list.name }}</li>
		</ul>
		
	</div>
</body>
</html>