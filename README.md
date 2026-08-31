# claywarren.com

The personal site for [Clay Warren](https://claywarren.com), founder of TaskForceAI and builder of LaserShark at Hobu.

## Stack

- Static HTML, CSS, and JavaScript
- Vite for bundling and local development
- Bun for dependency management and scripts
- Vercel for hosting, DNS, and deployment

The site deliberately has no client framework. Its primary job is to load quickly, remain fully crawlable, and provide a durable canonical identity page.

## Development

```sh
bun install
bun run dev
```

Create and inspect a production build with:

```sh
bun run build
bun run preview
```

## SEO surface

The homepage includes canonical metadata, social cards, a `WebSite` / `ProfilePage` / `Person` JSON-LD graph, a stable favicon, `robots.txt`, and `sitemap.xml`.
