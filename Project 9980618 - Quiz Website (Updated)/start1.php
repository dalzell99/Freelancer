<?php include('header.php'); ?>
        <div id="myModal" class="modal fade in">
        <div class="modal-dialog" style="    width: 50%;height: 50%;top: 122px;/* align-items: center; */left: 350px;">
            <div class="modal-content">
 
                <div class="modal-header" style="color:#333">
                   
                    <h4 class="modal-title">Heading</h4>
                </div>
                <div class="modal-body" style="color:#333">
                    <h4>Text in a modal</h4>
                    <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula.</p>
                </div>
                <div class="modal-footer">
                    <div class="btn-group">
                      <button class="btn btn-danger" data-dismiss="modal" style="margin-right:20px;"> OK</button> 
                        <button class="btn btn-danger" data-dismiss="modal"> Cancel</button>
                        
                    </div>
                </div>
 
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dalog -->
    </div>    
             
     <div class=" container-fluid" style=" background: url(images/backgrond.png); min-height:600px;">                
   <div class="container margin-top">
   <span style="box-shadow: 0 0 3px 1px rgba(0,0,0,.35); float: right;" class="btn btn-danger btn-lg"  data-toggle="modal" href="#myModal" >
             End Quiz and Submit Answers</span>
     <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" >
         
             <div class="col-md-2 col-sm-2 col-lg-2"></div>
             <div class="col-md-8 col-sm-10 col-lg-8 text-center">
                <h2 class="quetion">What is 2+4</h2>
                <div class="margin-top qution-bg">6</div>
                 <div class=" qution-bg1">8</div>
                  <div class=" qution-bg1">12</div>
                   <div class=" qution-bg1">2</div>
             </div>

     </div>
     <div class="col-md-5"></div>
     <div class="col-md-2"><span style="" class="btn btn-default btn-md margin-top" >
             <a href="#" style="color:#fff">Skip Quetion</a></span>
             </div> 
             <div class="col-md-2"><span style="" class="btn btn-danger btn-md margin-top" >
           <a href="start1.html" style="color:#fff">Next Quetion</a></span>
             </div>   
       
    </div>
    <div class="container-fluid margin-top" style="margin-top:80px;">
      <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" >
     <div class="col-md-2 col-sm-2 col-lg-2"></div>
     <div class="col-md-8 col-sm-10 col-xs-12 col-lg-8 " style="float:right;">
      <ul class="pagination" style="margin: -57px 36px 69px 133px;
">
  <li><a href="#">«</a></li>
  <li><a class="active"  href="#">1</a></li>
  <li><a href="#">2</a></li>
  <li><a href="#">3</a></li>
  <li><a href="#">4</a></li>
 
  <li><a href="#">»</a></li>
</ul>
</div>
</div>
</div>
</div>
   
   </div>
    
    
  
  </div>
  
<?php include('footer.php'); ?>