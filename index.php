<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">

		<title>Todo list demo with websockets & redis</title>

		<link href="entireframework.min.css" rel="stylesheet" type="text/css" />

		<style type="text/css">
			/* Min+ plugin*/
			message {
				padding: 7px 25px 9px 25px;
				background: #def;
				border-left: 5px solid #44e;
			}

			tache {
                display: block;
                float: left;
				padding: 20px 25px 20px 25px;
				background: #DDEEFF;
				border-left: 5px solid #5599DD;
				margin-right: 30px;
				width: 350px;
			}

			legende {
                display: block;
                float: left;
                color: grey;
                padding-top: 18px;
            }

			.mess {
				display: block;
				height: 64px;
			}

			.warning {
				border-color: #e44; 
				background: #fdd;
			}

			.username {
				margin-top: 10px;
				margin-bottom: 10px;
			}

		</style>
	</head>
	<body>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>

		<script language="javascript" type="text/javascript">  
			$(document).ready(function(){

				var warnusername = false;

				//create a new WebSocket object.
				var wsUri = "ws://localhost:8080"; 	
				websocket = new WebSocket(wsUri); 

				$('#send-btn').click(function(){ //use clicks message send button
				    var mymessage = $('#message').val(); //get message text
					var myname = $('#name').val(); //get user name
					
					if(myname == ""){ //empty name?
						if(!warnusername){
							$('#username').append($("<message class=\"warning\">Vous devez renseigner un nom d'utilisateur !</message>").hide().fadeIn(700));
							warnusername=true;
						}
						return;
					}
					if(mymessage == ""){ //emtpy message?
						return;
					}

					var d = new Date();
					var mytime = d.getDate()+"/"+d.getMonth()+"/"+d.getFullYear()+" à "+d.getHours()+"h"+d.getMinutes();

					//prepare json data
					var msg = {
					message: mymessage,
					name: myname,
					time: mytime
					};
					//convert and send data to server
					websocket.send(JSON.stringify(msg));

				});

				//#### Message received from server?
				websocket.onmessage = function(ev) {
					var msg = JSON.parse(ev.data); //PHP sends Json data
					var umsg = msg.message; //message text
					var uname = msg.name; //user name
					var utime = msg.time;

					$('#messages').append($("<div class=\"mess\"><tache><strong>"+umsg+"</strong></tache><legende>Ajoutée par <u>"+uname+"</u> le "+utime+"</legende></div>").hide().fadeIn(700));
				};
			});
		</script>

		<div class="container">
			<div id="username" class="username">
				<span class="addon">username</span><input id="name" type="text" class="smooth">
			</div>
			<div id="nouvelletache">
				<span class="addon">nouvelle tâche</span><input id="message" type="text" class="smooth">
				<a id="send-btn" class="btn btn-b btn-sm smooth">ajouter</a>
			</div>
			<h1>TO DO</h1>

			<div id="messages" class="messages">
				<?php
					require 'vendor/autoload.php';

					Predis\Autoloader::register();

					$client = new Predis\Client();
					$values = $client->lrange('todo',0,-1);

					foreach($values as $value){
						$fields = explode(":",$value);
						echo('<div class="mess"><tache><strong>'.$fields[0]."</strong></tache><legende>Ajoutée par <u>".$fields[1]."</u> le ".$fields[2]."</legende></div>");
					}
				?>
			</div>
		</div>
	</body>
</html>
