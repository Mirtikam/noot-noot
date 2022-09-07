<?php
error_reporting(E_ERROR); 
ini_set("display_errors", 1);
?>
<?php
include("db.php");
$str = "SELECT * FROM chat ORDER BY date DESC LIMIT 40";
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Дипломный сайт</title>
  <style>
  html{
    height: 100%;
  }
  body{
    min-height: 100%;
    display: flex;
    flex-direction: column;
    margin: 0;
    font: 12px arial;
    color: rgb(0,71,171);
	  text-align:center;
	  
  }
  body>.container{
    flex-grow: 1;
    background: url(https://www.ne.se/info/wp-content/uploads/2019/05/ne-se-franskaomslag.jpg) no-repeat center;
  }
  header{
    height: 100px;
    display: flex;
    justify-content: space-between;
    background: url(http://astronomy.net.ua/photo/2064-50-1/1757_67-galcent.jpg) no-repeat center bottom;
  }
  footer{
    height: 100px;
  }
  body>.container, header, footer{
    margin: 0 50px;
  }
  
  .logo{
    background: url(https://sun9-11.userapi.com/c622317/v622317821/26db9/9k2yXY5NG-w.jpg) no-repeat;
    background-size: 110px;
    width: 110px;
    height: 100px;
  }
  
  .header-title{
    heig ht: 50px;
  }
  
  .chat-container{
  	margin: 0 auto;
  	padding-bottom: 25px;
  	background: rgb(18,47,170);
  	width: 504px;
  	border: 1px solid black; 
  	margin-top: 10%;
  }
	.chat-input {
	  overflow-y: auto;
  	text-align: left;
  	margin: 0 auto;
  	margin-bottom: 25px;
  	padding: 10px;
  	background: rgb(127,199,255);
  	height: 270px;
  	width: 430px;
  	border: 2px solid black;
	}
	.message{
	  width:395px;
	  border:1px solid black;
	}
	.hello{
	  color: white;
	  font-size: 12pt;
	}
	
	.table{
	  width: 100%;
  }
	.ms{
	  word-break: break-all;
	}
	
  </style>
</head>
<body>
  <header>
    <a href="index.php" class="logo" width="100" height="100"></a>
    <h1 class="header-title">Добро пожаловать в чат!</h1>
  </header>
  
<div class="container">
  <div class="chat-container">
  	<div class="hello">
  		<p>Чат</p>
  	</div>	
  	<div class="chat-input" >
  	  <table class="table">
          <?php foreach ($db->query($str) as $chat) { ?>
             <tr class="row">
              <td valign="top" class="col"><?php print $chat['name'].":"; ?></td>
              <td class="ms"><?php print $chat['msg']; ?></td>
            </tr>
          <?php } ?>
      </table>
  	</div>
  	<form  class="chat-form" action="" method="post">
  	  <input name="name" type="text" placeholder="Введите имя">
  		<input name="msg" type="text" placeholder="Введите сообщение" class="msg">
  		<input type="submit" value="&rarr;">
  	</form>
  </div>
</div>
<script> 
  
  let form = document.querySelector(".chat-form");
  
  form.addEventListener("submit", formObr);
  
  function formObr(e){
    e.preventDefault();
    let formData = new FormData(this);
    let prom = sendForm(this.action, formData); 
    prom.then(updateForm);
    document.querySelector(".msg").value = "";
  }
  
  
  async function sendForm(url, data){
   let option = {
          method: "post", //указываем метод GET или POST
          body: data //передаем данные (форму)
        }; 
        //запускаем ассинхронную передачу данных
        let responce = await fetch("obr.php", option);//обмен с внешним файлом
        let text = await responce.text();//получаем страницу в виде текста
        return text;
  }
  

function updateForm(){
   
  let req = new XMLHttpRequest();
  req.open("get", "update.php", true);
  req.onload = function(){
  handler(req); 
};
   
  req.send(null);
   
};
  
  
  function handler(req) {
    let row = document.querySelector('.row');
      if (req.readyState == 4) {
        if (req.status == 200) {
          if(req.responseText != "LOADING_CANCEL"){
            let json = JSON.parse(req.responseText);
            append_json(json);
            console.log(json);
          } else {
            alert("повторите позже");
            console.log(req.responseText); 
          }
        }      
      }
  }
    
  setInterval(updateForm, 5000);
  
function append_json(json){
  let chat = document.querySelector(".chat-input")
  let table = document.createElement("table");
  json.forEach(function(r) {
    let tr = document.createElement('tr'); 
    tr.innerHTML = '<td>' + r[0] + ":" + '</td>' + '<td>' + r[1] + '</td>'; 
    table.appendChild(tr);
  });
  chat.innerHTML = "";
  chat.append(table);
}
</script>

<footer>
  <iframe autoplay frameborder="0" style="border:none;width:100%;height:100px;" width="100%" height="100" src="https://music.yandex.ru/iframe/#track/1710796/227551">Слушайте <a href='https://music.yandex.ru/album/227551/track/1710796'>Friends Will Be Friends</a> — <a href='https://music.yandex.ru/artist/79215'>Queen</a> на Яндекс.Музыке</iframe>
</footer>
</body>
</html>
