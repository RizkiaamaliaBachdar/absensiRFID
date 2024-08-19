<!DOCTYPE html>
<html>
<head>
    <?php include "header.php"; ?>
    <title>Scan Kartu</title>

    <script type="text/javascript">
        $(document).ready(function() {
            setInterval(function(){
                $("#cekkartu").load('bacakartu.php')
            }, 5000);
        });    
    </script>

</head>
<body>

    <?php include "menu.php"; ?>

    <div class="container-fluid" style="padding-top: 10%">
        <div id="cekkartu"></div>
    </div>
    <br>

    <?php include "footer.php"; ?>

</body>
</html>