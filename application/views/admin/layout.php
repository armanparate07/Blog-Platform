<!-- application/views/admin/layout.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title><?php echo isset($page_title) ? $page_title : 'Admin'; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Prevent flash: apply saved theme BEFORE paint -->
  <script>
    (function() {
      const saved = localStorage.getItem('theme');
      if (saved === 'light') document.documentElement.classList.add('theme-light');
    })();
  </script>

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

    /* ===== DARK THEME (default) ===== */
    body {
      font-family: 'Inter', sans-serif;
      background: #050814;
      color: #e5e7eb;
      margin: 0;
      transition: background 0.3s ease, color 0.3s ease;
    }

    /* ===== GLOBAL THEME TOKENS (used by cards, inputs, etc.) ===== */
    :root {
      --bg-card:          rgba(15, 23, 42, 0.95);
      --bg-input:         #050814;
      --border-card:      rgba(148, 163, 184, 0.15);
      --border-subtle:    rgba(255, 255, 255, 0.05);
      --border-input:     rgba(51, 65, 85, 0.7);
      --shadow-card:      0 16px 40px rgba(15, 23, 42, 0.8), 0 0 0 1px rgba(148, 163, 184, 0.18);
      --text-heading:     #f1f5f9;
      --text-primary:     #e2e8f0;
      --text-secondary:   #94a3b8;
      --text-muted:       #64748b;
      --text-link:        #f1f5f9;
      --badge-cat-bg:     rgba(255, 255, 255, 0.05);
      --badge-cat-border: rgba(255, 255, 255, 0.1);
      --badge-cat-text:   #cbd5e1;
    }

    /* ===== SOFTER LIGHT THEME ===== */
    .theme-light {
      --bg-card:          #e8eaef;
      --bg-input:         #dfe2e8;
      --border-card:      #c9ced6;
      --border-subtle:    #d1d5db;
      --border-input:     #bfc5cd;
      --shadow-card:      0 1px 3px rgba(0, 0, 0, 0.06), 0 0 0 1px rgba(0, 0, 0, 0.03);
      --text-heading:     #1e293b;
      --text-primary:     #334155;
      --text-secondary:   #475569;
      --text-muted:       #64748b;
      --text-link:        #1e293b;
      --badge-cat-bg:     #dde0e7;
      --badge-cat-border: #c9ced6;
      --badge-cat-text:   #475569;
    }

    .sidebar {
      background: linear-gradient(180deg, #0b1220 0%, #050816 100%);
      border-right: 1px solid rgba(148,163,184,0.1);
      transition: background 0.3s ease, border-color 0.3s ease;
    }
    .sidebar-item { transition: all 0.2s ease; color: #ffffff; }
    .sidebar-item:hover { background: rgba(148,163,184,0.08); color: #ffffff; }
    .sidebar-item.active {
      background: rgba(15,23,42,1);
      color: #ffffff;
      position: relative;
    }
    .sidebar-item.active::before {
      content: "";
      position: absolute;
      left: 0;
      top: 50%;
      transform: translateY(-50%);
      width: 4px;
      height: 32px;
      border-radius: 0 999px 999px 0;
      background: linear-gradient(180deg, #6366f1, #22c1c3);
      box-shadow: 0 0 10px rgba(129,140,248,0.7);
    }

    .main-area { background: #050814; transition: background 0.3s ease; }
    .mobile-topbar { background: #0b1220; transition: background 0.3s ease; }
    .logout-link { color: #ffffff; }

    .scrollbar-thin::-webkit-scrollbar { width: 6px; }
    .scrollbar-thin::-webkit-scrollbar-thumb {
      background: rgba(148,163,184,0.4);
      border-radius: 999px;
    }

    /* ===== LIGHT THEME OVERRIDES ===== */
    .theme-light body,
    html.theme-light body {
      background: #d8dce3;
      color: #334155;
    }

    .theme-light .sidebar {
      background: linear-gradient(180deg, #e2e5eb 0%, #d8dce3 100%);
      border-right-color: #c9ced6;
    }
    .theme-light .sidebar-item {
      color: #000000;
    }
    .theme-light .sidebar-item:hover {
      background: rgba(99,102,241,0.08);
      color: #000000;
    }
    .theme-light .sidebar-item.active {
      background: #cdd5e4;
      color: #000000;
    }
    .theme-light .sidebar-item.active::before {
      background: linear-gradient(180deg, #4f46e5, #10b981);
      box-shadow: 0 0 10px rgba(79,70,229,0.5);
    }

    .theme-light .main-area {
      background: #dfe2e8;
    }
    .theme-light .mobile-topbar {
      background: #e2e5eb;
      border-bottom-color: #c9ced6;
    }
    .theme-light .mobile-topbar span {
      color: #1e293b;
    }
    .theme-light .mobile-topbar button {
      color: #475569;
    }
    .theme-light .logout-link {
      color: #000000;
    }
    .theme-light .sidebar-overlay.active {
      background: rgba(0, 0, 0, 0.3);
    }
    .theme-light .scrollbar-thin::-webkit-scrollbar-thumb {
      background: rgba(100,116,139,0.5);
    }

    /* ===== FIXED BUTTON VISIBILITY FOR BOTH THEMES ===== */
    .btn-primary, .btn-new, .btn-add, button[class*="new"], button[class*="add"],
    a[class*="new"], a[class*="add"], [class*="btn-new"], [class*="btn-add"] {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
      color: black !important;
      border: 1px solid rgba(255,255,255,0.2) !important;
      padding: 0.75rem 1.5rem !important;
      border-radius: 0.75rem !important;
      font-weight: 600 !important;
      font-size: 0.875rem !important;
      transition: all 0.2s ease !important;
      text-decoration: none !important;
      display: inline-flex !important;
      align-items: center !important;
      gap: 0.5rem !important;
      box-shadow: 0 4px 14px rgba(102,126,234,0.4) !important;
    }

    .btn-primary:hover, .btn-new:hover, .btn-add:hover,
    button[class*="new"]:hover, button[class*="add"]:hover,
    a[class*="new"]:hover, a[class*="add"]:hover {
      background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%) !important;
      transform: translateY(-1px) !important;
      box-shadow: 0 8px 25px rgba(102,126,234,0.6) !important;
    }

    .theme-light .btn-primary, .theme-light .btn-new, .theme-light .btn-add,
    .theme-light button[class*="new"], .theme-light button[class*="add"],
    .theme-light a[class*="new"], .theme-light a[class*="add"] {
      background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%) !important;
      border-color: rgba(79,70,229,0.3) !important;
      color: black !important;
      box-shadow: 0 4px 14px rgba(79,70,229,0.4) !important;
    }

    .theme-light .btn-primary:hover, .theme-light .btn-new:hover, .theme-light .btn-add:hover {
      background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%) !important;
      box-shadow: 0 8px 25px rgba(79,70,229,0.6) !important;
    }

    /* Ensure cards and content areas have proper contrast */
    .card, [class*="card"], .content-card {
      background: var(--bg-card) !important;
      border: 1px solid var(--border-card) !important;
      color: var(--text-primary) !important;
      border-radius: 1rem !important;
    }

    /* Theme toggle switch styles */
    .theme-switch {
      width: 44px;
      height: 24px;
      background: #334155;
      border-radius: 999px;
      position: relative;
      cursor: pointer;
      transition: background 0.3s ease;
      border: none;
      padding: 0;
    }
    .theme-switch::after {
      content: "";
      position: absolute;
      top: 3px;
      left: 3px;
      width: 18px;
      height: 18px;
      border-radius: 50%;
      background: #818cf8;
      transition: transform 0.3s ease, background 0.3s ease;
      box-shadow: inset -3px -2px 0 0 #e5e7eb;
    }
    .theme-light .theme-switch {
      background: #9ca3af;
    }
    .theme-light .theme-switch::after {
      transform: translateX(20px);
      background: #f59e0b;
      box-shadow: none;
    }

    /* ===== MOBILE SIDEBAR ===== */
    @media (max-width: 767px) {
      .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 50;
        height: 100vh;
        transform: translateX(-100%);
        transition: transform 0.3s ease, background 0.3s ease;
      }
      .sidebar.open {
        transform: translateX(0);
      }
      .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        z-index: 40;
      }
      .sidebar-overlay.active {
        display: block;
      }
      .sidebar-toggle {
        display: flex;
      }
      .main-wrapper {
        padding-top: 56px;
      }
    }

    @media (min-width: 768px) {
      .sidebar-toggle {
        display: none !important;
      }
      .sidebar-overlay {
        display: none !important;
      }
    }

    .mobile-topbar {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 30;
      height: 56px;
      border-bottom: 1px solid rgba(148,163,184,0.1);
      align-items: center;
      padding: 0 16px;
      gap: 12px;
    }
    @media (max-width: 767px) {
      .mobile-topbar {
        display: flex;
      }
    }
  </style>
</head>

<body class="h-screen w-screen overflow-hidden">

<?php
  $role = $this->session->userdata('role');
?>

<!-- ===== MOBILE TOP BAR ===== -->
<div class="mobile-topbar">
  <button
    class="sidebar-toggle w-10 h-10 rounded-xl flex items-center justify-center text-slate-300 hover:bg-white/5 transition-colors"
    id="sidebarToggle">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
         stroke="currentColor" stroke-width="2" stroke-linecap="round">
      <line x1="3" y1="6" x2="21" y2="6"/>
      <line x1="3" y1="12" x2="21" y2="12"/>
      <line x1="3" y1="18" x2="21" y2="18"/>
    </svg>
  </button>
  <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-indigo-400 via-blue-500 to-purple-500 flex items-center justify-center shadow-lg">
    <span class="text-sm font-black text-white">P</span>
  </div>
  <span class="text-sm font-semibold text-slate-200">
    <?php echo isset($page_title) ? $page_title : 'Admin'; ?>
  </span>
  <button class="theme-switch ml-auto" id="mobileThemeToggle" title="Toggle light/dark mode"></button>
</div>

<!-- ===== DARK OVERLAY ===== -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="flex h-full w-full">

  <!-- ===== SIDEBAR ===== -->
  <aside class="sidebar w-56 flex flex-col py-6 px-4 shrink-0 h-full" id="sidebar">

    <!-- Close button (mobile only) -->
    <button
      class="sidebar-toggle w-8 h-8 rounded-lg flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/5 mb-4 self-end transition-colors"
      id="sidebarClose">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
           stroke="currentColor" stroke-width="2" stroke-linecap="round">
        <line x1="18" y1="6" x2="6" y2="18"/>
        <line x1="6" y1="6" x2="18" y2="18"/>
      </svg>
    </button>

    <!-- Logo -->
    <div class="flex items-center gap-3 mb-8 px-2">
      <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-indigo-400 via-blue-500 to-purple-500 flex items-center justify-center shadow-xl">
        <span class="text-lg font-black text-black">P</span>
      </div>
    </div>

    <!-- Nav -->
    <nav class="flex-1 space-y-1 text-sm overflow-y-auto scrollbar-thin">

      <?php if($role === 'admin'): ?>
        <a href="<?php echo base_url('admin'); ?>"
           class="sidebar-item <?php echo ($active_menu=='dashboard')?'active':''; ?> flex items-center gap-3 px-3 py-2.5 rounded-xl">
          <svg width="18" height="18" viewBox="0 0 24 24">
            <rect x="3" y="3" width="7" height="7" rx="1" fill="currentColor"/>
            <rect x="14" y="3" width="7" height="7" rx="1" fill="currentColor" opacity=".8"/>
            <rect x="14" y="14" width="7" height="7" rx="1" fill="currentColor" opacity=".7"/>
            <rect x="3" y="14" width="7" height="7" rx="1" fill="currentColor" opacity=".6"/>
          </svg>
          <span>Dashboard</span>
        </a>
      <?php endif; ?>

      <a href="<?php echo base_url('posts'); ?>"
         class="sidebar-item <?php echo ($active_menu=='posts')?'active':''; ?> flex items-center gap-3 px-3 py-2.5 rounded-xl">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="1.6">
          <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
          <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
        </svg>
        <span>Posts</span>
      </a>

      <a href="<?php echo base_url('categories'); ?>"
         class="sidebar-item <?php echo ($active_menu=='categories')?'active':''; ?> flex items-center gap-3 px-3 py-2.5 rounded-xl">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="1.6">
          <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
        </svg>
        <span>Categories</span>
      </a>

    </nav>

    <!-- Theme toggle + Logout -->
    <div class="mt-4 border-t border-white/5 pt-4 space-y-3">
      <div class="flex items-center justify-between px-2">
        <div class="flex items-center gap-2">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="1.6" class="text-slate-400">
            <circle cx="12" cy="12" r="5"/>
            <line x1="12" y1="1" x2="12" y2="3"/>
            <line x1="12" y1="21" x2="12" y2="23"/>
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
            <line x1="1" y1="12" x2="3" y2="12"/>
            <line x1="21" y1="12" x2="23" y2="12"/>
            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
          </svg>
          <span class="text-[11px] text-slate-400" id="themeLabel">Dark</span>
        </div>
        <button class="theme-switch" id="desktopThemeToggle" title="Toggle light/dark mode"></button>
      </div>

      <div class="flex items-center gap-3 px-2">
        <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-purple-400 via-indigo-400 to-blue-400"></div>
        <a href="<?php echo base_url('auth/logout'); ?>"
           class="logout-link text-xs hover:text-black transition-colors">
          Logout
        </a>
      </div>
    </div>
  </aside>

  <!-- ===== MAIN CONTENT AREA ===== -->
  <main class="main-wrapper main-area flex-1 min-w-0 h-full overflow-y-auto flex flex-col scrollbar-thin">
    <?php $this->load->view($content_view, $content_data); ?>
  </main>

</div>

<!-- ===== SCRIPTS ===== -->
<script>
  const sidebar   = document.getElementById('sidebar');
  const overlay   = document.getElementById('sidebarOverlay');
  const toggleBtn = document.getElementById('sidebarToggle');
  const closeBtn  = document.getElementById('sidebarClose');

  function openSidebar() {
    sidebar.classList.add('open');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeSidebar() {
    sidebar.classList.remove('open');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
  }

  toggleBtn?.addEventListener('click', openSidebar);
  closeBtn?.addEventListener('click', closeSidebar);
  overlay?.addEventListener('click', closeSidebar);

  sidebar?.querySelectorAll('.sidebar-item').forEach(link => {
    link.addEventListener('click', () => {
      if (window.innerWidth < 768) closeSidebar();
    });
  });

  const html           = document.documentElement;
  const desktopToggle  = document.getElementById('desktopThemeToggle');
  const mobileToggle   = document.getElementById('mobileThemeToggle');
  const themeLabel     = document.getElementById('themeLabel');

  function updateLabel() {
    const isLight = html.classList.contains('theme-light');
    if (themeLabel) themeLabel.textContent = isLight ? 'Light' : 'Dark';
  }

  function toggleTheme() {
    const isLight = html.classList.toggle('theme-light');
    localStorage.setItem('theme', isLight ? 'light' : 'dark');
    updateLabel();
  }

  updateLabel();

  desktopToggle?.addEventListener('click', toggleTheme);
  mobileToggle?.addEventListener('click', toggleTheme);
</script>

</body>
</html>
