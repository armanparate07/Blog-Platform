<!-- views/categories/edit.php -->

<!-- Top bar -->
<header class="flex items-center justify-between gap-4 px-6 py-4 shrink-0" style="border-bottom: 1px solid var(--border-subtle);">
  <div class="flex items-center gap-3">
    <h2 class="text-lg font-semibold" style="color: var(--text-heading);">Edit Category</h2>
    <span class="px-2 py-0.5 rounded-md bg-amber-500/20 text-amber-400 text-[10px] font-bold uppercase">Editing</span>
  </div>
  <a href="<?php echo base_url('categories'); ?>"
     class="soft-pill px-4 py-2 rounded-xl text-xs flex items-center gap-2 hover:bg-white/5 transition-colors"
     style="color: var(--text-secondary);">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
    </svg>
    Back to Categories
  </a>
</header>


<!-- Scrollable Content -->
<div class="flex-1 overflow-y-auto p-6 scrollbar-thin flex justify-center">
  <div class="w-full max-w-lg">
    <div class="glass-card rounded-2xl overflow-hidden">

      <!-- Card Header -->
      <div class="px-6 py-4 bg-amber-500/[0.03]" style="border-bottom: 1px solid var(--border-subtle);">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-xl bg-amber-500/10 flex items-center justify-center">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fbbf24" stroke-width="2">
              <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
              <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
          </div>
          <div>
            <h3 class="text-sm font-semibold" style="color: var(--text-heading);">
              <?php echo htmlspecialchars($category->name); ?>
            </h3>
            <p class="text-[10px]" style="color: var(--text-muted);">Slug will update automatically based on the new name</p>
          </div>
        </div>
      </div>

      <!-- Card Body -->
      <div class="px-6 py-5">

        <!-- Validation Errors -->
        <?php if(validation_errors()): ?>
          <div class="mb-4 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/20 text-xs text-red-400">
            <?php echo validation_errors(); ?>
          </div>
        <?php endif; ?>

        <!-- Form -->
        <?php echo form_open('categories/edit/'.$category->id); ?>

          <!-- Category Name -->
          <div class="mb-5">
            <label for="name" class="block text-xs font-medium mb-2" style="color: var(--text-secondary);">
              Category Name <span class="text-red-400">*</span>
            </label>
            <input type="text" id="name" name="name"
                   value="<?php echo set_value('name', $category->name); ?>"
                   required
                   class="w-full rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-amber-500/60 focus:border-amber-500/60 transition-colors"
                   style="background: var(--bg-input); border: 1px solid var(--border-input); color: var(--text-primary);"
                   placeholder="Category name..." />
            <p class="text-[10px] mt-1.5" style="color: var(--text-muted);">Minimum 3 characters</p>
          </div>

          <!-- Current Slug -->
          <div class="mb-5">
            <label class="block text-xs font-medium mb-2" style="color: var(--text-secondary);">Current Slug</label>
            <div class="px-4 py-2.5 rounded-xl" style="background: var(--bg-input); border: 1px solid var(--border-input); opacity: 0.7;">
              <code class="text-xs text-indigo-400 font-mono">
                <?php echo htmlspecialchars($category->slug); ?>
              </code>
            </div>
          </div>

          <!-- Created Date -->
          <div class="mb-5 flex items-center gap-2 text-[11px]" style="color: var(--text-muted);">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
            </svg>
            Created: <?php echo date('M d, Y H:i', strtotime($category->created_at)); ?>
          </div>

          <!-- Actions -->
          <div class="flex items-center justify-between pt-4" style="border-top: 1px solid var(--border-subtle);">
            <a href="<?php echo base_url('categories'); ?>"
               class="soft-pill px-5 py-2.5 rounded-xl text-xs hover:bg-white/5 transition-colors"
               style="color: var(--text-secondary);">
              Cancel
            </a>
            <button type="submit"
                    class="px-5 py-2.5 rounded-xl text-xs font-medium bg-amber-500/15 text-amber-400 border border-amber-500/25 hover:bg-amber-500/25 transition-colors flex items-center gap-2">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                <polyline points="17 21 17 13 7 13 7 21"/>
                <polyline points="7 3 7 8 15 8"/>
              </svg>
              Update Category
            </button>
          </div>

        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>


<style>
  .glass-card {
    background: var(--bg-card);
    border: 1px solid var(--border-card);
    border-radius: 16px;
    box-shadow: var(--shadow-card);
    transition: background 0.3s, box-shadow 0.3s, border-color 0.3s;
  }
</style>
