<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Database – {{ config('app.name') }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: ui-monospace, monospace; background: #0f172a; color: #e2e8f0; min-height: 100vh; padding: 2rem; }
        h1 { font-size: 1.3rem; color: #f8fafc; margin-bottom: 1.5rem; font-family: ui-sans-serif, sans-serif; }
        .section { margin-bottom: 2.5rem; }
        .section-title {
            font-size: .85rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: .1em; color: #94a3b8; margin-bottom: .75rem;
            font-family: ui-sans-serif, sans-serif;
        }
        .count { color: #38bdf8; margin-left: .5rem; }
        table { width: 100%; border-collapse: collapse; font-size: .82rem; }
        th {
            text-align: left; padding: .5rem .75rem;
            background: #1e293b; color: #94a3b8;
            font-size: .75rem; text-transform: uppercase; letter-spacing: .05em;
            border-bottom: 1px solid #334155;
        }
        td { padding: .5rem .75rem; border-bottom: 1px solid #1e293b; color: #cbd5e1; }
        tr:hover td { background: #1e293b; }
        .badge {
            display: inline-block; padding: .15rem .5rem;
            border-radius: 4px; font-size: .75rem; font-weight: 600;
        }
        .badge-blue  { background: #1e3a5f; color: #38bdf8; }
        .badge-green { background: #14532d; color: #4ade80; }
        .badge-amber { background: #451a03; color: #fb923c; }
        .back { display: inline-block; margin-bottom: 1.5rem; color: #38bdf8; text-decoration: none; font-family: ui-sans-serif, sans-serif; font-size: .875rem; }
        .back:hover { text-decoration: underline; }
        .empty { color: #475569; padding: .75rem; font-size: .85rem; }
    </style>
</head>
<body>
    <a href="/blog" class="back">← Back to Blog</a>
    <h1>Database Viewer</h1>

    {{-- USERS --}}
    <div class="section">
        <div class="section-title">Users <span class="count">{{ $users->count() }}</span></div>
        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Name</th><th>Email</th><th>Created</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                <tr>
                    <td><span class="badge badge-blue">{{ $u->id }}</span></td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="empty">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- POSTS --}}
    <div class="section">
        <div class="section-title">Posts <span class="count">{{ $posts->count() }}</span></div>
        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Title</th><th>Author</th><th>Content</th><th>Image</th><th>Created</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $p)
                <tr>
                    <td><span class="badge badge-green">{{ $p->id }}</span></td>
                    <td>{{ $p->title }}</td>
                    <td>{{ $p->user->name ?? '—' }}</td>
                    <td style="max-width:240px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $p->content }}</td>
                    <td>{{ $p->image ? '✓' : '—' }}</td>
                    <td>{{ $p->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="empty">No posts found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- COMMENTS --}}
    <div class="section">
        <div class="section-title">Comments <span class="count">{{ $comments->count() }}</span></div>
        <table>
            <thead>
                <tr>
                    <th>ID</th><th>Body</th><th>Author</th><th>Post</th><th>Created</th>
                </tr>
            </thead>
            <tbody>
                @forelse($comments as $c)
                <tr>
                    <td><span class="badge badge-amber">{{ $c->id }}</span></td>
                    <td>{{ $c->body }}</td>
                    <td>{{ $c->user->name ?? '—' }}</td>
                    <td>{{ $c->post->title ?? '—' }}</td>
                    <td>{{ $c->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="empty">No comments found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
