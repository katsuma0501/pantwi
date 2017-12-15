<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE11">
<meta name="viewport" content="width=320,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no,minimal-ui">
<meta name="apple-mobile-web-app-title" content="" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta property="og:title" content="">
<meta property="og:type" content="">
<meta property="og:site_name" content="">
<meta property="og:url" content="">
<meta property="og:description" content="">
<meta property="og:image" content="">
<link rel="apple-touch-icon-precomposed apple-touch-icon" href="" />
<link rel="shortcut icon" href="" />
<link rel="home" href="" title="" />
<title>パンとツイート</title>

<!--[if lt IE 10]>
<meta http-equiv="refresh" content="0; URL=oldie.html">
<![endif]-->
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
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
			lists: [],
			word: ""
		}
	});
	var twi_lists = new Vue({
		el: '#twi_lists',
		data: {
			twi_word: [],
			twi_list: []
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

				var rest = response["data"]["rest"];

				lists.$forceUpdate();

				for( var r  in rest ){
					// twi_lists.twi_word.push(rest[r]['name']);
					axios.get("./twi.php?q=" + rest[r]['name'],{'responseType':'json'})
						.then(function (response) {
							console.log(response);	
							for( var d  in response["data"] ){
								twi_lists.twi_list.push({
									text:response["data"][d]["text"],
									user_name:response["data"][d]["user"]["name"]
								})
							}
							// twi_lists.twi_list = response["data"];
						})
						.catch(function (error) {
							console.log(error);
						});
				}

				twi_lists.$forceUpdate();

				// var twi_search_word = twi_lists.twi_word.join(' OR ');

				// lists.word = twi_search_word;				

				// alert(twi_search_word);

				// axios.get("./twi.php?q=" + twi_search_word,{'responseType':'json'})
				// .then(function (response) {
				// 	console.log(response);				
				// 	twi_lists.twi_list = response["data"];
				// 	twi_lists.$forceUpdate();
				// })
				// .catch(function (error) {
				// 	console.log(error);
				// });
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
<header>
<div class="bs-component">
	<nav class="navbar navbar-dark bg-inverse">
	<button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarResponsive3" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"></button>
	<div class="container collapse navbar-toggleable-md" id="navbarResponsive3">
		<a class="navbar-brand" href="#">Brand</a>
		<ul class="nav navbar-nav">
		<li class="nav-item active">
			<a class="nav-link" href="#">ホーム <span class="sr-only">(current)</span></a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="#">リンク</a>
		</li>
		<li class="nav-item">
			<a class="nav-link" href="#">リンク</a>
		</li>
		<li class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" href="http://example.com" id="supportedContentDropdown2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">メニュー</a>
			<div class="dropdown-menu" aria-labelledby="supportedContentDropdown2">
			<a class="dropdown-item" href="#">高坂 穂乃果</a>
			<a class="dropdown-item" href="#">南 ことり</a>
			<a class="dropdown-item" href="#">園田 海未</a>
			</div>
		</li>
		</ul>
		<form class="form-inline float-lg-right">
		<input class="form-control" type="text" placeholder="Search">
		<button class="btn btn-primary" type="submit">検索</button>
		</form>
	</div>
	</nav>
</div>
</header>
<div class="container" style="margin-top:20px;">
	<div class="row">
		<div id="list" class="col-lg-4">
			<div class="card" v-for="list in lists">
				<img v-if="typeof list.image_url.shop_image1 == 'string' " style="height: 150px; margin:10px auto 0; display: block;background: #555;" v-bind:src="list.image_url.shop_image1" alt="Card image">
				<img v-else style="height: 150px; width: 100%; display: block;" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22318%22%20height%3D%22180%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20318%20180%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_158bd1d28ef%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A16pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_158bd1d28ef%22%3E%3Crect%20width%3D%22318%22%20height%3D%22180%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22129.359375%22%20y%3D%2297.35%22%3EImage%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" alt="Card image">
				
				<div class="card-block">
					<h5 class="card-title">{{ list.name }}</h5>
					
					<p v-if="typeof list.pr.pr_short == 'string' " class="card-text">{{ list.pr.pr_short }}</p>
					<p v-else></p>

					<small class="card-text">{{ list.opentime }}<br>{{ list.address }}<br>{{ list.tel }}</small>	
				</div>
				<div class="card-footer text-muted text-xs-center">
					<a v-bind:href="list.url" target="_blank">ぐるなび店舗ページへ</a>
				</div>
          </div>
		</div>
		<div id="twi_lists" class="col-lg-8">
			<div class="bs-component">
			<div class="card card-outline-primary text-xs-center" v-for="twi in twi_list">
            <div class="card-block">
              	<blockquote class="card-blockquote">
                <p>{{ twi.text }}</p>
                <footer>{{ twi.user_name }}</footer>
              	</blockquote>
            	</div>
          	</div>
			</div>
		</div>
	</div>
</div>

	<div id="app"></div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>