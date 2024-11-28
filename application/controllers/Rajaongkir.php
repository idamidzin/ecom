<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rajaongkir extends CI_Controller
{
    private $api_key = 'ad6f75cae274cc79ae3d0cd18aba96e5';

    public function provinsi()
    {
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
                "key: $this->api_key"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $array_response = json_decode($response, true);
            echo "<option hidden value=''>-- Pilih Provinsi --</option>";
            $data_provinsi = $array_response['rajaongkir']['results'];
            foreach ($data_provinsi as $key => $value) {
                echo "<option value='" . $value['province_id'] . "' id_provinsi='" . $value['province_id'] . "'>" . $value['province'] . "</option>";
            }
        }
    }

    public function kota()
    {
        $provinsi_set = $this->input->post('id_provinsi');

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=" . $provinsi_set,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: $this->api_key"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $array_response = json_decode($response, true);
            echo "<option hidden value=''>-- Pilih Kota --</option>";
            $data_kota = $array_response['rajaongkir']['results'];
            foreach ($data_kota as $key => $value) {
                echo "<option value='" . $value['city_id'] . "'>" . $value['city_id'] . ' - ' . $value['city_name'] . "</option>";
            }
        }
    }

    public function ekspedisi()
    {
        $ekspedisi_list = [
            'jne' => 'JNE',
            'tiki' => 'TIKI',
            'pos' => 'POS Indonesia',
            // 'jnt' => 'J&T Express',
            // 'sicepat' => 'Sicepat',
            // 'anteraja' => 'Anteraja',
            'gogo' => 'Gojek (GO-SEND)',
            'grab' => 'Grab (GrabSend)'
        ];

        echo "<option hidden value=''>-- Pilih Ekspedisi --</option>";

        foreach ($ekspedisi_list as $key => $value) {
            echo "<option value='$key'>$value</option>";
        }
    }

    public function ongkir()
    {
        // Mendapatkan data dari POST request
        $origin = $this->input->post('origin'); // ID kota asal
        $destination = $this->input->post('destination'); // ID kota tujuan
        $weight = $this->input->post('weight'); // Berat barang dalam gram
        $courier = $this->input->post('courier'); // Ekspedisi yang dipilih (misalnya 'jne', 'jnt', dll)

        // API URL untuk mengakses perhitungan ongkir
        $url = "https://api.rajaongkir.com/starter/cost";
        
        // Data yang akan dikirim melalui POST request
        $data = array(
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier
        );

        // Inisialisasi cURL
        $curl = curl_init();

        // Menyiapkan cURL dengan data dan header
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($data), // Kirimkan data POST
            CURLOPT_HTTPHEADER => array(
                "key: $this->api_key"
            ),
        ));

        // Eksekusi cURL
        $response = curl_exec($curl);
        $err = curl_error($curl);

        // Tutup koneksi cURL
        curl_close($curl);

        // Jika ada error cURL
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            // Menguraikan response JSON
            $array_response = json_decode($response, true);
            
            // Mengecek apakah response mengandung data ongkir
            if (isset($array_response['rajaongkir']['results'][0]['costs'])) {
                echo json_encode($array_response['rajaongkir']['results'][0]['costs']);
                // Menampilkan hasil ongkir
                // echo "<option hidden value=''>Pilih Layanan</option>";
                // foreach ($array_response['rajaongkir']['results'][0]['costs'] as $cost) {
                //     echo "<option value='" . $cost['service'] . "'>";
                //     echo $cost['service'] . " - IDR " . number_format($cost['cost'][0]['value'], 0, ',', '.');
                //     echo "</option>";
                // }
            } else {
                // echo "<option>No service available</option>";
                echo json_encode([]);
            }
        }
    }
}
