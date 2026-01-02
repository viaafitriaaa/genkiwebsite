<!doctype html>
<html lang="id">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Genki Food &amp; Drink</title>
  <script src="/_sdk/data_sdk.js"></script>
  <script src="/_sdk/element_sdk.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      box-sizing: border-box;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      width: 100%;
    }

    .gradient-bg {
      background: linear-gradient(135deg, #27334eff 0%, #1e293b 50%, #0f172a 100%);
    }

    .card {
      background: #1e293b;
      border: 1px solid #334155;
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.3);
    }

    .btn {
      transition: all 0.2s;
      cursor: pointer;
    }

    .btn:hover {
      transform: scale(1.02);
    }

    .btn:active {
      transform: scale(0.98);
    }

    .fade-in {
      animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
  <style>@view-transition { navigation: auto; }</style>
 </head>
 <body class="gradient-bg h-full w-full">
  <div id="app" class="w-full h-full"></div>
  <script>
     const defaultConfig = {
      background_color: "#593878ff",      
      surface_color: "#896eb9ff",         
      text_color: "#f1f5f9",            
      primary_action_color: "#9d7af0ff",  
      secondary_action_color: "#6936b4ff",
      brand_name: "Genki Food & Drink",
      welcome_description: "Sajikan momen istimewa dengan setiap tegukan yang memanjakan lidah. Rasakan kesegaran alami yang menyegarkan hari-harimu!",
      instagram_handle: "@genki.co.id",
      font_family: "Inter",
      font_size: 16
    };

    let config = { ...defaultConfig };
    let currentUser = null;
    let currentView = 'welcome';
    let cart = [];
    let orders = [];
    let promoScanned = false;
    let customerInfo = {
      name: '',
      email: '',
      phone: '',
      address: '',
      city: '',
      postal_code: ''
    };
    const csrfToken = "{{ csrf_token() }}";

    const productsFromServer = @json($products);
    const bundlesFromServer = @json($bundles);

    const menuData = buildMenuData(productsFromServer, bundlesFromServer);

    function buildMenuData(products, bundles) {
      const smoothies = [];
      const foods = [];

      (products || []).forEach((p) => {
        const item = {
          id: p.id,
          name: p.name,
          desc: p.description || '',
          price: p.price,
          image: p.image || null,
          type: p.category === 'smoothie' ? 'smoothie' : 'food'
        };

        if (item.type === 'smoothie') {
          smoothies.push(item);
        } else {
          foods.push(item);
        }
      });

      const bundleItems = (bundles || []).map((b) => ({
        id: b.id,
        name: b.title,
        desc: b.description || '',
        price: b.price,
        image: b.image || null,
        type: 'bundle'
      }));

      return { smoothies, foods, bundles: bundleItems };
    }

    function formatPrice(price) {
      return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(price);
    }

    function generateId() {
      return Date.now().toString(36) + Math.random().toString(36).substr(2);
    }

    function isCustomerInfoComplete() {
      return Boolean(
        (customerInfo.name || '').trim() &&
        (customerInfo.email || '').trim() &&
        (customerInfo.phone || '').trim()
      );
    }

    window.goToLogin = function() {
      currentView = 'home';
      render();
    };

    window.goToSignup = function() {
      currentView = 'home';
      render();
    };

    window.doLogin = function(event) {
      event.preventDefault();
      const username = document.getElementById('loginUsername').value;
      const password = document.getElementById('loginPassword').value;
      
      if (username && password) {
        currentUser = username;
        currentView = 'home';
        render();
      }
    };

    window.doSignup = function(event) {
      event.preventDefault();
      const username = document.getElementById('signupUsername').value;
      const password = document.getElementById('signupPassword').value;
      
      if (username && password) {
        currentUser = username;
        currentView = 'home';
        render();
      }
    };

    window.logout = function() {
      currentUser = null;
      currentView = 'welcome';
      cart = [];
      orders = [];
      promoScanned = false;
      render();
    };

    window.showView = function(view) {
      currentView = view;
      render();
    };

    window.addToCart = function(id, name, price, type) {
      cart.push({ id: generateId(), itemId: id, name, price, type });
      if (!isCustomerInfoComplete()) {
        showView('customer');
      } else {
        showView('orders');
      }
    };

    window.removeFromCart = function(index) {
      cart.splice(index, 1);
      render();
    };

    window.proceedToCheckout = function(goToPay = false) {
      if (cart.length === 0) return;
      if (!isCustomerInfoComplete()) {
        currentView = 'customer';
        render();
        return;
      }

      const form = document.createElement('form');
      form.method = 'POST';
      form.action = "{{ route('order.create') }}";
      form.style.display = 'none';

      const tokenInput = document.createElement('input');
      tokenInput.type = 'hidden';
      tokenInput.name = '_token';
      tokenInput.value = csrfToken;
      form.appendChild(tokenInput);

      const fields = ['name','email','phone','address','city','postal_code'];
      const map = {
        name: 'customer_name',
        email: 'customer_email',
        phone: 'customer_phone',
        address: 'customer_address',
        city: 'customer_city',
        postal_code: 'customer_postal_code',
      };
      fields.forEach((f) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = map[f];
        input.value = customerInfo[f] || '';
        form.appendChild(input);
      });

      cart.forEach((item, idx) => {
        const typeVal = item.type === 'bundle' ? 'bundle' : 'product';
        const idInput = document.createElement('input');
        idInput.type = 'hidden';
        idInput.name = `items[${idx}][id]`;
        idInput.value = item.itemId;
        form.appendChild(idInput);

        const typeInput = document.createElement('input');
        typeInput.type = 'hidden';
        typeInput.name = `items[${idx}][type]`;
        typeInput.value = typeVal;
        form.appendChild(typeInput);
      });

      const goPayInput = document.createElement('input');
      goPayInput.type = 'hidden';
      goPayInput.name = 'go_to_pay';
      goPayInput.value = goToPay ? 1 : 0;
      form.appendChild(goPayInput);

      document.body.appendChild(form);
      form.submit();
    };

    window.saveCustomerInfo = function(event) {
      event.preventDefault();
      const nameInput = document.getElementById('customerName');
      const emailInput = document.getElementById('customerEmail');
      const phoneInput = document.getElementById('customerPhone');
      const addressInput = document.getElementById('customerAddress');
      const cityInput = document.getElementById('customerCity');
      const postalInput = document.getElementById('customerPostal');

      customerInfo = {
        name: nameInput?.value || '',
        email: emailInput?.value || '',
        phone: phoneInput?.value || '',
        address: addressInput?.value || '',
        city: cityInput?.value || '',
        postal_code: postalInput?.value || ''
      };

      if (!isCustomerInfoComplete()) {
        const err = document.getElementById('customerError');
        if (err) err.textContent = 'Nama, email, dan nomor HP wajib diisi.';
        return;
      }

      currentView = cart.length > 0 ? 'orders' : 'menu';
      render();
    };

    window.showPromoScan = function() {
      proceedToCheckout();
    };

    window.showPayment = function() {
      if (cart.length === 0) return;
      if (!isCustomerInfoComplete()) {
        currentView = 'customer';
        render();
        return;
      }
      proceedToCheckout(true);
    };

    let cameraStream = null;

    window.startCamera = async function() {
      try {  
        const stream = await navigator.mediaDevices.getUserMedia({ 
          video: { facingMode: 'environment' } 
        });
        
        const videoElement = document.getElementById('cameraStream');
        const placeholder = document.getElementById('cameraPlaceholder');
        const startBtn = document.getElementById('startCameraBtn');
        
        if (videoElement && placeholder && startBtn) {
          videoElement.srcObject = stream;
          videoElement.style.display = 'block';
          placeholder.style.display = 'none';
          startBtn.textContent = 'Kamera Aktif';
          startBtn.disabled = true;
          startBtn.style.opacity = '0.6';
          cameraStream = stream;
        }
      } catch (error) {
        const errorContainer = document.getElementById('errorContainer');
        if (errorContainer) {
          errorContainer.innerHTML = `
            <div class="p-4 rounded-lg mt-4" style="background: #fee2e2; color: #991b1b;">
              Tidak dapat mengakses kamera. Pastikan izin kamera diaktifkan.
            </div>
          `;
        }
      }
    };

    function stopCamera() {
      if (cameraStream) {
        cameraStream.getTracks().forEach(track => track.stop());
        cameraStream = null;
      }
    }

    window.applyPromo = function() {
      stopCamera();
      promoScanned = true;
      showView('orders');
    };

    window.processPayment = async function() {
      if (cart.length === 0) return;

      const orderButton = document.getElementById('paymentBtn');
      if (orderButton) {
        orderButton.disabled = true;
        orderButton.textContent = 'Memproses...';
        orderButton.style.opacity = '0.6';
      }

      for (const item of cart) {
        const orderData = {
          id: item.id,
          item_name: item.name,
          item_image: item.image,
          item_price: item.price,
          item_type: item.type,
          quantity: 1,
          created_at: new Date().toISOString()
        };

        if (window.dataSdk) {
          const result = await window.dataSdk.create(orderData);
          if (!result.isOk) {
            if (orderButton) {
              orderButton.disabled = false;
              orderButton.textContent = 'Konfirmasi Pembayaran';
              orderButton.style.opacity = '1';
            }
            
            const errorContainer = document.getElementById('paymentError');
            if (errorContainer) {
              errorContainer.innerHTML = `
                <div class="mt-4 p-4 rounded-lg" style="background: #fee2e2; color: #991b1b;">
                  Gagal menyimpan pesanan. Silakan coba lagi.
                </div>
              `;
            }
            return;
          }
        }
      }

      cart = [];
      promoScanned = false;
      currentView = 'processing';
      render();
    };

