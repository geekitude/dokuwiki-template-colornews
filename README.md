![ColorNews - Dokuwiki template](/images/colornews-banner-red.png)

# dokuwiki-template-colornews

Porting ColorNews Wordpress theme (https://themegrill.com/themes/colornews/) to DokuWiki using [this guide](https://www.dokuwiki.org/devel:wp_to_dw_template).

    See template.info.txt for template details
    ColorNews is distributed under the terms of the GNU GPL (see LICENSE for details)
    
Version of ColorNews Wordpress theme used as base for this project : 1.1.4 (2018-09-06)

## Conversion progression todo list

* [x] Start with Starter template
* [x] Basic HTML/PHP
  * [x] Meta elements
  * [x] Site containers
  * [x] Header
  * [x] Content area
  * [x] Footer
  * [x] Sidebar
  * [x] WP vs. DW functions
  * [x] Language strings
* [x] Basic CSS
  * [x] style.css
  * [x] rtl.css
  * [x] print.css
  * [x] Necessary changes
* [ ] JS
* [ ] Further HTML/PHP
  * [ ] Other layouts
  * [ ] Special DW elements
  * [ ] Other actions
* [ ] Further CSS
  * [ ] style.ini
    * [ ] Guaranteed colour placeholders
    * [ ] Other values
  * [ ] WP vs. DW classes
    * [ ] The lazy way
    * [ ] The clean way
* [x] Rename IDs
* [ ] Support specific custom WP theme functionality
  * [ ] Custom colours
  * [ ] Custom background

## Credits

### Third party modules

* [Advanced News Ticker - 1.0.11](http://risq.github.io/jquery-advanced-news-ticker/), distributed under [GNU General Public License v2.0](https://www.gnu.org/licenses/gpl-2.0.en.html)
* [Web Font Loader - 1.6.28](https://github.com/typekit/webfontloader) to nicely load fonts from Google Web Fonts, distributed under [Apache License 2.0](https://www.apache.org/licenses/LICENSE-2.0)
* [JDENTICON - 1.8.0](https://jdenticon.com/) to add modern and highly recognizable identicons, distributed under [zlib License](https://www.zlib.net/zlib_license.html)

### Extra

* Replaced orginal 770Kb background pattern with a 48Kb one from [Subtle Patterns](https://www.toptal.com/designers/subtlepatterns/)
* Dummy blank avatar is under CC Attribution 3.0 Unported license and comes from [ICON-ICONS](https://icon-icons.com/)
* Font used for sample UI images (banner, widebanner and sidebar.png) is: [Rollandin by Emilie Rollandin](http://www.archistico.com/portfolio/nuovo-font-rollandin/).
* Special thanks to Giuseppe Di Terlizzi, author of [Bootstrap3](https://www.dokuwiki.org/template:bootstrap3) DokuWiki template who nicely acepted that I copy some of his code to build admin dropdown menu.

## Main features todo list

* [ ] Namespace dependent CSS placeholders (for colors and fonts)
* [ ] Namespace dependent UI images (background pattern, banner, logo, widebanner and a potential sidebar header)
* [ ] Google Fonts : each of main text, headings, condensed text (mostly nav bar) and monospaced text (```code``` syntax) can use a different Google font (be warned that main text font should be kept very readable)
* [ ] Easy to customize glyphs(*) (from [Material Design Icons](https://materialdesignicons.com/) like other DW's SVG glyphs or [IcoMoon](https://icomoon.io/) for social links)
* [ ] Can have a "scrollspy" ToC on wide screen
* [ ] Sidebar moved out of page content on wide screen
* [ ] Dynamic navigation button (current NS home, parent NS start, home)
* [x] Dynamic sidebar widgets
* [x] Github issues badge in footer
* [ ] Paralax wide banner?
* [ ] Include hooks(*), based on [this document](https://www.dokuwiki.org/include_hooks), starter template and also quite a few specific additions
  * [x] *meta.html* : just before `</head>` tag (use this to add additional styles or metaheaders)
  * [x] *header.html* : right above everything (except [Skip to Content])
  * [x] *brandingfooter.html* : just below site-logo/title/banner section
  * [x] *bannerheader.html* : above banner
  * [x] *bannerheader.html* : above banner
  * [x] *navbarheader.html* : above main navigation area
  * [x] *navbarfooter.html* : below main navigation area (right above breadcrumbs)
  * [x] *sidebarheader.html* : before sidebar content
  * [x] *sidebarfooter.html* : after sidebar content
  * [x] *pageheader.html* : above page
  * [x] *pagefooter.html* : right before site footer, below  page content
  * [ ] *footerwidget.html* : included in footer widgets area (after other widgets)
  * [x] *footer.html* : at the very end of the page just before the `</body>` tag
* [x] Replace hooks(**) to change some simple template elements into fancier HTML code of your own
  * [x] *topbar page* : debug dummy topbar links "page" [see here](https://www.dokuwiki.org/tips:topbar)
  * [x] *title.html* : replace wiki title string with HTML element
  * [x] *tagline.html* : replace wiki description string with HTML element
  * [x] 'sidebar page' : debug dummy sidebar page
* [ ] Expanded debug mode to show or hide some specific elements
  * [x] 'a11y' (visual accessibility helpers)
  * [x] 'alerts'
  * [x] 'avatar'
  * [x] 'banner'
  * [x] 'card' (sidebar namespace card image)
  * [x] 'images' (all UI images)
  * [x] 'include' (HTML include hooks)
  * [ ] 'logo' (namespace logo within page header)
  * [x] 'replace' (HTML replace hooks)
  * [ ] 'sitelogo'

(*) to replace a glyph by another, simply put desired SVG file (2kb max) in `colornews/svg/custom` folder and name it after the following list of elements : about.svg, acl.svg, admin.svg, config.svg, discussion.svg, extensions.svg, from-playground.svg, help.svg, home.svg, menu.svg, namespace-start.svg, parent-namespace.svg, playground.svg, popularity.svg, private-page.svg, public-page.svg, recycle.svg, refresh.svg, revert.svg, search.svg, styling.svg, translation.svg, upgrade.svg, user.svg, usermanager.svg or unknown-user.svg

## Expanded debug mode

Debug mode is meant to show usually hidden elements to test some of template's settings or features.

To enable "full" debug mode, simply add `&debug=1` or `?debug=1` at the end of URL, depending of current wiki mode (ie use "&" if there's already a "?" in URL, else use "?").

You can also use some specific keyword values instead of boolean to show only a given element category (e.g. `&debug=include`). Here's a complete list of possible keywords : 'a11y' (visual accessibility helpers), 'alerts', 'avatar', 'banner', 'card' (sidebar namespace card image), 'images' (all UI images), 'include' (HTML include hooks), 'logo' (namespace logo within page header), 'replace' (HTML replace hooks), 'sitelogo'

## About UI Images

### Background pattern

By default, the template uses `colornews/images/pattern.png` image as background pattern.
To use another one, simply upload a `pattern.png` image inside `wiki` namespace.