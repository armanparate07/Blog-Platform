# Blog Platform (CodeIgniter 3)

A simple **blog platform** built with CodeIgniter 3 and a modern Tailwind‑styled admin UI. It supports posts, categories, comments, user roles, and an approval workflow for pending posts.

> Tech stack: CodeIgniter 3, PHP, MySQL, Tailwind CDN, vanilla JS.

***

## Features

- **Authentication**
  - Login/logout
  - Session‑based access protection
- **User roles**
  - Admin: full access, can approve/reject posts
  - Normal user: can create posts, which go into pending status
- **Posts**
  - Create, edit, delete posts
  - Rich text content field
  - Slug generation from title
  - Status: published, pending, draft
  - Pagination on listing page
- **Categories**
  - Create, edit, delete categories
  - Assign category to posts
- **Comments**
  - Add comments on posts
  - List comments under each post in the frontend/admin
- **Admin dashboard**
  - Modern sidebar layout (dark/light theme toggle)
  - Pending posts screen for review/approval
  - Responsive layout with mobile sidebar
- **Dark / Light theme**
  - Theme toggle persists in `localStorage`
  - Custom CSS tokens (`--bg-card`, `--text-primary`, etc.) for easy theming

***

## Project Structure (key parts)

- `application/config/` – CodeIgniter configuration (database, routes, etc.)
- `application/controllers/`
  - `Auth.php` – login/logout
  - `Posts.php` – posts CRUD & listing
  - `Categories.php` – categories CRUD
  - `Comments.php` – comments handling
  - `Admin.php` – dashboard, pending posts, approvals
- `application/models/`
  - `Post_model.php` – queries for posts
  - `Category_model.php` – queries for categories
  - `Comment_model.php` – queries for comments
  - `User_model.php` – queries for users
- `application/views/admin/`
  - `layout.php` – main admin layout (sidebar, theme toggle)
  - `dashboard.php` – admin dashboard
  - `pending_posts.php` – list of posts awaiting approval
- `application/views/posts/` – list, view, create, edit post templates

***

## Requirements

- PHP 7.x or newer
- MySQL or MariaDB
- Composer (optional but recommended)
- Web server:
  - Apache with `mod_rewrite` (typical XAMPP/WAMP/LAMP stack), or
  - Nginx with proper rewrite rules
- Git (if you’re cloning from GitHub)

***

## Installation

1. **Clone the repository**

```bash
git clone https://github.com/armanparate07/Blog-Platform.git
cd Blog-Platform
```

2. **Create a database**

Create a new MySQL database, e.g. `ci3_blog_platform`, and import your SQL schema (if there is a `database.sql` or `schema.sql` file, import that in phpMyAdmin or via CLI).

3. **Configure database connection**

Edit `application/config/database.php`:

```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'ci3_blog_platform',
    'dbdriver' => 'mysqli',
    // other settings…
);
```

4. **Base URL & other config**

Edit `application/config/config.php`:

```php
$config['base_url'] = 'http://localhost/ci3_blog_platform/';
```

Make sure your virtual host or XAMPP project path matches this URL.

5. **Set routes (optional)**

Check `application/config/routes.php` and adjust if needed (e.g. default controller).

***

## Running the App

If using XAMPP:

- Put the project in `C:\xampp\htdocs\ci3_blog_platform`
- Start Apache & MySQL from XAMPP Control Panel
- Visit:

```text
http://localhost/ci3_blog_platform/
```

Log in using the default admin user (you may seed one manually in the `users` table if needed).

***

## Usage

### Admin

- Access: `/admin` or via the sidebar after login
- Manage posts:
  - Create/edit/delete posts
  - Approve or reject pending posts
- Manage categories
- See pending posts in a dedicated screen
- Switch between **dark** and **light** theme using the toggle in the sidebar

### Posts & comments

- View list of posts
- Open a single post page
- Add comments (if enabled in the controller/view)

***

## Theming & UI

- **Tailwind CDN** is used (`<script src="https://cdn.tailwindcss.com"></script>`).
- Layout is created with a **fixed sidebar** and a responsive mobile top bar.
- Custom properties (CSS variables) define colors for dark/light themes.
- Theme preference is stored in `localStorage` and applied before page paint to avoid flicker.

If you want to adjust colors, edit the CSS tokens in `application/views/admin/layout.php` under:

```css
:root { ... }
.theme-light { ... }
```

***

## Development Notes

- Framework: CodeIgniter 3
- MVC pattern:
  - Controllers in `application/controllers`
  - Models in `application/models`
  - Views in `application/views`
- URL structure uses CodeIgniter’s routing; controller methods map to endpoints like:
  - `/posts` → `Posts::index`
  - `/posts/view/(:id)` → `Posts::view`
  - `/posts/create` → `Posts::create`

***

## Roadmap / Ideas

- Add search & filter for posts in admin (by title, category, status)
- Add tags (many‑to‑many relation)
- Add user profile page with activity (posts + comments)
- Add API endpoints for posts/comments (REST)
