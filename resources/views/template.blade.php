<x-Layout>
    <x-slot:title>Template Dokumen Peneliti</x-slot:title>
  
    <div>
  
      <p class="text-gray-600 mb-8">
        Silakan unduh dan gunakan template dokumen berikut sesuai kebutuhan dalam pengajuan protokol penelitian.
      </p>
  
      <div class="space-y-6">

        {{-- Surat Permohonan --}}
        <x-template-card 
          title="Template Surat Permohonan"
          description="Dokumen resmi yang menyatakan permohonan kepada Komite Etik Penelitian Kesehatan (KEPK) untuk melakukan peninjauan protokol penelitian. Wajib ditandatangani oleh peneliti utama." 
          filename="template-surat-permohonan-etik.docx" />
      
        {{-- Surat Pernyataan Komitmen --}}
        <x-template-card 
          title="Template Surat Pernyataan Komitmen"
          description="Berisi pernyataan integritas dan tanggung jawab peneliti utama atas pelaksanaan penelitian, termasuk kepatuhan terhadap prinsip-prinsip etik dan perlindungan subjek penelitian." 
          filename="template-surat-pernyataan-komitmen-etik.docx" />
      
        {{-- CV Peneliti Dosen --}}
        <x-template-card 
          title="Curriculum Vitae Peneliti (Dosen)"
          description="Format daftar riwayat hidup untuk dosen yang terlibat sebagai peneliti, mencakup informasi akademik, pengalaman penelitian, publikasi, dan peran dalam proyek." 
          filename="CURICULLUM-VITAE-PENELITI-dosen.docx" />
      
        {{-- CV Peneliti Utama --}}
        <x-template-card 
          title="Curriculum Vitae Peneliti Utama"
          description="Daftar riwayat hidup peneliti utama yang bertanggung jawab penuh atas protokol penelitian. Digunakan untuk menilai kompetensi dan rekam jejak peneliti." 
          filename="CURICULLUM-VITAE-PENELITI-UTAMA.docx" />
      
        {{-- Inform Consent --}}
        <x-template-card 
          title="Inform Consent Penelitian"
          description="Dokumen persetujuan tertulis yang diberikan kepada partisipan penelitian untuk memahami tujuan, manfaat, risiko, serta hak dan kewajiban sebelum mereka setuju untuk berpartisipasi." 
          filename="INFORM-CONSENT-PERNYATAAN-PERSETUJUAN.docx" />
      
        {{-- Protokol Etik Kualitatif --}}
        <x-template-card 
          title="Protokol Etik - Kualitatif Observasional"
          description="Format protokol untuk penelitian observasional yang bersifat kualitatif, termasuk latar belakang, tujuan, metode pengumpulan data, perlindungan data, dan pertimbangan etik lainnya." 
          filename="PROTOKOL-ETIK-PENELITIAN-KUALITATIF-OBSERVASIONAL.docx" />
      
        {{-- Protokol Etik Kuantitatif --}}
        <x-template-card 
          title="Protokol Etik - Kuantitatif Intervensi"
          description="Format protokol untuk penelitian kuantitatif dengan intervensi, mencakup desain penelitian, sampel, instrumen, prosedur intervensi, dan justifikasi etik terkait risiko dan manfaat." 
          filename="PROTOKOL-ETIK-PENELITIAN-KUANTITATIF-INTERVENSI.docx" />
      
        {{-- Pedoman PSP --}}
        <div class="bg-white border rounded-lg p-4 shadow">
          <div class="flex justify-between items-center mb-2">
            <div>
              <h2 class="text-lg font-semibold text-gray-800">Pedoman Pengajuan Protokol (PDF)</h2>
              <p class="text-sm text-gray-600">
                Panduan lengkap mengenai prosedur, persyaratan, dan kelengkapan dokumen yang harus dipenuhi oleh peneliti sebelum mengajukan protokol ke KEPK.
              </p>
            </div>
            <a href="{{ url('/template/view/Pedoman-PSP.pdf') }}"
              class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700"
              target="_blank">
              Download
            </a>
          </div>
          <div class="mt-4 border rounded overflow-hidden">
            <iframe src="{{ url('/template/view/Pedoman-PSP.pdf') }}"
              class="w-full h-96"
              frameborder="0"></iframe>
          </div>
        </div>
      
        {{-- CIOMS Guidelines --}}
        <div class="bg-white border rounded-lg p-4 shadow">
          <div class="flex justify-between items-center mb-2">
            <div>
              <h2 class="text-lg font-semibold text-gray-800">CIOMS Ethical Guidelines (PDF)</h2>
              <p class="text-sm text-gray-600">
                Panduan etik internasional dari WHO dan CIOMS (Council for International Organizations of Medical Sciences) untuk penelitian biomedis yang melibatkan manusia. Dijadikan acuan etik dalam kajian protokol.
              </p>
            </div>
            <a href="{{ url('/template/view/2016-WHO-CIOMS-Ethical-Guidelines.pdf') }}"
              class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700"
              target="_blank">
              Download
            </a>
          </div>
          <div class="mt-4 border rounded overflow-hidden">
            <iframe src="{{ url('/template/view/2016-WHO-CIOMS-Ethical-Guidelines.pdf') }}"
              class="w-full h-96"
              frameborder="0"></iframe>
          </div>
        </div>
      
      </div>
      
    </div>
  </x-Layout>
  