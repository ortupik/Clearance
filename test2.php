<?php
  require_once __DIR__ . '/db/core.php';
  require_once __DIR__ . '/db/db_connect.php';

 $user_id = $_SESSION['user_id'];
  if(!isset($_SESSION['user_id'])){
      $user_id = $_SESSION['user_id'];
      header("location:login.php");
  }
  
  $db = new DB_CONNECT();
  
  $finalArray = array();
  $total_amount = 0;

   $query = mysqli_query($db->connect(), "Select user,paid,date,transaction_id FROM `report` WHERE `user_id`  = $user_id ") or die(mysqli_error($db->connect()));
    if ($query) {
        $rows = mysqli_num_rows($query);
        $count = 0;
        if ($rows > 0) {
            while ($row = mysqli_fetch_array($query)) {
              
                $cleared = "Yes";
                $remarks = "";
                
                $paid = $row['paid'];
                if($paid <= 0){
                    $paid = "";
                }
              
                
                $dataArray = array();
                $dataArray['user'] = $row["user"];
                $dataArray['date'] = "";
                $dataArray['transaction_id'] = $row["transaction_id"];
                // $dataArray['balance'] = $balance;
                
                $dataArray['paid'] = $paid;
                $dataArray['cleared'] = $cleared;
                 $dataArray['remarks'] = "";

                $finalArray[$count] = $dataArray;
                $count++;
            }
        }
    }
    
     $query2 = mysqli_query($db->connect(), "Select * FROM `cleartable` WHERE `user_id` = '$user_id'  ") or die(mysqli_error($db->connect()));
      if ($query2) {
        $rows2 = mysqli_num_rows($query2);
        if ($rows2 <= 0) {
             $query3 = mysqli_query($db->connect(), "CALL clearTable($user_id); ") or die(mysqli_error($db->connect()));
            if ($query3) {
                
            }
        }
      }
    
$query = mysqli_query($db->connect(), "Select * FROM `clearTable` WHERE `user_id`  = $user_id ") or die(mysqli_error($db->connect()));
    if ($query) {
        $rows = mysqli_num_rows($query);
        $count = 0;
        if ($rows > 0) {
            while ($row = mysqli_fetch_array($query)) {
              
                $status = $row["status"];
                if($status == "Y"){
                     $cleared = "Yes";
                }else{
                     $cleared = "No";
                }
               
                $remarks = "";
                $paid = "";
              
                
                $dataArray = array();
                $dataArray['user'] = $row["user"];
                $dataArray['date'] = "";
                $dataArray['transaction_id'] = "";
                // $dataArray['balance'] = $balance;
                $dataArray['paid'] = $paid;
                $dataArray['cleared'] = $cleared;
                 $dataArray['remarks'] = "";

                $finalArray[$count] = $dataArray;
                $count++;
            }
        }
    }
    
require('fpdf.php');

class PDF extends FPDF
{
// Load data

    // Page header
function Header()
{
    // Logo
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(45);
    // Title
    $this->Cell(100,10,'DEKUT CLEARANCE REPORT',1,0,'C');
    $this->Ln();
     $this->SetFont('Arial','B',11);
    $this->Cell(45);
    $this->Cell(60,10,"ANTONY NGANGA WANJIRU",1,0,'C');
    $this->Cell(40,10,"C026-01-0730/2012",1,0,'C');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}

// Simple table
function BasicTable($header, $data)
{// Colors, line width and bold font
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.1);
    $this->SetFont('','B');
    // Header
    $w = array(30, 20,20,20, 35,35, 30);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],6,$header[$i],1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
    
    foreach($data as $row)
    {
        //echo json_encode($row);
        $this->Cell($w[0],16,$row["user"],'LR',0,'C',$fill);
        $this->Cell($w[1],16,$row["paid"],'LR',0,'C',$fill);
        $this->Cell($w[2],16,'Mobile','LR',0,'L',$fill);
        $this->Cell($w[3],16,$row["cleared"],'LR',0,'L',$fill);
        $this->Cell($w[4],16,$row["remarks"],'LR',0,'R',$fill);
        $this->Cell($w[5],16,"",'LR',0,'R',$fill);
        $this->Cell($w[6],16,$row["date"],'LR',0,'R',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    
       
       /* $fill = !$fill;
         $this->Cell($w[0],16,"Director of School",'LR',0,'C',$fill);
        $this->Cell($w[1],16,"----",'LR',0,'C',$fill);
        $this->Cell($w[2],16,'----','LR',0,'L',$fill);
        $this->Cell($w[3],16,"----",'LR',0,'L',$fill);
        $this->Cell($w[4],16,"",'LR',0,'R',$fill);
        $this->Cell($w[5],16,"",'LR',0,'R',$fill);
        $this->Cell($w[6],16,"",'LR',0,'R',$fill);
        $this->Ln();*/
       
    
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
    
}

}

$pdf = new PDF();
// Column headings
$header = array('','Paid(KES)','Mode', 'Cleared', 'Remarks',"Sign", 'Time/Date');
$pdf->AliasNbPages();
// Data loading
$pdf->SetFont('Arial','',10);
$pdf->AddPage();
$pdf->BasicTable($header,$finalArray);
$pdf->Output();