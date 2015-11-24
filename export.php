<?php
switch($_GET['a']){
	case 'excel':
		header("Content-type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="'.date("Ymd_His").'_anjez.xls"');
		readfile(urldecode($_GET['f']));
	break;
	case 'word':
		header("Content-type: application/vnd.ms-word");
		header('Content-Disposition: attachment; filename="'.date("Ymd_His").'_anjez.doc"');
		readfile(urldecode($_GET['f']));
	break;
	case 'pdf':
		/*ob_start();
    	include(urldecode($_GET['f']));
    	$content = ob_get_clean();*/
		
		$file = fopen(urldecode($_GET['f']), 'r');
		$content = fread($file, filesize(urldecode($_GET['f'])));
		fclose($file);
		require_once('inc/html2pdf/html2pdf.class.php');
		try
		{
			$html2pdf = new HTML2PDF('Landscape', 'A4', 'en', TRUE, 'utf-8');
			$html2pdf->setDefaultFont('almohanad');
    		$html2pdf->pdf->SetDisplayMode('real');
			$html2pdf->writeHTML(str_replace('dir="rtl"', 'dir="ltr"', $content));
			$html2pdf->Output(date("Ymd_His").'_anjez.pdf');
		}
		catch(HTML2PDF_exception $e) {
			echo $e;
			exit;
		}
	break;
	case 'print':
	default:
		readfile(urldecode($_GET['f']));
		?>
        <script type="text/javascript">
		window.print();
		window.close();
		</script>
        <?php
	break;
}
?>