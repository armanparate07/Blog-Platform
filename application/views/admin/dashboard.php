<!-- views/admin/dashboard.php -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
  /* ===== CSS CUSTOM PROPERTIES (theme tokens) ===== */
  :root {
    --bg-card:        rgba(15, 23, 42, 0.95);
    --shadow-card:    0 16px 40px rgba(15,23,42,0.8), 0 0 0 1px rgba(148,163,184,0.18);
    --border-subtle:  rgba(255,255,255,0.05);
    --border-card:    rgba(148,163,184,0.15);

    --bg-input:       #050814;
    --border-input:   rgba(51,65,85,0.7);

    --text-heading:   #f1f5f9;
    --text-primary:   #e2e8f0;
    --text-secondary: #94a3b8;
    --text-muted:     #64748b;
    --text-link:      #f1f5f9;
    --text-link-hover:#818cf8;

    --metric-indigo:  radial-gradient(circle at top left, rgba(99,102,241,0.25), rgba(15,23,42,0.95));
    --metric-amber:   radial-gradient(circle at top left, rgba(245,158,11,0.25), rgba(15,23,42,0.95));
    --metric-green:   radial-gradient(circle at top left, rgba(34,197,94,0.25), rgba(15,23,42,0.95));
    --metric-slate:   radial-gradient(circle at top left, rgba(100,116,139,0.25), rgba(15,23,42,0.95));

    --mobile-card-bg: radial-gradient(circle at top left, rgba(37,99,235,0.1), rgba(15,23,42,0.98));
    --mobile-card-border: rgba(148,163,184,0.12);

    --badge-cat-bg:   rgba(255,255,255,0.05);
    --badge-cat-border: rgba(255,255,255,0.05);
    --badge-cat-text: #cbd5e1;

    --table-hover:    rgba(148,163,184,0.04);
    --thead-bg:       rgba(255,255,255,0.02);
  }

  /* ===== LIGHT THEME TOKENS (toned down — no pure whites) ===== */
  .theme-light {
    --bg-card:        #f0f1f5;
    --shadow-card:    0 2px 12px rgba(0,0,0,0.06), 0 0 0 1px rgba(203,213,225,0.5);
    --border-subtle:  #e2e5eb;
    --border-card:    #d4d8e0;

    --bg-input:       #e8eaef;
    --border-input:   #d1d5db;

    --text-heading:   #111827;
    --text-primary:   #1e293b;
    --text-secondary: #4b5563;
    --text-muted:     #6b7280;
    --text-link:      #1e293b;
    --text-link-hover:#4338ca;

    --metric-indigo:  radial-gradient(circle at top left, rgba(99,102,241,0.12), #eef0f5);
    --metric-amber:   radial-gradient(circle at top left, rgba(245,158,11,0.12), #eef0f5);
    --metric-green:   radial-gradient(circle at top left, rgba(34,197,94,0.12), #eef0f5);
    --metric-slate:   radial-gradient(circle at top left, rgba(100,116,139,0.12), #eef0f5);

    --mobile-card-bg: #eef0f5;
    --mobile-card-border: #d4d8e0;

    --badge-cat-bg:   #e2e5eb;
    --badge-cat-border: #d1d5db;
    --badge-cat-text: #374151;

    --table-hover:    rgba(99,102,241,0.06);
    --thead-bg:       #e8eaef;
  }


  /* ===== COMPONENT STYLES ===== */
  .glass-card {
    background: var(--bg-card);
    border-radius: 16px;
    box-shadow: var(--shadow-card);
    min-width: 0;
    overflow: hidden;
    transition: background 0.3s, box-shadow 0.3s;
  }
  .metric-card {
    background: var(--metric-indigo);
    border-radius: 18px;
    border: 1px solid var(--border-card);
    min-width: 0;
    overflow: hidden;
    transition: background 0.3s, border-color 0.3s;
  }
  .metric-card.amber { background: var(--metric-amber); }
  .metric-card.green { background: var(--metric-green); }
  .metric-card.slate { background: var(--metric-slate); }

  .table-row:hover { background: var(--table-hover); }

  .mobile-post-card {
    background: var(--mobile-card-bg);
    border: 1px solid var(--mobile-card-border);
    border-radius: 14px;
    padding: 14px;
    transition: background 0.3s, border-color 0.3s;
  }

  /* Canvas container — prevents chart overflow */
  .chart-wrap {
    position: relative;
    min-width: 0;
    overflow: hidden;
  }

  /* Text helpers */
  .t-heading   { color: var(--text-heading);   transition: color 0.3s; }
  .t-primary   { color: var(--text-primary);    transition: color 0.3s; }
  .t-secondary { color: var(--text-secondary);  transition: color 0.3s; }
  .t-muted     { color: var(--text-muted);      transition: color 0.3s; }
  .t-link      { color: var(--text-link);       transition: color 0.3s; }
  .t-link:hover { color: var(--text-link-hover); }

  .b-subtle { border-color: var(--border-subtle); }

  .dash-input {
    background: var(--bg-input);
    border: 1px solid var(--border-input);
    color: var(--text-primary);
    transition: background 0.3s, border-color 0.3s, color 0.3s;
  }
  .dash-input::placeholder { color: var(--text-muted); }
  .dash-select {
    background: var(--bg-input);
    color: var(--text-secondary);
    transition: background 0.3s, color 0.3s;
  }

  .badge-cat {
    background: var(--badge-cat-bg);
    border: 1px solid var(--badge-cat-border);
    color: var(--badge-cat-text);
  }

  .theme-light .badge-pending   { background: rgba(245,158,11,0.15); color: #92400e; }
  .theme-light .badge-published { background: rgba(34,197,94,0.15);  color: #166534; }
  .theme-light .badge-draft     { background: rgba(100,116,139,0.15); color: #374151; }

  .theme-light .act-approve       { background: rgba(34,197,94,0.12);  color: #166534; }
  .theme-light .act-approve:hover { background: rgba(34,197,94,0.22); }
  .theme-light .act-reject        { background: rgba(245,158,11,0.12); color: #92400e; }
  .theme-light .act-reject:hover  { background: rgba(245,158,11,0.22); }
  .theme-light .act-edit          { background: rgba(99,102,241,0.12); color: #3730a3; }
  .theme-light .act-edit:hover    { background: rgba(99,102,241,0.22); }
  .theme-light .act-delete        { background: rgba(239,68,68,0.12);  color: #991b1b; }
  .theme-light .act-delete:hover  { background: rgba(239,68,68,0.22); }

  .theme-light .pending-pill {
    color: #92400e;
    background: rgba(245,158,11,0.15);
    border-color: rgba(245,158,11,0.3);
  }

  .dash-thead { background: var(--thead-bg); }


  /* ===== RESPONSIVE ===== */
  @media (max-width: 767px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr) !important; }
    .middle-grid {
      grid-template-columns: 1fr !important;
      height: auto !important;
    }
    .middle-grid > div {
      height: 220px;
      min-width: 0;
      overflow: hidden;
    }
    .desktop-table { display: none !important; }
    .mobile-posts-list { display: flex !important; }
    .top-bar-actions .search-box { display: none; }
    .top-bar-actions { justify-content: flex-end; }
  }
  @media (min-width: 768px) {
    .mobile-posts-list { display: none !important; }
  }
</style>


<!-- Top bar -->
<header class="top-bar-actions flex items-center justify-between gap-4 px-4 sm:px-6 py-4 shrink-0 border-b b-subtle">
  <div class="search-box flex-1 max-w-md">
    <div class="relative">
      <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
        <svg width="16" height="16" viewBox="0 0 24 24" class="t-muted"><circle cx="11" cy="11" r="7" fill="none" stroke="currentColor" stroke-width="1.6"/><line x1="16.5" y1="16.5" x2="21" y2="21" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
      </div>
      <input class="dash-input w-full rounded-xl pl-9 pr-3 py-2 text-xs focus:outline-none focus:ring-1 focus:ring-indigo-500/60" placeholder="Search" />
    </div>
  </div>
  <div class="flex items-center gap-2 sm:gap-3">
    <a href="<?php echo base_url('posts/create'); ?>" class="pill-btn text-xs text-white px-3 sm:px-4 py-2 rounded-xl flex items-center gap-1.5 no-underline whitespace-nowrap bg-indigo-600 hover:bg-indigo-700 transition-colors">
      New Post <span>+</span>
    </a>
    <a href="<?php echo base_url('admin/pending_posts'); ?>" class="soft-pill w-9 h-9 rounded-xl flex items-center justify-center relative" title="Pending Approvals">
      <svg width="18" height="18" viewBox="0 0 24 24" class="t-primary"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M13.73 21a2 2 0 0 1-3.46 0" fill="none" stroke="currentColor" stroke-width="1.6"/></svg>
      <?php if($pending_posts > 0): ?>
        <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full text-[9px] font-bold flex items-center justify-center text-white"><?php echo $pending_posts; ?></span>
      <?php endif; ?>
    </a>
  </div>
</header>


<!-- Scrollable Content Area -->
<div class="flex-1 overflow-y-auto p-4 sm:p-6 scrollbar-thin space-y-5">

  <div class="flex items-center gap-3">
    <h2 class="t-heading text-base sm:text-lg font-semibold">Site Overview</h2>
    <span class="px-2 py-0.5 rounded-md bg-red-500/20 text-red-400 text-[10px] font-bold uppercase">Admin</span>
  </div>


  <!-- ===== STATS CARDS ===== -->
  <div class="stats-grid grid grid-cols-4 gap-3 sm:gap-4 text-xs">

    <div class="metric-card p-3 sm:p-4 flex flex-col justify-between">
      <div class="flex items-center justify-between mb-1">
        <div class="t-secondary text-[10px] sm:text-[11px]">Total Posts</div>
        <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg bg-indigo-500/10 flex items-center justify-center">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#818cf8" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        </div>
      </div>
      <div class="t-heading text-xl sm:text-2xl font-bold mb-1 sm:mb-2"><?php echo $total_posts; ?></div>
      <div class="h-8 sm:h-10 chart-wrap"><canvas id="sparkTotal"></canvas></div>
    </div>

    <div class="metric-card amber p-3 sm:p-4 flex flex-col justify-between">
      <div class="flex items-center justify-between mb-1">
        <div class="t-secondary text-[10px] sm:text-[11px]">Pending</div>
        <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg bg-amber-500/10 flex items-center justify-center">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
      </div>
      <div class="t-heading text-xl sm:text-2xl font-bold mb-1 sm:mb-2"><?php echo $pending_posts; ?></div>
      <div class="h-8 sm:h-10 chart-wrap"><canvas id="sparkPending"></canvas></div>
    </div>

    <div class="metric-card green p-3 sm:p-4 flex flex-col justify-between">
      <div class="flex items-center justify-between mb-1">
        <div class="t-secondary text-[10px] sm:text-[11px]">Published</div>
        <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg bg-emerald-500/10 flex items-center justify-center">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        </div>
      </div>
      <div class="t-heading text-xl sm:text-2xl font-bold mb-1 sm:mb-2"><?php echo $published_posts; ?></div>
      <div class="h-8 sm:h-10 chart-wrap"><canvas id="sparkPublished"></canvas></div>
    </div>

    <div class="metric-card slate p-3 sm:p-4 flex flex-col justify-between">
      <div class="flex items-center justify-between mb-1">
        <div class="t-secondary text-[10px] sm:text-[11px]">Drafts</div>
        <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg bg-slate-500/10 flex items-center justify-center">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        </div>
      </div>
      <div class="t-heading text-xl sm:text-2xl font-bold mb-1 sm:mb-2"><?php echo $draft_posts; ?></div>
      <div class="h-8 sm:h-10 chart-wrap"><canvas id="sparkDraft"></canvas></div>
    </div>

  </div>


  <!-- ===== MIDDLE ROW: Traffic + Recent Activity ===== -->
  <div class="middle-grid grid grid-cols-5 gap-4" style="height: 240px;">

    <div class="col-span-5 md:col-span-3 glass-card p-4 flex flex-col">
      <div class="flex items-center justify-between mb-3 text-xs">
        <div class="t-heading font-medium">Website Traffic</div>
        <select class="dash-select soft-pill px-3 py-1 rounded-lg text-[11px] focus:outline-none cursor-pointer border-0">
          <option>Last month</option>
          <option>Last week</option>
          <option>Last year</option>
        </select>
      </div>
      <div class="flex-1 chart-wrap"><canvas id="traffic"></canvas></div>
    </div>

    <div class="col-span-5 md:col-span-2 glass-card p-4 flex flex-col text-xs">
      <div class="flex items-center justify-between mb-3">
        <div class="t-heading font-medium">Recent Activity</div>
        <select class="dash-select soft-pill px-3 py-1 rounded-lg text-[11px] focus:outline-none cursor-pointer border-0">
          <option>Latest action</option>
          <option>Oldest first</option>
        </select>
      </div>
      <div class="flex-1 overflow-y-auto scrollbar-thin space-y-1 pr-1">
        <?php if(!empty($posts)): ?>
          <?php $count = 0; foreach($posts as $post): if($count >= 4) break; ?>
            <div class="flex items-center gap-2 py-2 border-b b-subtle">
              <div class="w-7 h-7 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-[10px] font-bold text-white shrink-0">
                <?php echo strtoupper(substr($post->username, 0, 1)); ?>
              </div>
              <div class="flex-1 min-w-0">
                <div class="text-[11px] t-primary truncate"><?php echo htmlspecialchars($post->title); ?></div>
              </div>
              <div class="text-[10px] t-secondary shrink-0"><?php echo htmlspecialchars($post->username); ?></div>
              <div class="text-[10px] t-muted shrink-0"><?php echo date('M d', strtotime($post->created_at)); ?></div>
            </div>
          <?php $count++; endforeach; ?>
        <?php else: ?>
          <div class="t-muted text-center py-4">No recent activity</div>
        <?php endif; ?>
      </div>
    </div>

  </div>


  <!-- ===== POSTS TABLE (desktop) ===== -->
  <div class="glass-card rounded-2xl desktop-table">
    <div class="p-4 border-b b-subtle flex items-center justify-between flex-wrap gap-2">
      <div>
        <h3 class="t-heading text-sm font-semibold">All Posts Management</h3>
        <p class="t-muted text-[10px] mt-0.5">Manage, approve, or delete posts</p>
      </div>
      <div class="flex gap-2">
        <a href="<?php echo base_url('categories'); ?>" class="soft-pill px-3 py-1.5 rounded-lg text-[11px] t-secondary flex items-center gap-1.5 hover:bg-indigo-500/5 transition-colors">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
          Categories
        </a>
        <a href="<?php echo base_url('admin/pending_posts'); ?>" class="pending-pill px-3 py-1.5 rounded-lg text-[11px] text-amber-400 bg-amber-500/10 border border-amber-500/20 flex items-center gap-1.5 hover:bg-amber-500/20 transition-colors">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          Pending
          <span class="px-1.5 py-0.5 bg-amber-500/20 rounded text-[9px] font-bold"><?php echo $pending_posts; ?></span>
        </a>
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-xs">
        <thead>
          <tr class="dash-thead text-[10px] t-muted uppercase tracking-wider">
            <th class="px-4 py-3 text-left font-semibold">ID</th>
            <th class="px-4 py-3 text-left font-semibold">Title</th>
            <th class="px-4 py-3 text-left font-semibold">Author</th>
            <th class="px-4 py-3 text-left font-semibold">Category</th>
            <th class="px-4 py-3 text-left font-semibold">Status</th>
            <th class="px-4 py-3 text-left font-semibold">Created</th>
            <th class="px-4 py-3 text-right font-semibold">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y" style="border-color: var(--border-subtle);">
          <?php if(empty($posts)): ?>
            <tr>
              <td colspan="7" class="px-4 py-12 text-center t-muted">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" class="mx-auto mb-2"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
                <div class="text-sm">No posts found</div>
              </td>
            </tr>
          <?php else: ?>
            <?php foreach($posts as $post): ?>
              <tr class="table-row transition-colors">
                <td class="px-4 py-3 t-muted">#<?php echo $post->id; ?></td>
                <td class="px-4 py-3">
                  <a href="<?php echo base_url('posts/view/'.$post->id); ?>" class="t-link font-medium hover:text-indigo-500 transition-colors">
                    <?php echo htmlspecialchars($post->title); ?>
                  </a>
                </td>
                <td class="px-4 py-3">
                  <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-[9px] font-bold text-white shrink-0">
                      <?php echo strtoupper(substr($post->username, 0, 1)); ?>
                    </div>
                    <span class="t-secondary"><?php echo htmlspecialchars($post->username); ?></span>
                  </div>
                </td>
                <td class="px-4 py-3">
                  <span class="badge-cat px-2 py-0.5 rounded-md text-[10px]">
                    <?php echo htmlspecialchars($post->category_name); ?>
                  </span>
                </td>
                <td class="px-4 py-3">
                  <?php if($post->status == 'pending'): ?>
                    <span class="badge-pending px-2 py-0.5 rounded-md bg-amber-500/10 text-amber-400 text-[10px] font-medium">Pending</span>
                  <?php elseif($post->status == 'published'): ?>
                    <span class="badge-published px-2 py-0.5 rounded-md bg-emerald-500/10 text-emerald-400 text-[10px] font-medium">Published</span>
                  <?php else: ?>
                    <span class="badge-draft px-2 py-0.5 rounded-md bg-slate-500/10 text-slate-400 text-[10px] font-medium">Draft</span>
                  <?php endif; ?>
                </td>
                <td class="px-4 py-3 t-secondary"><?php echo date('M d, Y', strtotime($post->created_at)); ?></td>
                <td class="px-4 py-3">
                  <div class="flex items-center justify-end gap-1.5">
                    <?php if($post->status == 'pending'): ?>
                      <a href="<?php echo base_url('admin/approve_post/'.$post->id); ?>" class="act-approve w-7 h-7 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center hover:bg-emerald-500/20 transition-colors" title="Approve">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                      </a>
                      <a href="<?php echo base_url('admin/reject_post/'.$post->id); ?>" class="act-reject w-7 h-7 rounded-lg bg-amber-500/10 text-amber-400 flex items-center justify-center hover:bg-amber-500/20 transition-colors" title="Reject">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                      </a>
                    <?php endif; ?>
                    <a href="<?php echo base_url('posts/edit/'.$post->id); ?>" class="act-edit w-7 h-7 rounded-lg bg-indigo-500/10 text-indigo-400 flex items-center justify-center hover:bg-indigo-500/20 transition-colors" title="Edit">
                      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </a>
                    <a href="<?php echo base_url('admin/delete_post/'.$post->id); ?>" onclick="return confirm('Are you sure you want to delete this post?')" class="act-delete w-7 h-7 rounded-lg bg-red-500/10 text-red-400 flex items-center justify-center hover:bg-red-500/20 transition-colors" title="Delete">
                      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>


  <!-- ===== MOBILE POSTS CARDS ===== -->
  <div class="mobile-posts-list flex-col gap-3" style="display:none;">
    <div class="flex items-center justify-between mb-1">
      <div>
        <h3 class="t-heading text-sm font-semibold">All Posts</h3>
        <p class="t-muted text-[10px] mt-0.5">Manage, approve, or delete</p>
      </div>
      <div class="flex gap-2">
        <a href="<?php echo base_url('categories'); ?>" class="soft-pill px-2.5 py-1 rounded-lg text-[10px] t-secondary hover:bg-indigo-500/5 transition-colors">Categories</a>
        <a href="<?php echo base_url('admin/pending_posts'); ?>" class="pending-pill px-2.5 py-1 rounded-lg text-[10px] text-amber-400 bg-amber-500/10 border border-amber-500/20">
          Pending <?php echo $pending_posts; ?>
        </a>
      </div>
    </div>

    <?php if(empty($posts)): ?>
      <div class="mobile-post-card text-center py-8">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" class="mx-auto mb-2 t-muted"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
        <p class="text-xs t-muted">No posts found</p>
      </div>
    <?php else: ?>
      <?php foreach($posts as $post): ?>
        <div class="mobile-post-card">
          <div class="flex items-start justify-between gap-2 mb-2">
            <a href="<?php echo base_url('posts/view/'.$post->id); ?>" class="text-[13px] font-semibold t-link hover:text-indigo-500 transition-colors leading-snug flex-1">
              <?php echo htmlspecialchars($post->title); ?>
            </a>
            <span class="text-[10px] t-muted shrink-0">#<?php echo $post->id; ?></span>
          </div>

          <div class="flex items-center gap-2 mb-2.5">
            <div class="w-5 h-5 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-[8px] font-bold text-white shrink-0">
              <?php echo strtoupper(substr($post->username, 0, 1)); ?>
            </div>
            <span class="text-[10px] t-secondary"><?php echo htmlspecialchars($post->username); ?></span>
            <span class="text-[10px] t-muted">·</span>
            <span class="text-[10px] t-muted"><?php echo date('M d, Y', strtotime($post->created_at)); ?></span>
          </div>

          <div class="flex flex-wrap items-center gap-1.5 mb-3">
            <span class="badge-cat px-2 py-0.5 rounded-md text-[9px]">
              <?php echo htmlspecialchars($post->category_name); ?>
            </span>
            <?php if($post->status == 'pending'): ?>
              <span class="badge-pending px-2 py-0.5 rounded-md bg-amber-500/10 text-amber-400 text-[9px] font-medium">Pending</span>
            <?php elseif($post->status == 'published'): ?>
              <span class="badge-published px-2 py-0.5 rounded-md bg-emerald-500/10 text-emerald-400 text-[9px] font-medium">Published</span>
            <?php else: ?>
              <span class="badge-draft px-2 py-0.5 rounded-md bg-slate-500/10 text-slate-400 text-[9px] font-medium">Draft</span>
            <?php endif; ?>
          </div>

          <div class="flex items-center gap-1.5 pt-2.5 border-t b-subtle">
            <?php if($post->status == 'pending'): ?>
              <a href="<?php echo base_url('admin/approve_post/'.$post->id); ?>" class="act-approve flex-1 py-1.5 rounded-lg bg-emerald-500/10 text-emerald-400 text-[10px] font-medium text-center hover:bg-emerald-500/20 transition-colors">✓ Approve</a>
              <a href="<?php echo base_url('admin/reject_post/'.$post->id); ?>" class="act-reject flex-1 py-1.5 rounded-lg bg-amber-500/10 text-amber-400 text-[10px] font-medium text-center hover:bg-amber-500/20 transition-colors">✕ Reject</a>
            <?php endif; ?>
            <a href="<?php echo base_url('posts/edit/'.$post->id); ?>" class="act-edit flex-1 py-1.5 rounded-lg bg-indigo-500/10 text-indigo-400 text-[10px] font-medium text-center hover:bg-indigo-500/20 transition-colors">Edit</a>
            <a href="<?php echo base_url('admin/delete_post/'.$post->id); ?>" onclick="return confirm('Delete this post?')" class="act-delete flex-1 py-1.5 rounded-lg bg-red-500/10 text-red-400 text-[10px] font-medium text-center hover:bg-red-500/20 transition-colors">Delete</a>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

</div>


<!-- Charts Script (theme-aware) -->
<script>
  const isLight = document.documentElement.classList.contains('theme-light');

  const C = {
    grid:      isLight ? 'rgba(203,213,225,0.5)' : 'rgba(255,255,255,0.03)',
    gridY:     isLight ? 'rgba(203,213,225,0.5)' : 'rgba(30,64,175,0.2)',
    tick:      isLight ? '#6b7280' : '#6b7280',
    tipBg:     isLight ? 'rgba(240,241,245,0.98)' : 'rgba(15,23,42,0.95)',
    tipBorder: isLight ? '#d1d5db' : 'rgba(148,163,184,0.4)',
    tipTitle:  isLight ? '#111827' : '#e5e7eb',
    tipBody:   isLight ? '#374151' : '#cbd5f5',
    grad1Top:  isLight ? 'rgba(96,165,250,0.25)'  : 'rgba(96,165,250,0.5)',
    grad1Bot:  isLight ? 'rgba(240,241,245,0.01)' : 'rgba(15,23,42,0.05)',
    grad2Top:  isLight ? 'rgba(167,139,250,0.25)'  : 'rgba(167,139,250,0.5)',
    grad2Bot:  isLight ? 'rgba(240,241,245,0.01)' : 'rgba(15,23,42,0.05)',
  };

  const sparkOpts = {
    responsive: true, maintainAspectRatio: false,
    plugins: { legend: { display: false }, tooltip: { enabled: false } },
    scales: { x: { display: false }, y: { display: false } },
    elements: { point: { radius: 0 }, line: { tension: 0.4 } }
  };

  function spark(id, color, data) {
    new Chart(document.getElementById(id), {
      type: 'line',
      data: { labels: data.map((_,i)=>i+1), datasets: [{ data, borderColor: color, borderWidth: 2, fill: false }] },
      options: sparkOpts
    });
  }

  spark('sparkTotal',     '#818cf8', [3,5,4,6,8,7,9,11]);
  spark('sparkPending',   '#fbbf24', [2,4,3,5,4,6,5,7]);
  spark('sparkPublished', '#34d399', [4,6,5,8,7,9,10,12]);
  spark('sparkDraft',     '#94a3b8', [3,2,4,3,5,4,3,4]);

  const tCtx = document.getElementById('traffic').getContext('2d');
  const g1 = tCtx.createLinearGradient(0,0,0,180);
  g1.addColorStop(0, C.grad1Top);
  g1.addColorStop(1, C.grad1Bot);
  const g2 = tCtx.createLinearGradient(0,0,0,180);
  g2.addColorStop(0, C.grad2Top);
  g2.addColorStop(1, C.grad2Bot);

  new Chart(tCtx, {
    type: 'line',
    data: {
      labels: ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],
      datasets: [
        { data: [200,260,240,300,360,380,420], borderColor: '#60a5fa', backgroundColor: g1, borderWidth: 2, fill: true, tension: 0.4, pointRadius: 0 },
        { data: [150,210,220,260,290,320,360], borderColor: '#a855f7', backgroundColor: g2, borderWidth: 2, fill: true, tension: 0.4, pointRadius: 0 }
      ]
    },
    options: {
      responsive: true, maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: { backgroundColor: C.tipBg, borderColor: C.tipBorder, borderWidth: 1, titleColor: C.tipTitle, bodyColor: C.tipBody, padding: 8, displayColors: false }
      },
      scales: {
        x: { grid: { color: C.grid, drawBorder: false }, ticks: { color: C.tick, font: { size: 10 } } },
        y: { grid: { color: C.gridY, drawBorder: false }, ticks: { color: C.tick, font: { size: 10 } } }
      }
    }
  });
</script>
