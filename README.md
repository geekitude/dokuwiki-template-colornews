![ColorNews - Dokuwiki template](/images/colornews-banner-red.png)

# dokuwiki-template-colornews

Porting ColorNews Wordpress theme (https://themegrill.com/themes/colornews/) to DokuWiki using [this guide](https://www.dokuwiki.org/devel:wp_to_dw_template).

    See template.info.txt for template details
    ColorNews is distributed under the terms of the GNU GPL (see LICENSE for details)
    
Version of ColorNews Wordpress theme used as base for this project : 1.1.4 (2018-09-06)

## Conversion progression todo list

* [x] Start with Starter template
* [ ] Basic HTML/PHP
  * [x] Meta elements
  * [x] Site containers
  * [ ] Header
  * [ ] Content area
  * [ ] Footer
  * [ ] Sidebar
  * [ ] WP vs. DW functions
  * [ ] Language strings
* [ ] Basic CSS
  * [ ] style.css
  * [ ] rtl.css
  * [ ] print.css
  * [ ] Necessary changes
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
* [ ] Rename IDs
* [ ] Support specific custom WP theme functionality
  * [ ] Custom colours
  * [ ] Custom background

## More Credits

### Third party modules

* [Normalize - 8.0.0](https://necolas.github.io/normalize.css/), distributed under [MIT License](https://opensource.org/licenses/MIT)
* [Advanced News Ticker - 1.0.11](http://risq.github.io/jquery-advanced-news-ticker/), distributed under [GNU General Public License v2.0](https://www.gnu.org/licenses/gpl-2.0.en.html)
* [Web Font Loader - 1.6.28](https://github.com/typekit/webfontloader) to nicely load fonts from Google Web Fonts, distributed under [Apache License 2.0](https://www.apache.org/licenses/LICENSE-2.0)
* [JDENTICON - 1.8.0](https://jdenticon.com/) to add modern and highly recognizable identicons, distributed under [zlib License](https://www.zlib.net/zlib_license.html)

### Extra

* Replaced orginal 770Kb background pattern with a 48Kb one from [Subtle Patterns](https://www.toptal.com/designers/subtlepatterns/)
* Font used for sample UI images (banner, widebanner and sidebar.png) is: [Rollandin by Emilie Rollandin](http://www.archistico.com/portfolio/nuovo-font-rollandin/).
* Special thanks to Giuseppe Di Terlizzi, author of [Bootstrap3](https://www.dokuwiki.org/template:bootstrap3) DokuWiki template who nicely acepted that I copy some of his code to build admin dropdown menu.

## Main Features todo

* [ ] Namespace dependent CSS placeholders (for colors and fonts)
* [ ] Namespace dependent UI images (background pattern, banner, logo, widebanner and a potential sidebar header)
* [ ] Google Fonts : each of main text, headings, condensed text (mostly nav bar) and monospaced text (```code``` syntax) can use a different Google font (be warned that main text font should be kept very readable)
* [ ] Easy to customize addittional glyphs (from [Material Design Icons](https://materialdesignicons.com/) like other DW's SVG glyphs or [IcoMoon](https://icomoon.io/) for social links)
* [ ] Can have a "scrollspy" ToC on wide screen
* [ ] Sidebar moved out of page content on wide screen
* [ ] Include hooks(*), based on [this document](https://www.dokuwiki.org/include_hooks), starter template and also quite a few specific additions
  * [ ] *meta.html* : just before `</head>` tag (use this to add additional styles or metaheaders)
  * [ ] *header.html* : right above everything (except [Skip to Content])
  * [ ] *brandingfooter.html* : just below site logo and title section
  * [ ] *bannerheader.html* : above banner
  * [ ] *navheader.html* : above main navigation area
  * [ ] *navfooter.html* : below main navigation area
  * [ ] *sidebarheader.html* : before sidebar content
  * [ ] *sidebarfooter.html* : after sidebar content
  * [ ] *pageheader.html* : above page
  * [ ] *articleheader.html* : above actual page content
  * [ ] *articlefooter.html* : just under actual page content
  * [ ] *pagefooter.html* : right before site footer, below  page content
  * [ ] *footerwidget.html* : included in footer widgets area (after other widgets)
  * [ ] *footer.html* : at the very end of the page just before the `</body>` tag
* [ ] Replace hooks(**) to change some simple template elements into fancier HTML code of your own
  * [ ] *title.html* : replace wiki title string
  * [ ] *tagline.html* : replace wiki description string
* [ ] Social links section in topbar or footer(***)
* [ ] Expanded debug mode to show or hide some specific elements
