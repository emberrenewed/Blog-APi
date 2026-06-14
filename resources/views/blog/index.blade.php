<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog – {{ config('app.name', 'Blog API') }}</title>
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
        }
        .btn:hover { background: #f3f4f6; }
        .btn-primary { background: #1b1b18; color: #fff; border-color: #1b1b18; }
        .btn-primary:hover { background: #3a3a36; }

        .container { max-width: 900px; margin: 0 auto; padding: 2rem 1.5rem; }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .page-header h1 { font-size: 1.5rem; font-weight: 700; color: #1b1b18; }

        .posts-grid { display: flex; flex-direction: column; gap: 1rem; }

        .post-card {
            background: #fff;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            display: flex;
            gap: 1.25rem;
            padding: 1.25rem;
            transition: box-shadow .15s;
            text-decoration: none;
            color: inherit;
        }
        .post-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,.08); cursor: pointer; }
        .post-img {
            width: 120px;
            height: 90px;
            object-fit: cover;
            border-radius: 6px;
            flex-shrink: 0;
            background: #f3f4f6;
        }
        .post-img-placeholder {
            width: 120px;
            height: 90px;
            border-radius: 6px;
            flex-shrink: 0;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            font-size: 1.5rem;
        }
        .post-body { flex: 1; min-width: 0; }
        .post-title { font-size: 1.05rem; font-weight: 600; color: #1b1b18; margin-bottom: .3rem; }
        .post-meta { font-size: .8rem; color: #9ca3af; margin-bottom: .5rem; }
        .post-content { font-size: .875rem; color: #4b5563; line-height: 1.5;
            overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
        .post-actions { display: flex; gap: .5rem; margin-top: .75rem; }
        .btn-sm { padding: .3rem .75rem; font-size: .8rem; }
        .btn-danger { border-color: #fca5a5; color: #b91c1c; }
        .btn-danger:hover { background: #fef2f2; }

        .empty { text-align: center; padding: 4rem; color: #9ca3af; }
        .empty p { margin-top: .5rem; font-size: .9rem; }

        #toast {
            position: fixed; bottom: 1.5rem; right: 1.5rem;
            background: #1b1b18; color: #fff;
            padding: .75rem 1.25rem; border-radius: 8px;
            font-size: .875rem; display: none; z-index: 999;
        }

        /* Modal */
        .modal-backdrop {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,.4); z-index: 100;
            align-items: center; justify-content: center;
        }
        .modal-backdrop.open { display: flex; }
        .modal {
            background: #fff; border-radius: 10px;
            padding: 1.75rem; width: 100%; max-width: 480px;
            box-shadow: 0 10px 30px rgba(0,0,0,.15);
        }
        .modal h2 { font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; font-size: .875rem; font-weight: 500; color: #374151; margin-bottom: .3rem; }
        input[type=text], textarea {
            width: 100%; padding: .6rem .75rem;
            border: 1px solid #d1d5db; border-radius: 6px;
            font-size: .9rem; outline: none;
            font-family: inherit;
        }
        input[type=text]:focus, textarea:focus { border-color: #6366f1; }
        textarea { resize: vertical; min-height: 80px; }
        .modal-footer { display: flex; justify-content: flex-end; gap: .75rem; margin-top: 1.25rem; }
    </style>
</head>
<body>
    <nav>
        <a href="/" class="brand">Blog API</a>
        <div class="nav-right">
            <span id="user-name"></span>
            <button class="btn btn-primary" onclick="openModal()">+ New Post</button>
            <button class="btn" onclick="logout()">Log out</button>
        </div>
    </nav>

    <div class="container">
        <div class="page-header">
            <h1>Blog Posts</h1>
        </div>
        <div class="posts-grid" id="posts-grid">
            <div class="empty"><span style="font-size:2rem">⏳</span><p>Loading posts…</p></div>
        </div>
    </div>

    <div id="toast"></div>

    <!-- New Post Modal -->
    <div class="modal-backdrop" id="modal">
        <div class="modal">
            <h2 id="modal-title">New Post</h2>
            <div class="form-group">
                <label>Title</label>
                <input type="text" id="post-title" placeholder="Post title">
            </div>
            <div class="form-group">
                <label>Content</label>
                <textarea id="post-content" placeholder="Write your post…"></textarea>
            </div>
            <div class="modal-footer">
                <button class="btn" onclick="closeModal()">Cancel</button>
                <button class="btn btn-primary" onclick="savePost()">Save</button>
            </div>
        </div>
    </div>

    <script>
        const token = localStorage.getItem('api_token');
        const user  = JSON.parse(localStorage.getItem('user') || 'null');

        if (!token) { window.location.href = '/login'; }

        if (user) {
            document.getElementById('user-name').textContent = 'Hi, ' + user.name;
        }

        let editingId = null;

        async function loadPosts() {
            const res  = await fetch('/api/posts', { headers: { Accept: 'application/json' } });
            const data = await res.json();
            const posts = data.data || [];
            const grid  = document.getElementById('posts-grid');

            if (!posts.length) {
                grid.innerHTML = '<div class="empty"><span style="font-size:2rem">📭</span><p>No posts yet. Create the first one!</p></div>';
                return;
            }

            grid.innerHTML = posts.map(p => `
                <a class="post-card" href="/blog/${p.id}">
                    ${p.image
                        ? `<img class="post-img" src="${p.image}" alt="${p.title}" onerror="this.style.display='none'">`
                        : `<div class="post-img-placeholder">📄</div>`}
                    <div class="post-body">
                        <div class="post-title">${p.title}</div>
                        <div class="post-meta">By ${p.user?.name ?? 'Unknown'} · ${new Date(p.created_at).toLocaleDateString()}</div>
                        <div class="post-content">${p.content}</div>
                    </div>
                </a>
            `).join('');
        }

        function openModal(title = '', content = '') {
            editingId = null;
            document.getElementById('modal-title').textContent = 'New Post';
            document.getElementById('post-title').value = title;
            document.getElementById('post-content').value = content;
            document.getElementById('modal').classList.add('open');
        }
        function closeModal() { document.getElementById('modal').classList.remove('open'); }

        function editPost(id, title, content) {
            editingId = id;
            document.getElementById('modal-title').textContent = 'Edit Post';
            document.getElementById('post-title').value = unescape(title);
            document.getElementById('post-content').value = unescape(content);
            document.getElementById('modal').classList.add('open');
        }

        async function savePost() {
            const title   = document.getElementById('post-title').value.trim();
            const content = document.getElementById('post-content').value.trim();
            if (!title || !content) { toast('Title and content are required.'); return; }

            const url    = editingId ? `/api/posts/${editingId}` : '/api/posts';
            const method = editingId ? 'PUT' : 'POST';

            const res = await fetch(url, {
                method,
                headers: { 'Content-Type': 'application/json', Accept: 'application/json', Authorization: 'Bearer ' + token },
                body: JSON.stringify({ title, content }),
            });

            if (res.ok) {
                closeModal();
                toast(editingId ? 'Post updated!' : 'Post created!');
                loadPosts();
            } else {
                const err = await res.json();
                toast(err.message || 'Something went wrong.');
            }
        }

        async function deletePost(id) {
            if (!confirm('Delete this post?')) return;
            const res = await fetch(`/api/posts/${id}`, {
                method: 'DELETE',
                headers: { Accept: 'application/json', Authorization: 'Bearer ' + token },
            });
            if (res.ok) { toast('Post deleted.'); loadPosts(); }
        }

        async function logout() {
            await fetch('/api/logout', {
                method: 'POST',
                headers: { Accept: 'application/json', Authorization: 'Bearer ' + token },
            }).catch(() => {});
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

        loadPosts();
    </script>
</body>
</html>
