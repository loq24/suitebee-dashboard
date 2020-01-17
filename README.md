<h1 align="center">
  Suitebee Dashboard
</h1>

<p align="center">
  TheWoo's dashboard theme.
</p>

<p align="center">
  <img src="/assets/images/suitebee-logo-wout-tagline.png" />
</p>

## Installation

<h4>Prerequisite:</h4>

```
Make sure that the WP Ultimo Admin Page Creator or WPUAPC plugin is installed.
```

- Download & activate this plugin

- Add Top Level admin pages using `WPUAPC` plugin
  - Make sure to select the `Use Normal Wordpress Editor` option
  - Write the `[sd-main-page-template]` shortcode into the editor
  - It should look something like [this](https://prnt.sc/qoy9h6)

- Replace Dashboard content with `WPUAPC`
  - In the `WPUAPC` Add New page, select `Replace Existing Page` in the `Type` field
  - Select `Dashboard` in the `Page To Replace` field
  - Select `Replace All Content` in the `How To Replace` field
  - Make sure to select the `Use Normal Wordpress Editor` option
  - Lastly, write the `[suitebee-dashboard]` shortcode into the editor. This is a different shortcode from the first stated above.
  - It should look somethign like [this](https://prnt.sc/qoz120)
  
- Assign subpages in the `Admin Subpages` admin page in the main site

<h5>To enable custom Login & Lost Password form</h5>

- Create a login page that uses `/login` url
- Assign the `Suitebee Login Template` page template


**NOTE:** The plugin won't automatically redirect to the `/login` page if the page isn't created yet.


___
*This plugin is owned by* [TheWoo](https://thewoo.com/).
