<!-- views/posts/edit.php -->

<!-- Top bar -->
<header class="flex items-center justify-between gap-4 px-6 py-4 shrink-0 border-b border-border-card">
  <div class="flex items-center gap-3">

    <a href="<?php echo base_url('posts'); ?>"
       class="w-8 h-8 rounded-lg bg-bg-hover flex items-center justify-center hover:opacity-80 transition">
      ←
    </a>

    <h2 class="text-lg font-semibold text-primary">Edit Post</h2>

    <?php if($post->status == 'pending'): ?>
      <span class="badge-amber">Pending</span>
    <?php elseif($post->status == 'published'): ?>
      <span class="badge-green">Published</span>
    <?php else: ?>
      <span class="badge-gray">Draft</span>
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
      <div class="px-6 py-4 border-b border-border-card bg-bg-soft flex justify-between items-center">

        <div>
          <h3 class="text-sm font-semibold text-primary truncate max-w-sm">
            <?php echo htmlspecialchars($post->title); ?>
          </h3>
          <p class="text-[11px] text-muted">Edit your post details below</p>
        </div>

        <div class="text-right hidden sm:block text-[11px] text-muted">
          <?php echo htmlspecialchars($post->username); ?><br>
          <?php echo date('M d, Y H:i', strtotime($post->created_at)); ?>
        </div>

      </div>



      <!-- Card Body -->
      <div class="px-6 py-5">

        <!-- Validation Errors -->
        <?php if(validation_errors()): ?>
          <div class="alert-error">
            <?php echo validation_errors(); ?>
          </div>
        <?php endif; ?>


        <!-- Form -->
        <?php echo form_open('posts/edit/'.$post->id); ?>

        <!-- Title -->
        <div class="mb-5">
          <label class="label">Post Title *</label>

          <input
            type="text"
            name="title"
            value="<?php echo set_value('title', $post->title); ?>"
            required
            class="input"
            placeholder="Enter your post title..."
          />

          <p class="helper">Minimum 5 characters</p>
        </div>


        <!-- Category -->
        <div class="mb-5">
          <label class="label">Category *</label>

          <select name="category_id" required class="input">
            <option value="">-- Select Category --</option>

            <?php foreach($categories as $category): ?>
              <option value="<?php echo $category->id; ?>"
                <?php echo ($category->id == $post->category_id) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($category->name); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>


        <!-- Content -->
        <div class="mb-5">
          <label class="label">Post Content *</label>

          <textarea
            name="content"
            rows="10"
            required
            class="input resize-none"
            placeholder="Write your post content here..."
          ><?php echo set_value('content', $post->content); ?></textarea>

          <p class="helper">Minimum 20 characters</p>
        </div>


        <!-- Status Info -->
        <div class="info-box">
          <span class="text-muted text-xs">Current Status:</span>

          <?php if($post->status == 'pending'): ?>
            <span class="badge-amber">Pending</span>
          <?php elseif($post->status == 'published'): ?>
            <span class="badge-green">Published</span>
          <?php else: ?>
            <span class="badge-gray">Draft</span>
          <?php endif; ?>
        </div>


        <!-- Actions -->
        <div class="flex items-center justify-between pt-4 border-t border-border-card">

          <a href="<?php echo base_url('posts'); ?>"
             class="px-5 py-2.5 rounded-xl text-xs text-secondary hover:bg-bg-hover transition">
            Cancel
          </a>

          <button type="submit" class="btn-warning">
            Update Post
          </button>

        </div>

        <?php echo form_close(); ?>

      </div>
    </div>
  </div>
</div>



<!-- Theme Components -->
<style>

.glass-card {
  background: var(--bg-card);
  border: 1px solid var(--border-card);
  box-shadow: var(--shadow-card);
  color: var(--text-primary);
  transition: .3s;
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
}

.input:focus {
  border-color: var(--accent);
  box-shadow: 0 0 0 1px var(--accent);
}

.label {
  display: block;
  font-size: 12px;
  color: var(--text-secondary);
  margin-bottom: 6px;
  font-weight: 500;
}

.helper {
  font-size: 11px;
  color: var(--text-muted);
  margin-top: 4px;
}

.info-box {
  background: var(--bg-soft);
  border: 1px solid var(--border-card);
  border-radius: 12px;
  padding: 10px 14px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 18px;
}

/* badges */
.badge-amber { background:#f59e0b22; color:#f59e0b; padding:4px 8px; border-radius:8px; font-size:10px; }
.badge-green { background:#10b98122; color:#10b981; padding:4px 8px; border-radius:8px; font-size:10px; }
.badge-gray  { background:#64748b22; color:#64748b; padding:4px 8px; border-radius:8px; font-size:10px; }

/* alerts */
.alert-error {
  background:#ef444422;
  border:1px solid #ef444466;
  color:#ef4444;
  padding:10px 14px;
  border-radius:12px;
  font-size:12px;
  margin-bottom:16px;
}

/* button */
.btn-warning {
  background:#f59e0b;
  color:white;
  padding:10px 16px;
  border-radius:12px;
  font-size:12px;
  font-weight:500;
  transition:.2s;
}
.btn-warning:hover { opacity:.9; }

.text-primary { color: var(--text-primary); }
.text-secondary { color: var(--text-secondary); }
.text-muted { color: var(--text-muted); }

.bg-bg-soft { background: var(--bg-soft); }
.bg-bg-hover { background: var(--bg-hover); }
.border-border-card { border-color: var(--border-card); }

</style>
