# Sleeky issue / PR map (master3395 fork)

Date: 16/08/2026

## Shipped in fix/sleeky-backlog

| Upstream | Change |
|----------|--------|
| #96 | Gate Sleeky CSS/JS to HTML admin `html_head` contexts |
| #120 | Valid footer HTML for Sleeky version link |
| #39 #64 #77 #80 #97 #113 | `admin_links` filter (no early style pollution path) |
| PR #154 | Theme `#delete-confirm-dialog` for YOURLS 1.10+ |
| PR #149 | `sass` instead of `node-sass` (already on master) |
| #138 | Enter submits admin add-URL form |
| #124 | Clipboard `execCommand` fallback |
| #115 / PR #48 | `enableUppercaseInputs` config (default false) |
| #99 | hCaptcha support (config sample, no secrets) |
| #132 | Auto-add `https://` |
| #89 | Bootstrap 5 CDN |
| #118 | `enablePublicShorten` |
| #129 | `enableQrOnSuccess` |
| #114 | Success screen + close button retained |

## Closed without code

Support / out of scope: #25, #44, #47, #53, #55, #59, #60, #62, #63, #66, #68, #70, #72-#76, #78, #87, #90, #105, #109, #111, #121, #123, #126 (covered by #132).

Dependabot PRs that still bump `node-sass` are obsolete after PR #149.