function renderWelcome() {
  const {
    font_family,
    font_size,
    primary_action_color,
    secondary_action_color,
    brand_name
  } = config;

  const welcomeText = `
    Nikmati cara baru memesan makanan dengan lebih cepat dan praktis.
    Tanpa antri, tanpa ribet cukup beberapa langkah,
    pesanan favoritmu langsung siap dinikmati.
  `;

  return `
    <div class="relative w-full h-full overflow-hidden"
         style="font-family: ${font_family}, sans-serif;">

      <!-- BACKGROUND IMAGE (BLUR) -->
      <div
        class="absolute inset-0"
        style="
          background: url('/image/genki_bg.jpeg') center / cover no-repeat;
          filter: blur(18px);
          transform: scale(1.12);
        ">
      </div>

      <!-- DARK OVERLAY -->
      <div
        class="absolute inset-0"
        style="background: rgba(10, 5, 30, 0.7);">
      </div>

      <!-- CONTENT -->
      <div class="relative z-10 w-full h-full flex items-center justify-center p-6">

        <div class="w-full max-w-4xl card rounded-3xl p-12 text-center"
          style="
            background: rgba(30, 20, 50, 0.82);
            backdrop-filter: blur(24px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
          ">

          <!-- LOGO -->
          <div class="mb-6 flex justify-center">
            <img 
              src="/image/genki_logo.png"
              alt="Logo"
              loading="eager"
              decoding="async"
              style="
                width: clamp(160px, 24vw, ${font_size * 10}px);
                height: auto;
                animation: float 4s ease-in-out infinite;
                filter: drop-shadow(0 6px 18px rgba(0,0,0,0.6));
              "
            />
          </div>

          <!-- BRAND NAME -->
          <h1 class="font-extrabold mb-6"
            style="
              font-size: ${font_size * 2.5}px;
              color: ${primary_action_color};
              text-shadow: 0 2px 6px rgba(0,0,0,0.6);
            ">
            ${brand_name}
          </h1>

          <!-- TEXT -->
          <p class="mb-8 leading-relaxed"
            style="
              font-size: ${font_size * 1.1}px;
              color: #dcd6f7;
              max-width: 600px;
              margin: 0 auto;
              line-height: 1.6;
            ">
            ${welcomeText}
          </p>

          <!-- BUTTON -->
          <button onclick="goToLogin()"
            class="btn font-bold py-4 px-12 rounded-xl transition-transform duration-300 hover:scale-105 hover:shadow-lg"
            style="
              background: linear-gradient(135deg, ${primary_action_color}, ${secondary_action_color});
              color: white;
              font-size: ${font_size * 1.2}px;
              box-shadow: 0 6px 15px rgba(0,0,0,0.35);
            ">
            Pesan Sekarang
          </button>

        </div>
      </div>

      <style>
        @keyframes float {
          0% { transform: translateY(0px); }
          50% { transform: translateY(-6px); }
          100% { transform: translateY(0px); }
        }
      </style>
    </div>
  `;
}
    function renderLogin() {
      const { font_family, font_size, primary_action_color, secondary_action_color, brand_name } = config;
      return `
        <div class="w-full h-full flex items-center justify-center p-6 gradient-bg" style="font-family: ${font_family}, sans-serif;">
          <div class="w-full max-w-md card rounded-2xl p-8 fade-in" style="background: #1e293b;">
            <div class="text-center mb-8">
              <span style="font-size: ${font_size * 3}px;">🔐</span>
            </div>
            <h2 class="text-center font-bold mb-2" style="font-size: ${font_size * 2}px; color: ${primary_action_color};">Masuk</h2>
            <p class="text-center mb-6" style="font-size: ${font_size * 0.9}px; color: #cbd5e1;">Masuk ke akun ${brand_name} Anda</p>
            <form onsubmit="doLogin(event)" class="space-y-4">
              <div>
                <label for="loginUsername" class="block mb-2 font-medium" style="font-size: ${font_size}px; color: #f1f5f9;">Username</label>
                <input type="text" id="loginUsername" required class="w-full px-4 py-3 rounded-lg border border-gray-600 focus:outline-none focus:border-purple-500" style="font-size: ${font_size}px; background: #0f172a; color: white;">
              </div>
              <div>
                <label for="loginPassword" class="block mb-2 font-medium" style="font-size: ${font_size}px; color: #f1f5f9;">Password</label>
                <input type="password" id="loginPassword" required class="w-full px-4 py-3 rounded-lg border border-gray-600 focus:outline-none focus:border-purple-500" style="font-size: ${font_size}px; background: #0f172a; color: white;">
              </div>
              <button type="submit" class="btn w-full font-semibold py-3 rounded-lg" style="background: ${primary_action_color}; color: white; font-size: ${font_size * 1.1}px;">
                Masuk
              </button>
            </form>
            <div class="mt-6 text-center">
              <p style="font-size: ${font_size * 0.9}px; color: #94a3b8;">
                Belum punya akun? 
                <button onclick="goToSignup()" class="font-semibold underline" style="color: ${primary_action_color};">Daftar di sini</button>
              </p>
            </div>
          </div>
        </div>
      `;
    }

    function renderSignup() {
      const { font_family, font_size, primary_action_color, secondary_action_color, brand_name } = config;
      return `
        <div class="w-full h-full flex items-center justify-center p-6 gradient-bg" style="font-family: ${font_family}, sans-serif;">
          <div class="w-full max-w-md card rounded-2xl p-8 fade-in" style="background: #1e293b;">
            <div class="text-center mb-8">
              <span style="font-size: ${font_size * 3}px;">✨</span>
            </div>
            <h2 class="text-center font-bold mb-2" style="font-size: ${font_size * 2}px; color: ${primary_action_color};">Buat Akun Baru</h2>
            <p class="text-center mb-6" style="font-size: ${font_size * 0.9}px; color: #cbd5e1;">Bergabung dengan ${brand_name} sekarang</p>
            <form onsubmit="doSignup(event)" class="space-y-4">
              <div>
                <label for="signupUsername" class="block mb-2 font-medium" style="font-size: ${font_size}px; color: #f1f5f9;">Username</label>
                <input type="text" id="signupUsername" required class="w-full px-4 py-3 rounded-lg border border-gray-600 focus:outline-none focus:border-purple-500" style="font-size: ${font_size}px; background: #0f172a; color: white;">
              </div>
              <div>
                <label for="signupPassword" class="block mb-2 font-medium" style="font-size: ${font_size}px; color: #f1f5f9;">Password</label>
                <input type="password" id="signupPassword" required class="w-full px-4 py-3 rounded-lg border border-gray-600 focus:outline-none focus:border-purple-500" style="font-size: ${font_size}px; background: #0f172a; color: white;">
              </div>
              <div>
                <label for="signupPasswordConfirm" class="block mb-2 font-medium" style="font-size: ${font_size}px; color: #f1f5f9;">Konfirmasi Password</label>
                <input type="password" id="signupPasswordConfirm" required class="w-full px-4 py-3 rounded-lg border border-gray-600 focus:outline-none focus:border-purple-500" style="font-size: ${font_size}px; background: #0f172a; color: white;">
              </div>
              <button type="submit" class="btn w-full font-semibold py-3 rounded-lg" style="background: ${primary_action_color}; color: white; font-size: ${font_size * 1.1}px;">
                Daftar Sekarang
              </button>
            </form>
            <div class="mt-6 text-center">
              <p style="font-size: ${font_size * 0.9}px; color: #94a3b8;">
                Sudah punya akun? 
                <button onclick="goToLogin()" class="font-semibold underline" style="color: ${primary_action_color};">Masuk di sini</button>
              </p>
            </div>
          </div>
        </div>
      `;
    }

  function renderHome() {
  const fontFamily = config.font_family || defaultConfig.font_family;
  const baseFontSize = config.font_size || defaultConfig.font_size;
  const textColor = "#f8fafc";

  return `
    ${renderNav()}

    <div class="w-full min-h-screen flex flex-col items-center justify-start px-6 py-20"
      style="
        background: linear-gradient(135deg, #1a0033, #2d1b4e);
        font-family:${fontFamily}, sans-serif;
        color:${textColor};
      ">

      <!-- HERO -->
      <div class="max-w-6xl text-center">
        <h1 class="font-extrabold mb-6 tracking-tight text-white"
          style="font-size:${baseFontSize * 3}px;">
          Order Lebih Cepat
        </h1>

        <p class="max-w-xl mx-auto leading-relaxed text-slate-300"
          style="font-size:${baseFontSize * 1.15}px;">
          Dapatkan makanan favorit Anda tanpa perlu mengantri.<br/>
          Pemesanan yang sederhana, cepat, dan tanpa repot
        </p>
      </div>

      <!-- FEATURES -->
      <div class="max-w-5xl mx-auto px-6 mt-24 grid grid-cols-1 md:grid-cols-2 gap-10">

        <!-- Instagram -->
        <div class="rounded-2xl p-8 text-center shadow-lg transition-transform duration-300 hover:-translate-y-2"
          style="background: rgba(255,255,255,0.08); backdrop-filter: blur(12px);">
          <div class="text-4xl mb-4">📸</div>
          <h3 class="font-semibold mb-2 text-lg text-white">Instagram</h3>
          <p class="text-sm text-slate-300 mb-2">Ikuti kami di Instagram</p>
          <p class="text-sm font-medium text-white">@genki.co.id</p>
        </div>

        <!-- Location -->
        <div class="rounded-2xl p-8 text-center shadow-lg transition-transform duration-300 hover:-translate-y-2"
          style="background: rgba(255,255,255,0.08); backdrop-filter: blur(12px);">
          <div class="text-4xl mb-4">📍</div>
          <h3 class="font-semibold mb-2 text-lg text-white">Location</h3>
          <p class="text-sm text-slate-300 mb-3">Alamat:</p>
          <p class="text-sm leading-relaxed text-white">
            Perum GTSI (Belakang UMP)<br/>
            Jl. Gatramas Raya No.1 Blok J4<br/>
            Bojongsari, Kec. Kembaran<br/>
            Kabupaten Banyumas, Jawa Tengah 53113
          </p>
        </div>

      </div>

      <div class="h-24"></div>
    </div>
  `;
}
    function renderNav() {
      const fontFamily = config.font_family || defaultConfig.font_family;
      const baseFontSize = config.font_size || defaultConfig.font_size;
      const surfaceColor = config.surface_color || defaultConfig.surface_color;
      const textColor = config.text_color || defaultConfig.text_color;
      const primaryColor = config.primary_action_color || defaultConfig.primary_action_color;
      const brandName = config.brand_name || defaultConfig.brand_name;

      return `
        <div style="font-family: ${fontFamily}, sans-serif;">
          <div class="shadow-sm" style="background: #180d33ff;">
            <div class="max-w-7xl mx-auto px-4 py-3">
              <div class="flex items-center justify-between">
                <h1 class="font-bold" style="font-size: ${baseFontSize * 1.5}px; color: ${primaryColor};">${brandName}</h1>
                <button onclick="logout()" class="btn font-semibold px-4 py-2 rounded-lg" style="font-size: ${baseFontSize * 0.875}px; color: white; background: #ef4444;">
                  Logout
                </button>
              </div>
            </div>
          </div>

          <div class="fixed bottom-0 left-0 right-0 shadow-lg z-50" style="background: #180d33ff; border-top: 2px solid ${primaryColor};">
            <div class="max-w-7xl mx-auto px-4 py-4">
              <div class="grid grid-cols-3 gap-4">
                <button onclick="showView('home')" class="btn font-semibold py-3 rounded-xl transition-all flex flex-col items-center gap-2" style="background: ${currentView === 'home' ? primaryColor : 'transparent'}; color: ${currentView === 'home' ? 'white' : '#cbd5e1'}; border: 2px solid ${primaryColor};">
                  <span style="font-size: ${baseFontSize * 1.5}px;">🏠</span>
                  <span style="font-size: ${baseFontSize * 0.875}px;">Beranda</span>
                </button>
                <button onclick="showView('menu')" class="btn font-semibold py-3 rounded-xl transition-all flex flex-col items-center gap-2" style="background: ${currentView === 'menu' ? primaryColor : 'transparent'}; color: ${currentView === 'menu' ? 'white' : '#cbd5e1'}; border: 2px solid ${primaryColor};">
                  <span style="font-size: ${baseFontSize * 1.5}px;">🍽️</span>
                  <span style="font-size: ${baseFontSize * 0.875}px;">Menu</span>
                </button>
                <button onclick="showView('orders')" class="btn font-semibold py-3 rounded-xl transition-all flex flex-col items-center gap-2 relative" style="background: ${currentView === 'orders' ? primaryColor : 'transparent'}; color: ${currentView === 'orders' ? 'white' : '#cbd5e1'}; border: 2px solid ${primaryColor};">
                  ${cart.length > 0 ? `<span class="absolute -top-2 -right-2 w-6 h-6 rounded-full flex items-center justify-center" style="background: #ef4444; color: white; font-size: ${baseFontSize * 0.75}px;">${cart.length}</span>` : ''}
                  <span style="font-size: ${baseFontSize * 1.5}px;">🛒</span>
                  <span style="font-size: ${baseFontSize * 0.875}px;">Pesanan</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      `;
    }

    function renderMenu() {
      const fontFamily = config.font_family || defaultConfig.font_family;
      const baseFontSize = config.font_size || defaultConfig.font_size;
      const primaryColor = config.primary_action_color || defaultConfig.primary_action_color;
      const textColor = config.text_color || defaultConfig.text_color;
      
   const smoothiesHTML = menuData.smoothies.map(item => {
  const imageUrl = item.image
    ? `/image/products/${item.image}`
    : `/image/no-image.png`;

  return `
    <div class="card rounded-xl p-5">
  <div style="overflow:hidden; border-radius: 40px;">
  <img src="${imageUrl}"
       class="w-full" 
       style="height:320px; object-fit:cover;"
       loading="lazy">
       
</div>
      <h4 class="font-bold mb-2"
          style="font-size: ${baseFontSize * 1.2}px; color: #f1f5f9;">
        ${item.name}
      </h4>

      <p class="mb-4"
         style="font-size: ${baseFontSize * 0.9}px; color: #cbd5e1;">
        ${item.desc}
      </p>

      <p class="font-bold mb-4"
         style="font-size: ${baseFontSize * 1.1}px; color: ${primaryColor};">
        ${formatPrice(item.price)}
      </p>

      <button onclick="addToCart('${item.id}', '${item.name}', ${item.price}, '${item.type}')"
              class="btn w-full font-semibold py-2 rounded-lg"
              style="background: ${primaryColor}; color: white; font-size: ${baseFontSize}px;">
        Pesan
      </button>
    </div>
  `;
}).join('');

    const foodsHTML = menuData.foods.map(item => {
  const imageUrl = item.image
    ? `/image/products/${item.image}`
    : `/image/no-image.png`;

  return `
    <div class="card rounded-xl p-5">
      <div style="overflow:hidden; border-radius: 90px;">
  <img src="${imageUrl}"
       class="w-full" 
       style="height:300px;"
       loading="lazy">
  </div>
      <h4 class="font-bold mb-2"
          style="font-size:${baseFontSize * 1.2}px; color:#f1f5f9;">
        ${item.name}
      </h4>

      <p class="mb-4"
         style="font-size:${baseFontSize * 0.9}px; color:#cbd5e1;">
        ${item.desc || ''}
      </p>

      <p class="font-bold mb-4"
         style="font-size:${baseFontSize * 1.1}px; color:${primaryColor};">
        ${formatPrice(item.price)}
      </p>

      <button
        onclick='addToCart(
          "${item.id}",
          ${JSON.stringify(item.name)},
          ${item.price},
          "${item.type}"
        )'
        class="btn w-full font-semibold py-2 rounded-lg"
        style="background:${primaryColor}; color:white; font-size:${baseFontSize}px;">
        Pesan
      </button>
    </div>
  `;
}).join('');

    const bundlesHTML = menuData.bundles.map(item => {
  const imageUrl = item.image
    ? `/image/products/${item.image}`
    : `/image/no-image.png`;

  return `
    <div class="card rounded-xl p-5" style="border: 2px solid #16a34a;">   
      <img src="${imageUrl}"
           loading="lazy"
           class="w-full rounded-lg mb-4"
           style="height:380px; object-fit:cover;"
           onerror="this.src='/image/no-image.png'">

      <span class="inline-block px-2 py-1 rounded text-xs mb-3"
            style="background:#16a34a; color:white;">
        PROMO
      </span>

      <h4 class="font-bold mb-2"
          style="font-size:${baseFontSize * 1.2}px; color:#f1f5f9;">
        ${item.name}
      </h4>

      <p class="mb-4"
         style="font-size:${baseFontSize * 0.9}px; color:#cbd5e1;">
        ${item.desc}
      </p>

      <p class="font-bold mb-4"
         style="font-size:${baseFontSize * 1.1}px; color:${primaryColor};">
        ${formatPrice(item.price)}
      </p>

      <button onclick="addToCart('${item.id}', '${item.name}', ${item.price}, '${item.type}')"
              class="btn w-full font-semibold py-2 rounded-lg"
              style="background:${primaryColor}; color:white; font-size:${baseFontSize}px;">
        Pesan
      </button>
    </div>
  `;
}).join('');

      return `
     <div class="w-full h-full" style="background: linear-gradient(135deg, #1a0033, #2d1b4e); font-family: ${fontFamily}, sans-serif; overflow-y: auto;">

     ${renderNav()}
          <div class="max-w-7xl mx-auto px-4 py-8" style="padding-bottom: 120px;">
            <section class="mb-12 fade-in">
              <h2 class="font-bold mb-8 text-center" style="font-size: ${baseFontSize * 2}px; color: ${primaryColor};">Smoothies Series</h2>
              <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                ${smoothiesHTML}
              </div>
            </section>

            <section class="mb-12">
              <h2 class="font-bold mb-8 text-center" style="font-size: ${baseFontSize * 2}px; color: ${primaryColor};">Menu Makanan</h2>
              <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                ${foodsHTML}
              </div>
            </section>

            <section class="mb-12">
              <h2 class="font-bold mb-8 text-center" style="font-size: ${baseFontSize * 2}px; color: ${primaryColor};">SPECIAL BUNDLING</h2>
              <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                ${bundlesHTML}
              </div>
            </section>
          </div>
        </div>
      `;
    }

    function renderCustomer() {
      const fontFamily = config.font_family || defaultConfig.font_family;
      const baseFontSize = config.font_size || defaultConfig.font_size;
      const primaryColor = config.primary_action_color || defaultConfig.primary_action_color;

      return `
        <div class="w-full h-full flex items-center justify-center p-4"
             style="background: linear-gradient(135deg, #1a0033, #2d1b4e);font-family: ${fontFamily}, sans-serif;">
          <div class="w-full max-w-lg rounded-3xl shadow-2xl p-8 fade-in" style="background: #1e293b; border: 1px solid #334155;">
            <h2 class="font-bold mb-2 text-center" style="font-size: ${baseFontSize * 1.75}px; color: ${primaryColor};">Data Diri</h2>
            <p class="mb-6 text-center" style="font-size: ${baseFontSize * 0.95}px; color: #cbd5e1;">Isi nama, email, dan nomor HP untuk melanjutkan pesanan.</p>
            <form onsubmit="saveCustomerInfo(event)" class="space-y-4">
              <div>
                <label class="block mb-2 font-medium" style="color: #f1f5f9; font-size: ${baseFontSize}px;">Nama</label>
                <input id="customerName" type="text" required value="${customerInfo.name || ''}" class="w-full px-4 py-3 rounded-lg border border-gray-600 focus:outline-none focus:border-purple-500" style="font-size: ${baseFontSize}px; background: #0f172a; color: white;">
              </div>
              <div>
                <label class="block mb-2 font-medium" style="color: #f1f5f9; font-size: ${baseFontSize}px;">Email</label>
                <input id="customerEmail" type="email" required value="${customerInfo.email || ''}" class="w-full px-4 py-3 rounded-lg border border-gray-600 focus:outline-none focus:border-purple-500" style="font-size: ${baseFontSize}px; background: #0f172a; color: white;">
              </div>
              <div>
                <label class="block mb-2 font-medium" style="color: #f1f5f9; font-size: ${baseFontSize}px;">No. HP</label>
                <input id="customerPhone" type="text" required value="${customerInfo.phone || ''}" class="w-full px-4 py-3 rounded-lg border border-gray-600 focus:outline-none focus:border-purple-500" style="font-size: ${baseFontSize}px; background: #0f172a; color: white;">
              </div>
              <div>
                <label class="block mb-2 font-medium" style="color: #f1f5f9; font-size: ${baseFontSize}px;">Alamat (opsional)</label>
                <textarea id="customerAddress" rows="2" class="w-full px-4 py-3 rounded-lg border border-gray-600 focus:outline-none focus:border-purple-500" style="font-size: ${baseFontSize}px; background: #0f172a; color: white;">${customerInfo.address || ''}</textarea>
              </div>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                  <label class="block mb-2 font-medium" style="color: #f1f5f9; font-size: ${baseFontSize}px;">Kota (opsional)</label>
                  <input id="customerCity" type="text" value="${customerInfo.city || ''}" class="w-full px-4 py-3 rounded-lg border border-gray-600 focus:outline-none focus:border-purple-500" style="font-size: ${baseFontSize}px; background: #0f172a; color: white;">
                </div>
                <div>
                  <label class="block mb-2 font-medium" style="color: #f1f5f9; font-size: ${baseFontSize}px;">Kode Pos (opsional)</label>
                  <input id="customerPostal" type="text" value="${customerInfo.postal_code || ''}" class="w-full px-4 py-3 rounded-lg border border-gray-600 focus:outline-none focus:border-purple-500" style="font-size: ${baseFontSize}px; background: #0f172a; color: white;">
                </div>
              </div>
              <div id="customerError" class="text-red-400 text-sm"></div>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <button type="button" onclick="showView('menu')" class="btn font-semibold py-3 rounded-xl border border-gray-600" style="color: #cbd5e1; font-size: ${baseFontSize * 0.95}px;">
                  Kembali ke Menu
                </button>
                <button type="submit" class="btn font-semibold py-3 rounded-xl" style="background: ${primaryColor}; color: white; font-size: ${baseFontSize * 1.05}px;">
                  Simpan & Lanjutkan
                </button>
              </div>
            </form>
          </div>
        </div>
      `;
    }

    function renderOrders() {
      const fontFamily = config.font_family || defaultConfig.font_family;
      const baseFontSize = config.font_size || defaultConfig.font_size;
      const surfaceColor = config.surface_color || defaultConfig.surface_color;
      const textColor = config.text_color || defaultConfig.text_color;
      const primaryColor = config.primary_action_color || defaultConfig.primary_action_color;
      const requireContact = !isCustomerInfoComplete();

      const cartHTML = cart.map((item, index) => `
        <div class="rounded-xl p-4 flex items-center justify-between" style="background: #1e293b; border: 1px solid #334155;">
          <div class="flex-1">
            <h4 class="font-semibold mb-1" style="font-size: ${baseFontSize * 1.125}px; color: #f1f5f9;">${item.name}</h4>
            <p class="font-bold" style="font-size: ${baseFontSize}px; color: ${primaryColor};">${formatPrice(item.price)}</p>
          </div>
          <button onclick="removeFromCart(${index})" class="btn px-4 py-2 rounded-lg font-semibold" style="background: #ef4444; color: white; font-size: ${baseFontSize * 0.875}px;">
            Hapus
          </button>
        </div>
      `).join('');
        const originalTotal = cart.reduce((sum, item) => {
        const qty = item.qty || 1;
        return sum + item.price * qty;
        }, 0);

        const discountAmount = promoScanned ? originalTotal * 0.1 : 0;
        const finalTotal = originalTotal - discountAmount;

      return `
       <div class="w-full h-full" 
     style="background: linear-gradient(135deg, #1a0033, #2d1b4e); 
            font-family: ${fontFamily}, sans-serif; 
            overflow-y: auto;">

          ${renderNav()}
          <div class="max-w-4xl mx-auto px-4 py-8" style="padding-bottom: 120px;">
            <h2 class="font-bold mb-8 text-center" style="font-size: ${baseFontSize * 2}px; color: ${primaryColor};">Data Pesanan</h2>
            
            ${requireContact ? `
              <div class="rounded-xl p-4 mb-6" style="background: #0f172a; border: 1px solid #f59e0b;">
                <p class="font-semibold mb-2" style="font-size: ${baseFontSize}px; color: #fbbf24;">Isi data diri untuk melanjutkan pembayaran.</p>
                <button onclick="showView('customer')" class="btn font-semibold px-4 py-2 rounded-lg" style="background: ${primaryColor}; color: white; font-size: ${baseFontSize * 0.95}px;">Isi Data Diri</button>
              </div>
            ` : ''}
            
            ${cart.length === 0 ? `
              <div class="rounded-3xl p-12 text-center" style="background: #462e81ff; border: 1px solid #180d33ff;">
                <svg width="100" height="100" viewBox="0 0 100 100" class="mx-auto mb-4">
                  <circle cx="50" cy="50" r="45" fill="${primaryColor}" opacity="0.2"/>
                  <rect x="30" y="40" width="40" height="30" rx="3" stroke="${primaryColor}" stroke-width="3" fill="none"/>
                  <path d="M35 40 L35 35 Q35 30 40 30 L60 30 Q65 30 65 35 L65 40" stroke="${primaryColor}" stroke-width="3" fill="none"/>
                </svg>
                <p class="font-semibold" style="font-size: ${baseFontSize * 1.25}px; color: #f1f5f9;">Keranjang Anda kosong</p>
              </div>
            ` : `
              ${requireContact ? `
                <div class="rounded-xl p-4 mb-4" style="background: #180d33ff; border: 1px solid #f59e0b;">
                  <p class="font-semibold" style="font-size: ${baseFontSize}px; color: #fbbf24;">Lengkapi data diri sebelum checkout.</p>
                  <button onclick="showView('customer')" class="btn mt-3 font-semibold px-4 py-2 rounded-lg" style="background: ${primaryColor}; color: white; font-size: ${baseFontSize * 0.95}px;">
                    Isi Data Diri
                  </button>
                </div>
              ` : ''}
              <div class="space-y-4 mb-6">
                ${cartHTML}
              </div>
              
              <div class="rounded-xl p-6 mb-6" style="background: #354155ff; border: 1px solid #334155;">
                <div class="flex justify-between items-center mb-4">
                  <span class="font-semibold" style="font-size: ${baseFontSize * 1.125}px; color: #f1f5f9;">Subtotal:</span>
                  <span class="font-bold" style="font-size: ${baseFontSize * 1.25}px; color: ${primaryColor};">${formatPrice(originalTotal)}</span>
                </div>
                ${promoScanned ? `
                  <div class="flex justify-between items-center mb-4 pb-4" style="border-bottom: 1px solid #334155;">
                    <span class="font-semibold" style="font-size: ${baseFontSize}px; color: #16a34a;">Diskon Promo (10%):</span>
                    <span class="font-semibold" style="font-size: ${baseFontSize}px; color: #16a34a;">-${formatPrice(discountAmount)}</span>
                  </div>
                ` : ''}
                <div class="flex justify-between items-center">
                  <span class="font-bold" style="font-size: ${baseFontSize * 1.5}px; color: #f1f5f9;">Total:</span>
                  <span class="font-bold" style="font-size: ${baseFontSize * 1.5}px; color: ${primaryColor};">${formatPrice(finalTotal)}</span>
                </div>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                ${!promoScanned ? `
                  <button onclick="showPromoScan()" class="btn font-semibold py-4 rounded-xl shadow-lg" style="background: #16a34a; color: white; font-size: ${baseFontSize * 1.125}px;">
                    Claim Promo
                  </button>
                ` : ''}
                <button onclick="showPayment()" class="btn font-semibold py-4 rounded-xl shadow-lg ${requireContact ? 'opacity-60 cursor-not-allowed' : ''}" ${requireContact ? 'disabled' : ''} style="background: ${primaryColor}; color: white; font-size: ${baseFontSize * 1.125}px;">
                  Lanjutkan Pembayaran
                </button>
              </div>
            `}
          </div>
        </div>
      `;
    }

    function renderPromoScan() {
      const fontFamily = config.font_family || defaultConfig.font_family;
      const baseFontSize = config.font_size || defaultConfig.font_size;
      const textColor = config.text_color || defaultConfig.text_color;
      const primaryColor = config.primary_action_color || defaultConfig.primary_action_color;

      return `
        <<div class="w-full h-full"
        style=" background: linear-gradient(135deg, #1a0033, #2d1b4e); font-family: ${fontFamily}, sans-serif; overflow-y: auto; ">
          <div class="w-full max-w-md rounded-3xl shadow-2xl p-8 text-center fade-in" style="background: #1e293b; border: 1px solid #334155;">
            <h2 class="font-bold mb-6" style="font-size: ${baseFontSize * 2}px; color: ${primaryColor};">Scan KTM</h2>
            
            <div id="cameraContainer" class="mb-6 rounded-2xl overflow-hidden relative" style="background: #0f172a; min-height: 300px;">
              <video id="cameraStream" autoplay playsinline class="w-full h-full" style="display: none;"></video>
              <div id="cameraPlaceholder" class="p-8" style="background: linear-gradient(135deg, ${primaryColor}, #a855f7); min-height: 300px; display: flex; align-items: center; justify-content: center;">
                <svg width="200" height="200" viewBox="0 0 200 200" class="mx-auto">
                  <rect width="200" height="200" rx="20" fill="white"/>
                  <rect x="40" y="40" width="30" height="30" fill="${primaryColor}"/>
                  <rect x="130" y="40" width="30" height="30" fill="${primaryColor}"/>
                  <rect x="40" y="130" width="30" height="30" fill="${primaryColor}"/>
                  <rect x="85" y="85" width="30" height="30" fill="${primaryColor}"/>
                </svg>
              </div>
              <div class="absolute inset-0 border-4 pointer-events-none" style="border-color: ${primaryColor}; opacity: 0.5;"></div>
            </div>

            <div id="errorContainer"></div>

            <p class="mb-6" style="font-size: ${baseFontSize * 1.125}px; color: #cbd5e1;">Scan KTM Anda untuk mendapatkan diskon 10%</p>
            
            <button id="startCameraBtn" onclick="startCamera()" class="btn w-full font-semibold py-3 rounded-xl shadow-lg mb-3" style="background: ${primaryColor}; color: white; font-size: ${baseFontSize * 1.125}px;">
              Aktifkan Kamera
            </button>
            
            <button onclick="applyPromo()" class="btn w-full font-semibold py-3 rounded-xl shadow-lg mb-3" style="background: #16a34a; color: white; font-size: ${baseFontSize * 1.125}px;">
              Konfirmasi Scan
            </button>
            
            <button onclick="showView('orders')" class="btn w-full font-semibold py-3 rounded-xl" style="background: transparent; border: 2px solid #334155; color: #cbd5e1; font-size: ${baseFontSize}px;">
              Kembali
            </button>
          </div>
        </div>
      `;
    }

    function renderPayment(amount) {
      const fontFamily = config.font_family || defaultConfig.font_family;
      const baseFontSize = config.font_size || defaultConfig.font_size;
      const textColor = config.text_color || defaultConfig.text_color;
      const primaryColor = config.primary_action_color || defaultConfig.primary_action_color;
      const surfaceColor = config.surface_color || defaultConfig.surface_color;

     const originalTotal = cart.reduce((sum, item) => {
    const qty = item.qty || 1;
    return sum + item.price * qty; }, 0);
 
  const DISCOUNT_RATE = 0.1; // 10%
  const discountAmount = promoScanned ? originalTotal * DISCOUNT_RATE : 0;
  const finalTotal = originalTotal - discountAmount;

      return `
        <div class="w-full h-full flex items-center justify-center p-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); font-family: ${fontFamily}, sans-serif;">
          <div class="w-full max-w-md rounded-3xl shadow-2xl p-8 text-center fade-in" style="background: #1e293b; border: 1px solid #334155;">
            <h2 class="font-bold mb-6" style="font-size: ${baseFontSize * 2}px; color: ${primaryColor};">Pembayaran</h2>
            <div class="mb-6 p-8 rounded-2xl" style="background: linear-gradient(135deg, ${primaryColor}, #a855f7);">
              <svg width="200" height="200" viewBox="0 0 200 200" class="mx-auto">
                <rect width="200" height="200" rx="20" fill="white"/>
                <rect x="40" y="40" width="30" height="30" fill="${primaryColor}"/>
                <rect x="130" y="40" width="30" height="30" fill="${primaryColor}"/>
                <rect x="40" y="130" width="30" height="30" fill="${primaryColor}"/>
                <rect x="85" y="85" width="30" height="30" fill="${primaryColor}"/>
                <text x="100" y="180" font-size="16" font-weight="bold" text-anchor="middle" fill="${primaryColor}">QRIS</text>
              </svg>
            </div>
            <p class="font-bold mb-6" style="font-size: ${baseFontSize * 1.5}px; color: ${primaryColor};">+ Total: ${formatPrice(finalTotal)}</p>
            <p class="mb-6" style="font-size: ${baseFontSize}px; color: #cbd5e1;">Scan kode QR untuk melakukan pembayaran</p>
            
            <div id="paymentError"></div>
            <button
              onclick="processPayment(${finalTotal})"
              class="btn w-full font-semibold py-3 rounded-xl shadow-lg"
              style="background: ${primaryColor}; color: white; font-size: ${baseFontSize * 1.125}px;">
          Konfirmasi Pembayaran
          </button>            
            </button>
          </div>
        </div>
      `;
    }

    function renderProcessing() {
      const fontFamily = config.font_family || defaultConfig.font_family;
      const baseFontSize = config.font_size || defaultConfig.font_size;
      const textColor = config.text_color || defaultConfig.text_color;
      const primaryColor = config.primary_action_color || defaultConfig.primary_action_color;

      setTimeout(() => {
        currentView = 'completed';
        render();
      }, 3000);

      return `
    <div class="w-full h-full flex items-center justify-center p-4"
       style="background: #1a0033; font-family: ${fontFamily}, sans-serif;">  
          <div class="w-full max-w-md rounded-3xl shadow-2xl p-8 text-center fade-in" style="background: #1e293b; border: 1px solid #334155;">
            <div class="w-24 h-24 rounded-full mx-auto mb-6 flex items-center justify-center" style="background: linear-gradient(135deg, ${primaryColor}, #a855f7);">
              <svg width="60" height="60" viewBox="0 0 60 60" class="animate-spin">
                <circle cx="30" cy="30" r="25" stroke="white" stroke-width="4" fill="none" stroke-dasharray="40 120"/>
              </svg>
            </div>
            <h2 class="font-bold mb-4" style="font-size: ${baseFontSize * 2}px; color: ${primaryColor};">Memproses Pembayaran</h2>
            <p class="mb-6" style="font-size: ${baseFontSize * 1.125}px; color: #cbd5e1;">Mohon ditunggu, pesanan Anda sedang kami proses...</p>
            <div class="flex items-center justify-center gap-2">
              <div class="w-3 h-3 rounded-full animate-bounce" style="background: ${primaryColor};"></div>
              <div class="w-3 h-3 rounded-full animate-bounce" style="background: ${primaryColor}; animation-delay: 0.2s;"></div>
              <div class="w-3 h-3 rounded-full animate-bounce" style="background: ${primaryColor}; animation-delay: 0.4s;"></div>
            </div>
          </div>
        </div>
      `;
    }

    function renderCompleted() {
      const fontFamily = config.font_family || defaultConfig.font_family;
      const baseFontSize = config.font_size || defaultConfig.font_size;
      const textColor = config.text_color || defaultConfig.text_color;
      const primaryColor = config.primary_action_color || defaultConfig.primary_action_color;

      return `
        <div class="w-full h-full flex items-center justify-center p-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); font-family: ${fontFamily}, sans-serif;">
          <div class="w-full max-w-md rounded-3xl shadow-2xl p-8 text-center fade-in" style="background: #1e293b; border: 1px solid #334155;">
            <div class="w-32 h-32 rounded-full mx-auto mb-6 flex items-center justify-center" style="background: linear-gradient(135deg, #16a34a, #22c55e);">
              <svg width="80" height="80" viewBox="0 0 80 80">
                <circle cx="40" cy="40" r="35" fill="white"/>
                <path d="M25 40 L35 50 L55 30" stroke="#16a34a" stroke-width="5" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </div>
            <h2 class="font-bold mb-4" style="font-size: ${baseFontSize * 2.5}px; color: #16a34a;">Pesanan Selesai!</h2>
            <p class="mb-3" style="font-size: ${baseFontSize * 1.25}px; color: #f1f5f9; font-weight: 600;">Terima kasih telah memesan!</p>
            <p class="mb-8" style="font-size: ${baseFontSize}px; color: #cbd5e1;">Pesanan Anda telah selesai diproses dan siap untuk diambil.</p>
            
            <div class="rounded-2xl p-6 mb-6" style="background: linear-gradient(135deg, ${primaryColor}, #a855f7); color: white;">
              <p class="font-semibold mb-2" style="font-size: ${baseFontSize}px;">Nomor Pesanan</p>
              <p class="font-bold" style="font-size: ${baseFontSize * 2}px;">#${Math.floor(Math.random() * 9000) + 1000}</p>
            </div>

            <div class="space-y-3">
              <button onclick="showView('home')" class="btn w-full font-semibold py-3 rounded-xl shadow-lg" style="background: ${primaryColor}; color: white; font-size: ${baseFontSize * 1.125}px;">
                Kembali ke Beranda
              </button>
              <button onclick="showView('orders')" class="btn w-full font-semibold py-3 rounded-xl" style="background: transparent; border: 2px solid ${primaryColor}; color: ${primaryColor}; font-size: ${baseFontSize}px;">
                Pesan Lagi
              </button>
            </div>
          </div>
        </div>
      `;
    }

    function render() {
      const app = document.getElementById('app');
      
      let html = '';
      switch(currentView) {
        case 'welcome':
          html = renderWelcome();
          break;
        case 'login':
          html = renderLogin();
          break;
        case 'signup':
          html = renderSignup();
          break;
        case 'home':
          html = renderHome();
          break;
        case 'menu':
          html = renderMenu();
          break;
        case 'customer':
          html = renderCustomer();
          break;
        case 'orders':
          html = renderOrders();
          break;
        case 'promoScan':
          html = renderPromoScan();
          break;
        case 'payment':
          html = renderPayment();
          break;
        case 'processing':
          html = renderProcessing();
          break;
        case 'completed':
          html = renderCompleted();
          break;
      }
      
      app.innerHTML = html;
    }

    async function onConfigChange(newConfig) {
      config = { ...config, ...newConfig };
      
      const customFont = config.font_family || defaultConfig.font_family;
      const baseFontStack = 'system-ui, -apple-system, sans-serif';
      document.body.style.fontFamily = `${customFont}, ${baseFontStack}`;
      
      render();
    }

    const dataHandler = {
      onDataChanged(data) {
        orders = data;
      }
    };

    window.addEventListener('DOMContentLoaded', async () => {
      if (window.dataSdk) {
        const initResult = await window.dataSdk.init(dataHandler);
        if (!initResult.isOk) {
          console.error('Failed to initialize data SDK');
        }
      }

      if (window.elementSdk) {
        window.elementSdk.init({
          defaultConfig,
          onConfigChange,
          mapToCapabilities: (config) => ({
            recolorables: [
              {
                get: () => config.background_color || defaultConfig.background_color,
                set: (value) => {
                  config.background_color = value;
                  window.elementSdk.setConfig({ background_color: value });
                }
              },
              {
                get: () => config.surface_color || defaultConfig.surface_color,
                set: (value) => {
                  config.surface_color = value;
                  window.elementSdk.setConfig({ surface_color: value });
                }
              },
              {
                get: () => config.text_color || defaultConfig.text_color,
                set: (value) => {
                  config.text_color = value;
                  window.elementSdk.setConfig({ text_color: value });
                }
              },
              {
                get: () => config.primary_action_color || defaultConfig.primary_action_color,
                set: (value) => {
                  config.primary_action_color = value;
                  window.elementSdk.setConfig({ primary_action_color: value });
                }
              },
              {
                get: () => config.secondary_action_color || defaultConfig.secondary_action_color,
                set: (value) => {
                  config.secondary_action_color = value;
                  window.elementSdk.setConfig({ secondary_action_color: value });
                }
              }
            ],
            borderables: [],
            fontEditable: {
              get: () => config.font_family || defaultConfig.font_family,
              set: (value) => {
                config.font_family = value;
                window.elementSdk.setConfig({ font_family: value });
              }
            },
            fontSizeable: {
              get: () => config.font_size || defaultConfig.font_size,
              set: (value) => {
                config.font_size = value;
                window.elementSdk.setConfig({ font_size: value });
              }
            }
          }),
          mapToEditPanelValues: (config) => new Map([
            ["brand_name", config.brand_name || defaultConfig.brand_name],
            ["welcome_description", config.welcome_description || defaultConfig.welcome_description],
            ["instagram_handle", config.instagram_handle || defaultConfig.instagram_handle]
          ])
        });
      }

      render();
    });
  </script>
  <script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');
  d.innerHTML="window.__CF$cv$params={r:'9ac1a7cec15cfd7f',t:'MTc2NTQyMTIyNy4wMDAwMDA='};var a=document.createElement('script')
  ;a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);
  ";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();
  </script></body>
</body>
  </html>
