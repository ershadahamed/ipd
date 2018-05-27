<?php
include "../../config.php";
include "../../manualdbconfig.php";
require('fpdf.php');

class PDF extends FPDF
{
// Load data
function LoadData($file)
{
    // Read file lines
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}
// Colored table
function FancyTable($header, $data)
{
    // Colors, line width and bold font
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Header
    $w = array(40, 35, 40, 45);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Closing line
    $this->Cell(array_sum($w),0,'','T');
}
}

$pdf=new PDF();
$pdf->AddPage();

$pdf->SetFont('Arial','B',10);

$pdf->Cell(50,3,"Cool PHP to PDF Tutorial by WebSpeaks.in");
$pdf->Ln();
$pdf->Ln();

$pdf->SetFont('Arial','B',6);
//$pdf->Cell(0, 10, 'Titel mit ln=1', 0, 1);
$pdf->Cell(22,5,"Learning Outcome");
$pdf->Cell(22,5,"Questions");
$pdf->Cell(25,5,"Questions Attempted");
//$pdf->Cell(133.5, 2.7, "1", 0, 0, 'L');
//$pdf->Cell(53.5, 2.7, "2", 0, 1, 'L');
$pdf->Cell(350,5,"Score(%)");

$pdf->Ln();
$pdf->Cell(450,3,"-------------------------------------------------------------------------------------");

	// Get data records from table.
	$result=mysql_query("select * from mdl_cifauser where confirmed='1' And auth='manual' And deleted='0' order by id");
	while($row=mysql_fetch_array($result))
	{

		$sh=strtoupper($row['firstname']).' '.strtoupper($row['lastname']);

		$pdf->Cell(22,5,"{$row['id']}");
		$pdf->Cell(22,5,"{$row['id']}");
		$pdf->Cell(25,5,"{$row['id']}");	
		$pdf->MultiCell(350,5,"{$sh}");
	
	}
$pdf->Output();

?>
