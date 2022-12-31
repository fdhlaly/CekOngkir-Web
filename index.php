<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "key: 99df37cdb768fee371ae9ac7326b73bb"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
//   echo $response;
$data = json_decode($response);
// echo "<pre>"; print_r($data); echo "</pre>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ongkir App</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="opening container-fluid p-5 text-white text-center">
  <h1>Welcome To Ongkir App</h1>
  <p>Cek Ongkos Kirim Paket Anda Disini !!</p> 
</div>
  
<div class="container-fluid mt-3">
  <div class="row">

  <div class="col-sm-4">
    <div class="card shadow p-3 mb-3 bg-body rounded">
        <div class="card-body">
            <h4 class="card-title">Asal Paket</h4>
            <p>
                Pilih Provinsi Asal </br>
                <select name="provinsi_asal" onchange="cariKotaAsal(this.value)">
                    <option>--Pilih Provinsi--</option>
                    <?php
                        foreach($data->rajaongkir->results as $provinsi){
                        echo '<option value="' . $provinsi->province_id . '">' . $provinsi->province . '</option>';
                        }
                    ?>
                </select>
            </p>
            <p>
                Pilih Kota Asal</br>
                <select name="kota_asal" id="kota_asal">
                    <option>--Pilih Kota--</option>
                </select>
            </p>
        </div>
    </div>
   </div>

   <div class="col-sm-4">
    <div class="card shadow p-3 mb-5 bg-body rounded">
        <div class="card-body">
            <h4 class="card-title">Tujuan Paket</h4>
            <p>
                Pilih Provinsi Tujuan </br>
                <select name="provinsi_tujuan" onchange="cariKotaTujuan(this.value)">
                    <option>--Pilih Provinsi--</option>
                    <?php
                        foreach($data->rajaongkir->results as $provinsi){
                        echo '<option value="' . $provinsi->province_id . '">' .$provinsi->province. '</option>';
                        }
                    ?>
                </select>
            </p>
            <p>
                Pilih Kota Tujuan </br>
                <select name="kota_tujuan" id="kota_tujuan">
                    <option>--Pilih Kota--</option>
                </select>
            </p>
        </div>
    </div>
   </div>


   <div class="col-sm-4">
    <div class="card shadow p-3 mb-5 bg-body rounded">
        <div class="card-body">
            <h4 class="card-title">Berat Paket dan Ekspedisi</h4>
            <p>
                Berat Paket (Dalam Gram) </br>
                <input type="text" id="berat_paket" name="berat_paket">
            </p>
            <p>
                Pilih Ekspedisi </br>
                <select name="kurir" id="kurir">
                    <option value="jne">JNE</option>
                    <option value="tiki">TIKI</option>
                    <option value="pos">Pos Indonesia</option>
                </select>
            </p>
        </div>
    </div>
   </div>




    <div class="container mb-4">
    <div class="row">
    <div class="col-sm-12 d-flex justify-content-center text-center">
    <div class="card shadow p-3 mb-5 bg-body rounded">
        <div class="card-body">
            <p>
                <h3>Cek Ongkos Kirim Anda</h3>
                <input type="submit" name="cari" value="Cek Ongkir" onclick="cekOngkir()">
            </p>
            <div id="hasil">
                <p class="fst-italic">Ongkos Kirim Anda Akan Tampil Disini</p>
            </div>
        </div> 
    </div>
   </div>
    </div>
    </div>
    <div class="button" onclick="goToTop()">Reset</div>
  </div>
</div>


<script>
    function cariKotaAsal(id_provinsi) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200){
            document.getElementById("kota_asal").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "http://localhost/ongkir/dataKota.php?id_provinsi="+id_provinsi, true);
    xmlhttp.send();
   }

   function cariKotaTujuan(id_provinsi){
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200){
        document.getElementById("kota_tujuan").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET","http://localhost/ongkir/dataKota.php?id_provinsi="+id_provinsi, true);
    xmlhttp.send();
   }

   function cekOngkir(){
    var id_kota_asal = document.getElementById("kota_asal").value;
    var id_kota_tujuan = document.getElementById("kota_tujuan").value;
    var berat_paket = document.getElementById("berat_paket").value;
    var kurir = document.getElementById("kurir").value;

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200){
        document.getElementById("hasil").innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "http://localhost/ongkir/dataOngkir.php?id_kota_asal="+id_kota_asal+"&id_kota_tujuan="+id_kota_tujuan+"&berat_paket="+berat_paket+"&kurir="+kurir, true);
    xmlhttp.send();
   }

   const goToTop = () => {
    return location.href = "index.php"
   }
</script>

</body>
</html>
