<!-- views/posts/create.php -->

<!-- Top bar -->
<header class="flex items-center justify-between gap-4 px-6 py-4 shrink-0 border-b border-border-card">
  <div class="flex items-center gap-3">
    <a href="<?php echo base_url('posts'); ?>" class="w-8 h-8 rounded-lg bg-bg-hover flex items-center justify-center hover:opacity-80 transition" title="Back">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <line x1="19" y1="12" x2="5" y2="12"/>
        <polyline points="12 19 5 12 12 5"/>
      </svg>
    </a>

    <h2 class="text-lg font-semibold text-primary">Create New Post</h2>

    <?php if($user_role == 'admin'): ?>
      <span class="px-2 py-0.5 rounded-md bg-emerald-500/20 text-emerald-500 text-[10px] font-bold uppercase">
        Auto-Publish
      </span>
    <?php else: ?>
      <span class="px-2 py-0.5 rounded-md bg-amber-500/20 text-amber-500 text-[10px] font-bold uppercase">
        Needs Approval
      </span>
    <?php endif; ?>
  </div>

  <a href="<?php echo base_url('posts'); ?>"
     class="px-4 py-2 rounded-xl text-xs text-secondary hover:bg-bg-hover transition">
    Cancel
  </a>
</header>


<!-- Scrollable Content -->
<div class="flex-1 overflow-y-auto p-6 flex justify-center">

  <div class="w-full max-w-2xl">

    <div class="glass-card rounded-2xl overflow-hidden">

      <!-- Card Header -->
      <div class="px-6 py-4 border-b border-border-card bg-bg-soft">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-xl bg-indigo-500/10 flex items-center justify-center">
            ✏️
          </div>

          <div>
            <h3 class="text-sm font-semibold text-primary">New Post</h3>
            <p class="text-[11px] text-muted">Fill in the details below to create your post</p>
          </div>
        </div>
      </div>


      <!-- Card Body -->
      <div class="px-6 py-5">

        <!-- Validation Errors -->
        <?php if(validation_errors()): ?>
          <div class="mb-4 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/30 text-xs text-red-500">
            <?php echo validation_errors(); ?>
          </div>
        <?php endif; ?>


        <!-- Status Notice -->
        <?php if($user_role == 'admin'): ?>
          <div class="mb-5 px-4 py-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-xs text-secondary">
            ✅ Admin mode — post will publish instantly.
          </div>
        <?php else: ?>
          <div class="mb-5 px-4 py-3 rounded-xl bg-amber-500/10 border border-amber-500/30 text-xs text-secondary">
            ⏳ Post will be created as <b>Pending</b> and needs admin approval.
          </div>
        <?php endif; ?>


        <!-- Form -->
        <?php echo form_open('posts/create'); ?>

        <!-- Title -->
        <div class="mb-5">
          <label class="block text-xs font-medium text-secondary mb-2">
            Post Title <span class="text-red-500">*</span>
          </label>

          <input
            type="text"
            name="title"
            value="<?php echo set_value('title'); ?>"
            required
            class="input"
            placeholder="Enter your post title..."
          />

          <p class="text-[11px] text-muted mt-1">Minimum 5 characters</p>
        </div>


        <!-- Category -->
        <div class="mb-5">
          <label class="block text-xs font-medium text-secondary mb-2">
            Category <span class="text-red-500">*</span>
          </label>

          <select name="category_id" required class="input">
            <option value="">-- Select Category --</option>

            <?php foreach($categories as $category): ?>
              <option value="<?php echo $category->id; ?>"
                <?php echo set_select('category_id', $category->id); ?>>
                <?php echo htmlspecialchars($category->name); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>


        <!-- Content -->
        <div class="mb-5">
          <label class="block text-xs font-medium text-secondary mb-2">
            Post Content <span class="text-red-500">*</span>
          </label>

          <textarea
            name="content"
            rows="10"
            required
            class="input resize-none"
            placeholder="Write your post content here..."
          ><?php echo set_value('content'); ?></textarea>

          <p class="text-[11px] text-muted mt-1">Minimum 20 characters</p>
        </div>


        <!-- Actions -->
        <div class="flex items-center justify-between pt-4 border-t border-border-card">

          <a href="<?php echo base_url('posts'); ?>"
             class="px-5 py-2.5 rounded-xl text-xs text-secondary hover:bg-bg-hover transition">
            Cancel
          </a>

          <?php if($user_role == 'admin'): ?>
            <button type="submit"
              class="px-5 py-2.5 rounded-xl text-xs font-medium bg-emerald-500/20 text-emerald-600 border border-emerald-500/40 hover:bg-emerald-500/30 transition">
              Create & Publish
            </button>
          <?php else: ?>
            <button type="submit"
              class="px-5 py-2.5 rounded-xl text-xs font-medium bg-indigo-600 text-white hover:bg-indigo-700 transition">
              Submit for Approval
            </button>
          <?php endif; ?>

        </div>

        <?php echo form_close(); ?>

      </div>
    </div>
  </div>
</div>



<!-- Theme-aware reusable styles -->
<style>
.glass-card {
  background: var(--bg-card);
  border: 1px solid var(--border-card);
  box-shadow: var(--shadow-card);
  color: var(--text-primary);
  transition: 0.3s ease;
}

.input {
  width: 100%;
  background: var(--bg-input);
  border: 1px solid var(--border-card);
  color: var(--text-primary);
  border-radius: 12px;
  padding: 10px 14px;
  font-size: 14px;
  outline: none;
  transition: 0.2s;
}

.input:focus {
  border-color: var(--accent);
  box-shadow: 0 0 0 1px var(--accent);
}

.text-primary { color: var(--text-primary); }
.text-secondary { color: var(--text-secondary); }
.text-muted { color: var(--text-muted); }

.bg-bg-soft { background: var(--bg-soft); }
.bg-bg-hover { background: var(--bg-hover); }
.border-border-card { border-color: var(--border-card); }
</style>
