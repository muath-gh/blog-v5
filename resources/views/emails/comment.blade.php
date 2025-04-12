@component('mail::message')
# 📬 New Comment Notification

A new comment has been posted on your site.

---

**Comment Details:**

- **Author:** {{ $comment->user?->name ?? 'Guest' }}
- **Post Title:** {{ $comment->post_slug ?? 'N/A' }}
- **Comment Body:**  
{{ $comment->body }}

- **Submitted At:** {{ $comment->created_at->format('Y-m-d H:i') }}

---



Thanks,<br>
{{ config('app.name') }}
@endcomponent