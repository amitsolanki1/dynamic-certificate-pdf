<?php
session_start();
if(isset($_POST['submit'])){
  

    $name= ucfirst($_POST['name']);
    $course=ucfirst($_POST['course']);
    $start_date=$_POST['start_date'];
    if(!empty($name) && !empty($start_date) && !empty($course))
    {
        require("fpdf.php");
        header("content-type:image/jpeg");
        $font="F:/xampp/htdocs/certificate/AGENCYR.TTF";
        $image= imagecreatefrompng("certificate.png");
        $color=imagecolorallocate($image,255,0,0);
            $img=imagettftext($image,30,0,200,380,$color,$font,$name);
            $image= imagecreatefrompng("certificate.png");
    
            if ($img[2]>600 && $img[2]<1000){
                imagettftext($image,20,0,50,370,$color,$font,$name);
            }
            else if ($img[2]>500 && $img[2]<900){
                imagettftext($image,30,0,50,380,$color,$font,$name);
            }
            else if($img[2]<500){
                imagettftext($image,30,0,200,380,$color,$font,$name);
            }
            $ref_number="RF/".date('Y/m/d').time();
            imagettftext($image,15,0,250,275,$color,$font,$ref_number);
    
            imagettftext($image,20,0,150,425,$color,$font,$course);
    
            $start_date=$start_date." To  ".date('Y-m-d');
            imagettftext($image,15,0,180,455,$color,$font,$start_date);
            $filename="media/certificate-".time()."-".$name.".jpg";
            imagejpeg($image,$filename);
            imagedestroy($image);

            // generate pdf
            $pdf=new FPDF();
            $pdf->AddPage('L','A5');
            $pdf->Image($filename,0,0,210,148,);
            ob_end_clean();
            $pdf->Output();
            unlink($filename);

            $_SESSION['filename']=$filename;
            header("Location:index.php");
            die();     
    }
    else{
        $_SESSION['error']="Please provide all fields";
        header("Location:index.php");
        die();
    }
}
?>