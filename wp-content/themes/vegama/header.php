<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- ── AUTH MODAL ──────────────────────────────────────────── -->
<div class="mo ml" id="moLogin" onclick="moOut(event,'moLogin')">
  <div class="mo-box">
    <button class="mo-x" onclick="closeMo('moLogin')">✕</button>

    <h2 class="mp-name" style="margin-bottom:18px">
      <?php echo is_user_logged_in() ? 'Your account' : 'Welcome back'; ?>
    </h2>

    <?php if ( is_user_logged_in() ) : ?>

      <p style="color:var(--mist);font-size:14px;margin-bottom:20px">
        Signed in as <strong><?php echo esc_html( wp_get_current_user()->display_name ); ?></strong>
      </p>
      <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>" style="display:block">
        <button type="button" style="width:100%;background:var(--sage);color:#fff;font-weight:800;font-size:14.5px;padding:14px;border-radius:11px;border:none;cursor:pointer">
          Sign out
        </button>
      </a>

    <?php else : ?>

      <div class="tab-bar">
        <button class="tab-b on" onclick="switchTab('in',this)">Sign in</button>
        <button class="tab-b"    onclick="switchTab('up',this)">Create account</button>
      </div>

      <!-- Sign-in form -->
      <form class="auth-form" id="formIn">
        <?php wp_nonce_field( 'vegama_login', 'login_nonce' ); ?>
        <input type="text"     name="log" placeholder="Username or email" required>
        <input type="password" name="pwd" placeholder="Password"          required>
        <p id="loginMsg" style="font-size:13px;color:red;display:none;text-align:center"></p>
        <button type="submit">Sign in →</button>
      </form>

      <!-- Register form -->
      <form class="auth-form" id="formUp" style="display:none;flex-direction:column">
        <?php wp_nonce_field( 'vegama_register', 'register_nonce' ); ?>
        <input type="text"     name="user_login" placeholder="Username" required>
        <input type="email"    name="user_email" placeholder="Email"    required>
        <input type="password" name="user_pass"  placeholder="Password" required>
        <p id="registerMsg" style="font-size:13px;color:red;display:none;text-align:center"></p>
        <button type="submit">Create account →</button>
      </form>

    <?php endif; ?>
  </div>
</div>
<!-- ── /AUTH MODAL ─────────────────────────────────────────── -->

<header class="site-header<?php echo is_page( 'about' ) ? ' about-header' : ''; ?>" id="site-header">
  <nav class="site-nav">

    <!-- Logo -->
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-logo" rel="home">
  <svg class="nav-mark" viewBox="0 0 155.35 155.35" width="38" height="38" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
    <circle fill="#f4eedc" cx="77.68" cy="77.68" r="77.68"/>
    <path fill="#185f30" d="M102.64,60.57h0c-.86-.23-1.87-.39-2.73-.62-.08,0-.16,0-.23-.16.86-3.51,4.84-4.68,7.49-6.56,1.48-1.09,2.19-1.8,1.72-3.75-.55-2.34-2.34-5.39-5.15-5.07-1.01.08-2.73,1.01-3.67,1.48-3.12,1.72-5.85,3.98-8.43,6.4.86-3.2,2.03-6.25,3.28-9.37.39-1.01.94-2.03,1.25-3.04.47-1.25,1.01-2.42-.23-3.51-1.01-.94-6.25-3.12-7.65-3.28-1.17,0-1.56.55-2.11,1.41-1.09,1.8-1.87,4.14-2.81,6.01-1.17,2.42-2.42,4.76-3.83,7.03-.23.16-.39-.55-.39-.7-.55-2.65-.47-5.85-.86-8.59-.08-.7-.16-1.41-.78-1.87-1.17-.78-5.85-.31-7.18.31-.86.39-1.17.86-1.33,1.8-.31,1.72-.39,3.98-.55,5.7-.16,1.72,0,3.83-.39,5.39q0,.16-.16.08c-2.19-5.23-3.12-10.93-4.92-16.32-.39-1.09-.7-2.26-1.87-2.65-1.87-.7-7.34-.7-9.13,0-1.64.62-2.26,1.72-1.87,3.43.55,2.81,2.03,6.01,2.81,8.9.7,2.73,1.17,5.54,1.25,8.35v3.04l-.39,4.14c-7.03,2.58-11.79,8.9-12.8,16.24-.39,2.81-.39,5.7,0,8.43,0,.47.08,1.01.23,1.41,1.56,9.45,6.87,18.35,13.66,24.75,4.76,4.45,10.85,8.9,16.24,12.57,2.03,1.33,4.84,3.43,7.34,3.28,3.04-.23,8.98-4.76,11.55-6.71,10.54-7.65,19.28-16.08,23.19-28.96.31-1.09.62-2.19.86-3.28h0v-.31.23c2.03-10.3-.55-22.17-11.55-25.92h0l.16.31Z"/>
  </svg>
  <span class="nav-wrd"><span class="veg">veg</span><span class="ama">ama</span></span>
