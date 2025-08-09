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

<a href="/" class="fixed top-4 left-4 z-30 px-4 py-2 bg-blue-100 text-blue-700 rounded-lg text-xs sm:text-sm font-semibold shadow hover:bg-blue-200 transition flex items-center gap-2">
  <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
  Halaman Utama
</a>
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
      <input type="email" id="email" name="email" required placeholder="Masukkan email aktif Anda" class="w-full border-2 border-blue-100 rounded-lg px-3 py-2 mb-1 text-sm focus:ring-2 focus:ring-blue-400 bg-blue-50">
      <div id="emailError" class="text-xs text-red-600 mb-2 hidden"></div>

      <label class="block text-sm mb-1 font-semibold text-blue-700">Kata Sandi</label>
      <div class="relative">
        <input type="password" id="password" name="password" minlength="8" required placeholder="Buat password minimal 8 karakter" class="w-full border-2 border-blue-100 rounded-lg px-3 py-2 mb-1 text-sm focus:ring-2 focus:ring-blue-400 bg-blue-50 pr-10" oninput="checkPasswordStrength()">
        <button type="button" tabindex="-1" onclick="togglePassword('password', this)" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-blue-700 focus:outline-none">
          <svg id="icon-password" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268-2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
        </button>
      </div>
      <div class="text-xs text-gray-600 mb-1">Password minimal 8 karakter, mengandung huruf besar, angka, dan simbol untuk keamanan maksimal.</div>
      <div id="passwordStrength" class="text-xs mb-1"></div>
      <div id="passwordError" class="text-xs text-red-600 mb-2 hidden"></div>

      <label class="block text-sm mb-1 font-semibold text-blue-700">Konfirmasi Kata Sandi</label>
      <div class="relative">
        <input type="password" id="password_confirmation" name="password_confirmation" minlength="8" required placeholder="Ulangi password yang sama" class="w-full border-2 border-blue-100 rounded-lg px-3 py-2 text-sm bg-blue-50 pr-10" oninput="checkPasswordMatch()">
        <button type="button" tabindex="-1" onclick="togglePassword('password_confirmation', this)" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-blue-700 focus:outline-none">
          <svg id="icon-password_confirmation" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268-2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
        </button>
      </div>
      <div id="passwordConfirmError" class="text-xs text-red-600 mb-2 hidden"></div>

      <div class="mt-5 flex justify-end">
        <button type="button" onclick="nextStep()" class="bg-gradient-to-r from-blue-600 to-blue-400 text-white px-6 py-2 rounded-lg text-sm font-bold shadow hover:from-blue-700 hover:to-blue-500 transition">Next</button>
      </div>

    </div>

    <!-- STEP 2: Info Diri -->
    <div class="form-step hidden" id="step-2">
      <label class="block text-sm mb-1 font-semibold text-blue-700">Nama Lengkap</label>
      <input type="text" id="name" name="name" required placeholder="Nama lengkap sesuai KTP" class="w-full border-2 border-blue-100 rounded-lg px-3 py-2 mb-2 text-sm focus:ring-2 focus:ring-blue-400 bg-blue-50">

      <label class="block text-sm mb-1 font-semibold text-blue-700">No HP</label>
      <input type="tel" id="nohp" name="nohp" required pattern="[0-9]{10,15}" placeholder="08xxxxxxxxxx" class="w-full border-2 border-blue-100 rounded-lg px-3 py-2 mb-2 text-sm focus:ring-2 focus:ring-blue-400 bg-blue-50">

      <label class="block text-sm mb-1 font-semibold text-blue-700">Alamat</label>
      <textarea id="alamat" name="alamat" required placeholder="Alamat domisili lengkap" class="w-full border-2 border-blue-100 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 bg-blue-50" rows="2"></textarea>

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
      <input type="text" id="institusi" name="institusi" required placeholder="Nama institusi/instansi" class="w-full border-2 border-blue-100 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 bg-blue-50">

      <div class="mt-5 flex justify-between">
        <button type="button" onclick="prevStep()" class="bg-gray-400 text-white px-6 py-2 rounded-lg text-sm font-bold shadow hover:bg-gray-500 transition">Previous</button>
        <button type="button" onclick="nextStep()" class="bg-gradient-to-r from-blue-600 to-blue-400 text-white px-6 py-2 rounded-lg text-sm font-bold shadow hover:from-blue-700 hover:to-blue-500 transition">Next</button>
      </div>
    </div>

    <!-- STEP 4: Upload KTP -->
    <div class="form-step hidden" id="step-4">
      <p class="mb-1 text-sm font-semibold text-blue-700">Upload KTP</p>
      <label for="ktp" class="block cursor-pointer mb-2">
        <div class="flex items-center justify-center border-2 border-dashed border-blue-300 rounded-lg bg-blue-50 py-2 px-2 hover:bg-blue-100 transition min-h-[56px]">
          <svg class="w-6 h-6 text-blue-400 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
          </svg>
          <span class="text-blue-600 font-semibold text-sm">Klik untuk pilih file KTP (jpg/png/pdf)</span>
        </div>
        <input type="file" id="ktp" name="ktp" accept="image/*,.pdf" required class="hidden" placeholder="Upload file KTP (jpg/png/pdf)">
      </label>
      <div id="ktpFileName" class="text-xs text-blue-700 mb-2"></div>
      <div id="ktpLoading" class="hidden flex flex-col items-center gap-2 mb-2">
        <span class="inline-block w-9 h-9 border-2 border-blue-400 border-t-transparent rounded-full animate-spin"></span>
        <span class="text-xs text-blue-500 font-semibold">Memproses gambar, mohon tunggu...</span>
      </div>
      <div id="ktpPreviewContainer" class="mb-2"></div>
      <p class="text-xs text-blue-500 mb-4">Data yang Anda upload akan <strong>aman</strong> dan dilindungi. Preview gambar akan muncul setelah proses selesai.</p>

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
  <div class="mt-2 flex flex-col items-center gap-1">
    <p class="text-center text-xs sm:text-sm text-gray-500">
      Sudah punya akun?
      <a href="/login" class="font-semibold text-blue-600 hover:text-blue-500">Masuk di sini</a>
    </p>
  </div>
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

