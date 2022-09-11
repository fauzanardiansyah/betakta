<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title> Sertifikat-{!! str_limit(strtoupper($nm_bu), 46, ',') !!} </title>
    {{-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href=" {{ asset('assets/main.css') }} " >
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   
       
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet"> --}}

    <style type="text/css">
        
        * {
            font-family: Roboto,  sans-serif;  
        }
        div{
            margin:0;
            padding:0;
        }
        h1,h2,h3,h4,h5,h6{
            font-family: Roboto,sans-serif;         
            margin: 0; 
            padding: 0; 
            border: 0; 
        }
        .f14{
            font-size: 14px;
        }
        .f12{
            font-size: 12px;
        }
        .f10{
            font-size: 10px;
        }
        .f11{
            font-size: 11px;
        }
        .normal{
            font-weight: normal;
        }
        table { 
          border-collapse: collapse; border-spacing: 0; /* cellspacing */
        }

        th, td { 
          padding: 3px;  /* cellpadding */
          margin: 3px;
        }

        .color_b {
            background-color: #B0C4DE
        }
        .bold{
            font-weight: bold;
        }
        

    </style>
</head>

<body style="background-color: #fff;">
<div style="padding:20px;background: #ecf0f1;margin:30px;">
      <table width="100%">
        <tr>
            <td style="text-align: center;"  width="10%">
                <img src="{{ asset('assets-kta/ktaV3/') }}/assets/logo.png" width="120" height="120">
                <br>
                
            </td>
            <td width="80%" style="text-align: center;">

                <h5>KARTU TANDA ANGGOTA </h5>
                <h5>IKATAN NASIONAL KONSULTAN INDONESIA</h5>
                <h5>(National Association of Indonesian Consultants) </h5>
            </td>
            
        </tr>
      </table>
      <hr>
      <div style="margin-bottom: 20px;margin-top: 20px;">
          <table>
              <tr>
                  <td style="text-align: justify;">
                    Berdasarkan ketentuan Anggaran Dasar Bab VII Pasal 12 dan Anggaran Rumah Tangga Bab III Pasal 9, maka bersama ini Dewan
                    Pengurus Nasional INKINDO menetapkan dan menerangkan perusahaan yang sudah memenuhi persyaratan untuk menjadi anggota
                    dengan keterangan sebagai berikut :
                  </td>
              </tr>
          </table>
      </div>

      <table cellpadding="0" cellspacing="0" width="100%">
          <tr>
              <td width="50%">
                <table cellspacing="0" cellspacing="0" width="90%" style="padding-bottom: 9px !important">
                    <tr>
                        <td width="30%">Nomor Keanggotaan</td>
                        <td width="5%"> :</td>
                        <td width="65%">   {{$no_kta}} </td>
                    </tr>
                    <tr>
                        <td>Dewan Pengurus </td>
                        <td> : </td>
                        <td>{{strtoupper($province_name)}}</td>
                    </tr>

                    <tr>
                        <td>Nama Badan Usaha</td>
                        <td> : </td>
                        <td>{!! str_limit(strtoupper($nm_bu), 100, ',') !!}</td>
                    </tr>

                    <tr>
                        <td> Alamat </td>
                        <td> : </td>
                        <td>{!! str_limit(ucwords($alamat), 50,",") !!} Kecamatan {!! ucwords($kecamatan) !!}, {!! ucwords($kota) !!}</td>
                    </tr>
                    <tr>
                        <td>Telepon / Fax</td>
                        <td> : </td>
                        <td>{!! ($no_telp) !!} / {!! $result = (!empty($no_fax)) ? $no_fax : ''; !!}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td> : </td>

                        <td>{!! ($email_bu) !!}</td>
                    </tr>
                    <tr>
                        <td>Website</td>
                        <td> : </td>
                        <td>{!! ($website) !!}</td>
                    </tr>  

                    <tr>
                        <td>Penaggung Jawab</td>
                        <td> : </td>
                        <td>{!! ($nm_pjbu) !!}</td>
                    </tr>
                </table>
              </td>
              <td width="10%">
                  <table width="100%">
                    <tr>
                        <td width="15%" class="text-right align-top">
                            <img src="{{ asset('storage/legalitas-files/'.$file_foto_pjbu) }}"
                        style="width:142px; height:169px">
                        </td>
                    </tr>
                  </table>
              </td>
          </tr>
          <tr>
              
          </tr>

      </table>
      


        <div style="margin-bottom: 10px;margin-top: 10px">
            <table width="100%">
              <tr>
                  <td align="center" style="text-align: center;"> <center style="font-weight: bold;text-align: center">ADALAH ANGGOTA IKATAN NASIONAL KONSULTAN INDONESIA DENGAN STATUS KEANGGOTAAN
                    <br>
                  </center></td>
              </tr>
            </table>
        </div>


    <table width="100%" border="0">
        <tbody>
            <tr>
                <td style=" text-align: center;" colspan="2">
                    <div style="text-align: center;font-weight: bold;" >
                         Dewan Pengurus Provinsi {!! strtoupper($province_name) !!}
                    </div>
                </td>
                <td style="width: 45%; height: 50px; text-align: center;">
                    <div style="text-align: center;">
                        Berlaku sampai dengan tanggal
                    </div>
                    <div style="font-weight: bold;">
                        {!! App\Helpers\LocalDate::toIndonesia($masa_berlaku) !!}
                    </div>
                </td>
                
                <td style=" text-align: center;" colspan="2">
                    <div style="text-align: center;font-weight: bold;" >
                        Disahkan dan diregistrasi :  <br> Jakarta {!! App\Helpers\LocalDate::toIndonesia($tgl_terbit) !!},<br> Dewan Pengurus Nasional
                    </div>
                </td>
                
            </tr>
            <tr>
                <td style="width: 15%; height: 50px;">&nbsp;</td>
                <td style="width: 15.5639%; height: 50px;">&nbsp;</td>
            </tr>
            <tr>
                
                <td style="width: 15.4361%; height: 50px;text-align: center;">
                    <div>
                        <img class="" style="width: 60px;" src="{{ asset('storage/signature/'.$ttd_ketua_provinsi) }}">
                    </div>
                    <div style="font-weight: bold;">{!! $nm_ketua_provinsi !!}</div> <br>Ketua
                </td>
                <td style="width: 0%; height: 50px;text-align: center;">
                    <div>
                        <img class="" style="width: 60px;" src="{{ asset('storage/signature/'.$ttd_sekretaris_provinsi) }}">
                    </div>
                    <div style="font-weight: bold;">{!! $nm_sekretaris_provinsi !!}</div> <br>Sekretaris
                </td>  



               

                <td style="width: 0%; height: 50px;text-align: center;">
                    <div>
                        <img class="" style="width: 60px;" src="{{ asset('storage/signature/'.$ttd_ketum) }}">
                    </div>
                    <div style="font-weight: bold;">{!! $nm_ketum !!}</div> <br>Ketua Umum
                </td>
                <td style="width: 0%; height: 50px;text-align: center;">
                    <div>
                        <img class="" style="width: 60px;" src="{{ asset('storage/signature/'.$ttd_sekjen) }}">
                    </div>
                    <div style="font-weight: bold;">{!! $nm_sekjen !!}</div> <br>Sekretaris Jenderal
                </td>
            </tr>
        </tbody>
    </table>

</div>
{{-- 
  <table>
      <tr>
            <td style="border-style: dotted;text-align: center;" width="5%" rowspan="3">
              Pas Foto
              <br>
               3 x 4 cm 
               <br>
                Dirut/Pimpinan 
                <br>
                Badan Usaha 
            </td>
            <td width="45%">
                <div style="margin-left: 100px;margin-right: 500px">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td>Sertifikat ini telah diregistrasi pada <br> 
                                Kamar Dagang dan Industri Indonesia <hr>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Kamar Dagang dan Industri Indonesia 
                            </td>
                        </tr>
                        <tr>

                            <td>
                                <div style="margin-top: 50px;text-align: center;">
                                    <br>
                                    Ketua Umum
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
            <td width="50%" style="text-align: center;"> Ditetapkan di Jakarta <br> Pada tanggal :  31 Januari 2008 <br>
            Dewan Pengurus Nasional <br> Ikatan Nasional Konsultan Indonesia</td>
      </tr>
  </table>

 --}}

</body>

</html>