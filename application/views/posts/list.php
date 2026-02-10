<!-- views/posts/list.php -->
<style>
  .post-card {
    background: var(--bg-card, rgba(15,23,42,0.98));
    border: 1px solid var(--border-card, rgba(148,163,184,0.15));
    box-shadow: var(--shadow-card, 0 20px 60px rgba(0,0,0,0.85), 0 0 0 1px rgba(148,163,184,0.25));
    border-radius: 18px;
    transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.3s, border-color 0.3s;
  }
  .post-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 28px 40px rgba(0,0,0,0.08), 0 0 0 1px var(--border-card, rgba(148,163,184,0.35));
  }
  .image-placeholder {
    background: var(--bg-input, radial-gradient(circle at top left, rgba(148,163,184,0.12), rgba(30,41,59,0.9)));
    border: 1px solid var(--border-card, rgba(148,163,184,0.1));
    transition: background 0.3s, border-color 0.3s;
  }

  /* Theme-aware helpers */
  .l-border  { border-color: var(--border-subtle, rgba(255,255,255,0.05)); }
  .l-heading { color: var(--text-heading, #f1f5f9); }
  .l-primary { color: var(--text-primary, #e2e8f0); }
  .l-second  { color: var(--text-secondary, #94a3b8); }
  .l-muted   { color: var(--text-muted, #64748b); }

  .l-input {
    background: var(--bg-input, #050814);
    border: 1px solid var(--border-input, rgba(51,65,85,0.7));
    color: var(--text-primary, #e2e8f0);
    transition: background 0.3s, border-color 0.3s, color 0.3s;
  }
  .l-input::placeholder { color: var(--text-muted, #64748b); }

  .l-cat-badge {
    background: var(--badge-cat-bg, rgba(255,255,255,0.05));
    border: 1px solid var(--badge-cat-border, rgba(255,255,255,0.1));
    color: var(--badge-cat-text, #cbd5e1);
    transition: background 0.3s, border-color 0.3s, color 0.3s;
  }

  .l-icon-btn {
    background: var(--badge-cat-bg, rgba(255,255,255,0.05));
    color: var(--text-secondary, #94a3b8);
    transition: background 0.2s;
  }
  .l-icon-btn:hover { opacity: 0.8; }

  /* ===== Pagination (theme-aware) ===== */
  .pagination {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
  }
  .pagination .page-item .page-link {
    background: var(--bg-card, rgba(15,23,42,0.9));
    border: 1px solid var(--border-card, rgba(148,163,184,0.15));
    color: var(--text-secondary, #94a3b8);
    border-radius: 10px;
    padding: 8px 14px;
    font-size: 13px;
    transition: all 0.2s ease;
    text-decoration: none;
  }
  .pagination .page-item .page-link:hover {
    background: rgba(99,102,241,0.15);
    border-color: rgba(99,102,241,0.4);
    color: #818cf8;
  }
  .pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    border-color: transparent;
    color: #fff;
    font-weight: 600;
  }

  /* Light-mode pagination refinement */
  .theme-light .pagination .page-item .page-link:hover {
    color: #4338ca;
  }
</style>

<!-- Top bar -->
<header class="flex items-center justify-between gap-4 px-6 py-4 shrink-0 border-b l-border">
  <!-- Search -->
  <div class="flex-1 max-w-lg">
    <div class="relative">
      <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
        <svg width="18" height="18" viewBox="0 0 24 24" class="l-muted">
          <circle cx="11" cy="11" r="7" fill="none" stroke="currentColor" stroke-width="1.6"/>
          <line x1="16.5" y1="16.5" x2="21" y2="21" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
        </svg>
      </div>
      <input
        class="l-input w-full rounded-2xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500/70"
        placeholder="Search"
        id="searchInput"
        onkeyup="filterPosts()"
      />
    </div>
  </div>

  <!-- New Post + Admin + Bell -->
  <div class="flex items-center gap-3">
    <?php if($user_role == 'admin'): ?>
      <a href="<?php echo base_url('admin'); ?>" class="soft-pill px-4 py-2 rounded-xl text-xs l-second flex items-center gap-2 hover:bg-white/5 transition-colors">
        <span class="px-1.5 py-0.5 rounded bg-red-500/20 text-red-400 text-[9px] font-bold">Admin</span>
        Dashboard
      </a>
    <?php endif; ?>
    <!-- CHANGED text color here: text-black instead of text-white -->
    <a href="<?php echo base_url('posts/create'); ?>" class="pill-btn text-sm text-black px-5 py-2.5 rounded-2xl flex items-center gap-2 no-underline">
      New Post
      <span class="w-6 h-6 rounded-full bg-white/15 flex items-center justify-center text-base">+</span>
    </a>
    <a href="<?php echo base_url('admin/pending_posts'); ?>" class="soft-pill w-10 h-10 rounded-2xl flex items-center justify-center relative">
      <svg width="18" height="18" viewBox="0 0 24 24" class="l-primary">
        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" fill="none" stroke="currentColor" stroke-width="1.6"/>
        <path d="M13.73 21a2 2 0 0 1-3.46 0" fill="none" stroke="currentColor" stroke-width="1.6"/>
      </svg>
      <span class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 rounded-full bg-red-500"></span>
    </a>
  </div>
</header>

<!-- Scrollable Content -->
<div class="flex-1 overflow-y-auto p-6 scrollbar-thin">

  <?php if(empty($posts)): ?>
    <div class="post-card p-10 text-center">
      <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" class="mx-auto mb-4 l-muted">
        <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/>
        <polyline points="13 2 13 9 20 9"/>
      </svg>
      <h3 class="text-lg font-semibold mb-2 l-heading">No posts found!</h3>
      <p class="text-sm l-second mb-4">Be the first to create a post.</p>
      <a href="<?php echo base_url('posts/create'); ?>" class="pill-btn inline-flex items-center gap-2 text-sm text-white px-5 py-2.5 rounded-2xl">
        Create Post <span>+</span>
      </a>
    </div>
  <?php else: ?>
    <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3" id="postsGrid">
      <?php foreach($posts as $post): ?>
        <article class="post-card p-4 flex flex-col post-item">

          <!-- Image placeholder / Featured image -->
          <?php if(!empty($post->image)): ?>
            <div class="rounded-xl h-44 mb-4 overflow-hidden">
              <img src="<?php echo base_url('uploads/'.$post->image); ?>"
                   alt="<?php echo htmlspecialchars($post->title); ?>"
                   class="w-full h-full object-cover" />
            </div>
          <?php else: ?>
            <div class="image-placeholder rounded-xl h-44 mb-4 flex items-center justify-center">
              <svg width="32" height="32" viewBox="0 0 24 24" class="l-muted">
                <rect x="3" y="3" width="18" height="18" rx="2" fill="none" stroke="currentColor" stroke-width="1.6"/>
                <circle cx="9" cy="9" r="2" fill="currentColor"/>
                <path d="M21 15l-4-4-5 7" fill="none" stroke="currentColor" stroke-width="1.6"/>
              </svg>
            </div>
          <?php endif; ?>

          <!-- Title -->
          <a href="<?php echo base_url('posts/view/'.$post->id); ?>">
            <h3 class="text-sm md:text-base font-semibold mb-2 l-heading hover:text-indigo-400 transition-colors post-title">
              <?php echo htmlspecialchars($post->title); ?>
            </h3>
          </a>

          <!-- Author + Date -->
          <div class="flex items-center justify-between text-[11px] l-second mb-2">
            <div class="flex items-center gap-2">
              <div class="w-5 h-5 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-[9px] font-bold text-white shrink-0">
                <?php echo strtoupper(substr($post->username, 0, 1)); ?>
              </div>
              <span>Author: <?php echo htmlspecialchars($post->username); ?></span>
            </div>
            <span class="l-muted"><?php echo date('M d, Y', strtotime($post->created_at)); ?></span>
          </div>

          <!-- Category + Status + Your Post -->
          <div class="flex flex-wrap items-center gap-1.5 mb-3">
            <span class="l-cat-badge px-2 py-0.5 rounded-md text-[10px]">
              <?php echo htmlspecialchars($post->category_name); ?>
            </span>
            <?php if($post->status == 'pending'): ?>
              <span class="px-2 py-0.5 rounded-md text-[10px] bg-amber-500/15 text-amber-400 border border-amber-500/20">Pending</span>
            <?php elseif($post->status == 'published'): ?>
              <span class="px-2 py-0.5 rounded-md text-[10px] bg-emerald-500/15 text-emerald-400 border border-emerald-500/20">Published</span>
            <?php else: ?>
              <span class="px-2 py-0.5 rounded-md text-[10px] bg-slate-500/15 text-slate-400 border border-slate-500/20">Draft</span>
            <?php endif; ?>
            <?php if($post->user_id == $user_id): ?>
              <span class="px-2 py-0.5 rounded-md text-[10px] bg-indigo-500/15 text-indigo-400 border border-indigo-500/20">Your Post</span>
            <?php endif; ?>
          </div>

          <!-- Excerpt -->
          <p class="text-[11px] l-second line-clamp-2 mb-4">
            <?php
              $content = strip_tags($post->content);
              echo (strlen($content) > 150) ? substr($content, 0, 150) . '...' : $content;
            ?>
          </p>

          <!-- Footer: Read More + Actions -->
          <div class="mt-auto flex items-center justify-between pt-3 border-t l-border">
            <a href="<?php echo base_url('posts/view/'.$post->id); ?>"
               class="text-[12px] font-medium text-indigo-400 hover:text-indigo-300 transition-colors">
              Read More →
            </a>

            <?php $can_edit = ($post->user_id == $user_id) || ($user_role == 'admin'); ?>
            <?php if($can_edit): ?>
              <div class="flex items-center gap-1.5">
                <a href="<?php echo base_url('posts/edit/'.$post->id); ?>"
                   class="w-7 h-7 rounded-lg bg-indigo-500/10 text-indigo-400 flex items-center justify-center hover:bg-indigo-500/20 transition-colors"
                   title="Edit">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                  </svg>
                </a>
                <a href="<?php echo base_url('posts/delete/'.$post->id); ?>"
                   onclick="return confirm('Are you sure you want to delete this post?')"
                   class="w-7 h-7 rounded-lg bg-red-500/10 text-red-400 flex items-center justify-center hover:bg-red-500/20 transition-colors"
                   title="Delete">
                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                  </svg>
                </a>
              </div>
            <?php endif; ?>
          </div>

        </article>
      <?php endforeach; ?>
    </div>

    <!-- ===== PAGINATION ===== -->
    <?php if(!empty($pagination)): ?>
      <div class="flex justify-center mt-8 mb-4">
        <?php echo $pagination; ?>
      </div>
    <?php endif; ?>

  <?php endif; ?>

</div>

<!-- Search filter script -->
<script>
  function filterPosts() {
    const query = document.getElementById('searchInput').value.toLowerCase();
    const cards = document.querySelectorAll('.post-item');
    cards.forEach(card => {
      const title = card.querySelector('.post-title').textContent.toLowerCase();
      card.style.display = title.includes(query) ? '' : 'none';
    });
  }
</script>
