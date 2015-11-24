<li>
    <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> لوحه الشؤون الإدارية<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level">
        <li><a href="index.php?c=hcp-plans&r=hcp"> &raquo; الخطط</a></li>
        <li><a href="index.php?c=hcp-timesheet&mid=<?=$lwd['plan_month_id']?>&day_id=<?=$lwd['day_id']?>" title="حضور وانصراف يوم <?=$lwd['week_day_name']?> <?=$lwd['day_order']?> <?=$lwd['ar_month_name']?>"> &raquo; حضور وإنصراف أمس</a></li>
        <li><a href="index.php?c=hcp-contracts"> &raquo; العقود</a></li>
        <!-- <li><a href="index.php?c=hcp-medical"> &raquo; التأمين الصحي</a></li>
        <li><a href="index.php?c=hcp-holidays"> &raquo; الإجازات الرسمية</a></li> -->
        <li>
        	<a href="#"> &raquo; الإجازات</a>
            <ul class="nav nav-second-level">
            	<li><a href="index.php?c=hcp-staffbalances">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &raquo; أرصدة الموظفين</a></li>
                <li><a href="index.php?c=hcp-vacations">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &raquo; تعريف الإجازات</a></li>
            </ul>
        </li>
    </ul>
    <!-- /.nav-second-level -->
</li>