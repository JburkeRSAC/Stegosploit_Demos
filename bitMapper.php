<?php
function RGBToHex($r, $g, $b) {
	$hex = "#";
	$hex.= str_pad(dechex($r), 2, "0", STR_PAD_LEFT);
	$hex.= str_pad(dechex($g), 2, "0", STR_PAD_LEFT);
	$hex.= str_pad(dechex($b), 2, "0", STR_PAD_LEFT);
	return $hex;
}
$src    = $argv[1];
$im     = imagecreatefromjpeg($src);
$size   = getimagesize($src);
$width  = $size[0];
$height = $size[1];
$img0 = imagecreatetruecolor($width,$height); 
$img1 = imagecreatetruecolor($width,$height);
$img2 = imagecreatetruecolor($width,$height);
$img3 = imagecreatetruecolor($width,$height);
$img4 = imagecreatetruecolor($width,$height);
$img5 = imagecreatetruecolor($width,$height);
$img6 = imagecreatetruecolor($width,$height);
$img7 = imagecreatetruecolor($width,$height);
$z = 1;
//Fill all pixels white?
#imagefill($img0, 0, 0, 0xFF);
for($x=0;$x<$width;$x++){
	for($y=0;$y<$height;$y++){
		//Bit Layer 0  = LSB[7], Bit Layer 7 = MSB[0]
		$rgb = imagecolorat($im, $x, $y);
		$r = ($rgb >> 16) & 0xFF;
		$g = ($rgb >> 8) & 0xFF;
		$b = $rgb & 0xFF;
		#var_dump($r, $g, $b);
		$hexval = RGBToHex($r, $g, $b);
		#echo $hexval."\n";
		//convert RGB to binary
		$bin_r = sprintf("%08d", decbin($r));
		#echo $bin_r."<BR>";
		//Get Bit Layers...
		//get LSB
		//if we went red lsb key based we would start here... detect op_mode?
		$r_bit_layer0 = $bin_r[7];
		//Can select individual layers here:
		#$red = imagecolorallocate($img,$r,0,0);
		#$green = imagecolorallocate($img,0,$g,0);
		#$blue = imagecolorallocate($img,0,0,$b);
		$color = imagecolorallocate($img0,$r,$g,$b);
		#imagesetpixel($img,$x,$y,$color);
		#echo $z."<BR>";
		$z++;
		//in between bits...
		$r_bit_layer1 = $bin_r[6];
		$r_bit_layer2 = $bin_r[5];
		$r_bit_layer3 = $bin_r[4];
		$r_bit_layer4 = $bin_r[3];
		$r_bit_layer5 = $bin_r[2];
		$r_bit_layer6 = $bin_r[1];
		//get MSB
		$r_bit_layer7 = $bin_r[0];
		if($r_bit_layer0 == 1){
			imagesetpixel($img0,$x,$y,$color);
			#echo "$x,$y,$r,$color\n";
		}
		if($r_bit_layer1 == 1){
			imagesetpixel($img1,$x,$y,$color);
			#echo "$x,$y,$r,$color\n";
		}
		if($r_bit_layer2 == 1){
			imagesetpixel($img2,$x,$y,$color);
			#echo "$x,$y,$r,$color\n";
		}
		if($r_bit_layer3 == 1){
			imagesetpixel($img3,$x,$y,$color);
			#echo "$x,$y,$r,$color\n";
		}
		if($r_bit_layer4 == 1){
			imagesetpixel($img4,$x,$y,$color);
			#echo "$x,$y,$r,$color\n";
		}
		if($r_bit_layer5 == 1){
			imagesetpixel($img5,$x,$y,$color);
			#echo "$x,$y,$r,$color\n";
		}
		if($r_bit_layer6 == 1){
			imagesetpixel($img6,$x,$y,$color);
			#echo "$x,$y,$r,$color\n";
		}
		if($r_bit_layer7 == 1){
			imagesetpixel($img7,$x,$y,$color);
		}
		#echo $r."<BR>";
		#echo "DEBUG".$r_bit_layer6."\n";
		#echo "\t $bin_r \n";
		$bin_g = sprintf("%08d", decbin($g));
		$g_bit_layer0 = $bin_g[7];
		$g_bit_layer1 = $bin_g[6];
		$g_bit_layer2 = $bin_g[5];
		$g_bit_layer3 = $bin_g[4];
		$g_bin_layer4 = $bin_g[3];
		$g_bin_layer5 = $bin_g[2];
		$g_bin_layer6 = $bin_g[1];
		$g_bit_layer7 = $bin_g[0];
		#echo $g."<BR>";
		#echo "\t $bin_g \n";
		$bin_b = sprintf("%08d", decbin($b));
		$b_bit_layer0 = $bin_b[7];
		$b_bit_layer1 = $bin_b[6];
		$b_bit_layer2 = $bin_b[5];
		$b_bit_layer3 = $bin_b[4];
		$b_bit_layer4 = $bin_b[3];
		$b_bit_layer5 = $bin_b[2];
		$b_bit_layer6 = $bin_b[1];
		$b_bit_layer7 = $bin_b[0];
		#echo $b."<BR>";
		#echo "\t $bin_b \n";
		#echo "\n\n";
	}
}
imagejpeg($img0, 'RESULTS/bitlayer0_LSB.jpg');
imagedestroy($img0);
imagejpeg($img1, 'RESULTS/bitlayer1.jpg');
imagedestroy($img1);
imagejpeg($img2, 'RESULTS/bitlayer2.jpg');
imagedestroy($img2);
imagejpeg($img3, 'RESULTS/bitlayer3.jpg');
imagedestroy($img3);
imagejpeg($img4, 'RESULTS/bitlayer4.jpg');
imagedestroy($img4);
imagejpeg($img5, 'RESULTS/bitlayer5.jpg');
imagedestroy($img5);
imagejpeg($img6, 'RESULTS/bitlayer6.jpg');
imagedestroy($img6);
imagejpeg($img7, 'RESULTS/bitlayer7_msb.jpg');
imagedestroy($img7);
