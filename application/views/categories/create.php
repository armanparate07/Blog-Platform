<!-- views/categories/create.php -->

<!-- Top bar -->
<header class="flex items-center justify-between gap-4 px-6 py-4 shrink-0" style="border-bottom: 1px solid var(--border-subtle);">
  <div class="flex items-center gap-3">
    <h2 class="text-lg font-semibold" style="color: var(--text-heading);">Create Category</h2>
    <span class="px-2 py-0.5 rounded-md bg-emerald-500/20 text-emerald-400 text-[10px] font-bold uppercase">New</span>
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
      <div class="px-6 py-4 bg-emerald-500/[0.03]" style="border-bottom: 1px solid var(--border-subtle);">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-xl bg-emerald-500/10 flex items-center justify-center">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2">
              <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
            </svg>
          </div>
          <div>
            <h3 class="text-sm font-semibold" style="color: var(--text-heading);">New Category</h3>
            <p class="text-[10px]" style="color: var(--text-muted);">The slug will be auto-generated from the name</p>
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
        <?php echo form_open('categories/create'); ?>

          <!-- Category Name -->
          <div class="mb-5">
            <label for="name" class="block text-xs font-medium mb-2" style="color: var(--text-secondary);">
              Category Name <span class="text-red-400">*</span>
            </label>
            <input type="text" id="name" name="name"
                   value="<?php echo set_value('name'); ?>"
                   required
                   class="w-full rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-emerald-500/60 focus:border-emerald-500/60 transition-colors"
                   style="background: var(--bg-input); border: 1px solid var(--border-input); color: var(--text-primary);"
                   placeholder="e.g. Technology, Design, Marketing..." />
            <p class="text-[10px] mt-1.5" style="color: var(--text-muted);">Minimum 3 characters, must be unique</p>
          </div>

          <!-- Info Note -->
          <div class="mb-5 px-4 py-3 rounded-xl bg-indigo-500/5 border border-indigo-500/15 flex items-start gap-3">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#818cf8" stroke-width="2" class="shrink-0 mt-0.5">
              <circle cx="12" cy="12" r="10"/>
              <line x1="12" y1="16" x2="12" y2="12"/>
              <line x1="12" y1="8" x2="12.01" y2="8"/>
            </svg>
            <p class="text-[11px]" style="color: var(--text-secondary);">
              The slug will be automatically generated from the category name. For example, "Web Development" becomes
              <span class="text-indigo-400 font-mono">web-development</span>.
            </p>
          </div>

          <!-- Actions -->
          <div class="flex items-center justify-between pt-4" style="border-top: 1px solid var(--border-subtle);">
            <a href="<?php echo base_url('categories'); ?>"
               class="soft-pill px-5 py-2.5 rounded-xl text-xs hover:bg-white/5 transition-colors"
               style="color: var(--text-secondary);">
              Cancel
            </a>
            <button type="submit"
                    class="px-5 py-2.5 rounded-xl text-xs font-medium bg-emerald-500/15 text-emerald-400 border border-emerald-500/25 hover:bg-emerald-500/25 transition-colors flex items-center gap-2">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="20 6 9 17 4 12"/>
              </svg>
              Create Category
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
