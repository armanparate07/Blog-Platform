<!-- views/admin/pending_posts.php -->

<!-- Top bar -->
<header class="flex items-center justify-between gap-4 px-6 py-4 shrink-0 border-b border-border-card">
  <div class="flex items-center gap-3">
    <h2 class="text-lg font-semibold text-primary">Pending Posts</h2>
    <span class="badge-amber">Awaiting Approval</span>
  </div>

  <a href="<?php echo base_url('admin'); ?>"
     class="px-4 py-2 rounded-xl text-xs text-secondary hover:bg-bg-hover transition">
    Back to Dashboard
  </a>
</header>



<!-- Scrollable Content -->
<div class="flex-1 overflow-y-auto p-6 space-y-4">

  <?php if(empty($posts)): ?>

    <!-- Empty State -->
    <div class="glass-card p-12 text-center">
      <h3 class="text-base font-semibold mb-2 text-green">All caught up!</h3>
      <p class="text-xs text-muted">There are no pending posts waiting for approval.</p>
    </div>

  <?php else: ?>

    <?php foreach($posts as $post): ?>

      <div class="glass-card rounded-2xl overflow-hidden">

        <!-- Card Header -->
        <div class="flex items-center justify-between px-5 py-3 border-b border-border-card bg-bg-soft">

          <div class="flex items-center gap-3">
            <div class="avatar">
              <?php echo strtoupper(substr($post->username, 0, 1)); ?>
            </div>

            <div>
              <a href="<?php echo base_url('posts/view/'.$post->id); ?>"
                 class="text-sm font-semibold text-primary hover:text-accent transition">
                <?php echo htmlspecialchars($post->title); ?>
              </a>

              <div class="text-[11px] text-muted">
                by <?php echo htmlspecialchars($post->username); ?>
              </div>
            </div>
          </div>

          <span class="badge-amber">Pending Review</span>
        </div>



        <!-- Card Body -->
        <div class="px-5 py-4">

          <!-- Excerpt -->
          <p class="text-xs text-secondary leading-relaxed mb-4">
            <?php
              $content = strip_tags($post->content);
              echo (strlen($content) > 200) ? substr($content, 0, 200) . '...' : $content;
            ?>
          </p>


          <!-- Meta -->
          <div class="flex items-center gap-4 mb-4 text-[11px] text-muted">
            <span><?php echo htmlspecialchars($post->category_name); ?></span>
            <span><?php echo date('M d, Y H:i', strtotime($post->created_at)); ?></span>
          </div>


          <!-- Actions -->
          <div class="flex flex-wrap items-center gap-2">

            <!-- Approve -->
            <a href="<?php echo base_url('admin/approve_post/'.$post->id); ?>"
               onclick="return confirm('Approve and publish this post?')"
               class="btn-success">
              Approve
            </a>

            <!-- Reject -->
            <a href="<?php echo base_url('admin/reject_post/'.$post->id); ?>"
               onclick="return confirm('Reject this post and move to draft?')"
               class="btn-warning">
              Reject
            </a>

            <!-- View -->
            <a href="<?php echo base_url('posts/view/'.$post->id); ?>"
               class="btn-info">
              View
            </a>

            <!-- Edit -->
            <a href="<?php echo base_url('posts/edit/'.$post->id); ?>"
               class="icon-btn text-accent" title="Edit">
              ✏️
            </a>

            <!-- Delete -->
            <a href="<?php echo base_url('admin/delete_post/'.$post->id); ?>"
               onclick="return confirm('Are you sure you want to delete this post?')"
               class="icon-btn text-red" title="Delete">
              🗑
            </a>

          </div>
        </div>
      </div>

    <?php endforeach; ?>

  <?php endif; ?>

</div>



<!-- Theme Styles -->
<style>

.glass-card {
  background: var(--bg-card);
  border: 1px solid var(--border-card);
  box-shadow: var(--shadow-card);
  color: var(--text-primary);
  transition: .3s;
}

/* avatar */
.avatar {
  width: 32px;
  height: 32px;
  border-radius: 999px;
  background: var(--accent-soft);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12px;
  font-weight: bold;
  color: var(--accent);
}

/* badges */
.badge-amber {
  background: #f59e0b22;
  color: #f59e0b;
  padding: 4px 8px;
  border-radius: 8px;
  font-size: 10px;
  font-weight: 600;
}

/* buttons */
.btn-success {
  background: #10b98122;
  color: #10b981;
  padding: 6px 12px;
  border-radius: 10px;
  font-size: 11px;
}

.btn-warning {
  background: #f59e0b22;
  color: #f59e0b;
  padding: 6px 12px;
  border-radius: 10px;
  font-size: 11px;
}

.btn-info {
  background: #6366f122;
  color: #6366f1;
  padding: 6px 12px;
  border-radius: 10px;
  font-size: 11px;
}

.icon-btn {
  width: 32px;
  height: 32px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: var(--bg-soft);
}

/* text helpers */
.text-primary { color: var(--text-primary); }
.text-secondary { color: var(--text-secondary); }
.text-muted { color: var(--text-muted); }
.text-accent { color: var(--accent); }
.text-red { color: #ef4444; }
.text-green { color: #10b981; }

/* bg helpers */
.bg-bg-soft { background: var(--bg-soft); }
.bg-bg-hover { background: var(--bg-hover); }
.border-border-card { border-color: var(--border-card); }

</style>
