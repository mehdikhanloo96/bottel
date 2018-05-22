<?php
define('API_KEY','489738465:AAEOrn9ebs1oVfJy__gk4RY7N4r2U0yd5os');
$admin = 577111273;
$host_folder = 'https://ProTenVPS.elithost.ga/BotSaz';
$pvresan = "SudoShayan";
function makereq($method,$datas=[])
    {$url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($datas));
    $res = curl_exec($ch);
    if(curl_error($ch))
  {var_dump(curl_error($ch));}
    else
  {return json_decode($res);}
    }
function apiRequest($method, $parameters)
    {if (!is_string($method))
    {error_log("Method name must be a string\n");
    return false;}
    if (!$parameters) {
    $parameters = array();}
  else if (!is_array($parameters))
  {error_log("Parameters must be an array\n");
    return false;}
  foreach ($parameters as $key => &$val)
  {if (!is_numeric($val) && !is_string($val))
  {$val = json_encode($val);}
  }
  $url = "https://api.telegram.org/bot".API_KEY."/".$method.'?'.http_build_query($parameters);
  $handle = curl_init($url);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($handle, CURLOPT_TIMEOUT, 60);
  return exec_curl_request($handle);
    }
$update = json_decode(file_get_contents('php://input'));
var_dump($update);
$chat_id = $update->message->chat->id;
$mossage_id = $update->message->message_id;
$from_id = $update->message->from->id;
$msg_id = $update->message->message_id;
$name = $update->message->from->first_name;
$username = $update->message->from->username;
$textmessage = isset($update->message->text)?$update->message->text:'';
$usm = file_get_contents("data/users.txt");
$step = file_get_contents("data/".$from_id."/step.txt");
$members = file_get_contents('data/users.txt');
$ban = file_get_contents('banlist.txt');
$uvip = file_get_contents('data/vips.txt');
$chanell = 'BotSazT';
$gold = file_get_contents('data/'.$from_id."/gold.txt");
function SendMessage($ChatId, $TextMsg)
{
makereq('sendMessage',[
'chat_id'=>$ChatId,
'text'=>$TextMsg,
'parse_mode'=>"MarkDown"
]);
}
function SendSticker($ChatId, $sticker_ID)
{
makereq('sendSticker',[
'chat_id'=>$ChatId,
'sticker'=>$sticker_ID
]);
}
function Forward($KojaShe,$AzKoja,$KodomMSG)
{
makereq('ForwardMessage',[
'chat_id'=>$KojaShe,
'from_chat_id'=>$AzKoja,
'message_id'=>$KodomMSG
]);
}
function save($filename,$TXTdata)
{
$myfile = fopen($filename, "w") or die("Unable to open file!");
fwrite($myfile, "$TXTdata");
fclose($myfile);
}
if (strpos($ban , "$from_id") !== false  ) {
SendMessage($chat_id,"متاسفیم😔\nدسترسی شما به این سرور مسدود شده است.⚫️");
	}elseif(isset($update->callback_query))
{$callbackMessage = '';var_dump(makereq('answerCallbackQuery',['callback_query_id'=>$update->callback_query->id,'text'=>$callbackMessage]));
$chat_id = $update->callback_query->message->chat->id;
$message_id = $update->callback_query->message->message_id;
$data = $update->callback_query->data;
if (strpos($data, "del") !== false )
{$botun = str_replace("del ","",$data);
unlink("bots/".$botun."/index.php");
save("data/$chat_id/bots.txt","");
save("data/$chat_id/tedad.txt","0");
var_dump(makereq('editMessageText',
['chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"ربات شما با موفقیت حذف شد !",
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"به کانال ما بپیوندید",'url'=>"https://telegram.me/$chanell"]]]
                            ])
]                )
        );
}
else{var_dump(makereq('editMessageText',
['chat_id'=>$chat_id,
'message_id'=>$message_id,
'text'=>"خطا",
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"به کانال ما بپیوندید",'url'=>"https://telegram.me/$chanell"]]]
                            ])
]                    )
             );
   }
}
elseif ($textmessage == '🔙 برگشت')
{save("data/$from_id/step.txt","none");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"سلام😃👋\n\n- به ربات ساز حرفه ای تلگرام خوش آمدید🌹\n- به راحتی برای خود یک ربات تلگرامی رایگان بسازید🎯\n- برای ساخت ربات جدید دکمه ساخت ربات را بزنید🤖\n🎗 @$chanell 🎗",
'parse_mode'=>'Html',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🎯ساخت ربات"],['text'=>"🎗ربات های من"],['text'=>"☢زیر مجموعه گیری"]],
[['text'=>"📋راهنما"],['text'=>"🗑حذف ربات"]],
[['text'=>"🔰قوانین"],['text'=>"📕راهنما بات فادر"],['text'=>"📩پیشنهاد جدید"]],
[['text'=>"🎁کد هدیه"],['text'=>"📬پشتیبانی"]],
[['text'=>" 📢کانال ما"],['text'=>"📜ارسال نظر"],['text'=>"👤مشخصات من"]],
],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
elseif ($textmessage == '📋راهنما')
{
SendMessage($chat_id,"برای ساخت ربات جدید روی دکمه 🤖 ساخت ربات بزنید.\n\nبرای حذف ربات روی دکمه ❌ حذف ربات بزنید.\n\nبرای دیدن تعداد ربات ها خود روی دکمه 🚀 ربات های من بزنید.\n🤖 @$chanell");
}
 elseif ($textmessage == '🔰قوانین')
{
SendMessage($chat_id,"ℹ قوانین استفاده از ربات:

☢ همه مطالب باید تابع قوانین جمهوری اسلامی ایران باشد.
☢ رعایت ادب و احترام به کاربران.
☢ ساخت هرگونه ربات در ضمیمه +18 خلاف قوانین ربات میباشد و در صورت مشاهده ربات مورد نظر مسدود و همچنین مدیر ربات از ربات ما بلاک میشود.
☢ مسئولیت پیام های رد و بدل شده در هر ربات با مدیر آن میباشد و ما هیچگونه مسئولیتی نداریم.
☢ در صورت مشاهده استفاده از قابلیت های ربات در جهات منفی به شدت برخورد میشود.
☢ اگر به هر دلیلی درخواست های ربات شما به سرور ما بیش از حد معمول باشد (و حساب ربات ویژه نباشد) چند باری به شما اخطار داده میشود اگر این اخطار ها نادیده گرفته شوند ربات شما مسدود و به هیچ عنوان از محدودیت خارج نمیشود.

🆔 @$chanell");
}
elseif ($textmessage == '☢زیر مجموعه گیری')
{
SendMessage($chat_id,"این بخش بزودی راه اندازی میشود...");
}
elseif ($textmessage == 'توکن اینفوℹ')
{
SendMessage($chat_id,"امکان ساخت این ربات فعلا وجود ندارد...");
}
elseif ($textmessage == 'توکن اینفو ویژهℹ')
{
SendMessage($chat_id,"امکان ساخت این ربات فعلا وجود ندارد...");
}
elseif ($textmessage == '📢کانال ما')
{
SendMessage($chat_id,"کاربر عزیز برای ورود به کانال ربات به روی لینک زیر کلیک و سپس ok را بزنید ✔️

https://telegram.me/joinchat/AAAAAEM83wxlOiKkjM9BcA");
}
elseif ($textmessage == '📬پشتیبانی')
{
SendMessage($chat_id,"☢ جهت ارتباط با ما به ایدی زیر مراجعه کنید
🆔 @$pvresan");
}
elseif ($textmessage == '☢زیر مجموعه گیری غیرفعال')
{
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"🔰 به منوی زیر مجموعه گیری خوش آمدید
💯 لطفا یک گزینه را انتخاب کنید",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode([
'keyboard'=>[
[
['text'=>"بنر من⚜"]
],
[
['text'=>"چقدر کاربر آوردم❓"],['text'=>"ارتقا حساب🆙"]
],
[
['text'=>"🔙 برگشت"]
]
],
'resize_keyboard'=>true
])
]));
}
elseif ($textmessage == 'بنر من⚜')
{
SendMessage($chat_id,"سلام👋

یه ربات پیدا کردم باهاش میتونی ربات بسازی🙀😍
توضیحاتش :
ربات تلگرامی خود را بسازید 🤖
ساخت ربات های مختلف با امکانات جالب و عالی 👌
فقط با چند کلیک صاحب ربات تلگرامی خود شوید ❗️
با سرعت و کیفیت بالا 🚀


https://telegram.me/BotSazTBot?start=$from_id");
}
elseif ($textmessage == '👤مشخصات من')
{
SendMessage($chat_id,"➖➖➖➖➖➖➖➖
👤 نام = `$name`
☢ آیدی = `@$username`
🆔 شناسه = $from_id 

👥 لینک دعوت = 
http://telegram.me/BotSazTBot?start=$from_id
➖➖➖➖➖➖➖➖
🆔 @$chanell");
}
elseif ($textmessage == '📕راهنما بات فادر')
{
SendMessage($chat_id,"➖➖➖➖➖➖➖➖➖➖➖
ابتدا وارد @BotFather شوید✅

دستور /newbot را ارسال کنید✅

حالا یه اسم برای ربات بفرستید✅

و سپس ایدی ربات رو از شما میخواد...
ایدی مورد نظر خود را بفرستید✅
توجه کنید : در آیدی، شما فقط میتوانید از `_` برای فاصله دادن استفاده کنید و باید آخر آیدی ربات کلمه Bot رو بزارید تا مشکلی پیش نیاد✅

پیامی نسبتا طولانی دریافت میکنید که توکن در آن پیام است✅
توکن متنی مانند 👇
310470471:AAEAe5CepBLswJaZd4jNy9NDYNCnTqPe5mY
میباشد.

حال به ربات ما برگشته و توکن خود را برای ساخت ربات ارسال کنید✅
➖➖➖➖➖➖➖➖➖➖➖");
}
elseif($textmessage == '📩پیشنهاد جدید')
{
save("data/$from_id/step.txt","pishnahad");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"پیشنهاد خود را برای ربات ارسال کنید :",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙 برگشت"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
elseif ($step == 'pishnahad')
{
save("data/$from_id/step.txt","none");
$feed = $textmessage;
SendMessage($admin,"پیشنهادی جدید برای ربات از طرف👇

👤 کاربر = @$username
🆔 شناسه = @$from_id

متن پیشنهاد =
$textmessage");
SendMessage($chat_id,"✌️ با تشکر
پیشنهاد شما با موفقیت به مدیر ارسال شد...✔️");
}
elseif ($textmessage == '/back')
{save("data/$from_id/step.txt","none");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"سلام😃👋\n\n- به ربات ساز حرفه ای تلگرام خوش آمدید🌹\n- به راحتی برای خود یک ربات تلگرامی رایگان بسازید🎯\n- برای ساخت ربات جدید دکمه ساخت ربات را بزنید🤖\n🎗 @$chanell 🎗",
'parse_mode'=>'Html',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🎯ساخت ربات"],['text'=>"🎗ربات های من"],['text'=>"☢زیر مجموعه گیری"]],
[['text'=>"📋راهنما"],['text'=>"🗑حذف ربات"]],
[['text'=>"🔰قوانین"],['text'=>"📕راهنما بات فادر"],['text'=>"📩پیشنهاد جدید"]],
[['text'=>"🎁کد هدیه"],['text'=>"📬پشتیبانی"]],
[['text'=>" 📢کانال ما"],['text'=>"📜ارسال نظر"],['text'=>"👤مشخصات من"]],
],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
elseif ($textmessage == 'آمار📋' && $from_id == $admin){
$number = count(scandir("bots"))-1;
$uvis = file_get_contents('data/vips.txt');
	$usercount = 1;
	$fp = fopen( "data/users.txt", 'r');
	while( !feof( $fp)) {
    		fgets( $fp);
    		$usercount ++;
	}
$avis = -1;
	$fp = fopen( "data/vips.txt", 'r');
	while( !feof( $fp)) {
    		fgets( $fp);
    		$avis ++;
	}
	fclose( $fp);
	SendMessage($chat_id,"آمار دقیق ربات در همین ساعت ⏰\n--------------------------------\n📋تعداد اعضای ربات : $usercount\n\n🤖تعداد رباتها : $number\n\n🏆تعداد اعضای ویژه : $avis\n--------------------------------\n🏆آیدی های ویژه :\n$uvis");
	}
elseif($textmessage == '📜ارسال نظر')
{
save("data/$from_id/step.txt","feedback");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"نظر خود را ارسال کنید : ",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🔙 برگشت"]]],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
elseif ($step == 'feedback')
{
save("data/$from_id/step.txt","none");
$feed = $textmessage;
SendMessage($admin,"یک نظر جدید📜\n\n-کاربر `$from_id`🍿\n\n-آیدی `@$username`🎨\n\n`📋متن نظر : $textmessage`");
SendMessage($chat_id,"ارسال شد.");
}
elseif ($step == 'create bot11')
{$token = $textmessage;
$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));

function objectToArrays( $object )
{if( !is_object( $object ) && !is_array( $object ) )
{return $object;}
if( is_object( $object ) )
{$object = get_object_vars( $object );}
return array_map( "objectToArrays", $object );
}

$resultb = objectToArrays($userbot);
$un = $resultb["result"]["username"];
$ok = $resultb["ok"];
if($ok != 100)
{SendMessage($chat_id,"❗️توکن نامعتبر❗️");}
else
save("data/$from_id/tedad.txt","1");
save("data/$from_id/bots.txt","$un");
{SendMessage($chat_id,"🚩در حال ساخت ربات 🚩");
if (file_exists("bots/$un/index.php"))
{$source = file_get_contents("bot/index10.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
$source = str_replace("[*ADMIN*]",$from_id,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"ربات شما با موفقیت ساخته شد✅",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🔙 برگشت"]]
],
'resize_keyboard'=>true
                            ])
                               ]
        )
    );
}
else
{
mkdir("bots/$un");
$source = file_get_contents("bot/index10.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
$source = str_replace("[*ADMIN*]",$from_id,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"ربات شما با موفقیت ساخته شد✅",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"@".$un,'url'=>"https://telegram.me/".$un]]]
                            ])
                               ]
        )
    );
}
}
}
elseif ($step == 'create bot37')
{$token = $textmessage;
$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));

