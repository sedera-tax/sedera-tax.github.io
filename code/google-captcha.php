<html>
	<head>
		<title>reCAPTCHA google</title>
		<script src='https://www.google.com/recaptcha/api.js'></script>
	</head>
	<body>
		<?php
		function getUserIP()
		{
			// Get real visitor IP behind CloudFlare network
			if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
				$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
				$_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
			}
			$client  = @$_SERVER['HTTP_CLIENT_IP'];
			$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
			$remote  = $_SERVER['REMOTE_ADDR'];

			if(filter_var($client, FILTER_VALIDATE_IP))
			{
				$ip = $client;
			}
			elseif(filter_var($forward, FILTER_VALIDATE_IP))
			{
				$ip = $forward;
			}
			else
			{
				$ip = $remote;
			}

			return $ip;
		}
		
		if (isset($_POST) && !empty($_POST)) {
			// Construct the Google verification API request link.
			$params = array();
			$params['secret'] = '6Lf1cmIUAAAAAMv45C1dY3EPT4OOzINkwtStPxIN'; // Secret key
			$params['response'] = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : "";
			$params['remoteip'] = getUserIP();
			
			// Get cURL resource
			$curl = curl_init();

			// Set some options
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://www.google.com/recaptcha/api/siteverify",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => "secret=".$params['secret']."&response=".$params['response']."&remoteip=".$params['remoteip']
			));

			// Send the request
			$response = curl_exec($curl);
			$err = curl_error($curl);

			// Close request to clear up some resources
			curl_close($curl);

			if ($err) {
				echo "cURL Error #:" . $err;
			} else {
				echo $response;
			  
				$response = @json_decode($response, true);
				if ($response["success"] == true) {
					echo '<h3 style="color: green;">Login Successful</h3>';
				} else {
					echo '<h3 style="color: red;">Login failed</h3>';
				}
			}
		}
		?>
		<form action="" method="POST">
			<div class="g-recaptcha" data-sitekey="6Lf1cmIUAAAAAM6sJ7S8-uu1gFYClVRGg_3pq2ia"></div>
			<br>
			<input type="submit" value="Submit">
		</form>
	</body>
</html>