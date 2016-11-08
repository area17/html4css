# HTML4 CSS

A default CSS file to give *unsupported* browsers something other than a totally broken experience of the web.
Inspired by Andy Clarke's 2009 *'Universal Internet Explorer 6 CSS'* <sup><a href="https://stuffandnonsense.co.uk/blog/about/universal_internet_explorer_6_css" target="blank">1</a></sup> <sup><a href="https://stuffandnonsense.co.uk/blog/about/universal_internet_explorer_6_css_revisited">2</a></sup>.

To see what your website would look like with HTML4CSS - **[try the demo tool](http://html4css.dev.area17.com/)**

In the demo, a website is stripped of its `<head>`, `<style>` and `<script>` tags and a new `<head>` inserted which hooks up the HTML4CSS.

Responsive images are shim'd using [legacypicturefill](https://github.com/area17/legacypicturefill).

## How I'm using this

In the `<head>` of my documents I'm inlining small piece of JavaScript:

```javascript
(function(d) {
  var w = window,
      h, s;

  var browserSpec = (typeof d.querySelectorAll && 'addEventListener' in w && w.history.pushState && d.implementation.hasFeature('http://www.w3.org/TR/SVG11/feature#BasicStructure', '1.1')) ? 'html5' : 'html4';

  // disable all the stylesheets, except the html4css one
  function disableSS() {
    if (/in/.test(d.readyState)) {
      setTimeout(disableSS,9);
    } else {
      for(var i = 0; i < d.styleSheets.length; i++){
        var ss = d.styleSheets[i];
        if (ss.title !== 'html4css') {
          ss.disabled = true;
        }
      }
    }
  }

  // FF < 3.6 didn't have document.readyState - hacky shim for it
  function disableSSff3() {
    if (!d.readyState && d.addEventListener) {
      if (d.body) {
        setTimeout(function(){
          d.readyState = 'complete';
        },500);
      } else {
        setTimeout(disableSSff3,9);
      }
    }
  }

  if(browserSpec === 'html4') {
    h = d.getElementsByTagName('head')[0];
    s = d.createElement('link');
    s.rel  = 'stylesheet';
    s.title = 'html4css';
    s.href = '/dist/styles/html4css.css';
    h.appendChild(s);
  }

})(document);
```

This is to decide on the browser's spec, basically my version of the BBC's ['cutting the mustard test'](http://responsivenews.co.uk/post/18948466399/cutting-the-mustard). If the browser is deemed to be a HTML4 browser I load the HTML4CSS and disable any other stylesheet in the page.

## Issues/Contributing/Discussion

If you find a bug in HTML4CSS, please add it to [the issue tracker](https://github.com/13twelve/html4css/issues) or fork it, fix it and submit a pull request for it (👍).

Tabs are 2 spaces, its plain CSS with some in-line organisational comments.

## Support

I've tested this in a variety of browsers:

* Chrome 15+
* Safari 5.1+
* Firefox 3+
* IE 6+
* Android 4+

## Author

* [Mike Byrne](https://github.com/13twelve) - [@13twelve](https://twitter.com/13twelve)
