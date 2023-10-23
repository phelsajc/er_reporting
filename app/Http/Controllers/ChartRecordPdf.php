<?php

namespace App\Http\Controllers;
use App\Model\Prescriptions_m;

use TJGazel\LaraFpdf\LaraFpdf;

class ChartRecordPdf extends LaraFpdf
{
  private $data;
  private $widths;
  private $aligns;

  public function __construct($data)
  {
    $this->data = $data;
    $pdf = new LaraFpdf();

    //parent::__construct('P', 'mm', array(215.7,107.7));
    #goodparent::__construct('P', 'mm', array(107.7,215.7));
    parent::__construct('L', 'mm', array(216, 277));
    //parent::__construct('L', 'mm', array(144.3,108.7));
    //parent::__construct('L', 'mm', array(154.3,108.7));
    //parent::__construct('L', 'mm', array(107.7,115.7));
    //parent::__construct('L', 'in', array(4.25,5.5));
    //parent::__construct('L', 'mm', array(107.7,215.7));
    //$this->SetA4();--SET

    $this->SetTitle('CLINICAL CHART', true);
    $this->SetAuthor('TJGazel', true);
    $this->AddPage('P');
    $this->SetWidths(array(15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15));
    $this->Body();
  }

  public function Header()
  {
  }

  // Simple table
  function HeaderTable($data)
  {

    $this->SetFont('Arial', 'B', 12);
    $this->Image(public_path() . '\img\UKlogo.jpg', 78, 2, 70, 30);
    /*      $this->Image( public_path().'\covidprint\header.jpg',1,5,100,25);
        $this->Image( public_path().'\covidprint\ililogo.png',165,5,50,25);*/
    $this->Ln(8);
    $this->Cell(210, 40, strtoupper("OUTPATIENT CLINICAL CHART RECORD \n"), 0, 0, 'C');

    // Move to the right
    // $this->Cell(80);
    // Title
    $this->Ln(21);
    $this->SetFont('Arial', 'B', 10);
    $this->AliasNbPages();

    $this->Rect(11, 40, 85, 14);

    $this->SetXY(8, 40);
    $this->Cell(21, 5, 'Name', 0, 0, 'C');
    $this->ln(5);
    $this->SetFont('Arial', '', 9);
    $this->Cell(0.1, 5, '', 0, 0, 'C');
    $this->SetFont('Arial', '', 10);


    $pname = explode(',',$this->data['query_patient']->patientname);
    $this->SetXY(32, 40);
    $this->Cell(11, 5, 'Last', 0, 0, 'C');
    $this->ln(5);
    $this->SetFont('Arial', '', 9);
    $this->Cell(0.1, 5, '', 0, 0, 'C');
    $this->SetXY(8, 45);
    $this->Cell(30, 7, strtoupper($pname[0]), 0, 0, 'C');
    $this->SetFont('Arial', '', 10);


    $this->SetXY(57, 40);
    $this->Cell(7, 5, 'First', 0, 0, 'C');
    $this->SetFont('Arial', '', 9);
    $this->ln(5);
    $this->SetFont('Arial', '', 9);
    $this->Cell(0.1, 5, '', 0, 0, 'C');
    $this->SetXY(46, 45);
    $this->Cell(15, 7, strtoupper($pname[1]), 0, 0, 'C');
    $this->SetFont('Arial', '', 10);


    $this->SetFont('Arial', '', 10);
    $this->SetXY(80, 40);
    $this->Cell(10, 5, 'Middle', 0, 0, 'C');
    $this->SetFont('Arial', '', 9);
    $this->ln(5);
    $this->SetFont('Arial', '', 9);
    $this->SetXY(70, 45);
    $this->Cell(30, 7, '', 0, 0, 'C');

    $this->Rect(96.1, 40, 10, 14);

    $this->SetFont('Arial', '', 10);
    $this->SetXY(91.1, 40);
    $this->Cell(20, 5, 'Age', 0, 0, 'C');
    $this->SetFont('Arial', '', 9);
    $this->ln(5);
    $this->SetXY(89, 45);
    $this->Cell(25, 7, date_diff(date_create($this->data['query_patient']->birthdate), date_create('now'))->y, 0, 0, 'C');

    $this->ln(5);
    $this->SetFont('Arial', '', 9);
    $this->Cell(0.1, 5, '', 0, 0, 'C');

    $this->Rect(106.1, 40, 10, 14);

    $this->SetFont('Arial', '', 10);
    $this->SetXY(101.1, 40);
    $this->Cell(20, 5, 'Sex', 0, 0, 'C');
    $this->SetFont('Arial', '', 9);
    $this->ln(5);
    $this->SetXY(99, 45);
    $this->Cell(25, 7, strtoupper($this->data['query_patient']->sex), 0, 0, 'C');
    $this->ln(5);
    $this->SetFont('Arial', '', 9);
    $this->Cell(0.1, 5, '', 0, 0, 'C');


    $this->Rect(116.1, 40, 20, 14);

    $this->SetFont('Arial', '', 9);
    $this->SetXY(116.1, 40);
    $this->Cell(20, 5, 'Civil Status', 0, 0, 'C');
    $this->SetFont('Arial', '', 9);
    $this->ln(5);
    $this->SetXY(114, 45);
    $this->Cell(25, 7, strtoupper($this->data['query_patient']->civil_status), 0, 0, 'C');
    $this->ln(5);
    $this->SetFont('Arial', '', 9);
    $this->Cell(0.1, 5, '', 0, 0, 'C');

    $this->Rect(136.1, 40, 15, 14);
    $this->SetFont('Arial', '', 9);
    $this->SetXY(136.1, 40);
    $this->Cell(16, 5, 'Room #.', 0, 0, 'C');
    $this->SetFont('Arial', '', 9);
    $this->ln(5);
    $this->SetXY(132, 45);
    $this->Cell(25, 7, '', 0, 0, 'C');
    $this->ln(5);
    $this->SetFont('Arial', '', 9);
    $this->Cell(0.1, 5, '', 0, 0, 'C');



    $this->Rect(151, 40, 15, 14);
    $this->SetFont('Arial', '', 8);
    $this->SetXY(151, 40);
    $this->Cell(15.5, 5, 'Hospital #.', 0, 0, 'C');
    $this->SetFont('Arial', '', 9);
    $this->ln(5);
    $this->SetXY(145, 45);
    $this->Cell(25, 7, '', 0, 0, 'C');
    $this->ln(5);
    $this->SetFont('Arial', '', 9);
    $this->Cell(0.1, 5, '', 0, 0, 'C');




    $this->Rect(166.1, 40, 38, 14);

    $this->SetFont('Arial', '', 10);
    $this->SetXY(175.1, 40);
    $this->Cell(20, 5, 'Attending Physician', 0, 0, 'C');
    $this->SetFont('Arial', '', 9);
    $this->ln(5);
    $this->SetXY(165, 45);

    $this->MultiCell(40, 4, $data->doctor, '', 'C', 0);
    $this->SetFont('Arial', 'B', 10);
    $this->Cell(0.1, 5, '', 0, 0, 'C');


    $this->Rect(11, 54, 193.1, 14);
    $this->SetFont('Arial', 'B', 10);
    $this->SetXY(17, 54);
    $this->Cell(21, 5, 'Patient Address', 0, 0, 'C');
    $this->ln(5);

    $this->SetFont('Arial', '', 9);
    $this->SetXY(13, 59);
    $this->MultiCell(100, 4, strtoupper($this->data['query_patient']->address), '', 'L', 0);
    $this->Cell(0.1, 5, '', 0, 0, 'C');

    /*DATE AND TIME*/
    $this->Rect(11, 69, 40, 6);
    $this->SetFont('Arial', 'B', 9);
    $this->SetXY(18, 69);
    $this->Cell(26, 5, 'Date time & Vital Signs', 0, 0, 'C');
    $this->ln(5);
    $this->SetFont('Arial', '', 9);
    $this->Cell(0.1, 5, '', 0, 0, 'C');

    $this->Rect(11, 75, 40, 200);
    $this->SetFont('Arial', '', 9);

    $this->SetXY(12, 77);
    $diagnose_dt = date_create($data->created_dt);
    $this->MultiCell(40, 4, date_format($diagnose_dt, "M d, Y g:i A") . "\nWeight: " . $data->weight . " \n" . "Height: " . $data->height . " \n" . "Temperature: " . $data->temp . " \n" . "Blood pressure: " . $data->bp . " \n", '', 'L', 0);
    $this->Cell(0.1, 5, '', 0, 0, 'C');


    /*-----------------------------*/

    /*CHIEF COMPLAINTS*/
    $this->Rect(51, 69, 40, 6);
    $this->SetFont('Arial', 'B', 9);
    $this->SetXY(53, 69);
    $this->Cell(36, 5, 'CHIEF COMPLAINTS', 0, 0, 'C');
    $this->ln(5);
    $this->SetFont('Arial', '', 9);
    $this->Cell(0.1, 5, '', 0, 0, 'C');

    $this->Rect(51, 75, 40, 200);

    $this->SetXY(52, 77);
    $this->MultiCell(40, 4, $data->chiefcomplaints, '', 'L', 0);
    $this->Cell(0.1, 5, '', 0, 0, 'C');
    /*------------------------------*/

    /*CHIEF HISTORY*/
    $this->Rect(91, 69, 40, 6);
    $this->SetFont('Arial', 'B', 9);
    $this->SetXY(93, 69);
    $this->Cell(36, 5, 'HISTORY & PE', 0, 0, 'C');
    $this->ln(5);
    $this->SetFont('Arial', '', 9);
    $this->Cell(0.1, 5, '', 0, 0, 'C');

    $this->Rect(91, 75, 40, 200);

    $this->SetXY(92, 77);
    $this->MultiCell(40, 4, $data->pe. '. '."\n" . $data->history, '', 'L', 0);
    $this->Cell(0.1, 5, '', 0, 0, 'C');
    /*-------------------------------*/

    /*DIAGNOSE & MEDICATIONS*/
    $this->Rect(131, 69, 40, 6);
    $this->SetFont('Arial', 'B', 9);
    $this->SetXY(133, 69);
    $this->Cell(36, 5, 'DIAGNOSE', 0, 0, 'C');
    $this->ln(5);
    $this->SetFont('Arial', '', 9);
    $this->Cell(0.1, 5, '', 0, 0, 'C');

    $this->Rect(131, 75, 40, 200);

   

    $this->SetXY(132, 77);
    $this->MultiCell(40, 4,  $data->diagosis, '', 'L', 0);
    $this->Cell(0.1, 5, '', 0, 0, 'C');
    /*-------------------------------*/

    /*REMARKS*/
    $getPrescriptions = Prescriptions_m::where(['diagnosis_id'=>$data->id])->get();
    $prescriptions = '';
    $ar = array();
    foreach ($getPrescriptions as $key => $value) {
      $prescriptions .=($key+1).'.) '. strtoupper($value->generic_name.' '.$value->medecine_desc)."\n";
      $ar[] = ($key+1).'.) '. strtoupper($value->generic_name.' '.$value->medecine_desc)."\n\n";
    }

    $this->Rect(171, 69, 33.1, 6);
    $this->SetFont('Arial', 'B', 9);
    $this->SetXY(173, 69);
    $this->Cell(30, 5, 'MEDICATIONS', 0, 0, 'C');
    $this->ln(5);
    $this->SetFont('Arial', '', 7);
    $this->Cell(0.1, 5, '', 0, 0, 'C');

    $this->Rect(171, 75, 33.1, 200);

    $this->SetXY(171, 77);
    $this->MultiCell(30, 4, $prescriptions, '', 'L', 0);
    //$this->Row($ar);
    $this->Cell(0.1, 5, '', 0, 0, 'C');
    /*---------------------------------*/
    
		
  }