const ktpInput = document.getElementById('ktp');
const ktpFileName = document.getElementById('ktpFileName');
const ktpLoading = document.getElementById('ktpLoading');
const ktpPreviewContainer = document.getElementById('ktpPreviewContainer');

ktpInput.addEventListener('change', function(e) {
  const file = e.target.files[0];
  ktpFileName.textContent = file ? `File terpilih: ${file.name}` : '';
  ktpPreviewContainer.innerHTML = '';
  if (!file) return;
  ktpLoading.classList.remove('hidden');
  // Simulasi loading lebih lama (2.5 detik)
  setTimeout(() => {
    ktpLoading.classList.add('hidden');
    if (file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = function(ev) {
        ktpPreviewContainer.innerHTML = `<img src="${ev.target.result}" alt="Preview KTP" class="mb-2 rounded shadow max-h-40 fade-in">`;
      };
      reader.readAsDataURL(file);
    } else {
      ktpPreviewContainer.innerHTML = `<span class="text-xs text-gray-500">File bukan gambar, preview tidak tersedia.</span>`;
    }
  }, 5000);
});

showStep(currentStep);

function togglePassword(fieldId, btn) {
  const input = document.getElementById(fieldId);
  const icon = btn.querySelector('svg');
  if (input.type === 'password') {
    input.type = 'text';
    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95m3.362-2.568A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.043 5.306M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />';
  } else {
    input.type = 'password';
    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
  }
}

// Password strength checker
function checkPasswordStrength() {
  const password = document.getElementById('password').value;
  const strengthDiv = document.getElementById('passwordStrength');
  let strength = 0;
  if (password.length >= 8) strength++;
  if (/[A-Z]/.test(password)) strength++;
  if (/[0-9]/.test(password)) strength++;
  if (/[^A-Za-z0-9]/.test(password)) strength++;
  let status = '';
  let color = '';
  if (password.length === 0) {
    status = '';
  } else if (strength <= 1) {
    status = 'Lemah';
    color = 'text-red-600';
  } else if (strength === 2 || strength === 3) {
    status = 'Sedang';
    color = 'text-yellow-600';
  } else if (strength >= 4) {
    status = 'Kuat';
    color = 'text-green-600';
  }
  strengthDiv.textContent = status ? `Password: ${status}` : '';
  strengthDiv.className = `text-xs mb-1 font-semibold ${color}`;
}

// Password match checker
function checkPasswordMatch() {
  const pass = document.getElementById('password').value;
  const confirm = document.getElementById('password_confirmation').value;
  const errorDiv = document.getElementById('passwordConfirmError');
  if (confirm && pass !== confirm) {
    errorDiv.textContent = 'Konfirmasi password tidak sama.';
    errorDiv.classList.remove('hidden');
  } else {
    errorDiv.textContent = '';
    errorDiv.classList.add('hidden');
  }
}

// Real-time validation for email and password
document.getElementById('email').addEventListener('input', function() {
  const email = this.value;
  const errorDiv = document.getElementById('emailError');
  if (email && !/^\S+@\S+\.\S+$/.test(email)) {
    errorDiv.textContent = 'Format email tidak valid.';
    errorDiv.classList.remove('hidden');
  } else {
    errorDiv.textContent = '';
    errorDiv.classList.add('hidden');
  }
});

document.getElementById('password').addEventListener('input', function() {
  const errorDiv = document.getElementById('passwordError');
  if (this.value.length > 0 && this.value.length < 8) {
    errorDiv.textContent = 'Password minimal 8 karakter.';
    errorDiv.classList.remove('hidden');
  } else {
    errorDiv.textContent = '';
    errorDiv.classList.add('hidden');
  }
});

document.getElementById('password_confirmation').addEventListener('input', checkPasswordMatch);
</script>

</body>
</html>