<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="Import Excel Sheet (.xls, .xlsx, .csv) and convert to HTML Table or in Array using PHP and Bootstrap">
<meta name="author" content="S. M. Monjurul Islam (http://srasel.com)">
<link rel="icon" href="">
<title>Excel / Spreadsheet Processor</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<link rel="stylesheet" href="starter-template.css" >
<style>
li {
	padding:5px;
}
</style>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand" href="#">Excel / Spreadsheet Processor</a> </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="http://srasel.com/exceltoweb">EXCEL TO WEB</a></li>
        <li><a target="_blank" href="http://srasel.com/">View Author</a></li>
      </ul>
    </div>
    <!--/.nav-collapse --> 
  </div>
</nav>
<div class="container">
  <div class="starter-template">
  
  
 <h3>Import Excel Sheet (.xls, .xlsx, .csv) and convert to HTML Table or in Array using PHP and Bootstrap </h3>



 <h4><u>If you need to export Microsoft Excel data as a web page (HTML file) Here is the Demo: </u></h4> 
 
 
 
 <hr />
    <div class="panel panel-primary">
      <div class="panel-heading">Excel Sheet (.xls, .xlsx, .csv) to Html Table (Web View) and as Array view.</div>
      
      <div class="panel-body"> 
      
      	
      
      
      	<form class="form-inline" action="" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label class="sr-only" for="exampleInputAmount">Excel File</label>
            <div class="input-group">
              <div class="input-group-addon">Select File</div>
              <input type="file" name="fileToUpload" id="fileToUpload" class="form-control" placeholder="Select File" >
              <div class="input-group-addon">.xls, .xlsx, .csv</div>
            </div>
          </div>
          <button type="submit" name="submit" class="btn btn-primary">Process Spreadsheet</button> 
          <a style="float:right; text-align:right;" target="_blank" class="btn btn-info text-right" href="https://github.com/monjurul-islam/exceltoweb">View Source or Download</a>
        </form>
        <br />
      <div class="alert alert-warning text-right" role="alert">Available for processing Microsoft Excel files(Ex- .xls, .xlsx, .csv etc..)  </div>
      
      	 <?php 
    
			echo '<hr/>';
			
			if(isset($_POST['submit']))
			{
				//  Include PHPExcel_IOFactory
				include '/classes/PHPExcel/IOFactory.php';
								
				$inputFileName = $_FILES["fileToUpload"]["tmp_name"];
				
				$ftype = pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION);
				
				//  Read your Excel workbook
				try {
					$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
					$objReader = PHPExcel_IOFactory::createReader($inputFileType);
					$objPHPExcel = $objReader->load($inputFileName);
							
				} catch(Exception $e) {
					die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
				}
				
				
				if($ftype=='xls' || $ftype=='xlsx' || $ftype=='csv')
				{
					//  Get worksheet dimensions
					$sheet = $objPHPExcel->getSheet(0); 
					$highestRow = $sheet->getHighestRow(); 
					$highestColumn = $sheet->getHighestColumn();
					
					$table = '<table class="table table-bordered">';					
					$thead = '<thead><tr>';	
					$tbody = '';	
					
					//  Loop through each row of the worksheet in turn for printing as table
					for ($row = 1; $row <= $highestRow; $row++)
					{ 
						//  Read a row of data into an array
						$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL,	TRUE, FALSE);					
												
						// processing for table view
						if($row==1)
						{
							foreach($rowData as $header)
							{
								foreach($header as $header_val)
								{
									$thead.= '<th>'.$header_val.'</th>';
								}
							}
						}
						else
						{
							$tbody.= '<tr>';
							foreach($rowData as $body)
							{
								foreach($body as $body_val)
								{
									$tbody.= '<td>'.$body_val.'</td>';
								}								
							}
							$tbody.= '</tr>';
						}											
					}
					
					$thead.= '</tr></thead>';
					
					$table .= $thead.$tbody;
					
					$table.= '</table>';
					
					echo '<h3>Output as HTML Table</h3><hr />';
					
					echo $table.'<hr />';
					
					echo '<h3>Output as PHP Arrays</h3><hr />';
					//  Loop through each row of the worksheet in turn for printing as array
					for ($row = 1; $row <= $highestRow; $row++)
					{ 
						//  Read a row of data into an array
						$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL,	TRUE, FALSE);
						
						echo print_r($rowData).'<br />'; // prints each row as array												
					}
					
								
				}					
			}
			
			?>
        
      
      </div>
    </div>
   
   
   
  </div>
</div>


<footer class="navbar-fixed-bottom footer" style="padding:10px; opacity:.7;"> &copy; 2016 <strong>SB Technology</strong> <span style="float:right;"> Developed By <a href="http://srasel.com" target="_blank">S. M. Monjurul Islam </a> </span> </footer>

<!-- /.container --> 

<!-- Bootstrap core JavaScript
    ================================================== --> 
<!-- Placed at the end of the document so the pages load faster --> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 

<!-- Latest compiled and minified JavaScript --> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>
