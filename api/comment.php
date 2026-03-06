<?php

// // Ini Menggunakan File Lokal

// $yourname = $_POST['yourname'];
// $comment = $_POST['comment'];

// // format the comment data into how you want it to be displayed on the page
// $data = $yourname . "|" . $comment . "|\n";

// //Open a text file for writing and save it in a variable of your chosen.    
// //Remember to use "a" not "w" to indicate write. Using 'w' will overwrite 
// // any existing item in the file whenever a new item is written to it.

// $myfile = fopen("comments.txt", "a"); 

// //write the formatted data into the opened file and close it
// fwrite($myfile, $data); 
// fclose($myfile);

// // Reopen the file for reading, echo the content and close the file
// // $myfile = fopen("comment.txt", "r");
// // echo fread($myfile,filesize("comment.txt"));
// $data_array = array("nama" => $yourname, "ucapan" => $comment);

// Ini Menggunakan JsonBin
    $binId = '69aa47e243b1c97be9b864a9';
    $apiKey = '$2a$10$i3qc0nVIX3GX4dQKmOUI5.0usSJOG2NFysIPZ02sQ.SzSZWuabT52';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['comment'])) {
        $ch_get = curl_init("https://api.jsonbin.io/v3/b/$binId/latest");
        curl_setopt($ch_get, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_get, CURLOPT_HTTPHEADER, ["X-Master-Key: $apiKey"]);
        curl_setopt($ch_get, CURLOPT_SSL_VERIFYPEER, false);

        $res_get = curl_exec($ch_get);
        $data_lama = json_decode($res_get, true);

        // Ambil array 'comments' dari record lama, jika belum ada buat array kosong
        $comments_list = $data_lama['record']['comments'];
        // 1. Persiapkan data baru
        $newEntry = [
            'ucapan' => $_POST['comment'], 
            'dari' => $_POST['yourname']
        ];

        // 2. Masukkan ke array comments yang sudah diambil tadi
        $comments_list[] = $newEntry;

        // 3. Bungkus kembali ke dalam objek sebelum dikirim
        $payload = ["comments" => $comments_list];

        $ch = curl_init("https://api.jsonbin.io/v3/b/$binId");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "X-Master-Key: $apiKey"
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $res_put = curl_exec($ch);
        curl_close($ch);
        echo json_encode($res_put, true);

        // header("Location: " . $_SERVER['PHP_SELF']);
        // exit;
    }
?>              
