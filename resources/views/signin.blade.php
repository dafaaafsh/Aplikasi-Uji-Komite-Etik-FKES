<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar Akun Peneliti | UNUJA</title>
  <link rel="icon" type="image/png" href="https://upload.wikimedia.org/wikipedia/commons/f/fa/Logo-UNUJA.png">
  @vite('resources/css/app.css')
  <style>
    body {
      background: linear-gradient(135deg, #e0e7ff 0%, #f0fdfa 100%);
    }
    .form-step { transition: opacity 0.3s ease, transform 0.3s ease; }
    .form-step.hidden { opacity: 0; transform: translateX(20px); pointer-events: none; position: absolute; }
    .step-circle {
      box-shadow: 0 2px 8px 0 rgba(59,130,246,0.08);
      transition: background 0.2s, color 0.2s;
    }
    .step-circle.active {
      border: 2px solid #38bdf8;
      box-shadow: 0 4px 16px 0 rgba(59,130,246,0.15);
      background: linear-gradient(135deg, #2563eb 60%, #38bdf8 100%);
    }
    .glass {
      background: rgba(255,255,255,0.85);
      backdrop-filter: blur(8px);
    }
    .fade-in {
      animation: fadeInKtp 0.6s;
    }
    @keyframes fadeInKtp {
      from { opacity: 0; transform: scale(0.95);}
      to   { opacity: 1; transform: scale(1);}
    }
    @keyframes spin {
      to { transform: rotate(360deg); }
    }
    .animate-spin {
      animation: spin 0.7s linear infinite;
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center">

<div class="glass shadow-2xl rounded-2xl w-full max-w-sm p-4 sm:p-6 relative overflow-hidden border border-blue-100">
  <div class="flex flex-col items-center mb-2">
    <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Logo-UNUJA.png" alt="UNUJA" class="w-12 h-12 mb-1 drop-shadow-lg">
    <h2 class="text-lg sm:text-xl font-extrabold text-blue-700 mb-1 tracking-tight">Daftar Akun Peneliti</h2>
    <p class="text-xs text-gray-500 mb-2">Gabung dan mulai penelitianmu bersama UNUJA</p>
  </div>

  <!-- Stepper -->
  <div class="mb-4">
    <div class="w-full bg-blue-100 rounded-full h-2 mb-2 overflow-hidden">
      <div id="progressBar" class="bg-blue-500 h-2 transition-all duration-300" style="width:0%"></div>
    </div>
    <div class="flex justify-between items-center relative">
      <div class="absolute top-1/2 left-0 right-0 h-1 bg-gradient-to-r from-blue-200 via-blue-400 to-blue-200 -z-10"></div>
      <div id="stepIndicators" class="flex justify-between w-full">
        <div class="step-circle bg-blue-600 text-white w-7 h-7 flex items-center justify-center rounded-full text-xs font-bold shadow-md">1</div>
        <div class="step-circle bg-gray-300 text-gray-600 w-7 h-7 flex items-center justify-center rounded-full text-xs font-bold shadow-md">2</div>
        <div class="step-circle bg-gray-300 text-gray-600 w-7 h-7 flex items-center justify-center rounded-full text-xs font-bold shadow-md">3</div>
        <div class="step-circle bg-gray-300 text-gray-600 w-7 h-7 flex items-center justify-center rounded-full text-xs font-bold shadow-md">4</div>
        <div class="step-circle bg-gray-300 text-gray-600 w-7 h-7 flex items-center justify-center rounded-full text-xs font-bold shadow-md">5</div>
      </div>
    </div>
    <div class="flex justify-between text-[10px] mt-1 text-blue-700 font-semibold">
      <span>Akun</span>
      <span>Info Diri</span>
      <span>Afiliasi</span>
      <span>Upload</span>
      <span>Review</span>
    </div>
  </div>

  @if ($errors->any())
    <div class="mb-4 flex items-start gap-2 px-4 py-2 bg-red-50 border border-red-400 rounded-lg text-red-700 text-sm shadow-sm">
      <svg class="w-5 h-5 mt-0.5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M12 5.5a7 7 0 1 1 0 13.999A7 7 0 0 1 12 5.5z"/>
      </svg>
      <div>
        @foreach ($errors->all() as $item)
          <div>{{ $item }}</div>
        @endforeach
      </div>
    </div>
  @endif

  <div id="passwordMismatchMsg" class="hidden mb-4 flex items-start gap-2 px-4 py-2 bg-red-50 border border-red-400 rounded-lg text-red-700 text-sm shadow-sm">
    <svg class="w-5 h-5 mt-0.5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M12 5.5a7 7 0 1 1 0 13.999A7 7 0 0 1 12 5.5z"/>
    </svg>
    <div>
      Password dan konfirmasi password tidak sama.
    </div>
  </div>

  <div id="emailExistsMsg" class="hidden mb-4 flex items-start gap-2 px-4 py-2 bg-red-50 border border-red-400 rounded-lg text-red-700 text-sm shadow-sm">
    <svg class="w-5 h-5 mt-0.5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M12 5.5a7 7 0 1 1 0 13.999A7 7 0 0 1 12 5.5z"/>
    </svg>
    <div>
      Email sudah terdaftar, silakan gunakan email lain.
    </div>
  </div>

  <form action="/signin" method="POST" id="multiStepForm" enctype="multipart/form-data" class="relative min-h-[220px]">
    @csrf

    <!-- STEP 1: Info Akun -->
    <div class="form-step" id="step-1">
      <label class="block text-sm mb-1 font-semibold text-blue-700">Email</label>
      <input type="email" id="email" name="email" required class="w-full border-2 border-blue-100 rounded-lg px-3 py-2 mb-2 text-sm focus:ring-2 focus:ring-blue-400 bg-blue-50">

      <label class="block text-sm mb-1 font-semibold text-blue-700">Kata Sandi</label>
      <input type="password" id="password" name="password" minlength="6" required class="w-full border-2 border-blue-100 rounded-lg px-3 py-2 mb-2 text-sm focus:ring-2 focus:ring-blue-400 bg-blue-50">

      <label class="block text-sm mb-1 font-semibold text-blue-700">Konfirmasi Kata Sandi</label>
      <input type="password" id="password_confirmation" name="password_confirmation" minlength="6" required class="w-full border-2 border-blue-100 rounded-lg px-3 py-2 text-sm bg-blue-50">

      <div class="mt-5 flex justify-end">
        <button type="button" onclick="nextStep()" class="bg-gradient-to-r from-blue-600 to-blue-400 text-white px-6 py-2 rounded-lg text-sm font-bold shadow hover:from-blue-700 hover:to-blue-500 transition">Next</button>
      </div>
    </div>

    <!-- STEP 2: Info Diri -->
    <div class="form-step hidden" id="step-2">
      <label class="block text-sm mb-1 font-semibold text-blue-700">Nama Lengkap</label>
      <input type="text" id="name" name="name" required class="w-full border-2 border-blue-100 rounded-lg px-3 py-2 mb-2 text-sm focus:ring-2 focus:ring-blue-400 bg-blue-50">

      <label class="block text-sm mb-1 font-semibold text-blue-700">No HP</label>
      <input type="tel" id="nohp" name="nohp" required pattern="[0-9]{10,15}" class="w-full border-2 border-blue-100 rounded-lg px-3 py-2 mb-2 text-sm focus:ring-2 focus:ring-blue-400 bg-blue-50" placeholder="08xxxxxxxxxx">

      <label class="block text-sm mb-1 font-semibold text-blue-700">Alamat</label>
      <textarea id="alamat" name="alamat" required class="w-full border-2 border-blue-100 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 bg-blue-50" rows="2"></textarea>

      <div class="mt-5 flex justify-between">
        <button type="button" onclick="prevStep()" class="bg-gray-400 text-white px-6 py-2 rounded-lg text-sm font-bold shadow hover:bg-gray-500 transition">Previous</button>
        <button type="button" onclick="nextStep()" class="bg-gradient-to-r from-blue-600 to-blue-400 text-white px-6 py-2 rounded-lg text-sm font-bold shadow hover:from-blue-700 hover:to-blue-500 transition">Next</button>
      </div>
    </div>

    <!-- STEP 3: Afiliasi -->
    <div class="form-step hidden" id="step-3">
      <label class="block text-sm mb-1 font-semibold text-blue-700">Status Peneliti</label>
      <select id="status" name="status" required class="w-full border-2 border-blue-100 rounded-lg px-3 py-2 mb-2 text-sm focus:ring-2 focus:ring-blue-400 bg-blue-50">
        <option value="">-- Pilih Status --</option>
        <option value="Mahasiswa (S1)">Mahasiswa (S1)</option>
        <option value="Mahasiswa (S2)">Mahasiswa (S2)</option>
        <option value="Mahasiswa (S3)">Mahasiswa (S3)</option>
        <option value="Dosen">Dosen</option>
        <option value="Peneliti Umum">Peneliti Umum</option>
      </select>

      <label class="block text-sm mb-1 font-semibold text-blue-700">Asal Peneliti</label>
      <select id="asal" name="asal" required class="w-full border-2 border-blue-100 rounded-lg px-3 py-2 mb-2 text-sm focus:ring-2 focus:ring-blue-400 bg-blue-50">
        <option value="">-- Pilih Asal --</option>
        <option value="UNUJA">UNUJA</option>
        <option value="Eksternal">Eksternal</option>
      </select>

      <label class="block text-sm mb-1 font-semibold text-blue-700">Institusi</label>
      <input type="text" id="institusi" name="institusi" required class="w-full border-2 border-blue-100 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 bg-blue-50">

      <div class="mt-5 flex justify-between">
        <button type="button" onclick="prevStep()" class="bg-gray-400 text-white px-6 py-2 rounded-lg text-sm font-bold shadow hover:bg-gray-500 transition">Previous</button>
        <button type="button" onclick="nextStep()" class="bg-gradient-to-r from-blue-600 to-blue-400 text-white px-6 py-2 rounded-lg text-sm font-bold shadow hover:from-blue-700 hover:to-blue-500 transition">Next</button>
      </div>
    </div>

    <!-- STEP 4: Upload KTP -->
    <div class="form-step hidden" id="step-4">
      <p class="mb-1 text-sm font-semibold text-blue-700">Upload KTP</p>
      <input type="file" id="ktp" name="ktp" accept="image/*,.pdf" required class="mb-2 text-xs bg-blue-50 border-2 border-blue-100 rounded-lg px-2 py-1">
      <div id="ktpLoading" class="hidden flex items-center gap-2 mb-2">
        <span class="inline-block w-5 h-5 border-2 border-blue-400 border-t-transparent rounded-full animate-spin"></span>
        <span class="text-xs text-blue-500">Memproses gambar...</span>
      </div>

      <p class="text-xs text-blue-500 mb-4">Data yang Anda upload akan <strong>aman</strong> dan dilindungi.</p>

      <div class="flex justify-between mt-4">
        <button type="button" onclick="prevStep()" class="bg-gray-400 text-white px-6 py-2 rounded-lg text-sm font-bold shadow hover:bg-gray-500 transition">Previous</button>
        <button type="button" onclick="nextStep()" class="bg-gradient-to-r from-blue-600 to-blue-400 text-white px-6 py-2 rounded-lg text-sm font-bold shadow hover:from-blue-700 hover:to-blue-500 transition">Next</button>
      </div>
    </div>

    <!-- STEP 5: Review -->
    <div class="form-step hidden" id="step-5">
      <div class="flex items-center mb-3">
        <svg class="w-6 h-6 text-blue-500 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3"></path>
          <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"></circle>
        </svg>
        <p class="font-semibold text-sm text-blue-700">Review Data Anda Sebelum Submit</p>
      </div>
      <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4 shadow-sm">
        <ul class="text-sm space-y-2">
          <li><span class="font-bold text-blue-700">Email:</span> <span id="reviewEmail"></span></li>
          <li><span class="font-bold text-blue-700">Nama:</span> <span id="reviewName"></span></li>
          <li><span class="font-bold text-blue-700">No HP:</span> <span id="reviewNoHP"></span></li>
          <li><span class="font-bold text-blue-700">Alamat:</span> <span id="reviewAlamat"></span></li>
          <li><span class="font-bold text-blue-700">Status Peneliti:</span> <span id="reviewStatus"></span></li>
          <li><span class="font-bold text-blue-700">Asal Peneliti:</span> <span id="reviewAsal"></span></li>
          <li><span class="font-bold text-blue-700">Institusi:</span> <span id="reviewInstitusi"></span></li>
          <li>
            <span class="font-bold text-blue-700">KTP:</span>
            <span id="reviewKTP"></span>
            <div id="reviewKTPPreview" class="mt-2"></div>
          </li>
        </ul>
      </div>
      <div class="flex justify-between mt-4">
        <button type="button" onclick="prevStep()" class="bg-gray-400 text-white px-6 py-2 rounded-lg text-sm font-bold shadow hover:bg-gray-500 transition">Previous</button>
        <button type="submit" class="bg-gradient-to-r from-green-600 to-green-400 text-white px-6 py-2 rounded-lg text-sm font-bold shadow hover:from-green-700 hover:to-green-500 transition">Daftar</button>
      </div>
    </div>
  </form>
  <p class="mt-2 text-center text-xs sm:text-sm text-gray-500">
    Sudah punya akun?
    <a href="/login" class="font-semibold text-blue-600 hover:text-blue-500">Masuk di sini</a>
  </p>
</div>

<script>

let currentStep = 0;
const totalSteps = 4;
const stepIndicators = document.querySelectorAll(".step-circle");
const progressBar = document.getElementById('progressBar');

function updateStepIndicators() {
  stepIndicators.forEach((circle, index) => {
    if (index <= currentStep) {
      circle.classList.remove("bg-gray-300", "text-gray-600");
      circle.classList.add("bg-blue-600", "text-white", "active");
    } else {
      circle.classList.remove("bg-blue-600", "text-white", "active");
      circle.classList.add("bg-gray-300", "text-gray-600");
    }
  });
  // Progress bar
  progressBar.style.width = ((currentStep) / totalSteps * 100) + "%";
}


function showStep(step) {
  document.querySelectorAll('.form-step').forEach((el, index) => {
    el.classList.toggle('hidden', index !== step);
    el.style.opacity = index === step ? 1 : 0;
    el.style.transform = index === step ? 'translateX(0)' : 'translateX(40px)';
  });

  updateStepIndicators();

  if (step === totalSteps) {
    document.getElementById('reviewEmail').textContent = document.getElementById('email').value;
    document.getElementById('reviewName').textContent = document.getElementById('name').value;
    document.getElementById('reviewNoHP').textContent = document.getElementById('nohp').value;
    document.getElementById('reviewAlamat').textContent = document.getElementById('alamat').value;
    document.getElementById('reviewStatus').textContent = document.getElementById('status').value;
    document.getElementById('reviewAsal').textContent = document.getElementById('asal').value;
    document.getElementById('reviewInstitusi').textContent = document.getElementById('institusi').value;
    const ktpInput = document.getElementById('ktp');
    const reviewKTP = document.getElementById('reviewKTP');
    const reviewKTPPreview = document.getElementById('reviewKTPPreview');
    if (ktpInput.files.length > 0) {
      reviewKTP.textContent = ktpInput.files[0].name;
      // Preview gambar jika file gambar
      if (ktpInput.files[0].type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(ev) {
          reviewKTPPreview.innerHTML = `<img src="${ev.target.result}" alt="Preview KTP" class="mt-1 rounded shadow max-h-32 fade-in">`;
        };
        reader.readAsDataURL(ktpInput.files[0]);
      } else {
        reviewKTPPreview.innerHTML = `<span class="text-xs text-gray-500">File bukan gambar, preview tidak tersedia.</span>`;
      }
    } else {
      reviewKTP.textContent = 'Belum Upload';
      reviewKTPPreview.innerHTML = '';
    }
  }
  updateNextButtonState();
}

// Real-time validation
document.querySelectorAll('input, select').forEach(input => {
  input.addEventListener('input', updateNextButtonState);
});

function updateNextButtonState() {
  const currentForm = document.querySelectorAll('.form-step')[currentStep];
  const inputs = currentForm.querySelectorAll('input, select');
  let valid = true;
  for (let input of inputs) {
    if (!input.checkValidity()) {
      valid = false;
      break;
    }
  }
  const nextBtn = currentForm.querySelector('button[onclick="nextStep()"]');
  if (nextBtn) nextBtn.disabled = !valid;
}

async function nextStep() {
  const currentForm = document.querySelectorAll('.form-step')[currentStep];
  const inputs = currentForm.querySelectorAll('input, select');
  const emailExistsMsg = document.getElementById('emailExistsMsg');

  if (emailExistsMsg) emailExistsMsg.classList.add('hidden');

  for (let input of inputs) {
    if (!input.checkValidity()) {
      input.reportValidity();
      return;
    }
  }

  if (currentStep === 0) {
    const pass = document.getElementById('password').value;
    const confirm = document.getElementById('password_confirmation').value;
    if (pass !== confirm) {
      document.getElementById('passwordMismatchMsg').classList.remove('hidden');
      return;
    } else {
      document.getElementById('passwordMismatchMsg').classList.add('hidden');
    }

    // Cek email ke backend
    const email = document.getElementById('email').value;
    try {
      const res = await fetch('/check-email', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('input[name=\"_token\"]').value
        },
        body: JSON.stringify({ email })
      });
      const data = await res.json();
      if (data.exists) {
        if (emailExistsMsg) emailExistsMsg.classList.remove('hidden');
        return;
      }
    } catch (e) {
      alert('Gagal memeriksa email. Coba lagi.');
      return;
    }
  }

  if (currentStep < totalSteps) {
    currentStep++;
    showStep(currentStep);
  }
}

function prevStep() {
  if (currentStep > 0) {
    currentStep--;
    showStep(currentStep);
  }
}

// Preview KTP dengan animasi fade-in
document.getElementById('ktp').addEventListener('change', function(e) {
  const file = e.target.files[0];
  const loading = document.getElementById('ktpLoading');
  let preview = document.getElementById('ktpPreview');
  if (preview) preview.remove(); // Hapus preview lama jika ada

  if (file && file.type.startsWith('image/')) {
    loading.classList.remove('hidden');
    const reader = new FileReader();
    reader.onload = function(ev) {
      loading.classList.add('hidden');
      let preview = document.getElementById('ktpPreview');
      if (!preview) {
        preview = document.createElement('img');
        preview.id = 'ktpPreview';
        preview.className = 'mb-2 rounded shadow max-h-32 fade-in';
        e.target.parentNode.insertBefore(preview, loading.nextSibling);
      }
      preview.src = ev.target.result;
      preview.classList.remove('fade-in');
      void preview.offsetWidth;
      preview.classList.add('fade-in');
    };
    reader.readAsDataURL(file);
  } else {
    if (loading) loading.classList.add('hidden');
  }
});

showStep(currentStep);
</script>

</body>
</html>