</a>

    <!-- Nav links -->
    <ul class="nav-links">
      <li><a href="<?php echo esc_url( home_url( '/shop' ) ); ?>">Shop</a></li>
      <li><a href="<?php echo esc_url( home_url( '/recipes' ) ); ?>">Recipes</a></li>
      <li><a href="<?php echo esc_url( home_url( '/classes' ) ); ?>">Classes</a></li>
      <li><a href="<?php echo esc_url( home_url( '/about' ) ); ?>">About</a></li>
      <li><a href="<?php echo esc_url( home_url( '/sustainability' ) ); ?>">Sustainability</a></li>
    </ul>

    <!-- Right controls -->
    <div class="nav-right">
      <a href="<?php echo esc_url( function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/cart' ) ); ?>"
         class="cart-btn" aria-label="Cart">
        🛒<span class="cart-badge" id="cartBadge">0</span>
      </a>
      <button class="btn-nav" id="authOpen">
        <?php echo is_user_logged_in() ? esc_html( wp_get_current_user()->display_name ) : 'Sign in'; ?>
      </button>
    </div>

  </nav>

  <script>
  (function () {
    var hd = document.getElementById('site-header');
    window.addEventListener('scroll', function () {
      hd.classList.toggle('solid', window.scrollY > 20);
    });
  })();

  function openMo(id)  { document.getElementById(id).classList.add('open');    document.body.style.overflow = 'hidden'; }
  function closeMo(id) { document.getElementById(id).classList.remove('open'); document.body.style.overflow = '';       }
  function moOut(e, id){ if (e.target === document.getElementById(id)) closeMo(id); }

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      document.querySelectorAll('.mo.open').forEach(function (m) {
        m.classList.remove('open');
        document.body.style.overflow = '';
      });
    }
  });

  document.getElementById('authOpen').addEventListener('click', function () {
    openMo('moLogin');
  });

  function switchTab(t, btn) {
    document.querySelectorAll('.tab-b').forEach(function (b) { b.classList.remove('on'); });
    btn.classList.add('on');
    var fi = document.getElementById('formIn');
    var fu = document.getElementById('formUp');
    if (fi) { fi.style.display = t === 'in' ? 'flex' : 'none'; fi.style.flexDirection = 'column'; }
    if (fu) { fu.style.display = t === 'up' ? 'flex' : 'none'; fu.style.flexDirection = 'column'; }
  }

  var formIn = document.getElementById('formIn');
  if (formIn) {
    formIn.addEventListener('submit', function (e) {
      e.preventDefault();
      var data = new FormData(this);
      data.append('action', 'vegama_login');
      fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', { method: 'POST', body: data })
        .then(function (r) { return r.json(); })
        .then(function (res) {
          if (res.success) { location.reload(); }
          else { var m = document.getElementById('loginMsg'); m.textContent = res.data; m.style.display = 'block'; }
        });
    });
  }

  var formUp = document.getElementById('formUp');
  if (formUp) {
    formUp.addEventListener('submit', function (e) {
      e.preventDefault();
      var data = new FormData(this);
      data.append('action', 'vegama_register');
      fetch('<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>', { method: 'POST', body: data })
        .then(function (r) { return r.json(); })
        .then(function (res) {
          if (res.success) { location.reload(); }
          else { var m = document.getElementById('registerMsg'); m.textContent = res.data; m.style.display = 'block'; }
        });
    });
  }
  </script>
</header>