  function SwabForm()
  {
  }

  public function Body()
  {
    $width_cell = array(125, 15, 30, 25, 15, 80, 35, 65, 15, 30, 25, 55, 55, 30, 30, 30, 60, 35, 15, 25);
    $this->SetWidths(array(125, 15, 30, 25, 15, 80, 35, 65, 15, 30, 25, 55, 55, 30, 30, 30, 60, 35, 15, 25));
    for ($i = 0; $i < sizeof($this->data['getHistory']); $i++) {

      $this->HeaderTable($this->data['getHistory'][$i]);

      $this->FooterTable();
    }
  }

  public function Footer()
  {
  }

  public function FooterTable()
  {
    $this->SetY(-10);

    $this->SetFont('Arial', 'B', 50);
    // $this->Image( public_path().'\img\rmci_footer.jpg',0,250,216,35);


    $this->SetFont('Arial', '', 5);
    $this->SetAutoPageBreak(true, 25);
  }

  function SetWidths($w)
  {
    //Set the array of column widths
    $this->widths = $w;
  }

  function SetAligns($a)
  {
    //Set the array of column alignments
    $this->aligns = $a;
  }

  function Row($data)
  {
    //Calculate the height of the row
    $nb = 0;
    for ($i = 0; $i < count($data); $i++)
      $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
    $h = 5 * $nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for ($i = 0; $i < count($data); $i++) {
      $w = $this->widths[$i];
      $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
      //Save the current position
      $x = $this->GetX();
      $y = $this->GetY();
      //Draw the border
      $this->Rect($x, $y, $w, $h);
      //Print the text
      $this->MultiCell($w, 5, $data[$i], 0, $a);
      //Put the position to the right of the cell
      $this->SetXY($x + $w, $y);
    }
    //Go to the next line
    $this->Ln($h);
  }



