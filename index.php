<?php
    require 'function.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>AbsenCam</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>

    <body onload="configure();">

    <div class="container">
        <div class="smallContain">
            <div id="my_camera"></div>
            <div id="results" style="display: none; position: absolute;">
                <img id="webcamImage">
            </div>
            <form class="form" method="POST">
                <div class="form-group">
                    <input type="text" id="name" name="name" class="input" placeholder="Nama">
                </div>
                <div class="form-group">
                    <input type="text" id="unit" name="unit" class="input" placeholder="Unit">
                </div>
                <div class="form-group">
                    <input type="email" id="email" name="email" class="input" placeholder="Alamat Email">
                </div>
                <button class="btn" type="button" onclick="saveSnap();">Save</button>
            </form>
            <br>
            <br>
        </div>
    </div>

    <div class="absensi">
        <div class="smallContain">
            <table class="tablist">
                <tr>
                    <td>No</td>
                    <td>Waktu</td>
                    <td>Nama</td>
                    <td>Unit</td>
                    <td>Email</td>
                    <td>Absensi</td>
                </tr>
                <?php
                    $i = 1;
                    $rows = mysqli_query($conn, "SELECT * FROM tb_image ORDER BY id DESC");
                ?>
                <?php foreach ($rows as $row) : ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row["date"]; ?></td>
                        <td><?php echo $row["name"]; ?></td>
                        <td><?php echo $row["unit"]; ?></td>
                        <td><?php echo $row["email"]; ?></td>
                        <td><img src="img/<?php echo $row["image"]; ?>" width=200 title="<?php echo $row["image"]; ?>"></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <script type="text/javascript" src="assets/webcam.min.js"></script>
    <script type="text/javascript">
        function configure() {
            Webcam.set({
                width: 560,
                height: 420,
                image_format: "jpeg",
                jpeg_quality: 90
            });
            Webcam.attach("#my_camera");
        }

        function saveSnap() {
            var name = document.getElementById("name").value;
            var unit = document.getElementById("unit").value;
            var email = document.getElementById("email").value;

            var url =  '?name=' + encodeURIComponent(name) + 
                        '&unit=' + encodeURIComponent(unit) + 
                        '&email=' + encodeURIComponent(email);

            Webcam.snap(function(data_uri) {
                document.getElementById("results").style.display = "block";
                document.getElementById("webcamImage").src = data_uri;
            });

            var base64image = document.getElementById("webcamImage").src;
            Webcam.upload(base64image, "function.php" + url, function (code, text) {
                alert("Kehadiran Berhasil Disimpan ✔️");
                window.location.href = url;
            });
        }
    </script>
    </body>
</html>