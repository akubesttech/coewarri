    <section id="content" role="document">
        <main style="min-height: 168px;">
                    <div class="container">
                        

<div class="row">
    <div class="col-xs-12">
        <div id="breadcrumbs-share">
            <section id="breadcrumbs">
                <ul class="breadcrumb">
                               
      <li><a href=".<?php host(); ?>">Home</a> </li>
                                <li><a href="javascript:void(0);" onclick="window.open('post.php?view=Program','_self')">Go Back</a> </li>

                </ul>
            </section>
        </div>
    </div>
</div>
                    </div>

            

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-md-9">
            <div class="page-title-box">
                <h2 id="pageTitleStub">List Of Department(s) in  <?php echo getfacultyc($_GET['facid']); ?></h2>
                
            </div>
        </div>
    </div>
</div>

<div class="container">

    <div class="row">
     
        <div id="posts_content" class="col-xs-12 col-md-9 margin-lg-bottom link-icons">
        
        
            <div class="row">
                <div class="col-xs-12 primary-content link-icons">
                          <?php
                          //get number of rows
                          $limit = 20;
                          $keywords = $_GET['search'];
                           if(!empty($keywords)){
$whereSQL = "WHERE d_name LIKE '%".$keywords."%' OR  d_faculty LIKE '%".$keywords."%' AND fac_did ='".($_GET['facid'])."' ORDER BY dept_id DESC";
    }else{
$whereSQL = "WHERE  fac_did ='".($_GET['facid'])."' ORDER BY dept_id DESC";
}
  
   $queryNum = mysqli_query($condb,"SELECT COUNT(*) as postNum FROM dept ".$whereSQL);
    $resultNum = mysqli_fetch_assoc($queryNum);
    $rowCount = $resultNum['postNum'];
    
    //initialize pagination class
    $pagConfig = array(
        'totalRows' => $rowCount,
        'perPage' => $limit,
       // 'link_func' => 'searchFilter'
    );
    $pagination =  new Pagination($pagConfig);
                   
			$sql ="SELECT * FROM dept  ";
			if(isset($_GET['search'])){ $sql = $sql . " where (d_name LIKE '%$_GET[search]%' OR  d_faculty LIKE '%$_GET[search]%' ) AND fac_did ='".($_GET['facid'])."' ";
			}else{ $sql = $sql . " where  fac_did ='".($_GET['facid'])."' ";}
			
			$sql = $sql . " ORDER BY dept_id DESC LIMIT $limit";
			$qsql = mysqli_query($condb,$sql); 
			$count = mysqli_num_rows($qsql);
			//if(empty($_GET['search'])){	redirect('post.php?view=q');}
			
		if ($count < 1){ ?>
			<div id="posts_content" class="col-xs-12 col-md-9 margin-lg-bottom link-icons">
        
              <h1 role="banner">Search Results</h1>
            <div class="row">
                <div class="col-xs-12">
                    <div id="searchResults">
                        <div class="margin-md-bottom">
							<a class="search-submit" onclick="document.getElementById('top_search').submit();"></a>
							<form method="get" action="post.php?view=nMore" id="top_search">
								<label for="q2" class="sr-only">Search</label>
								<input class="search-page-control form-control" id="q2" name="search" autocomplete="on" placeholder="Enter search terms" type="text"> <p align='justify'><h4 id="pageTitleStub"><font color="red">Sorry, no results were found.</font></h4></p>
							</form>
						</div>
                    </div>
                   
                </div>
                
            </div>
            
             
        </div>
		<?php	//echo " <p align='justify'>Sorry, no results were found.</p>";
		
			}else{
				while($rs = mysqli_fetch_array($qsql))
			{$newstype = $rs['news_type'];  $eventd = $rs['event_date'];
    $timestamp = strtotime($eventd); $datetime	= date('F', $timestamp);  $datetime2	= date('jS', $timestamp);
 // $datetime	= date('l, jS F Y', $timestamp);
$npostdate	= $rs['publish_date'];
			$newsicon = "<i class='fa fa-file'></i> "; 
		?>
        <div class="row">


                <div class="col-xs-12">
                    
          
                    <h3><?php echo $newsicon; ?><?php echo " ".ucwords($rs['d_name']); ?></h3>
                    <p class="info first-paragraph"><span class="nomargin">&nbsp;</span><span class="nomargin"><strong>Courses Allocated to <?php echo ucwords($rs['d_name']); ?>&nbsp;</strong></span></p>
                    <p align='justify'>
                  				 <?php  
  $sql_coursedisplay = mysqli_query($condb,"select * from courses where dept_c ='".safee($condb,$rs['dept_id'])."'   ")or die (mysqli_error($condb));
  	
  	if(mysqli_num_rows($sql_coursedisplay) > 0){ $number = 1; //$i = 0;
  while($get_proc=mysqli_fetch_array($sql_coursedisplay)){ //if ($i%2) {$class = 'row1';}else {$class = 'row2';}
  $headersubject = $get_proc['C_code']; $headersubject2 = $get_proc['C_title'];
  if($get_proc1 == '')$get_proc1 .= " "."<a target='_blank' $class > (".$number .")  ".$headersubject2." (". $headersubject .") &nbsp;</a> ";
        else
        $get_proc1 .= ", "."<a target='_blank' $class > (".$number .")  ".$headersubject2." (". $headersubject .") &nbsp;</a> ";
  ?> <?php $number ++; } echo $get_proc1;}else{ echo "<font color='red'> unable to Load Course (s) for ".ucwords($rs['d_name'])." . </font>";}?> 
<?php 
 ?>
					 </p>

                </div>
            
        </div><hr>
 <?php }} ?> 
 </div>
            </div>
              <!--  <div class="info first-paragraph"><?php echo $pagination->createLinks(); ?> </div> --!>
             
        </div>
       
        <div class="col-xs-12 col-md-3 margin-lg-bottom sidebar-right">
            <!-- Sidebar space -->
         <!--   
    <div class="apply-box">
        <a class="btn btn-default expand padding-md" href="Our_institution.htm">APPLY NOW</a>
    </div> --!>

<?php include("sidenews.php"); ?>
            <!--    <div class="feature-card">
        <a href="https://applyalberta.ca/media/1086/applyalberta_intro.mp4" target="_blank">
                <img src="Application%20Process%20%20%20ApplyAlberta_files/apply-ab-thumb.png" alt="" class="img-responsive">
        </a>
        <h4>Application Process Video</h4>
            <p>What steps do you need to take to complete your application?</p>
            <a class="btn btn-primary expand" href="https://applyalberta.ca/media/1086/applyalberta_intro.mp4" target="_blank">Watch Video</a>
    </div> --!>

            
        </div>
    </div>
    
</div>
        </main>
    </section>
    