  function CheckPageBreak($h)
  {
    //If the height h would cause an overflow, add a new page immediately
    if ($this->GetY() + $h > $this->PageBreakTrigger)
      $this->AddPage($this->CurOrientation);
  }

  function NbLines($w, $txt)
  {
    //Computes the number of lines a MultiCell of width w will take
    $cw = &$this->CurrentFont['cw'];
    if ($w == 0)
      $w = $this->w - $this->rMargin - $this->x;
    $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
    $s = str_replace("\r", '', $txt);
    $nb = strlen($s);
    if ($nb > 0 and $s[$nb - 1] == "\n")
      $nb--;
    $sep = -1;
    $i = 0;
    $j = 0;
    $l = 0;
    $nl = 1;
    while ($i < $nb) {
      $c = $s[$i];
      if ($c == "\n") {
        $i++;
        $sep = -1;
        $j = $i;
        $l = 0;
        $nl++;
        continue;
      }
      if ($c == ' ')
        $sep = $i;
      $l += $cw[$c];
      if ($l > $wmax) {
        if ($sep == -1) {
          if ($i == $j)
            $i++;
        } else
          $i = $sep + 1;
        $sep = -1;
        $j = $i;
        $l = 0;
        $nl++;
      } else
        $i++;
    }
    return $nl;
  }

