</div>
    <!-- /#wrapper -->

<?php
if(isset($_SESSION['my_data']) && $_SESSION['my_data'] !== $_SESSION['staff']){
	?>
    <p align="center"><i>( أنت هنا ك<?=$_SESSION['staff']['staff_fullname']?> وللرجوع لصفحتك يرجى <a href="index.php?a=logoutas">الضغط هنا</a> )</i></p>
    <?php
}
?>
</body>

</html>
