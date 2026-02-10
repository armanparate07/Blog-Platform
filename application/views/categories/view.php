<!-- views/posts/view.php -->

<!-- Top bar -->
<header class="flex items-center justify-between gap-4 px-6 py-4 shrink-0 border-b border-white/5">
  <div class="flex items-center gap-3">
    <a href="<?php echo base_url('posts'); ?>" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center hover:bg-white/10 transition-colors" title="Back">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
    </a>
    <h2 class="text-lg font-semibold truncate max-w-md"><?php echo htmlspecialchars($post->title); ?></h2>
    <?php if($post->status == 'pending'): ?>
      <span class="px-2 py-0.5 rounded-md bg-amber-500/20 text-amber-400 text-[10px] font-bold">Pending</span>
    <?php elseif($post->status == 'published'): ?>
      <span class="px-2 py-0.5 rounded-md bg-emerald-500/20 text-emerald-400 text-[10px] font-bold">Published</span>
    <?php else: ?>
      <span class="px-2 py-0.5 rounded-md bg-slate-500/20 text-slate-400 text-[10px] font-bold">Draft</span>
    <?php endif; ?>
  </div>

  <!-- Actions -->
  <?php $can_edit = ($post->user_id == $user_id) || ($user_role == 'admin'); ?>
  <?php if($can_edit): ?>
    <div class="flex items-center gap-2">
      <?php if($user_role == 'admin' && $post->status == 'pending'): ?>
        <a href="<?php echo base_url('admin/approve_post/'.$post->id); ?>"
           onclick="return confirm('Approve and publish this post?')"
           class="px-4 py-2 rounded-xl text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 hover:bg-emerald-500/20 transition-colors flex items-center gap-1.5">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
          Approve
        </a>
      <?php endif; ?>
      <a href="<?php echo base_url('posts/edit/'.$post->id); ?>"
         class="w-8 h-8 rounded-lg bg-indigo-500/10 text-indigo-400 flex items-center justify-center hover:bg-indigo-500/20 transition-colors" title="Edit">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
      </a>
      <a href="<?php echo base_url('posts/delete/'.$post->id); ?>"
         onclick="return confirm('Are you sure you want to delete this post?')"
         class="w-8 h-8 rounded-lg bg-red-500/10 text-red-400 flex items-center justify-center hover:bg-red-500/20 transition-colors" title="Delete">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
      </a>
    </div>
  <?php endif; ?>
</header>

<!-- Scrollable Content -->
<div class="flex-1 overflow-y-auto p-6 scrollbar-thin">
  <div class="max-w-3xl mx-auto space-y-5">

    <!-- ===== POST CARD ===== -->
    <div class="glass-card rounded-2xl overflow-hidden">

      <!-- Post Meta -->
      <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-sm font-bold shrink-0">
            <?php echo strtoupper(substr($post->username, 0, 1)); ?>
          </div>
          <div>
            <div class="text-sm font-medium text-slate-200"><?php echo htmlspecialchars($post->username); ?></div>
            <div class="text-[10px] text-slate-500"><?php echo date('F d, Y \a\t H:i', strtotime($post->created_at)); ?></div>
          </div>
        </div>
        <span class="px-2.5 py-1 rounded-lg bg-white/5 text-slate-300 text-[10px] border border-white/10">
          <?php echo htmlspecialchars($post->category_name); ?>
        </span>
      </div>

      <!-- Post Content -->
      <div class="px-6 py-5">
        <h1 class="text-xl font-bold mb-4 text-slate-100"><?php echo htmlspecialchars($post->title); ?></h1>
        <div class="text-sm text-slate-300 leading-relaxed post-content">
          <?php echo nl2br(htmlspecialchars($post->content)); ?>
        </div>
      </div>
    </div>

    <!-- ===== COMMENTS SECTION ===== -->
    <div class="glass-card rounded-2xl overflow-hidden">

      <!-- Comments Header -->
      <div class="px-6 py-4 border-b border-white/5 flex items-center gap-3">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#818cf8" stroke-width="2">
          <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
        </svg>
        <h3 class="text-sm font-semibold">Comments</h3>
        <span class="px-2 py-0.5 rounded-md bg-indigo-500/15 text-indigo-400 text-[10px] font-bold">
          <?php echo count($comments); ?>
        </span>
      </div>

      <div class="px-6 py-5 space-y-5">

        <!-- Add Comment Form -->
        <div>
          <?php if(validation_errors()): ?>
            <div class="mb-3 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/20 text-xs text-red-400">
              <?php echo validation_errors(); ?>
            </div>
          <?php endif; ?>

          <?php echo form_open('comments/add/'.$post->id); ?>
            <label class="block text-xs font-medium text-slate-300 mb-2">Add a comment</label>
            <textarea
              name="comment"
              rows="3"
              required
              class="w-full bg-[#050814] border border-slate-700/70 rounded-xl px-4 py-3 text-sm text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-1 focus:ring-indigo-500/60 transition-colors resize-none"
              placeholder="Write your comment here..."
            ></textarea>
            <div class="mt-2 flex justify-end">
              <button type="submit"
                      class="pill-btn px-5 py-2 rounded-xl text-xs font-medium text-white flex items-center gap-2">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                Post Comment
              </button>
            </div>
          <?php echo form_close(); ?>
        </div>

        <!-- Divider -->
        <div class="border-t border-white/5"></div>

        <!-- Comments List -->
        <?php if(empty($comments)): ?>
          <div class="text-center py-8">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" class="mx-auto mb-3 text-slate-600">
              <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
            </svg>
            <p class="text-xs text-slate-500">No comments yet. Be the first to comment!</p>
          </div>
        <?php else: ?>
          <div class="space-y-3">
            <?php foreach($comments as $comment): ?>
              <div class="rounded-xl bg-white/[0.02] border border-white/5 p-4">
                <div class="flex items-start justify-between mb-2">
                  <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-[10px] font-bold shrink-0">
                      <?php echo strtoupper(substr($comment->username, 0, 1)); ?>
                    </div>
                    <div>
                      <span class="text-xs font-medium text-slate-200"><?php echo htmlspecialchars($comment->username); ?></span>
                      <span class="text-[10px] text-slate-500 ml-2"><?php echo date('M d, Y \a\t H:i', strtotime($comment->created_at)); ?></span>
                    </div>
                  </div>

                  <?php $can_delete_comment = ($comment->user_id == $user_id) || ($user_role == 'admin'); ?>
                  <?php if($can_delete_comment): ?>
                    <a href="<?php echo base_url('comments/delete/'.$comment->id); ?>"
                       onclick="return confirm('Delete this comment?')"
                       class="w-7 h-7 rounded-lg bg-red-500/10 text-red-400 flex items-center justify-center hover:bg-red-500/20 transition-colors shrink-0" title="Delete">
                      <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                      </svg>
                    </a>
                  <?php endif; ?>
                </div>

                <p class="text-xs text-slate-300 leading-relaxed pl-9">
                  <?php echo nl2br(htmlspecialchars($comment->comment)); ?>
                </p>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

      </div>
    </div>

  </div>
</div>

<style>
  .glass-card {
    background: rgba(15, 23, 42, 0.95);
    border-radius: 16px;
    box-shadow: 0 16px 40px rgba(15,23,42,0.8), 0 0 0 1px rgba(148,163,184,0.18);
  }
</style>
