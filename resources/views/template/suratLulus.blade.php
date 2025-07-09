<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Layak Etik</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            margin: 50px;
            line-height: 1.6;
        }
        .center {
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
        }
        .text-center {
            text-align: center;
        }
        .nomor-surat {
            font-size: 11pt;
        }
        .label {
            display: inline-block;
            width: 200px;
            vertical-align: top;
        }
        .colon {
            display: inline-block;
            width: 10px;
        }
        .content {
            display: inline-block;
            width: calc(100% - 210px);
        }
        .paragraph {
            text-align: justify;
            margin-top: 15px;
        }
        .section {
            margin-top: 15px;
        }
        .Judul {
            font-size: 18pt;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="center section Judul">
        SURAT LAYAK ETIK <br>
        <span>RESEARCH ETHIC APPROVAL</span>
    </div>

    <div class="text-center nomor-surat">
        <strong>NOMOR</strong> {{ $nomor_surat }}
    </div>

    <div class="paragraph">
        <p>Protokol penelitian yang diusulkan oleh :</p>
        <p><em>The research protocol proposed by</em></p>
    </div>

    <div class="section">
        <div><span class="label">Nomor Protokol</span><span class="colon">:</span><span class="content">{{ $nomor_protokol }}</span></div>
        <div><span class="label">Peneliti Utama</span><span class="colon">:</span><span class="content">{{ $nama_peneliti }}</span></div>
        <div><span class="label">Nama Lembaga</span><span class="colon">:</span><span class="content">{{ $institusi }}</span></div>
        <div><span class="label">Judul</span><span class="colon">:</span><span class="content">{{ $judul_penelitian }}</span></div>
    </div>

    <div class="paragraph">
        <p>Atas nama Komite Etik Penelitian Kesehatan (KEPK), dengan ini diberikan surat layak etik terhadap
        usulan protokol penelitian, yang didasarkan pada 7 (tujuh) Standar dan Pedoman WHO 2011, dengan
        mengacu pada pemenuhan Pedoman CIOMS 2016.</p>

        <p><em>On behalf of the Research Ethics Committee (REC), I hereby give ethical approval in respect of the undertakings
        contained in the above mention research protocol. The approval is based on 7 (seven) WHO 2011 Standard and
        Guidance part III, namely Ethical Basis for Decision-making with reference to the fulfilment of 2016 CIOMS
        Guideline.</em></p>
    </div>

    <div class="paragraph">
        <p>Kelayakan etik ini berlaku satu tahun efektif sejak tanggal penerbitan, dan usulan perpanjangan
        diajukan kembali jika penelitian tidak dapat diselesaikan sesuai masa berlaku surat kelayakan etik.
        Perkembangan kemajuan dan selesainya penelitian, agar dilaporkan.</p>

        <p><em>The validity of this ethical clearance is one year effective from the approval date. You will be required to apply for
        renewal of ethical clearance on a yearly basis if the study is not completed at the end of this clearance. You will
        be expected to provide mid progress and final reports upon completion of your study. It is your responsibility to
        ensure that all researchers associated with this project are aware of the conditions of approval and which
        documents have been approved.</em></p>
    </div>

    <div class="paragraph">
        <p>Setiap perubahan dan alasannya, termasuk indikasi implikasi etis (jika ada), kejadian tidak diinginkan
        serius (KTD/KTDS) pada partisipan dan tindakan yang diambil untuk mengatasi efek tersebut;
        kejadian tak terduga lainnya atau perkembangan tak terduga yang perlu diberitahukan;
        ketidakmampuan untuk perubahan lain dalam personel penelitian yang terlibat dalam proyek, wajib
        dilaporkan.</p>

        <p><em>You require to notify of any significant change and the reason for that change, including an indication of  ethical
        implications (if any); serious adverse effects on participants and the action taken to address those effects; any
        other unforeseen events or unexpected developments that merit notification; the inability to any other change in
        research personnel involved in the project.</em></p>
    </div>

    <div class="section">
        <div><span class="label">Tanggal</span><span class="colon">:</span><span class="content">{{ $tanggal }}</span></div>
    </div>
</body>
</html>
