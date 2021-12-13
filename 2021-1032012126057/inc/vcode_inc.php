<?php 
function vcode($width=120,$height=40){
    header('Content-type:image/jpeg');
    $element=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','2','3','4','5','6','7','8','9');
    $string='';
    for($i=0;$i<4;$i++){
        $string.=$element[rand(0,count($element)-1)];
    }
    $img=imagecreatetruecolor($width,$height);
    $backgroung=imagecolorallocate($img,rand(200,255),rand(200,255),rand(200,255));
    $border=imagecolorallocate($img,0,0,0);
    $stringcolor=imagecolorallocate($img,rand(10,100),rand(10,100),rand(10,100));
    imagefill($img,0,0,$backgroung);
    for($i=0;$i<30;$i++){
        imagesetpixel($img,rand(0,$width-1),rand(0,$height-1),imagecolorallocate($img,rand(50,100),rand(50,100),rand(50,100)));
    }
    for($i=0;$i<5;$i++){
        imageline($img,rand(0,$width/2),rand(0,$height), rand($width/2,$width),rand(0,$height-1),imagecolorallocate($img,rand(20,255),rand(20,255),rand(20,255)));
    }
    imagettftext($img,20,rand(0,10),rand(10,40),rand(30,40),$stringcolor,'/wampserver/www/moral/font/African.TTF',$string);
    imagejpeg($img);
    imagedestroy($img);
    return $string;
}


?>