  function FancyRow($data, $border = array(), $align = array(), $style = array(), $maxline = array())
  {
    //Calculate the height of the row
    $nb = 0;
    for ($i = 0; $i < count($data); $i++) {
      $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
    }
    if (count($maxline)) {
      $_maxline = max($maxline);
      if ($nb > $_maxline) {
        $nb = $_maxline;
      }
    }
    $h = 5 * $nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for ($i = 0; $i < count($data); $i++) {
      $w = $this->widths[$i];
      // alignment
      $a = isset($align[$i]) ? $align[$i] : 'L';
      // maxline
      $m = isset($maxline[$i]) ? $maxline[$i] : false;
      //Save the current position
      $x = $this->GetX();
      $y = $this->GetY();
      //Draw the border
      if ($border[$i] == 1) {
        $this->Rect($x, $y, $w, $h);
      } else {
        $_border = strtoupper($border[$i]);
        if (strstr($_border, 'L') !== false) {
          $this->Line($x, $y, $x, $y + $h);
        }
        if (strstr($_border, 'R') !== false) {
          $this->Line($x + $w, $y, $x + $w, $y + $h);
        }
        if (strstr($_border, 'T') !== false) {
          $this->Line($x, $y, $x + $w, $y);
        }
        if (strstr($_border, 'B') !== false) {
          $this->Line($x, $y + $h, $x + $w, $y + $h);
        }
      }
      // Setting Style
      if (isset($style[$i])) {
        $this->SetFont('', $style[$i]);
      }
      $this->MultiCell($w, 5, $data[$i], 0, $a, 0, $m);
      //Put the position to the right of the cell
      $this->SetXY($x + $w, $y);
    }
    //Go to the next line
    $this->Ln($h);
  }

  function WordWrap(&$text, $maxwidth)
  {
    $text = trim($text);
    if ($text === '')
      return 0;
    $space = $this->GetStringWidth(' ');
    $lines = explode("\n", $text);
    $text = '';
    $count = 0;

    foreach ($lines as $line) {
      $words = preg_split('/ +/', $line);
      $width = 0;

      foreach ($words as $word) {
        $wordwidth = $this->GetStringWidth($word);
        if ($wordwidth > $maxwidth) {
          // Word is too long, we cut it
          for ($i = 0; $i < strlen($word); $i++) {
            $wordwidth = $this->GetStringWidth(substr($word, $i, 1));
            if ($width + $wordwidth <= $maxwidth) {
              $width += $wordwidth;
              $text .= substr($word, $i, 1);
            } else {
              $width = $wordwidth;
              $text = rtrim($text) . "\n" . substr($word, $i, 1);
              $count++;
            }
          }
        } elseif ($width + $wordwidth <= $maxwidth) {
          $width += $wordwidth + $space;
          $text .= $word . ' ';
        } else {
          $width = $wordwidth + $space;
          $text = rtrim($text) . "\n" . $word . ' ';
          $count++;
        }
      }
      $text = rtrim($text) . "\n";
      $count++;
    }
    $text = rtrim($text);
    return $count;
  }
}