function objectToArrays( $object )
{if( !is_object( $object ) && !is_array( $object ) )
{return $object;}
if( is_object( $object ) )
{$object = get_object_vars( $object );}
return array_map( "objectToArrays", $object );
}

$resultb = objectToArrays($userbot);
$un = $resultb["result"]["username"];
$ok = $resultb["ok"];
if($ok != 100)
{SendMessage($chat_id,"❗️توکن نامعتبر❗️");}
else
save("data/$from_id/tedad.txt","1");
save("data/$from_id/bots.txt","$un");
{SendMessage($chat_id,"🚩در حال ساخت ربات 🚩");
if (file_exists("bots/$un/index.php"))
{$source = file_get_contents("bot/index37.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
$source = str_replace("[*ADMIN*]",$from_id,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"ربات شما با موفقیت ساخته شد✅",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🔙 برگشت"]]
],
'resize_keyboard'=>true
])
]));
}
else
{
mkdir("bots/$un");
$source = file_get_contents("bot/index37.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
$source = str_replace("[*ADMIN*]",$from_id,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"ربات شما با موفقیت ساخته شد✅",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"@".$un,'url'=>"https://telegram.me/".$un]]]
])
]));
}
}
}
elseif ($step == 'create bot38')
{$token = $textmessage;
$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));

