<!-- views/categories/list.php -->


<!-- Top bar -->
<header class="flex items-center justify-between gap-4 px-6 py-4 shrink-0" style="border-bottom: 1px solid var(--border-subtle);">
  <div class="flex items-center gap-3">
    <h2 class="text-lg font-semibold" style="color: var(--text-heading);">Categories</h2>
    <span class="px-2 py-0.5 rounded-md bg-indigo-500/20 text-indigo-400 text-[10px] font-bold">
      <?php echo count($categories); ?> Total
    </span>
  </div>
  <div class="flex items-center gap-3">
    <a href="<?php echo base_url('posts'); ?>"
       class="soft-pill px-4 py-2 rounded-xl text-xs flex items-center gap-2 hover:bg-white/5 transition-colors"
       style="color: var(--text-secondary);">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
      </svg>
      Back to Posts
    </a>
    <!-- CHANGED: text-black instead of text-white -->
    <a href="<?php echo base_url('categories/create'); ?>"
       class="pill-btn text-xs text-black px-4 py-2 rounded-xl flex items-center gap-2 no-underline">
      New Category
      <span class="w-5 h-5 rounded-full bg-white/15 flex items-center justify-center text-sm">+</span>
    </a>
  </div>
</header>



<!-- Scrollable Content -->
<div class="flex-1 overflow-y-auto p-6 scrollbar-thin">


  <?php if(empty($categories)): ?>
    <!-- Empty State -->
    <div class="glass-card p-12 text-center">
      <div class="w-16 h-16 rounded-2xl bg-indigo-500/10 flex items-center justify-center mx-auto mb-4">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#818cf8" stroke-width="1.5">
          <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
        </svg>
      </div>
      <h3 class="text-base font-semibold mb-2" style="color: var(--text-heading);">No categories yet</h3>
      <p class="text-xs mb-4" style="color: var(--text-secondary);">Create your first category to organize posts.</p>
      <a href="<?php echo base_url('categories/create'); ?>"
         class="pill-btn inline-flex items-center gap-2 text-xs text-white px-5 py-2.5 rounded-xl">
        Create Category <span>+</span>
      </a>
    </div>


  <?php else: ?>
    <!-- Categories Table -->
    <div class="glass-card rounded-2xl overflow-hidden">
      <div class="p-4 flex items-center justify-between" style="border-bottom: 1px solid var(--border-subtle);">
        <div>
          <h3 class="text-sm font-semibold" style="color: var(--text-heading);">All Categories</h3>
          <p class="text-[10px] mt-0.5" style="color: var(--text-muted);">Manage your post categories</p>
        </div>
      </div>


      <div class="overflow-x-auto">
        <table class="w-full text-xs">
          <thead>
            <tr class="text-[10px] uppercase tracking-wider" style="background: var(--badge-cat-bg); color: var(--text-muted);">
              <th class="px-4 py-3 text-left font-semibold">ID</th>
              <th class="px-4 py-3 text-left font-semibold">Name</th>
              <th class="px-4 py-3 text-left font-semibold">Slug</th>
              <th class="px-4 py-3 text-left font-semibold">Created</th>
              <th class="px-4 py-3 text-right font-semibold">Actions</th>
            </tr>
          </thead>
          <tbody class="table-body-rows">
            <?php foreach($categories as $category): ?>
              <tr class="table-row transition-colors hover-row">
                <td class="px-4 py-3" style="color: var(--text-muted);">
                  #<?php echo $category->id; ?>
                </td>
                <td class="px-4 py-3">
                  <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-indigo-500/10 flex items-center justify-center shrink-0">
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#818cf8" stroke-width="2">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                      </svg>
                    </div>
                    <span class="font-medium" style="color: var(--text-primary);">
                      <?php echo htmlspecialchars($category->name); ?>
                    </span>
                  </div>
                </td>
                <td class="px-4 py-3">
                  <code class="text-[11px] text-indigo-400 font-mono bg-indigo-500/5 px-2 py-0.5 rounded-md">
                    <?php echo htmlspecialchars($category->slug); ?>
                  </code>
                </td>
                <td class="px-4 py-3" style="color: var(--text-secondary);">
                  <?php echo date('M d, Y', strtotime($category->created_at)); ?>
                </td>
                <td class="px-4 py-3">
                  <div class="flex items-center justify-end gap-1.5">
                    <a href="<?php echo base_url('categories/edit/'.$category->id); ?>"
                       class="w-7 h-7 rounded-lg bg-indigo-500/10 text-indigo-400 flex items-center justify-center hover:bg-indigo-500/20 transition-colors"
                       title="Edit">
                      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                      </svg>
                    </a>
                    <a href="<?php echo base_url('categories/delete/'.$category->id); ?>"
                       onclick="return confirm('Are you sure you want to delete this category?')"
                       class="w-7 h-7 rounded-lg bg-red-500/10 text-red-400 flex items-center justify-center hover:bg-red-500/20 transition-colors"
                       title="Delete">
                      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                      </svg>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  <?php endif; ?>


</div>



<style>
  .glass-card {
    background: var(--bg-card);
    border: 1px solid var(--border-card);
    border-radius: 16px;
    box-shadow: var(--shadow-card);
    transition: background 0.3s, box-shadow 0.3s, border-color 0.3s;
  }
  .table-body-rows tr + tr {
    border-top: 1px solid var(--border-subtle);
  }
  .hover-row:hover {
    background: var(--badge-cat-bg);
  }
</style>
