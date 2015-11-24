		<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-visible" id="spy1">
                        	<div class="panel-heading">
                        		<div class="panel-title hidden-xs"><span class="glyphicon glyphicon-tasks"></span> <a href="index.php?c=acp-staff">الموظفين</a> &raquo; إضافة موظف</div>
                        	</div>
                        	<div class="panel-body pn">
                        		<div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                	<form action="index.php?c=acp-addstaff" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="act" value="addStaff" />
                            		<table class="table table-striped table-hover dataTable no-footer" id="datatable">
                        				<tbody>
                                        	<tr role="row">
                                            	<td align="left"><strong>اسم الدخول</strong>: </td>
                                                <td align="right"><input type="text" name="un" value="" placeholder="username..." pattern=".{8,}" size="16" required></td>
                                                <td align="left"><strong>كلمة المرور</strong>: </td>
                                                <td align="right"><input type="password" name="pw" value="" placeholder="password..." size="16" required></td>
                                            </tr>
                                            <tr role="row">
                                            	<td align="left"><strong>الجوال</strong>: </td>
                                                <td align="right"><input type="text" name="mn" value="" placeholder="05xxxxxxxx" size="20" required></td>
                                                <td align="left"><strong>البريد الإلكتروني</strong>: </td>
                                                <td align="right"><input type="email" name="ue" value="info@ibn-jebreen.com" placeholder="info@ibn-jebreen.com" size="44" required></td>
                                            </tr>
                                            <tr role="row">
                                            	<td align="left"><strong>الاسم الكامل</strong>: </td>
                                                <td align="right"><input type="text" name="fn" value="" placeholder="fullname..." size="44" required></td>
                                                <td align="left"><strong>الاسم المختصر</strong>: </td>
                                                <td align="right"><input type="text" name="sn" value="" placeholder="shortname" size="20"></td>
                                            </tr>
                                            <tr role="row">
                                            	<td align="left"><strong>الصورة الشخصية</strong>: </td>
                                                <td align="right" colspan="3"><input type="file" name="pi" size="64" /></td>
                                            </tr>
                                            <tr role="row">
                                            	<td align="left"><strong>النوع</strong>: </td>
                                                <td align="right">
                                                	<select name="s" size="1">
                                                    	<option value="0">ذكر</option>
                                                        <option value="1">أنثى</option>
                                                    </select>
                                                </td>
                                                <td align="left"><strong>تاريخ الميلاد</strong>: </td>
                                                <td align="right"><input type="text" name="bd" value="" placeholder="1980-01-01" size="10" required="required" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" /></td>
                                            </tr>
                                            <tr role="row">
                                            	<td align="left"><strong>الهوية</strong>: </td>
                                                <td align="right"><input type="number" name="id" value="" placeholder="1xxxxxxxxx" size="10" min="1000000000" max="2999999999" required /></td>
                                                <td align="left"><strong>تاريخ الإنتهاء</strong>: </td>
                                                <td align="right"><input type="text" name="ex" value="" placeholder="1400-01-01" size="10" required="required" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" /></td>
                                            </tr>
                                            <tr role="row">
                                            	<td align="left"><strong>صورة الهوية</strong>: </td>
                                                <td align="right" colspan="3"><input type="file" name="ii" size="64" /></td>
                                            </tr>
                                            <tr role="row">
                                            	<td align="left"><strong>الكفيل</strong>: </td>
                                                <td align="right">
                                                	<select name="ki" size="1">
                                                    <?php foreach($kafeel as $k){ ?>
                                                    <option value="<?=$k['kafeel_id']?>"><?=$k['kafeel_name']?></option>
                                                    <?php } ?>
                                                    </select>
                                                </td>
                                                <td align="left"><strong>الجنسية</strong>: </td>
                                                <td align="right">
                                                	<select name="ci" size="1">
                                                    <?php foreach($countries as $k){ ?>
                                                    <option value="<?=$k['country_id']?>"><?=$k['country_name']?> ( <?=$k['country_nationality']?> )</option>
                                                    <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr role="row">
                                            	<td align="left"><strong>العنوان</strong>: </td>
                                                <td align="right" colspan="3"><textarea name="ad" cols="50" rows="3"></textarea></td>
                                            </tr>
                                        	<tr role="row">
                                                <td colspan="4" align="center"><input type="submit" name="save" value="حفظ" /><input type="reset" name="cancel" value="إلغاء" /></td>
                                            </tr>
                        				</tbody>
                        			</table>
                                    </form>
                        
                        </div>
                        </div>
                        </div>
                        </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>