function objectToArrays( $object )
{if( !is_object( $object ) && !is_array( $object ) )
{return $object;}
if( is_object( $object ) )
{$object = get_object_vars( $object );}
return array_map( "objectToArrays", $object );
}

$resultb = objectToArrays($userbot);
$un = $resultb["result"]["username"];
$ok = $resultb["ok"];
if($ok != 100)
{SendMessage($chat_id,"❗️توکن نامعتبر❗️");}
else
save("data/$from_id/tedad.txt","1");
save("data/$from_id/bots.txt","$un");
{SendMessage($chat_id,"🚩در حال ساخت ربات 🚩");
if (file_exists("bots/$un/index.php"))
{$source = file_get_contents("bot/index38.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
$source = str_replace("[*ADMIN*]",$from_id,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"ربات شما با موفقیت ساخته شد✅",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[
[['text'=>"🔙 برگشت"]]
],
'resize_keyboard'=>true
])
]));
}
else
{
mkdir("bots/$un");
$source = file_get_contents("bot/index38.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
$source = str_replace("[*ADMIN*]",$from_id,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"ربات شما با موفقیت ساخته شد✅",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['inline_keyboard'=>
[[['text'=>"@".$un,'url'=>"https://telegram.me/".$un]]]
])
]));
}
}
}
elseif ($step == 'create bot10')
{$token = $textmessage;
$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));

function objectToArrays( $object )
{if( !is_object( $object ) && !is_array( $object ) )
{return $object;}
if( is_object( $object ) )
{$object = get_object_vars( $object );}
return array_map( "objectToArrays", $object );
}

$resultb = objectToArrays($userbot);
$un = $resultb["result"]["username"];
$ok = $resultb["ok"];
if($ok != 100)
{SendMessage($chat_id,"❗️توکن نامعتبر❗️");}
else
save("data/$from_id/tedad.txt","1");
save("data/$from_id/bots.txt","$un");
{SendMessage($chat_id,"🚩در حال ساخت ربات 🚩");
if (file_exists("bots/$un/index.php"))
{$source = file_get_contents("bot/index9.php");
$source = str_replace("[*BOTTOKEN*]",$token,$source);
$source = str_replace("[*ADMIN*]",$from_id,$source);
save("bots/$un/index.php",$source); 
file_get_contents("http://api.telegram.org/bot".$token."/setwebhook?url=$host_folder/bots/$un/index.php");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"ربات شما با موفقیت ساخته شد✅",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard
