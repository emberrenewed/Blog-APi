<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Post – {{ config('app.name', 'Blog API') }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: ui-sans-serif, system-ui, sans-serif; background: #f5f5f5; min-height: 100vh; }

        nav {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: .9rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .brand { font-size: 1.1rem; font-weight: 700; color: #1b1b18; text-decoration: none; }
        .nav-right { display: flex; align-items: center; gap: 1rem; }
        #user-name { font-size: .875rem; color: #6b7280; }
        .btn {
            padding: .45rem 1rem;
            border-radius: 6px;
            font-size: .875rem;
            font-weight: 500;
            cursor: pointer;
            border: 1px solid #d1d5db;
            background: #fff;
            color: #1b1b18;
            text-decoration: none;
            transition: background .15s;
            display: inline-block;
        }
        .btn:hover { background: #f3f4f6; }
        .btn-primary { background: #1b1b18; color: #fff; border-color: #1b1b18; }
        .btn-primary:hover { background: #3a3a36; }
        .btn-danger { border-color: #fca5a5; color: #b91c1c; }
        .btn-danger:hover { background: #fef2f2; }

        .container { max-width: 720px; margin: 0 auto; padding: 2rem 1.5rem; }

        .back-link {
            display: inline-flex; align-items: center; gap: .4rem;
            color: #6b7280; text-decoration: none; font-size: .875rem;
            margin-bottom: 1.5rem;
        }
        .back-link:hover { color: #1b1b18; }

        .post-card {
            background: #fff;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            margin-bottom: 2rem;
        }
        .post-image {
            width: 100%; max-height: 320px;
            object-fit: cover; display: block;
        }
        .post-body { padding: 1.75rem; }
        .post-title { font-size: 1.6rem; font-weight: 700; color: #1b1b18; margin-bottom: .5rem; }
        .post-meta { font-size: .85rem; color: #9ca3af; margin-bottom: 1.25rem; }
        .post-content { font-size: .975rem; color: #374151; line-height: 1.75; white-space: pre-wrap; }
        .post-actions { display: flex; gap: .75rem; margin-top: 1.25rem; padding-top: 1.25rem; border-top: 1px solid #f3f4f6; }

        /* Comments */
        .comments-section { background: #fff; border-radius: 10px; border: 1px solid #e5e7eb; padding: 1.5rem; }
        .comments-title { font-size: 1.1rem; font-weight: 600; color: #1b1b18; margin-bottom: 1.25rem; }

        .comment {
            display: flex; gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid #f3f4f6;
        }
        .comment:last-of-type { border-bottom: none; }
        .avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: #1b1b18;
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: .875rem; font-weight: 600;
            flex-shrink: 0;
        }
        .comment-body { flex: 1; }
        .comment-author { font-size: .875rem; font-weight: 600; color: #1b1b18; }
        .comment-date { font-size: .78rem; color: #9ca3af; margin-left: .5rem; }
        .comment-text { font-size: .9rem; color: #4b5563; margin-top: .25rem; line-height: 1.5; }
        .comment-delete {
            background: none; border: none; color: #d1d5db; cursor: pointer;
            font-size: .8rem; padding: 0; align-self: flex-start; margin-top: 2px;
        }
        .comment-delete:hover { color: #b91c1c; }

        .no-comments { text-align: center; padding: 2rem; color: #9ca3af; font-size: .9rem; }

        /* Add comment form */
        .add-comment { margin-top: 1.25rem; padding-top: 1.25rem; border-top: 1px solid #f3f4f6; }
        .add-comment h3 { font-size: .95rem; font-weight: 600; color: #1b1b18; margin-bottom: .75rem; }
        textarea {
            width: 100%; padding: .65rem .85rem;
            border: 1px solid #d1d5db; border-radius: 6px;
            font-size: .9rem; font-family: inherit;
            resize: vertical; min-height: 80px; outline: none;
        }
        textarea:focus { border-color: #6366f1; }
        .comment-submit { margin-top: .6rem; }

        .login-prompt { font-size: .875rem; color: #6b7280; margin-top: 1rem; }
        .login-prompt a { color: #1b1b18; font-weight: 500; }

        #toast {
            position: fixed; bottom: 1.5rem; right: 1.5rem;
            background: #1b1b18; color: #fff;
            padding: .75rem 1.25rem; border-radius: 8px;
            font-size: .875rem; display: none; z-index: 999;
        }

        /* Edit modal */
        .modal-backdrop {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.4); z-index: 100;
            align-items: center; justify-content: center;
        }
        .modal-backdrop.open { display: flex; }
        .modal { background: #fff; border-radius: 10px; padding: 1.75rem; width: 100%; max-width: 480px; }
        .modal h2 { font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; font-size: .875rem; font-weight: 500; color: #374151; margin-bottom: .3rem; }
        input[type=text] {
            width: 100%; padding: .6rem .75rem;
            border: 1px solid #d1d5db; border-radius: 6px;
            font-size: .9rem; outline: none;
        }
        input[type=text]:focus { border-color: #6366f1; }
        .modal-footer { display: flex; justify-content: flex-end; gap: .75rem; margin-top: 1.25rem; }
    </style>
</head>
<body>
    <nav>
        <a href="/" class="brand">Blog API</a>
        <div class="nav-right">
            <span id="user-name"></span>
            <a href="/blog" class="btn">← All Posts</a>
            <button class="btn" onclick="logout()">Log out</button>
        </div>
    </nav>

    <div class="container">
        <div id="post-container">
            <div style="text-align:center;padding:3rem;color:#9ca3af">Loading…</div>
        </div>

        <div class="comments-section" id="comments-section" style="display:none">
            <div class="comments-title">Comments <span id="comment-count" style="font-weight:400;color:#9ca3af;font-size:.9rem"></span></div>
            <div id="comments-list"></div>
            <div class="add-comment" id="add-comment-area"></div>
        </div>
    </div>

    <div id="toast"></div>

    <!-- Edit Post Modal -->
    <div class="modal-backdrop" id="edit-modal">
        <div class="modal">
            <h2>Edit Post</h2>
            <div class="form-group">
                <label>Title</label>
                <input type="text" id="edit-title">
            </div>
            <div class="form-group">
                <label>Content</label>
                <textarea id="edit-content" style="min-height:120px"></textarea>
            </div>
            <div class="modal-footer">
                <button class="btn" onclick="closeEdit()">Cancel</button>
                <button class="btn btn-primary" onclick="saveEdit()">Save</button>
            </div>
        </div>
    </div>

    <script>
        const token = localStorage.getItem('api_token');
        const user  = JSON.parse(localStorage.getItem('user') || 'null');
        const postId = location.pathname.split('/').pop();

        if (user) document.getElementById('user-name').textContent = 'Hi, ' + user.name;

        async function loadPost() {
            const res  = await fetch(`/api/posts/${postId}`, { headers: { Accept: 'application/json' } });
            if (!res.ok) { document.getElementById('post-container').innerHTML = '<div style="text-align:center;padding:3rem;color:#b91c1c">Post not found.</div>'; return; }
            const post = await res.json();
            renderPost(post);
            loadComments();
        }

        function renderPost(post) {
            const isOwner = user && post.user_id === user.id;
            document.getElementById('post-container').innerHTML = `
                <a href="/blog" class="back-link">← Back to posts</a>
                <div class="post-card">
                    ${post.image ? `<img class="post-image" src="${post.image}" alt="${post.title}">` : ''}
                    <div class="post-body">
                        <div class="post-title">${post.title}</div>
                        <div class="post-meta">By ${post.user?.name ?? 'Unknown'} · ${new Date(post.created_at).toLocaleDateString('en-US', {year:'numeric',month:'long',day:'numeric'})}</div>
                        <div class="post-content">${post.content}</div>
                        ${isOwner ? `
                        <div class="post-actions">
                            <button class="btn btn-primary" onclick="openEdit('${escape(post.title)}','${escape(post.content)}')">Edit Post</button>
                            <button class="btn btn-danger" onclick="deletePost()">Delete Post</button>
                        </div>` : ''}
                    </div>
                </div>`;
            document.getElementById('comments-section').style.display = 'block';
        }

        async function loadComments() {
            const res      = await fetch(`/api/posts/${postId}/comments`, { headers: { Accept: 'application/json' } });
            const comments = await res.json();
            const list     = document.getElementById('comments-list');
            document.getElementById('comment-count').textContent = `(${comments.length})`;

            if (!comments.length) {
                list.innerHTML = '<div class="no-comments">No comments yet. Be the first!</div>';
            } else {
                list.innerHTML = comments.map(c => `
                    <div class="comment" id="comment-${c.id}">
                        <div class="avatar">${(c.user?.name ?? '?')[0].toUpperCase()}</div>
                        <div class="comment-body">
                            <span class="comment-author">${c.user?.name ?? 'Unknown'}</span>
                            <span class="comment-date">${new Date(c.created_at).toLocaleDateString('en-US', {month:'short',day:'numeric',year:'numeric'})}</span>
                            <div class="comment-text">${c.body}</div>
                        </div>
                        ${user && c.user_id === user.id ? `<button class="comment-delete" onclick="deleteComment(${c.id})" title="Delete">✕</button>` : ''}
                    </div>`).join('');
            }

            const area = document.getElementById('add-comment-area');
            if (token) {
                area.innerHTML = `
                    <h3>Leave a comment</h3>
                    <textarea id="comment-body" placeholder="Write your comment…"></textarea>
                    <div class="comment-submit">
                        <button class="btn btn-primary" onclick="addComment()">Post Comment</button>
                    </div>`;
            } else {
                area.innerHTML = `<p class="login-prompt"><a href="/login">Log in</a> to leave a comment.</p>`;
            }
        }

        async function addComment() {
            const body = document.getElementById('comment-body').value.trim();
            if (!body) { toast('Comment cannot be empty.'); return; }
            const res = await fetch(`/api/posts/${postId}/comments`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', Accept: 'application/json', Authorization: 'Bearer ' + token },
                body: JSON.stringify({ body }),
            });
            if (res.ok) { document.getElementById('comment-body').value = ''; loadComments(); toast('Comment added!'); }
            else { const e = await res.json(); toast(e.message || 'Failed to post comment.'); }
        }

        async function deleteComment(id) {
            if (!confirm('Delete this comment?')) return;
            const res = await fetch(`/api/comments/${id}`, {
                method: 'DELETE',
                headers: { Accept: 'application/json', Authorization: 'Bearer ' + token },
            });
            if (res.ok) { loadComments(); toast('Comment deleted.'); }
        }

        function openEdit(title, content) {
            document.getElementById('edit-title').value   = unescape(title);
            document.getElementById('edit-content').value = unescape(content);
            document.getElementById('edit-modal').classList.add('open');
        }
        function closeEdit() { document.getElementById('edit-modal').classList.remove('open'); }

        async function saveEdit() {
            const title   = document.getElementById('edit-title').value.trim();
            const content = document.getElementById('edit-content').value.trim();
            if (!title || !content) { toast('Title and content required.'); return; }
            const res = await fetch(`/api/posts/${postId}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', Accept: 'application/json', Authorization: 'Bearer ' + token },
                body: JSON.stringify({ title, content }),
            });
            if (res.ok) { closeEdit(); toast('Post updated!'); loadPost(); }
            else { const e = await res.json(); toast(e.message || 'Update failed.'); }
        }

        async function deletePost() {
            if (!confirm('Delete this post? This cannot be undone.')) return;
            const res = await fetch(`/api/posts/${postId}`, {
                method: 'DELETE',
                headers: { Accept: 'application/json', Authorization: 'Bearer ' + token },
            });
            if (res.ok) { toast('Post deleted.'); setTimeout(() => window.location.href = '/blog', 1000); }
        }

        function logout() {
            fetch('/api/logout', { method: 'POST', headers: { Accept: 'application/json', Authorization: 'Bearer ' + token } }).catch(() => {});
            localStorage.removeItem('api_token');
            localStorage.removeItem('user');
            window.location.href = '/login';
        }

        function toast(msg) {
            const el = document.getElementById('toast');
            el.textContent = msg;
            el.style.display = 'block';
            setTimeout(() => { el.style.display = 'none'; }, 3000);
        }

        loadPost();
    </script>
</body>
</html>
