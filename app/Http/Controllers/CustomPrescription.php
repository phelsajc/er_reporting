<?php
namespace App\Http\Controllers;
use TJGazel\LaraFpdf\LaraFpdf;

class CustomPrescription extends LaraFpdf
{
    private $data;
    private $widths;
    private $aligns;

    public function __construct($data)
    {
        $this->data = $data;
        $this->check_method = null;
        $pdf = new LaraFpdf();
        parent::__construct('L', 'mm', array(215.9,139.7));
        /* parent::__construct('L', 'mm', array(
            215,
            279.4
        )); */
        // $this->SetMargins(1,10.01,01,1);
        $this->SetTitle('My pdf title', true);
        $this->SetAuthor('TJGazel', true);
        $this->AddPage('P');
        $this->Body();
    }

    public function Header()
    {
        $this->SetFont('Arial', 'B', 5);
        $this->Image(public_path() . '\images\uk_logo.png', 2, -15, 50, 50, 'PNG');
        /* $this->Cell(130, -9, strtoupper(strtoupper($this->data['doctor'])) , 0, 0, 'C'); */
        $this->Cell(130, -9, strtoupper(strtoupper($this->data['dctr_details']->name)) , 0, 0, 'C');
        $this->Cell(130, -9, strtoupper(strtoupper(" ")) , 0, 0, 'C');
        $this->Ln(5);
        $this->Cell(130, -14, strtoupper($this->data['dctr_details']->specialization) , 0, 0, 'C');
        $this->Cell(130, -14, strtoupper(" ") , 0, 0, 'C');

        /* if($this->data['dctr_details']->rm_loc){
            $this->Ln(1);
            $this->Cell(130,-11,strtoupper($this->data['dctr_details']->rm_loc),0,0,'C');
            $this->Cell(130,-11,strtoupper(" "),0,0,'C');
        } */

        //if($this->data['dctr_details']->smsplusmobileno||$this->data['dctr_details']->telefax){
            $this->Ln(1.5);
            $this->Cell(130,-11,"0929-2153564".' / '."+6334 435 4052-54",0,0,'C');
            $this->Cell(130,-11,strtoupper(" "),0,0,'C');
        //}

        $this->Ln(0.5);
        $this->Cell(130, -5, strtoupper("SM City Bacolod - South Wing, Bacolod, 6100 Negros") , 0, 0, 'C');
        $this->Cell(130, -5, strtoupper(" ") , 0, 0, 'C');
        $this->Ln(1);
        $this->Ln(5);
        $this->SetFont('Arial', '', 7);
        $this->AliasNbPages();
        $this->cell(20, 3, 'Name of Patient :', 0, 0);
        $this->SetFont('');
        $this->cell(65, 3, strtoupper($this->data['query_patient']->patientname) , 'B', 0);
        $this->cell(8, 3, 'Sex :', 0, 0);
        $this->cell(1, 3,strtoupper($this->data['query_patient']->sex) , 'B', 0);
        $this->SetFont('');
        $this->cell(15, 3, '', 'B', 0);
        $this->cell(8, 3, 'Age :', 0, 0);
        $this->cell(1, 3, date_diff(date_create( $this->data['query_patient']->birthdate), date_create('now'))->y , 'B', 0);
        $this->SetFont('');
        $this->cell(10, 3, '', 'B', 1);
        $this->cell(13, 4, 'Address :', 0, 0);
        $add = strlen($this->data['query_patient']->address);        

        if($add<=51){
            $this->cell(1, 4, strtoupper($this->data['query_patient']->address) , 'B', 0);        
            $this->cell(87, 4, '', 'B', 0);
            $this->cell(8, 4, 'Date :', 0, 0);
            $this->cell(15, 4, date('F d,Y') , 'B', 1, 'C');
            $this->Ln(10);
            $this->Image(public_path() . '\img\rx.png', 10, 32, 4, 4, 'PNG');
        }else{
            $this->MultiCell(198,4,strtoupper(substr($this->data['query_patient']->address, 0, 81)),'B','L');
            $this->MultiCell(100,4,strtoupper(substr($this->data['query_patient']->address, 82, $add)),'B','L'); 
            $this->SetXY(110, 31);
            $this->cell(8, 4, 'Date :', 0, 0);
            $this->SetXY(120, 31);
            $this->cell(15, 4, date('F d,Y') , 'B', 1, 'C');
            $this->Ln(5);
            $this->Image(public_path() . '\img\rx.png', 10, 36, 4, 4, 'PNG');
        }

        $this->SetFont('');
        $this->SetFont('');
    }

