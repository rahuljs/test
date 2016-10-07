<?php 
ini_set('display_errors', '0');

require_once "include/recaptchalib.php";

  // your secret key
$secret = "6Ldglg8TAAAAAFdrr3HM6QKUL7qdAlJV3lU5tbBS";

  // empty response
$response = null;

  // check secret key
$reCaptcha = new ReCaptcha($secret);
if ($_POST["g-recaptcha-response"]) {
  $response = $reCaptcha->verifyResponse(
    $_SERVER["REMOTE_ADDR"],
    $_POST["g-recaptcha-response"]
    );
}
if ($response != null && $response->success) {
  require("include/config.php");

  $filetosend= SITE_URL.'vh_fees/';

  $name = $_REQUEST['name']; 

  $email = $_REQUEST['email'];

  $phone = $_REQUEST['std'].$_REQUEST['phone'];

  $selectschool=$_REQUEST["selectschool"]; 

  $message1=$_REQUEST['message'];

  $lanphone=$_REQUEST['lanphone'];

  $class=$_REQUEST['class'];

  $chyes=$_REQUEST['chyes'];

  $chno=$_REQUEST['chno'];

  $enquiryfrom=$_REQUEST['enquiryfrom'];
  $GCLID=$_REQUEST['gclid_field'];


  ?>

  <?php
  if($name && $email && $phone && $selectschool){

   if(!empty($_REQUEST['year']))
   {
    $year=$_REQUEST['year'];
  }else
  {
    $year='null';
  }

  $subscribe;
  if(!empty($_REQUEST['Subscribe']))
  {
    $subscribe=$_REQUEST['Subscribe'];
  }else
  {$subscribe='No';}


  $link = dbLink();

  $today = date("Y-m-d H:i:s");

  $insert = "insert into dbadmission (academicyear,schoolname,fullname,email,landlineno,mobileno,ClassToBeAdmitted,specialchild,message,enquiryfrom,GCLID,CreatedDateTime) values('".$year."','".$selectschool."', '".$name."', '".$email."', '".$lanphone."', '".$phone."','".$class."', '','".$message1."', '".$enquiryfrom."','".$GCLID."','".$today ."')";


  $result = executeInsert($insert, $link); 




  $query = "select * from dbadmission";

  $results = mysql_query($query);

  include 'include/push.php'; 



   /* $filename =  'file-'. date("Y-m-d-H-i-s").'-'.rand(1, 25).'-'.rand(1, 25).'.csv';

    $handle =  fopen('tmp//'.$filename, 'w+');  

    fputcsv($handle, array('id','schoolname','fullname','email','landlineno','mobileno','ClassToBeAdmitted','specialchild','message','enquiryfrom','CreatedDateTime'));

    while($row = mysql_fetch_array($results))

    {fputcsv($handle, array($row['id'], $row['schoolname'], $row['fullname'],$row['email'],$row['landlineno'],$row['mobileno'],$row['ClassToBeAdmitted'],$row['specialchild'],$row['message'],$row['enquiryfrom'],$row['CreatedDateTime']));

    }

     fclose($handle);

     $file= $filename;*/

     $subject= "Admission Inquiry";

     $message= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">

     <html xmlns='http://www.w3.org/1999/xhtml'>

     <head>

     <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />

     </head>

     <body>

     <style>

     body { font-family: Calibri, Arial, Helvetica, sans-serif; font-size: 12pt; }

     h2 { color: rgb(79,97,40); margin: 1em 0 0 0; padding: 0; font-size: 18pt; }

     hr { height: 3px; border: 0; background: #ccc; margin-top: 3em; }

     table { margin: 0; border: 0; border-collapse:collapse; border-spacing:0;}

     table td { padding: 0.5em 1em; border-bottom: 1px solid rgb(155, 187, 89); }

     table td.response { text-align: right; }

     

     .gray { color: #808080; }

     .gray-bg { background: #e6eed6; }

     </style>

     <table align='center' width='100%' cellpadding='0' cellspacing='0'>

     <tr>

     <td>

     <table align='left' width='100%' cellpadding='4' cellspacing='4'>  ";

     

     if(isset($selectschool) ==TRUE|| $selectschool!='')

     {

      $message=$message."<tr>

      <td class='hed' align='left' width='20%'>

      School Name :

      </td>

      <td align='left' width='80%'>

      $selectschool

      </td>

      </tr> ";

    }

    

    if(isset($name) ==TRUE|| $name!='')

    {

     $message=$message."<tr>

     <td class='hed' align='left' width='20%'>

     Name :

     </td>

     <td align='left' width='80%'>

     $name

     </td>

     </tr> ";

   }

   

   

   if(isset($lanphone) ==TRUE|| $lanphone!='')

   {

     $message=$message."<tr>

     <td class='hed' align='left' width='20%'>

     Landline Number :

     </td>

     <td align='left' width='80%'>

     $lanphone

     </td>

     </tr>  ";

   }

   

   if(isset($class) ==TRUE|| $class!='')

   {

     $message=$message."<tr>

     <td class='hed' align='left' width='20%'>

     Grade :

     </td>

     <td align='left' width='80%'>

     $class

     </td>

     </tr>   ";

   }

   

   if(isset($phone) ==TRUE|| $phone!='')

   {

     $message=$message."<tr>

     <td class='hed' align='left'width='20%'>

     Mobile Number:

     </td>

     <td align='left' width='80%'>

     $phone

     </td>

     </tr>   ";

   }

   

   

   if(isset($email) ==TRUE|| $email!='')

   {

     $message=$message."<tr>

     <td class='hed' align='left'width='20%'>

     Email Id:

     </td>

     <td align='left' width='80%'>

     $email

     </td>

     </tr>   ";

   }

   

   if(isset($message1) ==TRUE|| $message1!='')

   {

     $message=$message."<tr>

     <td class='hed' align='left'width='20%'>

     Message:

     </td>

     <td align='left' width='80%'>

     $message1

     </td>

     </tr> ";

   }

   

   if(isset($enquiryfrom) ==TRUE|| $enquiryfrom!='')

   {

     $message=$message." <tr>

     <td class='hed' align='left'width='20%'>

     Enquiry From:

     </td>

     <td align='left' width='80%'>

     $enquiryfrom

     </td>

     </tr>   ";

   }

   

   $message=$message."</table> </td></tr> </table></body></html>"; 

   

    //<tr><td class='hed' align='left'width='20%'>Special Need Child:</td><td align='left' width='80%'>$chyes $chno</td></tr>

   $usersubject= "Enquiry At ".$selectschool;

   $usermessage= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">

   <html xmlns='http://www.w3.org/1999/xhtml'>

   <head>

   <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />

   </head>

   <body>

   <style>

   body { font-family: Calibri, Arial, Helvetica, sans-serif; font-size: 12pt; }

   h2 { color: rgb(79,97,40); margin: 1em 0 0 0; padding: 0; font-size: 18pt; }

   hr { height: 3px; border: 0; background: #ccc; margin-top: 3em; }

   table { margin: 0; border: 0; border-collapse:collapse; border-spacing:0;}

   table td { padding: 0.5em 1em; border-bottom: 1px solid rgb(155, 187, 89); }

   table td.response { text-align: right; }

   

   .gray { color: #808080; }

   .gray-bg { background: #e6eed6; }

   </style>

   <table align='center' width='100%' cellpadding='0' cellspacing='0'>

   <tr>

   <td>

   <table align='left' width='100%' cellpadding='4' cellspacing='4'> " ;

   

   if(isset($selectschool) ==TRUE|| $selectschool!='')

   {

    $usermessage=$usermessage."<tr>

    <td class='hed' align='left' width='20%'>

    School Name :

    </td>

    <td align='left' width='80%'>

    $selectschool

    </td>

    </tr> ";

  }

  

  if(isset($name) ==TRUE|| $name!='')

  {

   $usermessage=$usermessage."<tr>

   <td class='hed' align='left' width='20%'>

   Name :

   </td>

   <td align='left' width='80%'>

   $name

   </td>

   </tr> ";

 }

 

 

 if(isset($lanphone) ==TRUE|| $lanphone!='')

 {

   $usermessage=$usermessage."<tr>

   <td class='hed' align='left' width='20%'>

   Landline Number :

   </td>

   <td align='left' width='80%'>

   $lanphone

   </td>

   </tr>  ";

 }

 

 if(isset($class) ==TRUE|| $class!='')

 {

   $usermessage=$usermessage."<tr>

   <td class='hed' align='left' width='20%'>

   Grade :

   </td>

   <td align='left' width='80%'>

   $class

   </td>

   </tr>   ";

 }

 

 if(isset($phone) ==TRUE|| $phone!='')

 {

   $usermessage=$usermessage."<tr>

   <td class='hed' align='left'width='20%'>

   Mobile Number:

   </td>

   <td align='left' width='80%'>

   $phone

   </td>

   </tr>   ";

 }

 

 

 if(isset($email) ==TRUE|| $email!='')

 {

   $usermessage=$usermessage."<tr>

   <td class='hed' align='left'width='20%'>

   Email Id:

   </td>

   <td align='left' width='80%'>

   $email

   </td>

   </tr>   ";

 }

 

 if(isset($message1) ==TRUE|| $message1!='')

 {

   $usermessage=$usermessage."<tr>

   <td class='hed' align='left'width='20%'>

   Message:

   </td>

   <td align='left' width='80%'>

   $message1

   </td>

   </tr> ";

 }

 $usermessage=$usermessage. "</table></td></tr></table></body></html>";

 if($selectschool=="Mum - Goregaon"){

   $to = "helpdesk.vh10103@vibgyorhigh.com";

                          //$to = "shrutika@crystal-logic.com,Prabhat001@gmail.com";

   $headers = 'MIME-Version: 1.0' . "\r\n";

   $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

   $headers .= "From: Mumbai Goregaon West<helpdesk.vh10103@vibgyorhigh.com>" . "\r\n"; 

   $headers .= 'Bcc: helpdesk.vh@gmail.com,smashmit@gmail.com' . "\r\n";

   

   if($enquiryfrom=="admission-form"){

    $filetosend1='VH_GOREGAON_ICSE_FEES_2015-16.pdf';

    $filetosend1= $filetosend. $filetosend1;

    $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ( Mumbai - Goregaon West)</a>';

    $filetosend1='VH_GOREGAON_(IGCSE & A level)_2015-16.pdf';

    $filetosend1= $filetosend. $filetosend1;

    $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Fees Structure for IGCSE & A level (Mumbai - Goregaon West)</a>';


    $filetosend2='VH_GOREGAON_CIE_FEES_2015-16.pdf';

    $filetosend2= $filetosend. $filetosend2;

    $message=$message.'<br/><a href="'.$filetosend2.'" target="_blank" >Fees Structure for CIE ( Mumbai - Goregaon West)</a>';

    
    
  }


  $mail = mail($to, $subject, $message, $headers);
  $headers1 = 'MIME-Version: 1.0' . "\r\n";

  $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  $headers1 .= "From:Mumbai Goregaon<helpdesk.vh10103@vibgyorhigh.com>" . "\r\n"; 

  if($enquiryfrom=="admission-form"){

    $filetosend1='VH_GOREGAON_ICSE_FEES_2015-16.pdf';

    $filetosend1= $filetosend. $filetosend1;

    $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

    $filetosend1='VH_GOREGAON_(IGCSE & A level)_2015-16.pdf';

    $filetosend1= $filetosend. $filetosend1;

    $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Fees Structure for IGCSE & A level   ('.$selectschool.')</a>'; 
    
    

    $filetosend2='VH_GOREGAON_CIE_FEES_2015-16.pdf';

    $filetosend2= $filetosend. $filetosend2;

    $usermessage=$usermessage.'<br/><a href="'.$filetosend2.'" target="_blank" >Fees Structure for CIE ( Mumbai - Goregaon West)</a>';
    
  }
  
  $mail1 = mail($email, $usersubject, $usermessage, $headers1);

} elseif($selectschool=="Mum - Malad"){

  $to = "helpdesk.vh10107@vibgyorhigh.com";

                           //$to = "shrutika@crystal-logic.com,Prabhat001@gmail.com"; 

  $headers = 'MIME-Version: 1.0' . "\r\n";

  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  $headers .= "From: Mumbai Malad East<helpdesk.vh10107@vibgyorhigh.com>" . "\r\n"; 

  $headers .= 'Bcc: helpdesk.vh@gmail.com,smashmit@gmail.com' . "\r\n";

  if($enquiryfrom=="admission-form"){

    $filetosend1='VH_MALAD_FEES_2015-16.pdf';

    $filetosend1= $filetosend. $filetosend1;

    
    $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

  }

  $mail = mail($to, $subject, $message, $headers);

  $headers1 = 'MIME-Version: 1.0' . "\r\n";

  $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  $headers1 .= "From: Mumbai Malad East<helpdesk.vh10107@vibgyorhigh.com>" . "\r\n"; 

  if($enquiryfrom=="admission-form"){

    $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

  }

  $mail1 = mail($email, $usersubject, $usermessage, $headers1);

  

}elseif($selectschool=="Mum - Airoli"){

 $to = "helpdesk.vh10108@vibgyorhigh.com";

                            // $to = "shrutika@crystal-logic.com,Prabhat001@gmail.com";

 $headers = 'MIME-Version: 1.0' . "\r\n";

 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

 $headers .= "From: Navi Mumbai Airoli<helpdesk.vh10108@vibgyorhigh.com>" . "\r\n";

 $headers .= 'Bcc: helpdesk.vh@gmail.com,smashmit@gmail.com' . "\r\n"; 

 if($enquiryfrom=="admission-form"){

   $filetosend1='VH_AIROLI_FEES_2015-16.pdf';

   $filetosend1= $filetosend. $filetosend1;

   $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

 }

 $mail = mail($to, $subject, $message, $headers);

 

 $headers1 = 'MIME-Version: 1.0' . "\r\n";

 $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

 $headers1 .= "From: Navi Mumbai Airoli<helpdesk.vh10108@vibgyorhigh.com>" . "\r\n"; 

 if($enquiryfrom=="admission-form"){        
  $filetosend1='VH_AIROLI_FEES_2015-16.pdf';
  $filetosend1= $filetosend. $filetosend1;

  $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

}

$mail1 = mail($email, $usersubject, $usermessage, $headers1);



}elseif($selectschool=="Mum - Borivali"){

 $to = "helpdesk.vh10112@vibgyorhigh.com";

 $headers = 'MIME-Version: 1.0' . "\r\n";

 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

 $headers .= "From: Mumbai Borivali<helpdesk.vh10112@vibgyorhigh.com>" . "\r\n";

 $headers .= 'Bcc: helpdesk.vh@gmail.com,smashmit@gmail.com' . "\r\n"; 

 if($enquiryfrom=="admission-form"){

   $filetosend1='VH_IC-Colony_2015-16.pdf';

   $filetosend1= $filetosend. $filetosend1;

   $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

 }

 $mail = mail($to, $subject, $message, $headers);

 

 $headers1 = 'MIME-Version: 1.0' . "\r\n";

 $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

 $headers1 .= "From: Mumbai Borivali<helpdesk.vh10112@vibgyorhigh.com>" . "\r\n"; 

 if($enquiryfrom=="admission-form"){

   $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

 }

 $mail1 = mail($email, $usersubject, $usermessage, $headers1);

}elseif($selectschool=="Pun - NIBM"){

  $to = "helpdesk.vh10202@vibgyorhigh.com";

          // $to = "shrutika@crystal-logic.com,Prabhat001@gmail.com";

  $headers = 'MIME-Version: 1.0' . "\r\n";

  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  $headers .= "From: Pune NIBM Road<helpdesk.vh10202@vibgyorhigh.com>" . "\r\n";

  $headers .= 'Bcc: helpdesk.vh@gmail.com,smashmit@gmail.com' . "\r\n"; 

  

  if($enquiryfrom=="admission-form"){

   $filetosend1='VH_NIBM_2015-16.pdf';

   $filetosend1= $filetosend. $filetosend1;

   $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

   $filetosend1='VH_NIBM_CIE_FEES_2015-16.pdf';

   $filetosend1= $filetosend. $filetosend1;

   $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Fees Structure for CIE Level ('.$selectschool.')</a>';

   $filetosend2='VH_NIBM_(IGCSE_& A_level)_2015-16.pdf';

   $filetosend2= $filetosend. $filetosend2;

   $message=$message.'<br/><a href="'.$filetosend2.'" target="_blank" >Fees Structure for IGCSE & A LEVEL</a>';


 }
 

 $mail = mail($to, $subject, $message, $headers);
 

 $headers1 = 'MIME-Version: 1.0' . "\r\n";

 $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

 $headers1 .= "From: Pune NIBM Road<helpdesk.vh10202@vibgyorhigh.com>" . "\r\n"; 

 

 if($enquiryfrom=="admission-form"){

  $filetosend1='VH_NIBM_2015-16.pdf';

  $filetosend1= $filetosend. $filetosend1;

  $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

  

  $filetosend1='VH_NIBM_CIE_FEES_2015-16.pdf';

  $filetosend1= $filetosend. $filetosend1;

  $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Fees Structure for CIE ('.$selectschool.')</a>';

  
  $filetosend2='VH_NIBM_(IGCSE_& A_level)_2015-16.pdf';

  $filetosend2= $filetosend. $filetosend2;

  $usermessage=$usermessage.'<br/><a href="'.$filetosend2.'" target="_blank" >Fees Structure for IGCSE & A LEVEL</a>';


}



$mail1 = mail($email, $usersubject, $usermessage, $headers1);



}elseif($selectschool=="Pun - Balewadi"){

  $to = "helpdesk.vh10206@vibgyorhigh.com";

           //$to = "shrutika@crystal-logic.com,Prabhat001@gmail.com";

  $headers = 'MIME-Version: 1.0' . "\r\n";

  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  $headers .= "From: Pune Balewadi<helpdesk.vh10206@vibgyorhigh.com>" . "\r\n";

  $headers .= 'Bcc: helpdesk.vh@gmail.com,smashmit@gmail.com' . "\r\n";

  

  if($enquiryfrom=="admission-form"){

   

    $filetosend1='VH_BALEWADI_FEES_2015-16.pdf';

    $filetosend1= $filetosend. $filetosend1;

    $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

  }

  

  $mail = mail($to, $subject, $message, $headers);

  

  $headers1 = 'MIME-Version: 1.0' . "\r\n";

  $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  $headers1 .= "From: Pune Balewadi<helpdesk.vh10206@vibgyorhigh.com>" . "\r\n"; 

  if($enquiryfrom=="admission-form"){

    $filetosend1='VH_BALEWADI_FEES_2015-16.pdf';

    $filetosend1= $filetosend. $filetosend1;

    $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

  }

  $mail1 = mail($email, $usersubject, $usermessage, $headers1);

}elseif($selectschool=="Pun - Magarpatta"){

  $to = "helpdesk.vh10207@vibgyorhigh.com";

           //$to = "shrutika@crystal-logic.com,Prabhat001@gmail.com";

  $headers = 'MIME-Version: 1.0' . "\r\n";

  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  $headers .= "From: Pune MagarpattaCity<helpdesk.vh10207@vibgyorhigh.com>" . "\r\n";

  $headers .= 'Bcc: helpdesk.vh@gmail.com,smashmit@gmail.com' . "\r\n";

  if($enquiryfrom=="admission-form"){

    $filetosend1='VH_MAGARPATTA_FEES_2015-16.pdf';

    $filetosend1= $filetosend. $filetosend1;

    

    $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

  }

  $mail = mail($to, $subject, $message, $headers);

  

  $headers1 = 'MIME-Version: 1.0' . "\r\n";

  $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  $headers1 .= "From: Pune MagarpattaCity<helpdesk.vh10207@vibgyorhigh.com>" . "\r\n"; 

  if($enquiryfrom=="admission-form"){

    $filetosend1='VH_MAGARPATTA_FEES_2015-16.pdf';

    $filetosend1= $filetosend. $filetosend1;

    $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

  }

  $mail1 = mail($email, $usersubject, $usermessage, $headers1);

}elseif($selectschool=="Vadodara"){

  $to = "helpdesk.vadodara30@vibgyorhigh.com";

            //$to = "shrutika@crystal-logic.com,Prabhat001@gmail.com";

  $headers = 'MIME-Version: 1.0' . "\r\n";

  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  $headers .= "From: Vadodara PadraRoad<helpdesk.vadodara30@vibgyorhigh.com>" . "\r\n";

  $headers .= 'Bcc: helpdesk.vh@gmail.com,smashmit@gmail.com' . "\r\n";

  if($enquiryfrom=="admission-form"){

   

    $filetosend1='VH_VADODARA_FEES_2015-16.pdf';

    $filetosend1= $filetosend. $filetosend1;

    $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

    $filetosend1='VH_VADODARA_FEES_2015-16_CIE.pdf';

    $filetosend1= $filetosend. $filetosend1;

    

    $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >CIE Admission Procedure & Fees Structure ('.$selectschool.')</a>';

    

    $filetosend1='VH_Vadodara _15_16(IGCSE & A level).pdf';

    $filetosend1= $filetosend. $filetosend1;

    $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Fees Structure for A Level ('.$selectschool.')</a>';

  }

  

  $mail = mail($to, $subject, $message, $headers);

  

  $headers1 = 'MIME-Version: 1.0' . "\r\n";

  $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  $headers1 .= "From: Vadodara PadraRoad<helpdesk.vadodara30@vibgyorhigh.com>" . "\r\n"; 

  if($enquiryfrom=="admission-form"){

   

   

    $filetosend1='VH_VADODARA_FEES_2015-16.pdf';

    $filetosend1= $filetosend. $filetosend1;

    

    $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

    $filetosend1='VH_VADODARA_FEES_2015-16_CIE.pdf';

    $filetosend1= $filetosend. $filetosend1;

    

    $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

    $filetosend1='Vadodara VH_15_16(IGCSE & A level).pdf';

    $filetosend1= $filetosend. $filetosend1;

    $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Fees Structure for A Level ('.$selectschool.')</a>';

  }

  $mail1 = mail($email, $usersubject, $usermessage, $headers1);

  

}else /*if($selectschool=="Surat"){

                   $to = "helpdesk.vh10602@vibgyorhigh.com";

                           $headers = 'MIME-Version: 1.0' . "\r\n";

                  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                           $headers .= "From: Surat<helpdesk.vh10602@vibgyorhigh.com>" . "\r\n";

                            $headers .= 'Bcc: helpdesk.vh@gmail.com,smashmit@gmail.com' . "\r\n"; 

              if($enquiryfrom=="admission-form"){

               $filetosend1='VHSURAT_Fees.pdf';

                $filetosend1= $filetosend. $filetosend1;

            $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

 }

             

                             $mail = mail($to, $subject, $message, $headers);

                            

                              $headers1 = 'MIME-Version: 1.0' . "\r\n";

                  $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                           $headers1 .= "From: Surat<helpdesk.vh10602@vibgyorhigh.com>" . "\r\n"; 

              if($enquiryfrom=="admission-form"){

                 $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';
         

             }

                   $mail1 = mail($email, $usersubject, $usermessage, $headers1);

 

                 }else */ if($selectschool=="Kolhapur"){

                  $to = "helpdesk.vh10404@vibgyorhigh.com";

            //$to = "shrutika@crystal-logic.com,Prabhat001@gmail.com";

                  $headers = 'MIME-Version: 1.0' . "\r\n";

                  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                  $headers .= "From: Kolhapur<helpdesk.vh10404@vibgyorhigh.com>" . "\r\n";

                  $headers .= 'Bcc: helpdesk.vh@gmail.com,smashmit@gmail.com' . "\r\n";

                  if($enquiryfrom=="admission-form"){

                    

                    $filetosend1='VH_KOLHAPUR_FEES_2015-16.pdf';

                    $filetosend1= $filetosend. $filetosend1;

                    $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

                  }

                  $mail = mail($to, $subject, $message, $headers);

                  

                  $headers1 = 'MIME-Version: 1.0' . "\r\n";

                  $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                  $headers1 .= "From: Kolhapur<helpdesk.vh10404@vibgyorhigh.com>" . "\r\n"; 

                  if($enquiryfrom=="admission-form"){

                   $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

                 }

                 $mail1 = mail($email, $usersubject, $usermessage, $headers1);

               }elseif($selectschool=="Lucknow"){

                $to = "helpdesk.vh10503@vibgyorhigh.com";

          //$to = "shrutika@crystal-logic.com,Prabhat001@gmail.com";

                $headers = 'MIME-Version: 1.0' . "\r\n";

                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                $headers .= "From: Lucknow<helpdesk.vh10503@vibgyorhigh.com>" . "\r\n"; 

                $headers .= 'Bcc: helpdesk.vh@gmail.com,smashmit@gmail.com' . "\r\n";

                if($enquiryfrom=="admission-form"){

                  $filetosend1='VH_LUCKNOW_FEES_2015-16.pdf';

                  $filetosend1= $filetosend. $filetosend1;

                  $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

                }

                $mail = mail($to, $subject, $message, $headers);

                

                $headers1 = 'MIME-Version: 1.0' . "\r\n";

                $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                $headers1 .= "From: Lucknow<helpdesk.vh10503@vibgyorhigh.com>" . "\r\n"; 

                if($enquiryfrom=="admission-form"){

                  $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

                }

                $mail1 = mail($email, $usersubject, $usermessage, $headers1);

              }elseif($selectschool=="Blr - Marathahalli"){

                $to = "helpdesk.vh15102@vibgyorhigh.com";

            //$to = "shrutika@crystal-logic.com,Prabhat001@gmail.com"; 

                $headers = 'MIME-Version: 1.0' . "\r\n";

                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                $headers .= "From: Bengaluru Marathahalli<helpdesk.vh15102@vibgyorhigh.com>" . "\r\n";

                $headers .= 'Bcc: helpdesk.vh@gmail.com,smashmit@gmail.com' . "\r\n";

                if($enquiryfrom=="admission-form"){

                 $filetosend1='VH_MARATHAHALLI_FEES_2015-16.pdf';

                 $filetosend1= $filetosend. $filetosend1;

                 $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure (Marathahalli)</a>';

                 $filetosend1='VH_MARATHAHALLI_CIE_FEES_2015-16.pdf';

                 $filetosend1= $filetosend. $filetosend1;

                 $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Fees Structure for CIE (Bangalore - Marathahalli)</a>';

               }
               

               

               $mail = mail($to, $subject, $message, $headers);

               

               $headers1 = 'MIME-Version: 1.0' . "\r\n";

               $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

               $headers1 .= "From: Bengaluru Marathahalli<helpdesk.vh15102@vibgyorhigh.com>" . "\r\n"; 

               if($enquiryfrom=="admission-form"){
                $filetosend1='VH_MARATHAHALLI_FEES_2015-16.pdf';
                $filetosend1= $filetosend. $filetosend1;
                $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

                
                $filetosend1='VH_MARATHAHALLI_CIE_FEES_2015-16.pdf';
                $filetosend1= $filetosend. $filetosend1;

                $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';
              }

              $mail1 = mail($email, $usersubject, $usermessage, $headers1);

            }elseif($selectschool=="Blr - Haralur Road"){

             $to = "helpdesk.vh15103@vibgyorhigh.com";

           //$to = "shrutika@crystal-logic.com,Prabhat001@gmail.com";

             $headers = 'MIME-Version: 1.0' . "\r\n";

             $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

             $headers .= "From: Bengaluru Haralur Road<helpdesk.vh15103@vibgyorhigh.com>" . "\r\n";

             $headers .= 'Bcc: helpdesk.vh@gmail.com,smashmit@gmail.com' . "\r\n";

             if($enquiryfrom=="admission-form"){

               $filetosend1='VH_HARALUR_FEES_2015-16.pdf';
               $filetosend1= $filetosend. $filetosend1;
               $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';
             }
             $mail = mail($to, $subject, $message, $headers);
             

             $headers1 = 'MIME-Version: 1.0' . "\r\n";

             $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

             $headers1 .= "From: Bengaluru Haralur Road<helpdesk.vh15103@vibgyorhigh.com>" . "\r\n"; 

             if($enquiryfrom=="admission-form"){

              $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

            }

            $mail1 = mail($email, $usersubject, $usermessage, $headers1);

          }elseif($selectschool=="Blr - Horamavu"){

           $to = "helpdesk.vh15107@vibgyorhigh.com";

          //$to = "shrutika@crystal-logic.com,Prabhat001@gmail.com";

           $headers = 'MIME-Version: 1.0' . "\r\n";

           $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

           $headers .= "From: Bengaluru-Horamavu<helpdesk.vh15107@vibgyorhigh.com>" . "\r\n";

           $headers .= 'Bcc: helpdesk.vh@gmail.com,smashmit@gmail.com' . "\r\n";

           if($enquiryfrom=="admission-form"){

             $filetosend1='VH_HORAMAVU_FEES_2015-16.pdf';

             $filetosend1= $filetosend. $filetosend1;

             $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

           }

           $mail = mail($to, $subject, $message, $headers);

           

           $headers1 = 'MIME-Version: 1.0' . "\r\n";

           $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

           $headers1 .= "From: Bengaluru Horamavu<helpdesk.vh15107@vibgyorhigh.com>" . "\r\n"; 

           if($enquiryfrom=="admission-form"){

            $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

          }

          $mail1 = mail($email, $usersubject, $usermessage, $headers1);

        }elseif($selectschool=="Blr - Electronic City"){

          $to = "helpdesk.vh15111@vibgyorhigh.com";

           //$to = "shrutika@crystal-logic.com,Prabhat001@gmail.com";

          $headers = 'MIME-Version: 1.0' . "\r\n";

          $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

          $headers .= "From: Bengaluru Electronic City<helpdesk.vh15111@vibgyorhigh.com>" . "\r\n";

          $headers .= 'Bcc: helpdesk.vh@gmail.com,smashmit@gmail.com' . "\r\n";

          if($enquiryfrom=="admission-form"){

           $filetosend1='VH_ELECTRONIC CITY_FEES_2015-16.pdf';

           $filetosend1= $filetosend. $filetosend1;

           $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

         }

         $mail = mail($to, $subject, $message, $headers);

         

         $headers1 = 'MIME-Version: 1.0' . "\r\n";

         $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

         $headers1 .= "From: Bengaluru Electronic City <helpdesk.vh15111@vibgyorhigh.com>" . "\r\n"; 

         if($enquiryfrom=="admission-form"){

           $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

         }

         $mail1 = mail($email, $usersubject, $usermessage, $headers1);

       }elseif($selectschool=="Blr - BTM Layout"){

         $to = "helpdesk.vh15112@vibgyorhigh.com";

           //$to = "shrutika@crystal-logic.com,Prabhat001@gmail.com"; 

         $headers = 'MIME-Version: 1.0' . "\r\n";

         $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

         $headers .= "From: Bengaluru BTM Layout<helpdesk.vh15112@vibgyorhigh.com>" . "\r\n";

         $headers .= 'Bcc: helpdesk.vh@gmail.com,smashmit@gmail.com' . "\r\n"; 

         if($enquiryfrom=="admission-form"){

           $filetosend1='VH_BTM LAYOUT_FEES_2015-16.pdf';

           $filetosend1= $filetosend. $filetosend1;

           $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

         }

         $mail = mail($to, $subject, $message, $headers);

         

         $headers1 = 'MIME-Version: 1.0' . "\r\n";

         $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

         $headers1 .= "From: Bengaluru BTM Layout<helpdesk.vh15112@vibgyorhigh.com>" . "\r\n"; 

         if($enquiryfrom=="admission-form"){

           $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

         }

         $mail1 = mail($email, $usersubject, $usermessage, $headers1);

         

       }else if($selectschool=="Blr - Yelahanka"){

         $to = "helpdesk.vh15130@vibgyorhigh.com";

         $headers = 'MIME-Version: 1.0' . "\r\n";

         $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

         $headers .= "From: Bengaluru Yelahanka<helpdesk.vh15130@vibgyorhigh.com>" . "\r\n";

         $headers .= 'Bcc: helpdesk.vh@gmail.com,smashmit@gmail.com' . "\r\n"; 

         if($enquiryfrom=="admission-form"){

          $filetosend1='VH_YELAHANKA_FEES_2015-16.pdf';

          $filetosend1= $filetosend. $filetosend1;

          $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

        }

        $mail = mail($to, $subject, $message, $headers);

        

        $headers1 = 'MIME-Version: 1.0' . "\r\n";

        $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        $headers1 .= "From: Bengaluru Yelahanka<helpdesk.vh15130@vibgyorhigh.com>" . "\r\n"; 

        if($enquiryfrom=="admission-form"){

         $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

       }

       $mail1 = mail($email, $usersubject, $usermessage, $headers1);

       

       

     }else  if($selectschool=="Blr - Hennur"){

       $to = "helpdesk.vh15301@vibgyorhigh.com";

       $headers = 'MIME-Version: 1.0' . "\r\n";

       $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

       $headers .= "From: Bengaluru Hennur<helpdesk.vh15301@vibgyorhigh.com>" . "\r\n";

       $headers .= 'Bcc: helpdesk.vh@gmail.com,smashmit@gmail.com' . "\r\n"; 

       if($enquiryfrom=="admission-form"){

        $filetosend1='VH_HENNUR_FEES_2015-16.pdf';

        $filetosend1= $filetosend. $filetosend1;

        $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

      }

      $mail = mail($to, $subject, $message, $headers);

      

      $headers1 = 'MIME-Version: 1.0' . "\r\n";

      $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

      $headers1 .= "From: Bengaluru Hennur<helpdesk.vh15301@vibgyorhigh.com>" . "\r\n"; 

      if($enquiryfrom=="admission-form"){

       $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

     }

     $mail1 = mail($email, $usersubject, $usermessage, $headers1);

     

   }else if($selectschool=="Blr - Kadugodi"){

     $to = "helpdesk.vh15116@vibgyorhigh.com";

           //$to = "shrutika@crystal-logic.com,Prabhat001@gmail.com";

     $headers = 'MIME-Version: 1.0' . "\r\n";

     $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

     $headers .= "From: Bengaluru Kadugodi<helpdesk.vh15116@vibgyorhigh.com>" . "\r\n"; 

     $headers .= 'Bcc: helpdesk.vh@gmail.com,smashmit@gmail.com' . "\r\n";

     if($enquiryfrom=="admission-form"){

      $filetosend1='VH_KADUGODI_FEES_2015-16.pdf';

      $filetosend1= $filetosend. $filetosend1;

      $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

    }

    $mail = mail($to, $subject, $message, $headers);

    

    $headers1 = 'MIME-Version: 1.0' . "\r\n";

    $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    $headers1 .= "From: Bengaluru Kadugodi<helpdesk.vh15116@vibgyorhigh.com>" . "\r\n"; 

    if($enquiryfrom=="admission-form"){

      $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

    }

    $mail1 = mail($email, $usersubject, $usermessage, $headers1);

  }else if($selectschool=="Blr - Jakkur"){

   $to = "helpdesk.vh15120@vibgyorhigh.com";

          // $to = "shrutika@crystal-logic.com,Prabhat001@gmail.com"; 

   $headers = 'MIME-Version: 1.0' . "\r\n";

   $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

   $headers .= "From: Bengaluru Jakkur<helpdesk.vh15120@vibgyorhigh.com>" . "\r\n";

   $headers .= 'Bcc: helpdesk.vh@gmail.com,smashmit@gmail.com' . "\r\n"; 

   if($enquiryfrom=="admission-form"){

    $filetosend1='VH_JAKKUR_FEES_2015-16.pdf';

    $filetosend1= $filetosend. $filetosend1;

    $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

  }

  $mail = mail($to, $subject, $message, $headers);

  

  $headers1 = 'MIME-Version: 1.0' . "\r\n";

  $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  $headers1 .= "From: Bengaluru Jakkur<helpdesk.vh15120@vibgyorhigh.com>" . "\r\n"; 

  if($enquiryfrom=="admission-form"){  $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

}

$mail1 = mail($email, $usersubject, $usermessage, $headers1);

}else if($selectschool=="Blr - Bannerghatta"){

 $to = "helpdesk.vh15121@vibgyorhigh.com";

          //$to = "shrutika@crystal-logic.com,Prabhat001@gmail.com";

 $headers = 'MIME-Version: 1.0' . "\r\n";

 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

 $headers .= "From: Bengaluru Bannerghatta Road<helpdesk.vh15121@vibgyorhigh.com>" . "\r\n"; 

 $headers .= 'Bcc: helpdesk.vh@gmail.com,smashmit@gmail.com' . "\r\n";

 if($enquiryfrom=="admission-form"){

   $filetosend1='VH_BANNERGHATTA_FEES_2015-16.pdf';

   $filetosend1= $filetosend. $filetosend1;

   $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

 }

 $mail = mail($to, $subject, $message, $headers);

 

 $headers1 = 'MIME-Version: 1.0' . "\r\n";

 $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

 $headers1 .= "From: Bengaluru Bannerghatta Road<helpdesk.vh15121@vibgyorhigh.com>" . "\r\n"; 

 $mail1 = mail($email, $usersubject, $usermessage, $headers1);

 if($enquiryfrom=="admission-form")
   {   $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

}

            }else /*if($selectschool=="Hyderabad"){

           $to = "helpdesk.hyderabad46@vibgyorhigh.com";

                      $headers = 'MIME-Version: 1.0' . "\r\n";

                  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                           $headers .= "From: Hyderabad<helpdesk.hyderabad46@vibgyorhigh.com>" . "\r\n"; 

                            $headers .= 'Bcc: helpdesk.vh@gmail.com,smashmit@gmail.com' . "\r\n";

              if($enquiryfrom=="admission-form"){

                 $filetosend1='VH_FEES_2015-16.pdf';

                 $filetosend1= $filetosend. $filetosend1;

             $message=$message.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

 }

                             $mail = mail($to, $subject, $message, $headers);

                           

                              $headers1 = 'MIME-Version: 1.0' . "\r\n";

                  $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                           $headers1 .= "From: Hyderabad<helpdesk.hyderabad46@vibgyorhigh.com>" . "\r\n"; 

                   $mail1 = mail($email, $usersubject, $usermessage, $headers1);

                if($enquiryfrom=="admission-form"){   $usermessage=$usermessage.'<br/><a href="'.$filetosend1.'" target="_blank" >Admission Procedure & Fees Structure ('.$selectschool.')</a>';

             }

           }else*/ {

           }

           

           if($mail){
             echo 'Thank you. Please check your email for further details. Sometimes spam filter blocks automated emails. If you do not find the email in your inbox, please check your spam / bulk / junk email folder. One of our representatives will get back to you shortly.';
            //echo "Thank you. One of our representatives will get back to you shortly." ; 

           }else{

             echo "Problem sending email.";  

           }

      //To CRM BE
           
   //         $url = 'http://vibgyor-online.com/onl/data/inqdatapage.aspx';

      //  //echo $url;

   //         $fields = array(
   //          "School" => $selectschool, 
   //          "Class" => $class, 
   //          "Firstname" => $name, 
   //          "Lastname" => "", 
   //          "Email" => $email, 
   //          "Mobileno" => $phone, 
   //          "Comments" => $message1, 
   //          "action" => "SaveQuickInquiry"
   //          );
   //         $data = http_build_query($fields);

   //         $params = array (
   //           'http' => array (
   //             'method' => 'POST',
   //             'content' => $data,
   //             'header' => "Content-type: application/x-www-form-urlencoded\r\n" .
   //             "Content-Length: " . strlen ( $data ) . "\r\n" 
   //             ) 
   //           );

      // //echo $params;

   //         if ($optional_headers != null) {
   //          $params ['http'] ['header'] = $optional_headers;
   //        }
   //        $ctx = stream_context_create ( $params );
   //        try {
   //          $fp = fopen ( $url, 'rb', false, $ctx );
   //          $response = stream_get_contents ( $fp );
   //        } catch ( Exception $e ) {
   //          echo 'Exception: ' . $e->getMessage ();
   //        }
      //echo "this is response ";
      //echo $response;
           
      /*if ($response != "")
      {
        echo " Dear Parent/s, \n Thank you for your enquiry with the VIBGYOR High School.\n We have registered your Enquiry Number as " . $response .  " \n After careful review of your Enquiry we will arrange to have our Relationship Managers contact you at the earliest.\n We appreciate your interest in our institution and would look forward to a successful association.";
      }*/
      //To CRM BE







    }else{

     echo "All fields are mandatory";

   }
 } else {
  echo "Captcha Verification Error: Please check I'am not robot";
}
?>



