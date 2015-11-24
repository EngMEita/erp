<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-visible" id="spy1">
                    <div class="panel-heading">
                    
                    </div>
                    <div class="panel-body pn">
                    	<div style="display:block; width:100%; height:auto; margin:auto; margin-top:0px; text-align:center">
                    		<img src="<?=$baseUrl?>temp/enjez/img/JEBREEN.gif" alt="logo" style="width:50%; height:auto;" />
                            <br />
                            <p align="center">مرحبا <a href="index.php?c=profile"><?=$_SESSION['staff']['staff_fullname']?></a> بك في أنجز</p>
                            <br />
                            <input type="button" name="b1" value="&nbsp;&nbsp;صفحتي&nbsp;&nbsp;" onClick="window.location = 'index.php?c=profile';" class="logo-page" />
                            <input type="button" name="b2" value="&nbsp;&nbsp;الرسائل ( <?=$msg?> )&nbsp;&nbsp;" onClick="window.location = 'index.php?c=messages&mod=new';" class="logo-page" />
                            <input type="button" name="b3" value="&nbsp;&nbsp;الإجازات<?php if($intf){ echo " ( ".$ivcs." ) "; } ?>&nbsp;&nbsp;" onClick="window.location = 'index.php?c=hcp-staffvacations';" class="logo-page" />
                            <input type="button" name="b4" value="&nbsp;&nbsp;الأذونات<?php if($intf){ echo " ( ".$ilvs." ) "; } ?>&nbsp;&nbsp;" onClick="window.location = 'index.php?c=hcp-leaves';" class="logo-page" />
                            <input type="button" name="b6" value="&nbsp;&nbsp;التعاميم الإدارية&nbsp;&nbsp;" onClick="window.location = 'index.php?c=ccp-circulars';" class="logo-page" />
                            <input type="button" name="b5" value="&nbsp;&nbsp;بيان الراتب&nbsp;&nbsp;" onClick="window.location = 'index.php?c=salary';" class="logo-page" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>