    function DiagnosticTbl($header)
    {
        $this->SetFont('Arial', 'B', 6);

        // Column widths
        $w = array(
            60,
            60
        );

        // Header
        for ($i = 0;$i < count($header);$i++) $this->Cell($w[$i], 5, $header[$i], 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Arial', '', 6);
        $this->SetWidths(array(
            60,
            60
        ));
        foreach ($this->data['query_diagnostic'] as $row)
        {
            $this->Row(array(
                $row['diagnostic'],
                $row['instructions']
            ));
        }
        // Closing line
        $this->Cell(array_sum($w) , 0, '', 'T');
    }

    public function mealHeader(){
        $this->SetFont('Arial', '', 5);
        $this->Cell(25, 5, "Generic", 'LTR', 0, 'C');
        $this->Cell(25, 5, "Brand", 'LTR', 0, 'C');

        $this->Cell(5, 5, "Days", "TR", 0, 'C');

        $this->Cell(9, 5, "Breakfast", 'T', 0, 'C');

        $this->Cell(9, 5, "Lunch", 1, 0, 'C');

        $this->Cell(9, 5, "Supper", 1, 0, 'C');

        $this->Cell(9, 5, "Bed", "TR", 0, 'C');

        $this->Cell(5, 5, "Qty", 'RT', 0, 'C');

        $this->Cell(30, 5, "Remarks", "TR", 0, 'C');

        $this->Ln(5);

        $this->SetFont('Arial', '', 5);
        $this->Cell(25, 5, "", 'LBR', 0, 'C');
        $this->Cell(25, 5, "", 'LBR', 0, 'C');

        $this->Cell(5, 5, "", "RB", 0, 'C');

        $this->Cell(9, 5, "Time", 1, 0, 'C');
        //$this->Cell(4.5, 5, "After", 1, 0, 'C');

        $this->Cell(9, 5, "Time", 1, 0, 'C');
        //$this->Cell(4.5, 5, "After", 1, 0, 'C');

        $this->Cell(9, 5, "Time", 1, 0, 'C');
        //$this->Cell(4.5, 5, "After", 1, 0, 'C');

        $this->Cell(9, 5, "", "RB", 0, 'C');

        $this->Cell(5, 5, "", 'LBR', 0, 'C');

        $this->Cell(30, 5, "", "RB", 0, 'C');
        $this->Ln(5);

        $this->SetWidths(array(
            25,
            25,
            5,
            9,
            9,
            9,
            9,
            5,
            30
        ));
    }

    public function frequencyHeader(){
        $caption = array();
        $this->Ln(1);

        $this->SetFont('Arial', '', 5);
        $this->Cell(22, 6, "Generic", 'LTR', 0, 'C');
        $this->Cell(21, 6, "Brand", 'LTR', 0, 'C');

        $this->Cell(10, 6, "Days", "TR", 0, 'C');

        $this->Cell(20, 6, "Frequency", "TR", 0, 'C');

        $this->Cell(7, 6, "Qty", 'RT', 0, 'C');

        
        $this->Cell(12, 6, "Due Date", "TR", 0, 'C');

        $this->Cell(35, 6, "Remarks", "TR", 0, 'C');
        

        $this->Ln(5);

        $this->Cell(22, 1, "", 'LBR', 0, 'C');

        $this->Cell(21, 1, "", 'LBR', 0, 'C');

        $this->Cell(10, 1, "", 'LBR', 0, 'C');

        $this->Cell(20, 1, "", "RB", 0, 'C');

        $this->Cell(7, 1, "", "RB", 0, 'C');
        
        $this->Cell(12, 1, "", "RB", 0, 'C');

        $this->Cell(35, 1, "", "RB", 0, 'C');
        $this->Ln(1);

        $this->SetWidths(array(
            22,
            21,
            10,
            20,
            7,
            12,
            35
        ));
    }

    public function meal()
    {  
        $this->mealHeader();
        foreach ($this->data['query_prescription']  as $key => $item)
        {
            $nkey = $key + 1;
            
            if ($item['frequency_txt'] == null){
                if($nkey==1){
                }
               // $this->check_method = $item['frequency_txt'];
                   // if($nkey<=5){
                        $this->Row(array(
                            $item['generic_name'],
                            $item['medecine_desc'].($item['dosage']!=0&&$item['dosage']!=null&&$item['dosage']!=''? $item['dosage']:''),
                            $item['days'],
                            $item['bf_time'],
                            $item['ln_time'],
                            $item['sp_time'],
                            $item['bbt_time'],
                            $item['quantity'],
                            "SIG: " . $item['instruction']
                        ));
                        
                    
                  //  }
            }
        }
    }

    public function frequency()
    { 
        $this->frequencyHeader();
        foreach ($this->data['query_prescription'] as $key => $item)
        {
            $nkey = $key + 1;
            $this->check_method = $item['frequency_txt'];
            if ($item['frequency_txt'] != null)
            {
                if($nkey==1){
                }
                $this->Row(array(
                    $item['generic_name'],
                    $item['medecine_desc'].($item['dosage']!=0&&$item['dosage']!=null&&$item['dosage']!=''? $item['dosage']:''),
                    $item['days'],
                    $item['frequency_txt'],
                    $item['quantity'],
                    date_format(date_create($item['due']),'F d,Y'),
                    "Sig: " . $item['instruction']
                ));
            }
        }
        $this->Ln(1);
    }

    public function Body()
    {
        $this->SetFont('Arial', '', 7);
        $this->AliasNbPages();
        //$this->SetFont('Arial', 'B', 5);
        $this->Cell(100, 5, "PRESCRIPTIONS:", 0, 1, 'L');
        $this->SetFont('Arial', '', 5);
        $this->meal();
        $this->Ln(5);
        $header = array(
            'Diagnostic',
            'Instruction'
        );
        $this->SetFont('Arial', '', 7);
        $this->AliasNbPages();
        //$this->SetFont('Arial', 'B', 7);
        $this->SetFont('Arial', '', 5);
        $this->frequency();
        $this->Ln(5);
        $header = array(
            'Diagnostic',
            'Instruction'
        );
        $this->SetFont('Arial', '', 5);
        $this->BasicTable($header);
        //$this->Ln(20);
        $this->Ln(3);
        if($this->data['diagnosis']->followup){

            $flwpdt = date_create($this->data['diagnosis']->followup);
            $this->Cell(120,3,"FOLLOW UP CHECK UP IS ON ".date_format($flwpdt,"F d,Y").' AT '.$this->data['diagnosis']->followup_place.' . PLEASE CALL THE CLINIC BEFORE YOUR APPOINMENT.',0,1,'C');
    }
            
    
    }

    function BasicTable($header)
    {
        $this->SetFont('Arial', 'B', 6);

        // Column widths
        $w = array(
            60,
            60
        );

        // Header
        for ($i = 0;$i < count($header);$i++) $this->Cell($w[$i], 5, $header[$i], 1, 0, 'C');
        $this->Ln();

        $this->SetFont('Arial', '', 6);
        $this->SetWidths(array(
            60,
            60
        ));
        foreach ($this->data['query_diagnostic'] as $row)
        {
            $this->Row(array(
                $row['diagnostic'],
                $row['instructions']
            ));
        }
        // Closing line
        $this->Cell(array_sum($w) , 0, '', 'T');
    }

    public function Footer()
    {
        $this->SetY(-17);
        $this->SetFont('Arial', 'B', 5);
        $this->SetFont('Arial', '', 5);        
        $this->Image( $this->data['dctr_details']->signature ,110,188,40,20,'png');    
        $this->cell(105, 3, "", '', 0, 'R');   
        $this->cell(20, 3, strtoupper($this->data['dctr_details']->name), 'B', 1, 'R');
        $this->cell(105, 3, "License No:", '', 0, 'R');
        $this->cell(20, 3, $this->data['dctr_details']->prcno, 'B', 1, 'R');
        $this->cell(105, 3, "PTR. No.", '', 0, 'R');
        $this->cell(20, 3, $this->data['dctr_details']->ptr, 'B', 1, 'R');
        $this->cell(105, 3, "Narcotic Lic. No. (S2)", '', 0, 'R');
        $this->cell(20, 3, "", 'B', 1, 'R');
        $this->cell(105, 3, "Valid Until:", '', 0, 'R');
        $this->cell(20, 3, $this->data['dctr_details']->validity?date_format(date_create($this->data['dctr_details']->validity),'F d,Y'):'', 'B', 1, 'R');
        $this->cell(20, 3, "", 'B', 1, 'R');
        $this->Cell(105, 5, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
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
        for ($i = 0;$i < count($data);$i++) $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0;$i < count($data);$i++)
        {
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
        if ($this->GetY() + $h > $this->PageBreakTrigger) $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw = & $this->CurrentFont['cw'];
        if ($w == 0) $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n") $nb--;
        $sep = - 1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb)
        {
            $c = $s[$i];
            if ($c == "\n")
            {
                $i++;
                $sep = - 1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax)
            {
                if ($sep == - 1)
                {
                    if ($i == $j) $i++;
                }
                else $i = $sep + 1;
                $sep = - 1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else $i++;
        }
        return $nl;
    }

    function FancyRow($data, $border = array() , $align = array() , $style = array() , $maxline = array())
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0;$i < count($data);$i++)
        {
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        if (count($maxline))
        {
            $_maxline = max($maxline);
            if ($nb > $_maxline)
            {
                $nb = $_maxline;
            }
        }
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0;$i < count($data);$i++)
        {
            $w = $this->widths[$i];
            // alignment
            $a = isset($align[$i]) ? $align[$i] : 'L';
            // maxline
            $m = isset($maxline[$i]) ? $maxline[$i] : false;
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            if ($border[$i] == 1)
            {
                $this->Rect($x, $y, $w, $h);
            }
            else
            {
                $_border = strtoupper($border[$i]);
                if (strstr($_border, 'L') !== false)
                {
                    $this->Line($x, $y, $x, $y + $h);
                }
                if (strstr($_border, 'R') !== false)
                {
                    $this->Line($x + $w, $y, $x + $w, $y + $h);
                }
                if (strstr($_border, 'T') !== false)
                {
                    $this->Line($x, $y, $x + $w, $y);
                }
                if (strstr($_border, 'B') !== false)
                {
                    $this->Line($x, $y + $h, $x + $w, $y + $h);
                }
            }
            // Setting Style
            if (isset($style[$i]))
            {
                $this->SetFont('', $style[$i]);
            }
            $this->MultiCell($w, 5, $data[$i], 0, $a, 0, $m);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }
}

